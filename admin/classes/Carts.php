<?php

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Carts {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->carts = $tableNames['carts'];
        $this->orders = $tableNames['orders'];
        $this->categories = $tableNames['categories'];
        $this->products = $tableNames['products'];

        $this->pagination = array();
        $this->sort = array();
        $this->format_query = array();
    }

    /**
     * @param int $order_id
     * @return array
     *
    */
    public function getCartItemsByOrderId($order_id, $status = 0) {

        $query = "SELECT c.id as cart_id, c.user_id, user_ses_id, url_tag, c.qty, 
            c.product_id, price, p.name, 
            FORMAT(amount, 2) AS amount, item_size as size, 
            FORMAT(total_amount, 2) AS total_amount, p.id, 
            comments, likes, dislikes, url_tag, 
            DATE_FORMAT(c.date_time, '%D %b %Y %l:%i %p') as date_time, 
            image_urls, product_off, description, 
            DATE_FORMAT(delivery_date, '%D %b %Y %l:%i %p') as delivery_date 
            from $this->carts c 
            INNER JOIN $this->products p ON c.product_id=p.id WHERE order_id = ? ";
        $values = array($order_id);
        if ($status) {
            $query .= "AND c.status != ?";
            $values = array($order_id, $status);
        }
        $response = $this->databaseInstance->getRows($query, $values);

        return $this->library->formatResponse($response, $this->pagination, $this->sort, $this->format_query);
    }

    /**
     * @param int $product_id
     * @return array
     *
    */
    public function getCartByProduct($product_id) {

        $query = "SELECT * from $this->carts c INNER JOIN $this->products p ON c.product_id=p.id WHERE order_id = ? ";
        $values = array($product_id);
        $response = $this->databaseInstance->getRows($query, $values);

        return $this->library->formatResponse($response);
    }

    /**
     * @param int $product_id
     * @return array
     * 
    */    
    public function getCartItemsByProductId($product_id, $from_date = null, $to_date = null) {
    
        $query = "SELECT COUNT(id) AS total, SUM(total_amount) AS total_amount, 
            SUM(qty) AS total_qty, product_id 
            FROM $this->carts WHERE product_id = ? AND status = ?";
        $values = array($product_id, 6);

        if ($from_date) {
            $from_date = date("Y-m-d H:i:s", strtotime($from_date));
            $to_date = $to_date != null 
                ? date("Y-m-d H:i:s", strtotime($to_date)) : date("Y-m-d H:i:s");

            $query = "SELECT COUNT(c.id) AS total, SUM(c.total_amount) AS total_amount, 
                SUM(c.qty) AS total_qty, c.product_id 
                FROM $this->carts c 
                INNER JOIN $this->orders o ON c.order_id=o.id 
                WHERE c.product_id = ? AND c.status = ? 
                AND o.date_time >= ? AND o.date_time <= ?";
            $values = array($product_id, 6, $from_date, $to_date);
        }
        $response = $this->databaseInstance->getRow($query, $values);

        return $this->library->formatSingleResponse($response);
    }

    /**
     * @param int $status
     * @param int $order_id
     * @return array
     * 
    */    
    public function updateCartStatusById($status, $order_id) {

        $query = "UPDATE $this->carts SET status = ? WHERE order_id = ?";
        $values = array($status, $order_id);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    }

    /**
     * @param int $user_id
     * @param int $order_id
     * @param int $status
     * @return boolean
     *
    */
    public function updateCartStatusByOrderID($user_id, $order_id, $status) {

        $query = "UPDATE $this->carts 
            SET status = ? WHERE user_id = ? AND order_id = ?";
        $values = array($status, $user_id, $order_id);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    }

    /**
     * @param int $order_id
     * @return boolean
     *
    */
    public function closeCartByOrderId($order_id) {

        $query = "UPDATE $this->carts 
            SET close_cart = ? WHERE order_id = ?";
        $values = array(1, $order_id);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    }
}