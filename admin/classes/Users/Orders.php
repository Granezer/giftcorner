<?php

namespace Users;

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Orders {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();
        $this->cartInstance = new Carts();
        $this->shippingInstance = new Shipping();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->carts = $tableNames['carts'];
        $this->orders = $tableNames['orders'];
        $this->order_history = $tableNames['order_history'];
        $this->shipping_addresses = $tableNames['shipping_addresses'];
        $this->products = $tableNames['products'];
        $this->users = $tableNames['users'];
        $this->order_status = $tableNames['order_status'];
        $this->payments = $tableNames['payments'];
        $this->tbl_states = $tableNames['tbl_states'];
        $this->tbl_country = $tableNames['tbl_country'];
    }

    public function orderQuery (){

        $query = "SELECT o.id, address, first_name, last_name, 
            FORMAT(total_amount, 2) AS total_amount, voucher_code, 
            FORMAT(sub_total, 2) AS sub_total, 
            FORMAT(tax_amount, 2) AS tax_amount, 
            FORMAT(shipping_amount, 2) AS shipping_amount, 
            DATE_FORMAT(o.date_time, '%D %b %Y %l:%i %p') as date_time, 
            c.name AS country, os.name as delivery_status, 
            os.name as status, o.user_id, o.id as order_id, s.email, reference_no, 
            paid_status as payment_status, payment_mode as payment_method, 
            s.phone, postcode, u.email as customer_email, s.city, st.name AS state 
            from $this->orders o 
            INNER JOIN $this->users u ON o.user_id=u.id 
            INNER JOIN $this->shipping_addresses s ON o.shipping_id=s.id 
            INNER JOIN $this->order_status os ON o.status=os.id 
            LEFT JOIN $this->tbl_states st ON s.state=st.id 
            INNER JOIN $this->tbl_country c ON s.country=c.id ";

        return $query;

    }

    /**
     * @param string $user_id
     * @param string $reference_no
     * @return array
     *
    */
    public function getOrders($user_id, $reference_no = null) {

        $response = array();

        if ($reference_no) {

            $query = $this->orderQuery()."where reference_no = ?";
            $values = array($reference_no);
            $result = $this->databaseInstance->getRow($query, $values);
            if (!$result) throw new \Exception("Invalid reference no");;
            
            $order_id = $result->id;
            
            $paid_amount = $this->getPaidAmount($reference_no);
            $result->amount_paid = number_format($paid_amount);

            $response = $this->cartInstance->getItemsFromCartByOrderId($user_id, $order_id);
            $result->cartDetails = $response;

            $history = $this->getOrderHistory($order_id);
            $result->history = $history;

            $payment_history = $this->getPaymentHistory($reference_no);
            $result->payment_history = $payment_history;

            return $this->library->formatSingleResponse($result);
        }

        $query = $this->orderQuery()."WHERE o.user_id = ? ORDER BY o.id DESC";
        $values = array($user_id);
        $response = $this->databaseInstance->getRows($query, $values);

        $results = array();
        foreach ($response as $value) {
            $history = $this->getOrderHistory($value->id);
            $payment_history = $this->getPaymentHistory($value->reference_no);
            $cartDetails = $this->cartInstance->getItemsFromCartByOrderId($user_id, $value->id);
            $value->history = $history;
            $value->payment_history = $payment_history;
            $value->cartDetails = $cartDetails;
            array_push($results, $value);
        }

        return $results;
    }

    /**
     * @param string $reference_no
     * @return array
     *
    */
    public function getOrderByReferenceNo($reference_no) {

        $response = array();

        $query = $this->orderQuery()."where reference_no = ?";
        $values = array($reference_no);
        $response = $this->databaseInstance->getRow($query, $values);
        if (!$response) return false;
        
        $order_id = $response->id;
        $user_id = $response->user_id;

        $items = $this->cartInstance->getItemsFromCartByOrderId($user_id, $order_id);
        $response->order_details = $items;

        $history = $this->getOrderHistory($order_id);
        $response->history = $history;

        $payment_history = $this->getPaymentHistory($reference_no);
        $response->payment_history = $payment_history;

        return $response;
    }

    /**
     * @param int $order_id
     * @return array
     *
    */
    public function getOrderHistory($order_id) {
        $query = "SELECT DATE_FORMAT(date_time, '%D %b %Y %l:%i %p') as date_time, 
            id, status, description 
            FROM $this->order_history WHERE order_id = ?";
        $values = array($order_id);
        $response = $this->databaseInstance->getRows($query, $values);

        return $response;
    }

    /**
     * @param int $user_id
     * @param string $user_ses_id
     * @param double $shipping_amount
     * @param double $amount_paid
     * @param string $payment_mode
     * @return int
     *
    */
    public function createOrder($user_id, $user_ses_id, $shipping_amount, $payment_mode, $shipping_id, $email, $voucher_code) {

        $items_cart = $this->cartInstance->getCartItemsBySession($user_id, $user_ses_id);
        if (!$items_cart) throw new \Exception("Cart is empty");

        $response = $this->shippingInstance->getShippingAddress($shipping_id);
        if (!$response) throw new \Exception("No shipping details found");
        if ($response->user_id != $user_id) 
            throw new \Exception("No shipping details found. Try again");

        $shipping_amount = $response->price;
        
        $sub_total = 0;
        foreach ($items_cart as $value) 
            $sub_total += $value->total_amount;

        $close_cart = 1;  
        $paid_status = 0;
        $date = date("Y-m-d H:i:s");

        $total_amount = $sub_total + $shipping_amount;

        $reference_no = $this->library->generateCode(6);
        for ($i=0; $i < 10; $i++) { 
            $result = $this->getOrderByReferenceNo($reference_no);
            if (!$result) break;
            $reference_no = $this->library->generateCode(6);

            if ($i == 10) throw new \Exception("Something went wrong");
        }

        $query = "INSERT into $this->orders 
            set user_id = ?, shipping_amount = ?, sub_total = ?, shipping_id = ?, 
            total_amount = ?, paid_status = ?, date_time = ?, reference_no = ?, 
            payment_mode = ?, voucher_code = ?";
        $values = array($user_id, $shipping_amount, $sub_total, $shipping_id, 
            $total_amount, $paid_status, $date, $reference_no, $payment_mode, 
            $voucher_code);
        $order_id = $this->databaseInstance->insertRow($query, $values);

        $this->cartInstance->updateCartOrderID($user_id, $user_ses_id, $order_id, $close_cart);

        $voucher_amount = 0;
        if ($voucher_code) {
            $amount = $this->createPayment($reference_no, 0, null, null, null, $date, "Voucher", $voucher_code);

            $voucher_amount = $amount->total_amount_paid;

            $query = "UPDATE $this->vouchers_table 
                set reference_no = ?, status = ? where voucher = ?";
            $values = array($reference_no, 'used', $voucher_code);
            $this->databaseInstance->updateRow($query, $values);
        }

        $total_amount = $total_amount - $voucher_amount;
        
        $response = array(
            "user_id"=> $user_id, 
            "reference_no"=>$reference_no, 
            "order_no"=>$reference_no, 
            "total_amount"=>$total_amount, 
            "order_id"=>$order_id
        );

        return $response;
    }

    ####################################################################
    #   PAYMENTS

    /**
     * @param string $reference_no
     * @return int
     *
    */
    public function getPaidAmount($reference_no) {

        $query = "SELECT SUM(amount_paid) as amount_paid, 
            SUM(voucher_amount) as voucher_amount 
            from $this->payments where reference_no = ?";
        $result = $this->databaseInstance->getRow($query, array($reference_no));
        $prev_paid_amount = 0;
        if ($result) {
            $prev_paid_amount = $result->amount_paid + $result->voucher_amount;
        }

        return $prev_paid_amount;
    }

    /**
     * @param string $reference_no
     * @return array
     *
    */
    public function getPaymentHistory($reference_no) {

        $query = "SELECT id, reference_no, transaction_reference_no, bank, acc_name, 
            FORMAT(amount_paid, 2) AS amount_paid,   
            DATE_FORMAT(date_time, '%D %b %Y %l:%i %p') as date_time, 
            DATE_FORMAT(date_paid, '%D %b %Y') as date_paid  
            from $this->payments where reference_no = ?";
        $results = $this->databaseInstance->getRows($query, array($reference_no));

        return $results;
    }

    /**
     * @param string $transaction_reference_no
     * @return int
     *
    */
    public function getPaymentByTransactionReference($transaction_reference_no) {

        $query ="SELECT * from $this->payments where transaction_reference_no = ?";
        $result = $this->databaseInstance->getRow($query, array($transaction_reference_no));

        return $result;
    }

    /**
     * @param int $user_id
     * @param double $amount_paid
     * @param string $reference_no
     * @param string $reference_no
     * @return int
     *
    */
    public function createPayment($reference_no, $amount_paid, $bank, $acc_name, $transaction_reference_no, $date, $payment_mode, $voucher_code = null ) {
        
        if (!$reference_no) throw new \Exception("No reference no found");

        $userOrder = $this->getOrderByReferenceNo($reference_no);

        if (!$userOrder)throw new \Exception("Invalid order reference no");

        // check if transaction reference no exist
        if ($this->getPaymentByTransactionReference($transaction_reference_no)) {
            throw new \Exception("Transaction reference no already exist");  
        }

        $prev_paid_amount = $this->getPaidAmount($reference_no);

        $order_id = $userOrder->order_id;
        $user_id = $userOrder->user_id;
        $total_amount = (float) str_replace(",", "", $userOrder->total_amount);

        $voucher_amount = 0;

        $status = 1;
        $paid_status = 1;
        if ($total_amount > ($amount_paid + $prev_paid_amount)) {
            $status = 10;//Awaiting payment
            $paid_status = 0;
        }

        $query = "INSERT into $this->payments 
            set user_id = ?, amount_paid = ?, reference_no = ?, date_time = ?, 
            date_paid = ?, bank = ?, acc_name = ?, transaction_reference_no = ?, 
            voucher_amount = ?, payment_mode = ?";
        $values = array($user_id, $amount_paid, $reference_no, $date, 
            $date, $bank, $acc_name, $transaction_reference_no, 
            $voucher_amount, $payment_mode);
        $result = $this->databaseInstance->insertRow($query, $values);
        if (!$result) throw new \Exception("unable to save payment");
        
        $query = "UPDATE $this->orders 
            set paid_status = ?, status = ? where reference_no = ?";
        $values = array($paid_status, $status, $reference_no);
        $this->databaseInstance->updateRow($query, $values);

        $this->cartInstance->updateCartStatusByOrderID($user_id, $order_id, $status);

        $this->cartInstance->closeCartByOrderId($order_id);

        $userOrder = $this->getOrderByReferenceNo($reference_no);
        if (!$userOrder) throw new \Exception("Error Processing Request", 1);
        
        $userOrder->total_amount_paid = $amount_paid + $prev_paid_amount;

        return $userOrder;
    }
    /**
     * @param int $seller_id
     * @param string $reference_no
     * @return array
     *
    */
    public function getPreviousAmount($seller_id, $reference_no) {

        $query = "SELECT SUM(amount) as amount from $this->sellers_account_table 
            where seller_id = ? and reference_no = ?";
        $values = array($seller_id, $reference_no);
        $response = $this->databaseInstance->getRow($query, $values);

        return $response;
    }
}