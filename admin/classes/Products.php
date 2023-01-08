<?php

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Products {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();
        $this->cartInstance = new Carts();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->products = $tableNames['products'];
        $this->products_status = $tableNames['products_status'];
        $this->products_status_history = $tableNames['products_status_history'];
        $this->viewed_products = $tableNames['viewed_products'];
        $this->product_discount_history = $tableNames['product_discount_history'];
        $this->product_images = $tableNames['product_images'];

        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
     *
    */
    public function productQuery() {
        $query = "SELECT p.id, p.name, price, ps.name AS product_status, url_tag, 
            product_off, image_urls, description, comments, likes, short_desc, dislikes, 
            p.status, p.date_time AS date_uploaded, discount_start_date, discount_end_date, 
            DATE_FORMAT(p.date_time, '%D %b %Y %l:%i %p') as date_time, weight, breadth, length, depth 
            FROM $this->products p 
            INNER JOIN $this->products_status ps ON p.status=ps.status ";

        return $query;
    } 

    /**
     * @return boolean
     *
    */
    public function getProductStatistics() {

        $paused = $this->getProductByStatus(0);
        $live_on_site = $this->getProductByStatus(1);

        $response = array(
            "data" => array(
                "paused" => $paused,
                "live_on_site" => $live_on_site
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
    public function getProductByStatus($status) {

        $query = $this->productQuery();
        $query .= "WHERE p.status = ? ORDER BY p.id DESC";
        $values = array($status);
        $response = $this->databaseInstance->getRows($query, $values);

        return count($response);
    }

    /**
     * @param string $status
     * @return array
     *
    */    
    public function getProducts($pagination = array(), $sort = array(), $format_query = array(), $request = array(), $status = 100) {

        $query = $this->productQuery();
        $values = array();

        if (in_array($status, array(0,1))) {
            $query .= " WHERE p.status  = ? ";
            $values = array($status);   
        } 
        
        $query .= "ORDER BY p.id DESC";
        $response = $this->databaseInstance->getRows($query, $values);

        $response = $this->getProductStatusHistory($response);

        return $this->library->formatResponse($response, $pagination, $sort = array(), $format_query, $request);
    }

    /**
     * @param string $status
     * @return array
     *
    */    
    public function getFrontendProducts($pagination = array(), $sort = array(), $format_query = array(), $request = array()) {

        $query = $this->productQuery();
        $query .= " WHERE p.status  = ? AND p.image_urls IS NOT NULL ORDER BY RAND()";
        $values = array(1);   
        $response = $this->databaseInstance->getRows($query, $values);

        // $response = $this->getProductStatusHistory($response);

        return $this->library->formatResponse($response, $pagination, $sort = array(), $format_query, $request);
    }

    /**
     * @param string $status
     * @return array
     *
    */    
    public function getProductsSearch($keywords) {

        $keywords = $keywords != null ? "%".$keywords."%" : "%@@@@%";

        $query = $this->productQuery();
        $query .= "WHERE p.name LIKE ? OR p.description LIKE ? ORDER BY p.id DESC";
        $values = array($keywords, $keywords);
        $response = $this->databaseInstance->getRows($query, $values);

        $response = $this->getProductStatusHistory($response);

        return $this->library->formatResponse($response);
    }

    /**
     * @param string $status
     * @return array
     *
    */    
    public function getRelatedProducts($id) {

        $query = $this->productQuery();
        $query .= " WHERE p.id  != ? ORDER BY RAND() LIMIT 5";
        $values = array($id);   
        $response = $this->databaseInstance->getRows($query, $values);

        return $this->library->formatResponse($response);
    }

    /**
     * @param string $status
     * @return array
     *
    */    
    public function getRecentProducts($id = 0, $limit = 5) {

        $query = $this->productQuery()
            . "WHERE p.id  != ? ORDER BY p.id DESC LIMIT $limit";
        $values = array($id);
        $response = $this->databaseInstance->getRows($query, $values);

        return $this->library->formatResponse($response);
    }

    /**
     * @param string $ids
     * @return array
     *
    */    
    public function getRecommendedProducts($ids) {

        $query = $this->productQuery();
        $query .= " WHERE p.id NOT IN ($ids) ORDER BY RAND() LIMIT 2";
        $values = array();   
        $response = $this->databaseInstance->getRows($query, $values);

        return $this->library->formatResponse($response);
    }

    /**
     * @param int $id
     * @return array
     *
    */    
    public function getProduct($id) {

        $query = $this->productQuery();
        $query .= " WHERE p.id = ? ";
        $values = array($id);
        $response = $this->databaseInstance->getRows($query, $values);
        $response = $this->getProductStatusHistory($response);
        $response = reset($response);

        return $this->library->formatSingleResponse($response);
    }

    /**
     * @param string $status
     * @return array
     *
    */    
    public function getStatus($status = null) {

        if (in_array($status, array(0,1))) {
            $query = "SELECT * from $this->products_status WHERE status = ?";
            $values = array($status);
            $response = $this->databaseInstance->getRow($query, $values);
                
            return $this->library->formatSingleResponse($response);
        }

        $query = "SELECT * from $this->products_status";
        $values = array();
        $response = $this->databaseInstance->getRows($query, $values);
            
        return $this->library->formatResponse($response);
    }

    /**
     * @param string $status
     * @return int
     *
    */    
    public function getProductStatusHistory($response) {

        $results = array(); 
        foreach ($response as $value) {
            $query = "SELECT from_status, description, to_status, admin, date_time 
                from $this->products_status_history where product_id = ?";
            $values = array($value->id);
            $history = $this->databaseInstance->getRows($query, $values);

            $value->status_history = $history;
            array_push($results, $value);
        }

        return $results;
    }

    /**
     * @param int $limit
     * @param int $store_id
     * @return array
     *
    */    
    public function getBestSellingProducts($limit = 10, $from_date = null, $to_date = null) {

        $response = array();
        $offset = 0;
        $a = null;

        $products = $this->getProducts($a, $a, $a, $a, 88); 
        foreach ($products['data'] as $value) {
            // echo json_encode($value->id);exit;
            $result = $this->cartInstance->getCartItemsByProductId($value->id, $from_date, $to_date);
            if ($result['data']) {
                if ($result['data']->product_id) {
                    $value->total_qty = $result['data']->total_qty;
                    $value->total_amount = $result['data']->total_amount;
                    array_push($response, $value);
                }
            }
        }

        $total_qty  = array_column($response, 'total_qty');

        array_multisort($total_qty, SORT_DESC, $response);
        $response = array_slice($response, $offset, $limit);

        return $this->library->formatResponse($response);
    }

    /**
     * @param int $store_id
     * @return array
     *
    */    
    public function getTotalSales($from_date = null, $to_date = null) {

        $response = array();

        $products = $this->getProducts(); 

        $total_sales_amount = 0;
        foreach ($products['data'] as $value) {
            $details = $this->getCartItemsByProductId($value->id, $from_date, $to_date);
            if ($details['data']) 
                $total_sales_amount += $details['data']->total_amount;
        }

        return array(
            'data' => array('total_sales_amount' => $total_sales_amount), 
            'success' => true,
            'message' => 'success'
        );//return response
    }

    /**
     * @param int $store_id
     * @return array
     *
    */    
    public function getTotalProductSold($from_date=null, $to_date =null) {

        $response = array();
        $offset = 0;

        $products = $this->getProducts(); 

        $total_qty_sold = 0;

        foreach ($products['data'] as $value) {
            $details = $this->getCartItemsByProductId($value->id, $from_date, $to_date);
            if ($details['data']) 
                $total_qty_sold += $details['data']->total_qty;
        }

        return array(
            'data' => array('total_qty_sold' => $total_qty_sold), 
            'success' => true,
            'message' => 'success'
        ); //return response
    }

    /**
     * @param int $limit
     * @param datetime $from_date
     * @param datetime $to_date
     * @param int $store_id
     * @return array
     *
    */
    public function getTopViewedItems($limit = 10, $from_date=null, $to_date=null) {

        $total = array();
        $offset = 0;

        $response = array();

        $products = $this->getProducts(); 

        foreach ($products['data'] as $value) {
            $result = $this->getViewedItem($value->id, $from_date, $to_date);
            
            $value->total = 0;
            if ($result) $value->total = $result->total;
            array_push($response, $value);
        }  

        $total  = array_column($response, 'total');

        array_multisort($total, SORT_DESC, $response);
        $response = array_slice($response, $offset, $limit); 

        return array(
            'data' => array('top_viewed_items' => $response), 
            'success' => true,
            'message' => 'success'
        );
    }

    /**
     * @param int $product_id
     * @param datetime $from_date
     * @param datetime $to_date
     * @return array
     *
    */
    public function getViewedItem($product_id, $from_date=null, $to_date=null) {

        $query = "SELECT count(id) AS total FROM $this->viewed_products 
            WHERE product_id = ? ";
        $values = array($product_id);

        if ($from_date) {
            $from_date = date("Y-m-d H:i:s", strtotime($from_date));
            $to_date = $to_date != null 
                ? date("Y-m-d H:i:s", strtotime($to_date)) : date("Y-m-d H:i:s");

            $query = "SELECT count(id) AS total FROM $this->viewed_products 
                WHERE product_id = ? AND date_time >= ? AND date_time <= ?";
            $values = array($product_id, $from_date, $to_date);
        }
        $result = $this->databaseInstance->getRow($query, $values);

        return $this->library->formatSingleResponse($response);
    }

    private function getUuid(){
        return $this->databaseInstance->getRow("SELECT uuid() as uuid", array());
    }

    /**
     * @return array
     *
    */
    public function newProduct($name, $price, $description, $short_desc, $product_off, $discount_start_date, $discount_end_date, $weight, $breadth, $length, $depth, $image_id) { 

        $image_urls = $this->getImages($image_id);
        if (!$image_urls) throw new Exception("No product image uploaded", 1);
        
        $result = $this->getUuid();
        $uuid = $result->uuid;

        if (!$discount_start_date) $discount_start_date = null;
        if (!$discount_end_date) $discount_end_date = null;

        $query = "INSERT into $this->products 
            SET uuid = ?, name = ?, price = ?, description = ?, short_desc = ?, 
            product_off = ?, discount_start_date = ?, discount_end_date = ?, 
            weight = ?, breadth = ?, length = ?, depth = ?, date_time = ?";
        $values = array($uuid, $name, $price, $description, $short_desc, 
            $product_off, $discount_start_date, $discount_end_date, $weight, $breadth, $length, $depth, $this->date_time);
        $product_id = $this->databaseInstance->insertRow($query, $values);

        $this->updateURLTags($product_id, $name);

        $this->updateProductImage($product_id, $image_urls);
        $this->deleteProductImages($image_id);

        if ($product_off && $discount_start_date && $discount_end_date) 
            $this->newDiscountHistory($product_id, $product_off, $discount_start_date, $discount_end_date);

        $result = array(
            "product_id" => $product_id,
            "image_urls" => $image_urls,
            "success" => true, 
            "message" => "Product created successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function editProduct($id, $name, $price, $description, $short_desc, $product_off, $discount_start_date, $discount_end_date, $weight, $breadth, $length, $depth, $image_id) { 

        $response = $this->getProduct($id);              
        if(!$response['data'])
            throw new Exception("Product does not exist");

        $response = $response['data'];
        $image_urls = $this->getImages($image_id);
        if (!$image_urls && !$response->image_urls) 
            throw new Exception("No product image uploaded", 1);

        if (!$discount_start_date) $discount_start_date = null;
        if (!$discount_end_date) $discount_end_date = null;

        $query = "UPDATE $this->products SET 
            name = ?, price = ?, description = ?, short_desc = ?, product_off = ?, discount_start_date = ?, 
            discount_end_date = ?, weight = ?, breadth = ?, length = ?, depth = ? WHERE id = ?";
        $values = array($name, $price, $description, $short_desc, $product_off, $discount_start_date, $discount_end_date, 
            $weight, $breadth, $length, $depth, $id);
        $this->databaseInstance->updateRow($query, $values);

        $this->updateURLTags($id, $name);

        if ($image_urls) {
            if ($response->image_urls) $image_urls = $response->image_urls.'|'.$image_urls;
            $this->updateProductImage($id, $image_urls);
            $this->deleteProductImages($image_id);
        }

        if ($product_off != $response->product_off  || $discount_start_date != $response->discount_start_date || $discount_end_date != $response->discount_end_date) {
            $this->newDiscountHistory($id, $product_off, $discount_start_date, $discount_end_date);
        }
            
        $result = array(
            "product_id" => $id,
            "image_urls" => $image_urls,
            "success" => true, 
            "message" => "Product updated successfully"
        );
        
        return $result;
    }

    /**
     * @param int $id
     * @return array
     *
    */
    public function deleteProduct($id) {

        $result = $this->getProduct($id);
        if (!$result['data']) 
            throw new Exception("Error: Product does not exist");

        $response = $this->cartInstance->getCartByProduct($id);
        if ($response['data']) {
            $query = "UPDATE $this->products SET status = ? WHERE id = ?";
            $this->databaseInstance->updateRow($query, array(5, $id));
        } else {
            $query = "DELETE FROM $this->products WHERE id = ?";
            $this->databaseInstance->deleteRow($query, array($id));

            $query = "DELETE FROM $this->products_status_history WHERE product_id = ?";
            $this->databaseInstance->deleteRow($query, array($id));

            $query = "DELETE FROM $this->product_discount_history WHERE product_id = ?";
            $this->databaseInstance->deleteRow($query, array($id));
        }

        return array(
            "product_id" => $id,
            "name" => $result['data']->name,
            "success" => true,
            "message" => "Operation was successful"
        );
    }

    /**
     * @param int $id
     * @param string $status
     * @return array
     *
    */
    public function updateProductStatus($id, $status, $admin) {

        $product = $this->getProduct($id);
        if (!$product['data']) 
            throw new Exception("Product does not exist");

        $product = $product['data'];

        $result = $this->getStatus($status);
        if (!$result['data']) 
            return false;

        if ($product->status == $status) 
            return false;

        $from_status = $product->status;
        $to_status = $status;

        $query = "UPDATE $this->products SET status = ? WHERE id = ?";
        $values = array($status, $id);
        $this->databaseInstance->updateRow($query, $values);

        $description = "Updated from ".$from_status ." to ". $to_status ." by ". $admin;

        $this->newProductStatus($id, $from_status, $to_status, $description, $admin);

        return array(
            "from_status" => $from_status,
            "to_status"=>$to_status,
            "name"=>$product->name,
            "success"=>true,
            "message"=> "Product(s) status updated to ".strtoupper($result['data']->name)
        );
    }

    /**
     * @return array
     *
    */
    public function newProductStatus($product_id, $from_status, $to_status, $description, $admin) {

        $query = "INSERT INTO $this->products_status_history 
            SET product_id = ?, from_status = ?, to_status = ?, 
            description = ?, admin = ?, date_time = ?";
        $values = array($product_id, $from_status, $to_status, 
            $description, $admin, $this->date_time);
        $response = $this->databaseInstance->insertRow($query, $values);

        return $response;
    }

    /**
     * @return array
     *
    */
    public function updateURLTags($id, $name) {

        $name = strtolower(str_replace([' ','*',"'",'"',',','.','=','+', '&', '(',')','#','@','!','$','%','^','_','~','`',':','>','<','?','/','//','\/','|','}','{','[',']' ], '-', $name));
        $url_tag = strtolower($name).'-'.$id;

        $query = "UPDATE $this->products SET url_tag = ? where id = ?";
        $this->databaseInstance->updateRow($query, array($url_tag, $id));

        return true;
    }

    /**
     * @return array
     *
    */
    public function updateProductImage($id, $image_urls) {

        $query = "UPDATE $this->products SET image_urls = ? WHERE id = ?";
        $values = array($image_urls, $id);
        $this->databaseInstance->updateRow($query, $values);
        
        return true;
    }

    /**
     * @return array
     *
    */
    public function newDiscountHistory($product_id, $discount, $discount_start_date, $discount_end_date) {

        $query = "INSERT INTO $this->product_discount_history SET 
            product_id = ?, discount = ?, discount_start_date = ?, discount_end_date = ?, date_time = ?";
        $values = array($product_id, $discount, $discount_start_date, $discount_end_date, $this->date_time);
        $this->databaseInstance->insertRow($query, $values);
        
        return true;
    }

    /**
     * @return array
     *
    */
    public function getImages($image_id) {

        $query = "SELECT * FROM $this->product_images WHERE image_id = ?";
        $values = array($image_id);
        $response = $this->databaseInstance->getRows($query, $values);

        $image_urls = '';
        foreach ($response as $image) 
            $image_urls .= $image->name.'|';
        
        return rtrim($image_urls, '| ');
    }

    /**
     * @return array
     *
    */
    public function deleteProductImages($image_id) {

        $query = "DELETE FROM $this->product_images WHERE image_id = ?";
        $values = array($image_id);
        $this->databaseInstance->deleteRow($query, $values);
        
        return true;
    }
}