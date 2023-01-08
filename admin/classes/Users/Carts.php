<?php

namespace Users;

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Carts {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->productInstance = new \Products();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->carts = $tableNames['carts'];
        $this->category_types = $tableNames['category_types'];
        $this->products = $tableNames['products'];
        $this->order_status = $tableNames['order_status'];
        $this->products_status = $tableNames['products_status'];
    }

    /**
     * @param string $user_ses_id
     * @return array
     *
    */
    public function getCartItemsBySession($user_id, $user_ses_id, $state = null) {

        $response = array();

        if ($state) {
            $query = "SELECT c.id as cart_id, c.user_id, user_ses_id, 
                c.product_id, c.qty, product_off, comments, amount, 
                total_amount, url_tag, item_size as size, p.id, url_tag, 
                p.name, DATE_FORMAT(c.date_time, '%D %b %Y %l:%i %p') as date_time, 
                image_urls, price, description, ps.name as product_status 
                FROM $this->carts c 
                INNER JOIN $this->products p ON c.product_id=p.id 
                INNER JOIN $this->products_status ps ON p.status=ps.status  
                WHERE user_ses_id = ? AND close_cart = ? AND p.status = 1";
            $values = array($user_ses_id, 0);
            $response = $this->databaseInstance->getRows($query, $values);

            return $response;
        }

        $query = "SELECT * FROM $this->carts 
            WHERE user_ses_id = ? and close_cart = ?";
        $values = array($user_ses_id, 0);
        $response = $this->databaseInstance->getRows($query, $values);

        return $response;
    }

    /**
     * @param string $user_ses_id
     * @param int $product_id
     * @return array
     *
    */
    public function getItemFromCart($user_ses_id, $product_id) {

        $query = "SELECT * FROM $this->carts 
            WHERE user_ses_id = ? and product_id = ? and close_cart = ?";
        $values = array($user_ses_id, $product_id, 0);
        $response = $this->databaseInstance->getRow($query, $values);

        return $response;
    }

    /**
     * @param int $user_id
     * @param string $user_ses_id
     * @param int $product_id
     * @param int $qty
     * @param double $amount
     * @return int
     *
    */
    public function addToCart($user_id, $user_ses_id, $product_id, $qty, $color, $item_size = null, $amount = 0) {
        
        $product = $this->productInstance->getProduct($product_id);
        if (empty($product['data']->id))
            throw new \Exception("product does not exist");
    
        $amount = (float) str_replace(",", '', $product['data']->price);

        if ($product['data']->product_off != 0) {
            $percent = (float) str_replace(",", '', $product['data']->product_off);
            $amount = round(($amount * ((100 - $percent)/100)), 2);
        }

        $date = date("Y-m-d H:i:s");
        $cart = $this->getItemFromCart($user_ses_id, $product_id);
        if ($cart) {
            $qty = $qty + $cart->qty;
            $total_amount = $qty * $amount;
            $query = "UPDATE $this->carts 
                SET qty = ?, amount = ?, total_amount = ?, date_time = ? WHERE id = ?";
            $values = array($qty, $amount, $total_amount, $date, $cart->id);
            $this->databaseInstance->updateRow($query, $values);

            return $cart->id;

        }

        $total_amount = $qty * $amount;
        $query = "INSERT INTO $this->carts 
            SET user_id = ?, user_ses_id = ?, product_id = ?, qty = ?, amount = ?, 
            total_amount = ?, item_size = ?, color = ?, date_time = ?";
        $values = array($user_id, $user_ses_id, $product_id, $qty, $amount, 
            $total_amount, $item_size, $color, $date);
        $result = $this->databaseInstance->insertRow($query, $values);


        return $result;
    }

    /**
     * @param int $user_id
     * @param string $user_ses_id
     * @param int $product_id
     * @param int $qty
     * @param double $amount
     * @return int
     *
    */
    public function editCart($user_id, $user_ses_id, $product_id, $qty, $color, $item_size) {

        $product = $this->productInstance->getProduct($product_id);//Function call
        if (empty($product['data']->id))
            throw new \Exception("product does not exist");
        
        $amount = (float) str_replace(",", '', $product['data']->price);

        if ($product['data']->product_off != 0) {
            $percent = (float) str_replace(",", '', $product['data']->product_off);
            $amount = round(($amount * ((100 - $percent)/100)), 2);
        }

        $date = date("Y-m-d H:i:s");
        $cart = $this->getItemFromCart($user_ses_id, $product_id);
        if (!$cart) 
            throw new \Exception("something is wrong with Session ID");

        $total_amount = $qty * $amount;
        $query = "UPDATE $this->carts 
            SET qty = ?, amount = ?, total_amount = ?, item_size = ?, color = ?, date_time = ? WHERE id = ?";
        $values = array($qty, $amount, $total_amount, $item_size, $color, $date, $cart->id);
        $this->databaseInstance->updateRow($query, $values);

        return $cart->id;
    }

    /**
     * @param string $user_ses_id
     * @param int $product_id
     * @return int
     *
    */
    public function deleteCart($user_ses_id, $product_id) {

        $product = $this->productInstance->getProduct($product_id);//Function call
        if (empty($product['data'])) 
            throw new \Exception("product does not exist");

        $date = date("Y-m-d H:i:s");
        $cart = $this->getItemFromCart($user_ses_id, $product_id);

        if (!$cart) throw new \Exception("Item does not exist");
        if ($cart->product_id != $product_id) 
            throw new \Exception("something is wrong with Product ID");

        $query = "DELETE FROM $this->carts WHERE id = ? LIMIT 1";
        $values = array($cart->id);
        $this->databaseInstance->deleteRow($query, $values);

        return $cart->id;
    }

    /**
     * @param int $user_id
     * @param string $old_user_ses_id
     * @param string $new_user_ses_id
     * @return boolean
     *
    */
    public function updateCartSession($user_id, $old_user_ses_id, $new_user_ses_id) {

        $items_cart = $this->getCartItemsBySession($user_id, $old_user_ses_id);

        if ($items_cart) {
            foreach ($items_cart as $value) {
                $query = "UPDATE $this->carts 
                    SET user_ses_id = ?, user_id = ? WHERE id = ?";
                $values = array($new_user_ses_id, $user_id, $value->id);
                $this->databaseInstance->updateRow($query, $values);
            }
        }

        return true;
    }

    /**
     * @param int $order_id
     * @return array
     *
    */
    public function getItemsFromCartByOrderId($user_id, $order_id) {

        $query = "SELECT c.id as cart_id, c.user_id, user_ses_id, c.qty, url_tag, 
            c.product_id, p.name, price, image_urls, 
            FORMAT(amount, 2) AS amount, item_size as size, 
            FORMAT(total_amount, 2) AS total_amount, p.id, 
            os.name as status, product_off, description, 
            DATE_FORMAT(c.date_time, '%D %b %Y %l:%i %p') as date_time,  
            comments, ps.name as product_status 
            FROM $this->carts c 
            INNER JOIN $this->products p ON c.product_id=p.id 
            INNER JOIN $this->products_status ps ON p.status=ps.status 
            INNER JOIN $this->order_status os ON c.status=os.id 
            WHERE order_id = ?";
        $values = array($order_id);
        $response = $this->databaseInstance->getRows($query, $values);

        return $response;
    }

    /**
     * @param int $user_id
     * @param string $user_ses_id
     * @param int $order_id
     * @return boolean
     *
    */
    public function updateCartOrderID($user_id, $user_ses_id, $order_id, $close_cart) {

        $items_cart = $this->getCartItemsBySession($user_id, $user_ses_id);

        if ($items_cart) {
            foreach ($items_cart as $value) {
                $query = "UPDATE $this->carts SET order_id = ?, close_cart = ? WHERE id = ?";
                $values = array($order_id, $close_cart, $value->id);
                $this->databaseInstance->updateRow($query, $values);
            }
        }

        return true;
    }

    /**
     * @param int $order_id
     * @return boolean
     *
    */
    public function closeCartByOrderId($order_id) {

        $query = "UPDATE $this->carts SET close_cart = ? WHERE order_id = ?";
        $values = array(1, $order_id);
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

        $query = "UPDATE $this->carts SET status = ? WHERE user_id = ? and order_id = ?";
        $values = array($status, $user_id, $order_id);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    }
}