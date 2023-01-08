<?php
/**
 * @author Redjic Solutions
 * @since August 09, 2019
*/

class SMS {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }
        
        $this->sms_account = $tableNames['sms_account'];
        $this->sms_response_codes = $tableNames['sms_response_codes'];

        $this->date = $this->tablesAndKeys->getDateTime();
        $this->json_url = $tableNames['ebulk_sms_url'];
    }

    /**
     * @return array
     *
    */
    public function getAllLoginDetails() {

        $query = "SELECT * from $this->sms_account ORDER BY status DESC";
        $result = $this->databaseInstance->getRows($query, array());

        return $result; 
    }

    /**
     * @return array
     *
    */
    public function getLoginDetails() {

        $query = "SELECT * from $this->sms_account where status = 1";
        $result = $this->databaseInstance->getRow($query, array());

        return $result; 
    }

    /**
     * @return array
     *
    */
    public function getLoginDetailsById($id) {

        $query = "SELECT * from $this->sms_account where id = ?";
        $result = $this->databaseInstance->getRow($query, array($id));

        return $result; 
    }

    /**
     * @return array
     *
    */
    public function newLoginDetails($email, $password) {

        $query = "INSERT into $this->sms_account set username = ?, password = ?";
        $values = array($email, $password);
        $id = $this->databaseInstance->insertRow($query, $values);

        return $id;  
    }

    /**
     * @return array
     *
    */
    public function activateLoginDetails($id) {

        $query = "UPDATE $this->sms_account set status = ? where id >= ?";
        $values = array(0, 1);
        $this->databaseInstance->updateRow($query, $values);

        $query = "UPDATE $this->sms_account set status = ? where id = ?";
        $values = array(1, $id);
        $this->databaseInstance->updateRow($query, $values);

        return $id;  
    }

    /**
     * @return array
     *
    */
    public function updateLoginDetails($id, $email, $password) {

        $query = "UPDATE $this->sms_account set username = ?, password = ? 
            where id = ?";
        $values = array($email, $password, $id);
        $this->databaseInstance->updateRow($query, $values);

        return $id;  
    }

    /**
     * @return array
     *
    */
    public function deleteLoginDetails($id) {

        $query = "DELETE from $this->sms_account where id = ?";
        $this->databaseInstance->deleteRow($query, array($id));

        return $id;  
    }

    /**
     * @return array
     *
    */
    public function getSMSResponseDescriptionByCode($response) {

        $error = $response['response']->status;

        $query = "SELECT * from $this->sms_response_codes where code = ?";
        $result = $this->databaseInstance->getRow($query, array($error));

        return $result;
        
    }

    public function sendSMS($recipients, $messagetext, $sendername = "Pure-HC", $flash = 0) {

        $smsAcc = $this->getLoginDetails();
        $username = $smsAcc->username; 
        $apikey = $smsAcc->password;

        $gsm = array();
        $country_code = '234';
        $arr_recipient = explode(',', $recipients);
        foreach ($arr_recipient as $recipient) {
            $mobilenumber = trim($recipient);
            if (substr($mobilenumber, 0, 1) == '0'){
                $mobilenumber = $country_code . substr($mobilenumber, 1);
            }
            elseif (substr($mobilenumber, 0, 1) == '+'){
                $mobilenumber = substr($mobilenumber, 1);
            }
            $generated_id = uniqid('int_', false);
            $generated_id = substr($generated_id, 0, 30);
            $gsm['gsm'][] = array('msidn' => $mobilenumber, 'msgid' => $generated_id);
        }
        $message = array(
            'sender' => $sendername,
            'messagetext' => $messagetext,
            'flash' => "{$flash}",
        );
        $request = array(
            'SMS' => array(
                    'auth' => array(
                    'username' => $username,
                    'apikey' => $apikey
                ),
                'message' => $message,
                'recipients' => $gsm
            )
        );
        $json_data = json_encode($request);
        if ($json_data) {
            $response = $this->doPostRequest($json_data, array('Content-Type: application/json'));
            $result = json_decode($response);
            if (!$result) {
                return false;
            }
            $result = json_decode(json_encode($result), True);

            return $result;
        } else {
            return false;
        }
    }

    //Function to connect to SMS sending server using HTTP POST
    public function doPostRequest($data, $headers = array()) {
        $php_errormsg = '';
        if (is_array($data)) {
            $data = http_build_query($data, '', '&');
        }
        $params = array('http' => array(
            'method' => 'POST',
            'content' => $data)
        );
        if ($headers !== null) {
            $params['http']['header'] = $headers;
        }
        $ctx = stream_context_create($params);
        $fp = fopen($this->json_url, 'rb', false, $ctx);
        if (!$fp) {
            $error = error_get_last()['message'];
            return "Error: gateway is inaccessible";
        }
        //stream_set_timeout($fp, 0, 250);
        try {
            $response = stream_get_contents($fp);
            if ($response === false) {
                throw new Exception("Problem reading data from $this->json_url, $php_errormsg");
            }
            return $response;
        } catch (Exception $error) {
            $response = $error->getMessage();
            return $response;
        }
    }

    public function checkBalance() {

        $smsAcc = $this->getLoginDetails();
        $username = $smsAcc->username; 
        $apikey = $smsAcc->password;
        $apiurl = "http://api.ebulksms.com:8080/balance/$username/$apikey";

        $response = file_get_contents($apiurl);
        if (!$response) {
            $error = error_get_last();
            return array("success" => false, "message" => $error['message']);
        }

        return array("success" => true, "units" => $response);
    }

}