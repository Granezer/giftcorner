<?php

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Orders {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();
        $this->cartsItems = new Carts();
        // $this->payments = new Payments();

        $tableNames = $this->tablesAndKeys->getTableNames();

        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }
        
        $this->carts = $tableNames['carts'];
        $this->orders = $tableNames['orders'];
        $this->order_history = $tableNames['order_history'];
        $this->products = $tableNames['products'];
        $this->shipping_addresses = $tableNames['shipping_addresses'];
        $this->order_status = $tableNames['order_status'];
        $this->users = $tableNames['users'];
        $this->order_and_payment_history = $tableNames['order_and_payment_history'];

        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return boolean
     *
    */
    public function getOrderStatistics() {

        $awaiting_payment = $this->getOrdersByStatus(10);
        $pending = $this->getOrdersByStatus(1);
        $pending_pickup = $this->getOrdersByStatus(11);
        $pending_delivery = $this->getOrdersByStatus(5);
        $delivered = $this->getOrdersByStatus(6);
        $cancelled = $this->getOrdersByStatus(3);
        $accepted = $this->getOrdersByStatus(4);
        $total_orders = $awaiting_payment + $pending + $pending_pickup + $pending_delivery + $delivered + $cancelled + $accepted;

        if ($total_orders > 0) {
            $awaiting_payment = $awaiting_payment > 0 ? round((($awaiting_payment/$total_orders)*100),2) : 0;
            $pending = $pending > 0 ? round((($pending/$total_orders)*100),2) : 0;
            $pending_pickup = $pending_pickup > 0 ? round((($pending_pickup/$total_orders)*100),2) : 0;
            $pending_delivery = $pending_delivery > 0 ? round((($pending_delivery/$total_orders)*100),2) : 0;
            $delivered = $delivered > 0 ? round((($delivered/$total_orders)*100),2) : 0;
            $cancelled = $cancelled > 0 ? round((($cancelled/$total_orders)*100),2) : 0;
            $accepted = $accepted > 0 ? round((($accepted/$total_orders)*100),2) : 0;
        } else $awaiting_payment = $pending = $delivered = $cancelled = 0;

        $response = array(
            "data" => array(
                "awaiting_payment" => $awaiting_payment,
                "pending" => $pending,
                "pending_pickup" => $pending_pickup,
                "pending_delivery" => $pending_delivery,
                "delivered" => $delivered,
                "cancelled" => $cancelled,
                "accepted" => $accepted,
                "total_orders" => $total_orders
            ),
            "message" => "success",
            "success" => true
        );

        return $response;
    }

    /**
     * @param string $status
     * @return int
     *
    */    
    public function getOrdersByStatus($status) {

        $query = $this->getOrderQuery();
        $query .= "WHERE o.status = ? ORDER BY o.id DESC";
        $values = array($status);
        $response = $this->databaseInstance->getRows($query, $values);

        return count($response);
    }

    /**
     * @param int $status
     * @return array
     *
    */    
    public function getOrders($pagination, $sort, $format_query, $request, $status = 0) {
        
        $values = array();

        $query = $this->getOrderQuery();
        if (in_array($status, array(1,3,4,6,10,11,5))) {
            $query .= "where o.status = ? ";
            $values = array($status);
        } 
        
        $query .= "ORDER BY o.id DESC ";
        $response = $this->databaseInstance->getRows($query, $values);

        $response = $this->formatOrder($response);

        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);
    }

    /**
     * @param int $status
     * @return array
     *
    */    
    public function getBuyerOrders($pagination, $sort, $format_query, $request, $user_id) {

        $query = $this->getOrderQuery();
        $query .= "where o.user_id = ? ORDER BY o.id DESC ";
        $values = array($user_id);
        $response = $this->databaseInstance->getRows($query, $values);

        $response = $this->formatOrder($response);

        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);
    }

    /**
     * @return array
     *
    */
    public function formatOrder($orders) {

        $response = array();
        foreach ($orders as $order) {
            $carts = $this->cartsItems->getCartItemsByOrderId($order->order_id);
            $order->carts = $carts['data'];

            array_push($response, $order);
        }

        return $response;
    }

    /**
     * @return array
     *
    */
    public function getOrderQuery() {
        $query = "SELECT o.id, u.email as customer_email, o.user_id, 
            FORMAT(total_amount, 2) AS total_amount, 
            address, voucher_code, first_name, last_name, s.email, 
            FORMAT(sub_total, 2) AS sub_total, s.city, s.state, 
            FORMAT(tax_amount, 2) AS tax_amount, s.phone, postcode, 
            FORMAT(shipping_amount, 2) AS shipping_amount,
            DATE_FORMAT(o.date_time, '%D %b %Y %l:%i %p') as date_time, 
            s.country, os.name as delivery_status, o.status AS order_status, 
            paid_status as payment_status, payment_mode as payment_method, 
            os.name as status, o.id as order_id, reference_no, 
            o.date_time AS order_date_time 
            from $this->orders o 
            INNER JOIN $this->users u ON o.user_id=u.id 
            INNER JOIN $this->shipping_addresses s ON o.shipping_id=s.id 
            INNER JOIN $this->order_status os ON o.status=os.id ";

        return $query;
    }

    /**
     * @return array
     *
    */
    public function getOrderOrPaymentHistory($reference_no, $type = 'order') {
        
        $query = "SELECT description, status, by_admin as admin, date_time 
            from $this->order_and_payment_history 
            where reference_no = ? and type = ?";

        $values = array($reference_no, $seller_id, $type);
        $response = $this->databaseInstance->getRows($query, $values);
        
        return $response;
    }

    /**
     * @param int $id
     * @return array
     * 
    */    
    public function getOrder($id) {
        
        $query = $this->getOrderQuery();
        $query .= "where o.id = ?";
        $values = array($id);

        $response = $this->databaseInstance->getRows($query, $values);
        $response = $this->formatOrder($response);
        $response = reset($response);

        return $this->library->formatSingleResponse($response);
    }

    /**
     * @param string $reference_no
     * @return array
     *
    */
    public function getOrderByReferenceNo($reference_no) {

        $results = array();

        $query = $this->getOrderQuery()."where reference_no = ?";
        $values = array($reference_no);
        $response = $this->databaseInstance->getRow($query, $values);
        if (!$response) return array("data"=>false);
        
        $order_id = $response->id;

        $items = $this->cartsItems->getCartItemsByOrderId($order_id);
        $response->order_details = $items['data'];

        $history = $this->getOrderHistory($order_id);
        $response->history = $history;

        return $this->library->formatSingleResponse($response);
    }

    /**
     * @param int $order_id
     * @return array
     *
    */
    public function getOrderHistory($order_id) {
        $query = "SELECT DATE_FORMAT(date_time, '%D %b %Y %l:%i %p') AS date_time, 
            id, status, description 
            FROM $this->order_history WHERE order_id = ?";
        $values = array($order_id);
        $response = $this->databaseInstance->getRows($query, $values);

        return $response;
    }
    
    /**
     * @param int $order_id
     * @param int $status
     * @return array
     *
    */    
    public function updateOrderStatus($order_id, $status = '') {
 
        $order = $this->getOrder($order_id);
        if (!$order['data']) throw new Exception("Order ID not found");

        $status = $this->getOrderStatus($status);
        if (!$status) throw new Exception("Invalid status detected", 1);

        $reference_no = $order['data']->reference_no;
        $this->cartsItems->updateCartStatusById($status, $order_id);

        $query = "UPDATE $this->orders SET status = ? WHERE id = ?";
        $values = array($status, $order_id);
        $this->databaseInstance->updateRow($query, $values);

        $status = $this->getOrderStatusById($status);
        $status = strtolower($status->name);

        $description = "";
        if ($status == 'rejected') {
            $description = "Order has been rejected/declined by admin";
        } elseif ($status == 'accepted') {
            $description = "Order has been confirmed by admin";
        } elseif ($status == 'cancelled') {
            $description = "Order has been cancelled by admin";
        } elseif ($status == 'pending pickup') {
            $description = "Order items are waiting to be picked up";
        } elseif ($status == 'pending delivery') {
            $description = "Order is waitng to be delivered";
        } elseif ($status == 'delivered') {
            $description = "Order has been delivered";
        }

        if ($description) 
            $this->newOrderHistory($order_id, ucwords($status), $description);

        return $response = array("reference_no"=>$reference_no,"description"=>$description);
    }
    
    /**
     * @param int $order_id
     * @param int $status
     * @return array
     *
    */    
    public function updateOrderStatusByReferenceNo($paid_status, $status, $reference_no) {

        $query = "UPDATE $this->orders 
            SET paid_status = ?, status = ? WHERE reference_no = ?";
        $values = array($paid_status, $status, $reference_no);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    }

    /**
     * @param int $order_id
     * @return array
     *
    */
    public function newOrderHistory($order_id, $status, $description) {

        $query = "INSERT INTO $this->order_history 
            SET order_id = ?, status = ?, description = ?, date_time = ?";
        $values = array($order_id, $status, $description, $this->date_time);
        $response = $this->databaseInstance->insertRow($query, $values);

        return true;
    }

    /**
     * @return array
     *
    */    
    public function getAllOrderStatus() {

        $query = "SELECT * FROM $this->order_status";
        $response = $this->databaseInstance->getRows($query, array());

        return $response;
    }

    /**
     * @return array
     *
    */    
    public function getOrderStatusById($id) {

        $query = "SELECT * FROM $this->order_status WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));

        return $response;
    }

    /**
     * @param string $name
     * @return int
     *
    */    
    public function getOrderStatus($name) {

        $query = "SELECT * FROM $this->order_status where name = ?";
        $values = array(ucwords($name));
        $response = $this->databaseInstance->getRow($query, $values);
        $id = 0;
        if ($response) $id = $response->id;

        return $id;
    }

    /**
     * @return array
     *
    */    
    public function recordOrderOrPaymentStatusAction($reference_no, $description, $status, $by_admin, $type) {

        $query = "INSERT into $this->order_and_payment_history 
            set description = ?, reference_no = ?, status = ?, 
            by_admin = ?, type = ?, date_time = ?";
        $values = array($description, $reference_no, $status, 
            $by_admin, $type, $this->date_time);
        $response = $this->databaseInstance->insertRow($query, $values);

        return $response;
    }

    /**
     * @return boolean
     *
    */
    public function updatePaidStatus($paid_status, $status, $reference_no) {

        $query = "UPDATE $this->orders SET paid_status = ?, status = ? WHERE reference_no = ?";
        $values = array($paid_status, $status, $reference_no);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    } 
}