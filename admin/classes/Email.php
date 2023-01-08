<?php

/**
* @author Redjic Solutions
 * @since October 17, 2019
*/

class Email {

    public function __construct() {
        $this->personalEmail = new PersonalEmail();
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
         
        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->apiKey = $tableNames['sendgrid_api'];
        $this->email_templates = $tableNames['email_templates'];
        $this->email_title = $tableNames['email_title'];
        
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
     *
    */
    public function getEmailTemplateByType($type) {
        
        $query = "SELECT * FROM $this->email_templates WHERE type = ?";
        $values = array($type);//SQL command value
        $response = $this->databaseInstance->getRow($query, $values);

        return $response;
    }

    public function sendHTMLEmail($from, $to, $subject, $message, $title, $name = null) {

        if ($name != null) $name = ucwords($name);
        $title = str_replace("{name}", $name, $title);
        $html_content = str_replace("{name}", $name, $message);

        // using SendGrid's PHP Library
        require_once __DIR__ .'/../vendor/autoload.php';

        $html_content = $this->personalEmail->personalEmailContent($title, $html_content, $name);

        $from = new SendGrid\Email($this->email_title, $from);
        $to = new SendGrid\Email(strtoupper($name), $to);
        $content = new SendGrid\Content("text/html", $html_content);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $sg = new \SendGrid($this->apiKey);
        $response = $sg->client->mail()->send()->post($mail);
       
        if($response->statusCode() == 202) {
            return true;
        } else return false;
    }

}