<?php

namespace Users;

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Wishlists {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();
        $this->productInstance = new \Products();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->saved_items = $tableNames['saved_items'];
        $this->saved_products = $tableNames['saved_products'];
    }

    /**
     * @param int $user_id
     * @return array
     *
     *Function that gets saved user's item
    */
    public function getWishlists($user_id) {

        $isExist = $this->itemExist($user_id);
        $response = array();

        if($isExist) {  
            $item_ids = explode("|", $isExist->item_ids);
            $date_saved = explode("|", $isExist->date_saved);
            $count = 0;

            foreach ($item_ids as $id) {
                $result = $this->productInstance->getProduct($id);
                if($result['data']){
                    $count++;
                    array_push($response, $result['data']);
                }           
            }
        } 

        return $this->library->formatResponse($response);   
    }

    /**
     * @param string $user_ses_id
     * @return array
     *
    */
    public function getWishlistsForUnknownUsers($user_ses_id) {
        
        $items = $this->getUnknownUserWishlists($user_ses_id);
        $response = array();

        if($items) {  
            foreach ($items as $item_ids) {
                $id = $item_ids->item_ids;
                $result = $this->productInstance->getProduct($id);
                if($result['data']){
                    array_push($response, $result['data']);
                }           
            }
        }

        return $this->library->formatResponse($response); ;   
    }

    /**
     * @param string $user_ses_id
     * @return array
     *
    */
    public function getUnknownUserWishlists($user_ses_id) {

        $query = "SELECT * from $this->saved_items where user_ses_id = ?";
        $values = array($user_ses_id);
        $response = $this->databaseInstance->getRows($query, $values);

        return $response;    
    }

    /**
     * @param string $user_ses_id
     * @return array
     *
    */
    public function getUnknownUserWishlist($user_ses_id, $product_id) {

        $query = "SELECT * from $this->saved_items where user_ses_id = ? and item_ids = ?";
        $values = array($user_ses_id, $product_id);
        $response = $this->databaseInstance->getRow($query, $values);

        return $response;    
    }

    /**
     * @param int $user_ses_id
     * @return boolean
     *
    */
    public function deleteUnknownUserWishlists($user_ses_id) {

        $query = "DELETE from $this->saved_items where user_ses_id = ?";
        $values = array($user_ses_id);
        $this->databaseInstance->deleteRow($query, $values);

        return true;    
    }

    /**
     * @param int $user_ses_id
     * @param array $item
     * @return boolen
     *
    */
    public function saveWishlistForUnknownUser($user_ses_id, $item) {

        $response = $this->getUnknownUserWishlist($user_ses_id, $item);

        if (!$response) {
            $query = "INSERT into $this->saved_items set user_ses_id = ?, item_ids = ?, date_time = ?";
            $values = array($user_ses_id, $item, date("Y-m-d H:i:s"));
            $this->databaseInstance->insertRow($query, $values); 
         } else {
            $query = "DELETE from $this->saved_items where id = ?";
            $values = array($response->id);
            $this->databaseInstance->deleteRow($query, $values);
         } 

        return true;    
    }


    /**
     * @param int $user_id
     * @param array $item
     * @return boolen
     *
    */
    public function saveWishlist($user_id, $item) {

        $date = date("Y-m-d H:i:s");
        $isExist = $this->itemExist($user_id);
        $items = '';
        $dates = '';
        $status = false;

        if(!$isExist){
            $item = $item.'|';
            $query = "INSERT into $this->saved_items set user_id = ?, item_ids = ?, date_saved = ?, date_time = ?";
            $values = array($user_id, $item, $date.'|', date("Y-m-d H:i:s"));
            $result = $this->databaseInstance->insertRow($query, $values);

            $query = "INSERT IGNORE INTO $this->saved_products 
                SET user_id = ?, product_id = ?, date_time = ?";
            $values = array($user_id, $item, $date);
            $this->databaseInstance->insertRow($query, $values);

            return $result;     

        } else {

            $item_ids = explode("|", $isExist->item_ids);
            $dates_saved = explode("|", $isExist->date_saved);

            $count = 0;
            foreach ($item_ids as $value) {
                if($value != $item) {
                   $items .= $value.'|';
                   $dates .= $dates_saved[$count].'|'; 
                } else {
                    $status = true;
                }
                $count++;
            }

            $items = substr($items, 0, -1);
            $dates = substr($dates, 0, -1);
            if($status == false) {
                $items .= $item.'|';
                $dates .= $date.'|';
            }

            if(!empty($items) and !empty($dates)) {
                $query = "UPDATE $this->saved_items set item_ids = ?, 
                    date_saved = ?, date_time = ? where user_id = ?";
                $values = array($items, $dates, date("Y-m-d H:i:s"), $user_id);
                $result = $this->databaseInstance->updateRow($query, $values);
                if($status == false) {
                    $query = "INSERT IGNORE INTO $this->saved_products 
                        SET user_id = ?, product_id = ?, date_time = ?";
                    $values = array($user_id, $item, $date);
                    $this->databaseInstance->insertRow($query, $values);
                } else {
                    $query = "DELETE from $this->saved_products 
                        where user_id = ? and product_id = ?";
                    $values = array($user_id, $item);
                    $this->databaseInstance->deleteRow($query, $values);
                }

            } else {
                $query = "DELETE from $this->saved_items where user_id = ?";
                $values = array($user_id);
                $result = $this->databaseInstance->deleteRow($query, $values);

                $query = "DELETE from $this->saved_products where user_id = ? and product_id = ?";
                $values = array($user_id, $item);
                $this->databaseInstance->deleteRow($query, $values);
            }       

            $id = $isExist->id;    

            return $id;  
        }
          
    }

    /**
     * update saved tems during login
     * @param int $user_id
     * @param string $device_id
     * @return boolen
     *
    */
    public function updateWishlists($user_id, $device_id) {

        $savedItems = $this->getUnknownUserWishlists($device_id);
        if ($savedItems) {
            $isItemExist = $this->itemExist($user_id);
            $items = explode("|", $isItemExist['item_ids']);
            $date_saved = $isItemExist['date_saved'];
            $item_ids = isset($isItemExist['item_ids']) ? $isItemExist['item_ids']:"";
            $status = false;
            foreach ($savedItems as $row) {
                if(!in_array($row, $items)) {
                    $item_ids .= $row['item_ids']."|";
                    $date_saved .= $row['date_time']."|";
                    $status = true;
                }
            }
            if ($status) {
                $query = "UPDATE $this->saved_items 
                    set item_ids = ?, date_saved = ? WHERE user_id = ?";
                $values = array($item_ids, $date_saved, $user_id);
                $this->databaseInstance->updateRow($query, $values); 

                $this->deleteUnknownUserWishlists($device_id);
            }
        }

        return true;    
    }

    /**
     * @param int $user_id
     * @return array
     *
     *Function that checks if user has saved item before
    */
    public function itemExist($user_id) {
        
        $query = "SELECT * from  $this->saved_items where user_id = ?";
        $values = array($user_id);
        $result = $this->databaseInstance->getRow($query, $values);

        return $result;

    }
}
