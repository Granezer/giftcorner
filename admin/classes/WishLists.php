<?php

/**
 *
 * @author Redjic Solutions
 * @since Febuary 1, 2020
*/

class WishLists {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();
        $this->users = new Users();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->products = $tableNames['products'];
        $this->categories = $tableNames['categories'];
        $this->products_status = $tableNames['products_status'];
        $this->saved_items = $tableNames['saved_items'];

        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @param int $user_id
     * @return array
     *
    */
    public function getWishLists($pagination, $sort, $format_query, $request, $user_id = null) {
        
        $query = "SELECT * FROM $this->saved_items ORDER BY id DESC";
        $values = array();
        if ($user_id) {
            $query ="SELECT * FROM $this->saved_items 
                WHERE user_id = ? ORDER BY id DESC";
            $values = array($user_id);
        }
        $isExist = $this->databaseInstance->getRows($query, $values);

        $response = array();

        foreach ($isExist as $value) {
 
            $item_ids = explode("|", $value->item_ids);
            $date_saved = explode("|", $value->date_saved);
            $user_id = $value->user_id;
            $user_details = $this->users->getUser($user_id);
            $user_details = $user_details['data'];

            $count = 0;

            foreach ($item_ids as $id) {
                $query = "SELECT p.id, name, price, 
                    ps.name AS product_status, product_off, image_urls, p.status, 
                    description, comments, likes, dislikes, url_tag, 
                    DATE_FORMAT(p.date_time, '%D %b %Y %l:%i %p') as date_time 
                    FROM $this->products p 
                    INNER JOIN $this->products_status ps ON p.status=ps.status 
                    WHERE p.id = ? ";
                $values = array($id);
                $result = $this->databaseInstance->getRow($query, $values);

                if ($result) {
                    $result->date_saved = $date_saved[$count];
                    if ($user_details) {
                        $result->fullname = $user_details->fullname;
                        $result->email = $user_details->email;
                        $result->phone = $user_details->phone;
                    }
                    array_push($response, $result); 
                }
                $count++;          
            }
        }

        $date_saved = array();
        foreach ($response as $key => $value) 
            $date_saved[$key] = $value->date_saved;

        array_multisort($date_saved, SORT_DESC, $response);

        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);   
    }
}