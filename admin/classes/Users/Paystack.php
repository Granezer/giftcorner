<?php

namespace Users;

/**
 *
 * @author Redjic Solutions
 * @since February 12, 2020
*/

class Paystack {

    protected $transactionURL = "https://api.paystack.co/transaction/initialize";

    public function __construct() {
        $this->tablesAndKeys = new \TablesAndKeys();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->secret_key = $tableNames['secret_key'];
    }

    /**
     * @param string $url
     * @return array
     *
    */
    public function GETcURL($url) {

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$this->secret_key) );
        // curl_setopt ( $ch, CURLOPT_VERBOSE, true );
        // curl_setopt ( $ch, CURLOPT_HEADER, true );
        $response = curl_exec ( $ch );

        // $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        // $header = substr($response, 0, $header_size);
        // $body = substr($response, $header_size);
        curl_close($ch);  

        return $response;     
    }

    /**
     * @param string $url
     * @param string $data
     * @return array
     *
    */
    public function POSTcURL($url, $data) {

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, 
            array("Authorization: Bearer ".$this->secret_key, 
                "Content-Type: application/json"
            ) 
        );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $response = curl_exec ( $ch );
        curl_close($ch);

        return $response;
    }

    /**
     * @param string $reference
     * @return array
     *
    */
    public function verifyTransaction($reference) {

        $url = "https://api.paystack.co/transaction/verify/".$reference;
        $response = $this->GETcURL($url);

        return json_decode($response, true);
    }

    /**
     * @param string $reason
     * @param double $amount
     * @param string $recipient
     * @return array
     *
    */
    public function initializeTransaction($email, $amount) {

        $reference = substr(
            str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 
            0, 14
        );

        $i = 0; //counter
        while($i < 6){
            //generate a random number between 0 and 9.
            $reference .= mt_rand(0, 9);
            $reference = str_shuffle($reference);
            $i++;
        }

        $amount = $amount * 100;
   
        $data = json_encode(array( 
            "email" => $email,
            "amount" => $amount,
            "reference" => $reference
        ));

        $response = $this->POSTcURL($this->transactionURL, $data);

        return json_decode($response, true);
    }
}