<?php

namespace Settings;

/**
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Invoice {
    
    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }
        
        $this->invoice_settings = $tableNames['invoice_settings'];
        $this->tbl_states = $tableNames['tbl_states'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
    */
    public function getInvoiceSettings() {

        $query = "SELECT * FROM $this->invoice_settings";//SQL command
        $values = array();//SQL command value
        $result = $this->databaseInstance->getRow($query, $values);

        return $this->library->formatSingleResponse($result);
    }

    /**
     * @return array
    */
    public function getInvoiceSettingsById($id) {

        $query = "SELECT * FROM $this->invoice_settings WHERE id = ?";//SQL command
        $values = array($id);//SQL command value
        $result = $this->databaseInstance->getRow($query, $values);

        return $this->library->formatSingleResponse($result);
    }

    /**
     * @return string
     *
    */
    public function uploadLogoURL($imageDestination, $image, $url = null) {

        if(!$url) $url = microtime();
        $uploader = new \ImageUploader($imageDestination, $image, $url);
        $file_name = $uploader->moveUploadedImage();

        return $file_name;
    }

    /**
     * @return array
     *
    */
    public function updateInvoiceSettings($id, $prefix, $image, $path, $imageDestination) {

        $response = $this->getInvoiceSettingsById($id);
        if (!$response['data'])
            throw new \Exception("ID not found");

        $old_logo_name = $response['data']->logo_name;
            
        $logo_name = $this->uploadLogoURL($path, $image);
        $logo_url = $imageDestination.$logo_name;
        
        $query = "UPDATE $this->invoice_settings 
            SET prefix = ?, logo_url = ?, logo_name = ? WHERE id = ?";
        $values = array($prefix, $logo_url, $logo_name, $id);
        $response =  $this->databaseInstance->updateRow($query, $values);

        unlink($path.$old_logo_name);

        return array(
            "data" => array("logo_url" => $logo_url, "id" => $id, "prefix" => $prefix),
            "success" => true, 
            "message" => "Invoice settings updated successfully"
        );
    }

}