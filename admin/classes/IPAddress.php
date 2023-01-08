<?php

/**
 *
 * @author Redjic Solutions
 * @since September 9, 2022
*/

class IPAddress {

    private $url = 'https://www.iplocate.io/api/lookup/';

    /**
     * @return array
     *
    */
    public function getIPAddressDetails($ip_address = null) {

        if (!$ip_address) $ip_address = $this->getIPAddress();
        
        $details = json_decode(file_get_contents($this->url.$ip_address));
            
        $response = array(
            "country" => isset($details->country) ? $details->country : 'unknown',
            "ip_address" => isset($details->ip) ? $details->ip : 'unknown',
            "province" => isset($details->subdivision) ? $details->subdivision : 'unknown',
            "city" => isset($details->city) ? $details->city : 'unknown',
            "org" => isset($details->org) ? $details->org : 'unknown',
            "latitude" => isset($details->latitude) ? $details->latitude : 'unknown',
            "longitude" => isset($details->longitude) ? $details->longitude : 'unknown',
            "time_zone" => isset($details->time_zone) ? $details->time_zone : 'unknown',
        );

        return (object) $response;
    }

    /**
     * @return array
     *
    */
    public function getIPAddress() {

        $ip_address = "";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip_address=$_SERVER['HTTP_CLIENT_IP'];
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip_address=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip_address=$_SERVER['REMOTE_ADDR'];
        }
        
        return $ip_address;
    }
}