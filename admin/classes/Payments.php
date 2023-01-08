<?php

/**
 *
 * @author Redjic Solutions
 * @since January 28, 2020
*/

class Payments {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->paystackInstance = new Users\Paystack();
        $this->library = new Library();
        $this->orderInstance = new Orders();
        $this->cartInstance = new Carts();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)) {
            throw new Exception("Can't access the table names");
        }

        $this->orders = $tableNames['orders'];
        $this->payments = $tableNames['payments'];
        $this->users = $tableNames['users'];
        $this->shipping_addresses = $tableNames['shipping_addresses'];
        $this->order_status = $tableNames['order_status'];
    }

    /**
     * @param string $name
     * @return int
     *
    */    
    public function getStatus($name) {

        $query = "SELECT * FROM $this->order_status WHERE name = ?";
        $values = array(ucfirst($name));
        $response = $this->databaseInstance->getRow($query, $values);
        $id = 0;
        if ($response) $id = $response->id;

        return $id;
    }
    /**
     * @param int $payment_id
     * @return array
     *
    */
    public function confirmPayment($payment_id) {
        
        $payment = $this->getPayment($payment_id);
        if (!$payment['data'])throw new Exception("Invalid payment ID");

        $payment = $payment['data'];
        // if ($payment->status == "Confirmed") 
        //     throw new Exception("Payment confirmation failed");
            
        $amount_paid = (float) str_replace(",", "", $payment->amount_paid);
        $voucher_amount = (float) str_replace(",", "", $payment->voucher_amount);
        $amount_paid += $voucher_amount;
        $reference_no = $payment->reference_no;

        $userOrder = $this->orderInstance->getOrderByReferenceNo($reference_no);
        if (!$userOrder['data'])throw new Exception("Invalid order reference no $reference_no");
        $userOrder = $userOrder['data'];

        $prev_paid_amount = $this->getPaidAmount($reference_no);

        $order_id = $userOrder->order_id;
        $user_id = $userOrder->user_id;
        $total_amount = (float) str_replace(",", "", $userOrder->total_amount);

        $status = 1;
        $paid_status = 1;
        if ($total_amount > ($amount_paid + $prev_paid_amount)) {
            $status = 10;//Awaiting payment
            $paid_status = 0;
        }

        $query = "UPDATE $this->payments SET status = ? WHERE id = ?";
        $values = array("Confirmed", $payment_id);
        $this->databaseInstance->updateRow($query, $values);
        
        $this->orderInstance->updateOrderStatusByReferenceNo($paid_status, $status, $reference_no);

        $this->cartInstance->updateCartStatusByOrderID($user_id, $order_id, $status);
 
        $this->cartInstance->closeCartByOrderId($order_id);

        $response = $this->orderInstance->getOrderByReferenceNo($reference_no);
        if (!$response['data']) throw new Exception("Error Processing Request", 1);
        
        $response['data']->total_amount_paid = $amount_paid + $prev_paid_amount;

        return $response;
    }

    /**
     * @param int $payment_id
     * @return array
     *
    */
    public function cancelPayment($payment_id) {
        
        $payment = $this->getPayment($payment_id);
        if (!$payment['data'])throw new Exception("Invalid payment ID");

        if ($payment['data']->status == "Cancelled") 
            throw new Exception("Payment cancellation failed");
            
        $reference_no = $payment['data']->reference_no;
        $response = $this->orderInstance->getOrderByReferenceNo($reference_no);
        if (!$response['data'])throw new Exception("Invalid order reference no");

        $query = "UPDATE $this->payments SET status = ? WHERE id = ?";
        $values = array("Cancelled", $payment_id);
        $this->databaseInstance->updateRow($query, $values);

        return $response;
    }

    /**
     * @param string $reference_no
     * @return int
     *
    */
    public function getPaidAmount($reference_no) {

        $query = "SELECT SUM(amount_paid) AS amount_paid, 
            SUM(voucher_amount) AS voucher_amount 
            FROM $this->payments WHERE reference_no = ? AND status = ?";
        $values = array($reference_no, "Confirmed");
        $result = $this->databaseInstance->getRow($query, $values);
        $prev_paid_amount = 0;
        if ($result) 
            $prev_paid_amount = $result->amount_paid + $result->voucher_amount;

        return $prev_paid_amount;
    }

    /**
     * @return array
     *
    */
    public function paymentQuery() {

        $query = "SELECT p.id, p.reference_no, address, 
            FORMAT((amount_paid + voucher_amount), 2) AS amount_paid, 
            FORMAT(voucher_amount, 2) AS voucher_amount, p.bank, p.acc_name, 
            transaction_reference_no, fullname, s.email, profile_image_url, 
            DATE_FORMAT(p.date_paid, '%D %b %Y') as date_paid, p.status,  
            DATE_FORMAT(p.date_time, '%D %b %Y %l:%i %p') as date_time,  
            DATE_FORMAT(o.date_time, '%D %b %Y %l:%i %p') as order_date_time, 
            FORMAT(o.shipping_amount, 2) AS shipping_amount, p.payment_mode, 
            FORMAT(o.sub_total, 2) AS sub_total, o.id AS order_id, 
            FORMAT(o.total_amount, 2) AS total_amount, screenshot 
            FROM $this->payments p 
            INNER JOIN $this->users s ON p.user_id=s.id 
            INNER JOIN $this->orders o ON p.reference_no=o.reference_no 
            LEFT JOIN $this->shipping_addresses sh ON o.shipping_id=sh.id ";

        return $query;
    }  

    /**
     * @return boolean
     *
    */
    public function getPaymentStatistics() {

        $pending = $this->getPaymentsByStatus("Pending");
        $confirmed = $this->getPaymentsByStatus("Confirmed");
        $cancelled = $this->getPaymentsByStatus("Cancelled");
        $total_user_payments = $pending + $cancelled + $confirmed;

        if ($total_user_payments > 0) {
            $pending = $pending > 0 ? round(($pending/$total_user_payments)*100) : 0;
            $confirmed = $confirmed > 0 ? round(($confirmed/$total_user_payments)*100) : 0;
            $cancelled = $cancelled > 0 ? round(($cancelled/$total_user_payments)*100) : 0;
        } else $pending = $delivered = $cancelled = 0;

        $response = array(
            "data" => array(
                "pending" => $pending,
                "confirmed" => $confirmed,
                "cancelled" => $cancelled
            ),
            "message" => "success",
            "success" => true
        );

        return $response;
    }

    /**
     * @return array
     *
    */
    public function getPaymentsByStatus($status) {

        $query = $this->paymentQuery() ."WHERE p.status = ? ORDER BY p.id DESC";
        $response = $this->databaseInstance->getRows($query, array($status));

        return count($response);
    }

    /**
     * @return array
     *
    */
    public function getRecentPayments() {

        $query = $this->paymentQuery() ."WHERE p.status != ? ORDER BY p.id DESC LIMIT 5";
        $response = $this->databaseInstance->getRows($query, array("Cancelled"));

        return $this->library->formatResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getPayments($pagination, $sort, $format_query, $request, $user_id = 0) {

        $query = $this->paymentQuery();
        $values = array();

        if ($user_id) {
            $query .= "WHERE p.user_id = ? ";
            $values = array($user_id);
        }
        $query .= "ORDER BY p.id DESC";
        $response = $this->databaseInstance->getRows($query, $values);

        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);
    }

    /**
     * @return array
     *
    */
    public function getPaymentByReferenceNo($reference_no) {

        $query = $this->paymentQuery() ."WHERE p.reference_no = ?";
        $response = $this->databaseInstance->getRow($query, array($reference_no));
        if ($response) {
            $response->total_amount_paid = $this->getPreviousPaymentByReferenceNo($reference_no, $response->id);

            $carts = $this->cartInstance->getCartItemsByOrderId($response->order_id);
            $response->carts = $carts['data'];
        }

        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getPreviousPaymentByReferenceNo($reference_no, $id) {

        $query = "SELECT SUM(amount_paid) AS amount_paid, 
            SUM(voucher_amount) AS voucher_amount  
            FROM $this->payments p 
            INNER JOIN $this->users s ON p.user_id=s.id 
            INNER JOIN $this->orders o ON p.reference_no=o.reference_no 
            WHERE p.id != ? AND p.reference_no = ? AND p.status = ? 
            ORDER BY p.id DESC";
        $values = array($id, $reference_no, "Confirmed");
        $response = $this->databaseInstance->getRow($query, $values);
        $prev_paid_amount = 0;
        if ($response) 
            $prev_paid_amount=$response->amount_paid + $response->voucher_amount;

        return number_format($prev_paid_amount);
    }

    /**
     * @return array
     *
    */
    public function getPayment($id) {

        $query = $this->paymentQuery() ."WHERE p.id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));
        if ($response) {
            $response->total_amount_paid = $this->getPreviousPaymentByReferenceNo($response->reference_no, $id);

            $carts = $this->cartInstance->getCartItemsByOrderId($response->order_id);
            $response->carts = $carts['data'];
        }

        return $this->library->formatSingleResponse($response);
    }

    /**
     * @param string $transaction_reference_no
     * @return int
     *
    */
    public function getPaymentByTransactionReference($transaction_reference_no) {

        $query ="SELECT * FROM $this->payments where transaction_reference_no = ?";
        $result = $this->databaseInstance->getRow($query, array($transaction_reference_no));

        return $result;
    }

    public function updatePaymentStatus($reference_no, $status) {

        $query = "UPDATE $this->sellers_account_table 
            set status = ? WHERE reference_no = ?";
        $values = array($status, $reference_no);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    }

    /**
     * @param string $reference_no
     * @return array
     *
    */
    public function getPaymentHistory($reference_no) {

        $query = "SELECT id, reference_no, transaction_reference_no, bank, 
            FORMAT(amount_paid, '###,###,###') AS amount_paid,   
            DATE_FORMAT(date_time, '%D %b %Y %l:%i %p') as date_time, 
            DATE_FORMAT(date_paid, '%D %b %Y') as date_paid, acc_name  
            FROM $this->payments WHERE reference_no = ?";
        $results = $this->databaseInstance->getRows($query, array($reference_no));

        return $results;
    }

    /**
     * @param string $reference_no
     * @param string $transaction_reference_no
     * @return int
     *
    */
    public function updatePaystckPayment($reference_no, $transaction_reference_no) {

        $payment_mode = "Card Payment";
        if (!$reference_no) throw new \Exception("No order no found");

        $userOrder = $this->orderInstance->getOrderByReferenceNo($reference_no);
        if (!$userOrder['data'])throw new \Exception("Invalid order no");

        $userOrder = $userOrder['data'];
        // check if transaction reference no exist
        if ($this->getPaymentByTransactionReference($transaction_reference_no)) 
            throw new \Exception("Transaction reference no already exist");

        $result = $this->paystackInstance->verifyTransaction($transaction_reference_no);
        if (!(array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success'))) 
            throw new \Exception("Transaction failed");
        
        $amount_paid = $result['data']['amount']/100;   
        $prev_paid_amount = $this->getPaidAmount($reference_no);

        $total_amount = (float) str_replace(",", "", $userOrder->total_amount);
        $status = 1;
        $paid_status = 1;
        if ($total_amount > ($amount_paid + $prev_paid_amount)) {
            $status = 10;//Awaiting payment
            $paid_status = 0;
        }  

        $date_time = date("Y-m-d H:i:s");

        $query = "INSERT into $this->payments 
            SET user_id = ?, amount_paid = ?, reference_no = ?, date_time = ?, date_paid = ?, 
            transaction_reference_no = ?, voucher_amount = ?, payment_mode = ?, status = ?";
        $values = array($userOrder->user_id, $amount_paid, $reference_no, $date_time, 
            $date_time, $transaction_reference_no, 0, $payment_mode, 'Confirmed');
        $result = $this->databaseInstance->insertRow($query, $values);

        $this->orderInstance->updatePaidStatus($paid_status, $status, $reference_no);

        return $result;
    }
}