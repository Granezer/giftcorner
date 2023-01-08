<?php

namespace Settings;

/**
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class CompanySettings {
    
    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }
        
        $this->company_info = $tableNames['company_info'];
        $this->tbl_states = $tableNames['tbl_states'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
    */
    public function getCompanySettings() {

        $query = "SELECT * FROM $this->company_info";//SQL command
        $values = array();//SQL command value
        $result = $this->databaseInstance->getRow($query, $values);

        return $this->library->formatSingleResponse($result);
    }

    /**
     * @return array
    */
    public function getCompanySettingsById($id) {

        $query = "SELECT * FROM $this->company_info WHERE id = ?";//SQL command
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
    public function updateLogoSettings($id, $image, $path, $imageDestination) {

        $response = $this->getCompanySettingsById($id);
        if (!$response['data'])
            throw new \Exception("ID not found");

        $old_logo_name = $response['data']->logo_name;
            
        $logo_name = $this->uploadLogoURL($path, $image);
        $logo_url = $imageDestination.$logo_name;
        
        $query = "UPDATE $this->company_info SET logo_url = ?, logo_name = ? WHERE id = ?";
        $values = array($logo_url, $logo_name, $id);
        $response =  $this->databaseInstance->updateRow($query, $values);

        unlink($path.$old_logo_name);

        return array(
            "data" => array("logo_url" => $logo_url, "id" => $id),
            "success" => true, 
            "message" => "Company logo updated successfully"
        );
    }

    /**
     * @return array
     *
    */
    public function updateCompanySettings($name, $contact_person, $mobile, $fax, $email, $phone, $address, $post_code, $city, $state, $country, $website) {

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception("Invalid email format"); 
       }

        $query = "UPDATE $this->company_info
            SET name = ?, contact_person = ?, mobile = ?, fax = ?, email = ?, phone = ?, address = ?, post_code = ?, city = ?, state = ?, country = ?, website = ?, date_time =?";
        $values = array($name, $contact_person, $mobile, $fax, $email, $phone, $address, 
            $post_code, $city, $state, $country, $website, $this->date_time);
        $response =  $this->databaseInstance->updateRow($query, $values);

        return array("success" => true, "message" => "Company settings updated successfully");
    }

}