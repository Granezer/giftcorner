<?php

namespace Users;

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Shipping {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->shipping_addresses = $tableNames['shipping_addresses'];
        $this->tbl_states = $tableNames['tbl_states'];
        $this->tbl_country = $tableNames['tbl_country'];
        $this->shipping_fee = $tableNames['shipping_fee'];
    }

    /**
     * @return string
     *
    */
    public function shippingQuery() {

        $query = "SELECT s.*, c.name AS country, st.name AS state, 
            c.id AS country_id, st.id AS state_id 
            from $this->shipping_addresses s 
            LEFT JOIN $this->tbl_states st ON s.state=st.id 
            INNER JOIN $this->tbl_country c ON s.country=c.id ";

        return $query;
    }

    /**
     * @param int $user_id
     * @return array
     *
    */
    public function getShippingAddresses($user_id) {

        $query = $this->shippingQuery()."where user_id = ? ORDER BY s.status DESC";
        $values = array($user_id);
        $result = $this->databaseInstance->getRows($query, $values);

        return $result;
    }

    /**
     * @param int $id
     * @return array
     *
    */
    public function getShippingAddress($id) {

        $query = $this->shippingQuery()."where s.id = ?";
        $values = array($id);
        $result = $this->databaseInstance->getRow($query, $values);

        if ($result) {
            $result = $this->formatShipping($result);
        }

        return $result;
    }

    /**
     * @param int $id
     * @return array
     *
    */
    public function getDefaultShippingAddress($user_id, $shipping_cost = null) {

        $query = $this->shippingQuery()."where user_id = ? and s.status = ?";
        $values = array($user_id, 1);
        $result = $this->databaseInstance->getRow($query, $values);

        if ($result) {
            $result = $this->formatShipping($result);
        }

        return $result;
    }

    /**
     * @return array
     *
    */
    public function formatShipping($result) {
        $state = $result->state;
        $country = $result->country;
        $free_states = array("lagos", "fct", "benue");
        $weight = 2; $shipping = null;

        if (!empty($state) and !in_array(strtolower($state), $free_states)) {
            $shippingCost = new \Settings\States();
            $shipping = $shippingCost->getStatePriceByWeight($state, $weight);

        } elseif ($country and strtolower($country) != "nigeria") {
            $shippingCost = new \Settings\Country();
            $shipping = $shippingCost->getCountryPriceByWeight($country, $weight);
        } else {
            $result->price = 0;
            $result->amount = "Free Shipping";
            $result->weight = 2;
        }

        if ($shipping) {
            $result->price = $shipping->price;
            $result->amount = $shipping->amount;
            $result->weight = $shipping->weight;
        }

        return $result;
    }

    /**
     * @param int $user_id
     * @param string $first_name
     * @param string $last_name
     * @param string $address
     * @return array
     *
    */
    public function getUserShippingAddress($user_id, $first_name, $last_name, $address, $id = 0) {

        $query = "SELECT * from $this->shipping_addresses 
            where user_id = ? and first_name = ? and 
            last_name = ? and address = ?";
        if ($id > 0) $query .= " and id != $id";
        $values = array($user_id, $first_name, $last_name, $address);
        $result = $this->databaseInstance->getRow($query, $values);

        return $result;
    }

    /**
     * @param int $user_id
     * @param string $first_name
     * @param string $last_name
     * @param string $company_name
     * @param string $country
     * @param string $state
     * @param string $city
     * @param string $address
     * @param string $postcode
     * @param string $email
     * @param string $phone
     * @return int
     *
    */ 
    public function setShippingAddress($user_id, $first_name, $last_name, $company_name, $country, 
        $state, $city, $address, $postcode, $email, $phone) {

        $checkDetails = $this->getUserShippingAddress($user_id, $first_name, $last_name, $address);
        if ($checkDetails) throw new \Exception("Shipping added before");

        $status = 0;
        $response = $this->getShippingAddresses($user_id);
        if (!$response) $status = 1;
        
        $date = date("Y-m-d H:i:s");
        $query = "INSERT into $this->shipping_addresses 
            set user_id = ?, first_name = ?, last_name = ?, company_name = ?, 
            country = ?, state = ?, city = ?, address = ?, postcode = ?, 
            email = ?, phone = ?, date_time = ?, status = ?";
        $values = array($user_id, $first_name, $last_name, $company_name, 
            $country, $state, $city, $address, $postcode, $email, $phone, 
            $date, $status);
        $result = $this->databaseInstance->insertRow($query, $values);

        return $result;
    }

    /**
     * @param int $user_id
     * @param int $id
     * @param string $first_name
     * @param string $last_name
     * @param string $company_name
     * @param string $country
     * @param string $state
     * @param string $city
     * @param string $address
     * @param string $postcode
     * @param string $email
     * @param string $phone
     * @return int
     *
    */ 
    public function editShippingAddress($user_id, $id, $first_name, $last_name, $company_name, $country, $state, $city, $address, $postcode, $email, $phone) {

        $response = $this->getUserShippingAddress($user_id, $first_name, $last_name, $address, $id);
        if ($response) throw new \Exception("Shipping added before");

        $response = $this->getShippingAddress($id);
        if (!$response) throw new \Exception("Shipping address not found");

        if ($response->user_id != $user_id)
            throw new Exception("Something went wrong");
            
        $query = "UPDATE $this->shipping_addresses 
            set first_name = ?, last_name = ?, company_name = ?, country = ?, 
            state = ?, city = ?, address = ?, postcode = ?, email = ?, phone = ? where id = ?";
        $values = array($first_name, $last_name, $company_name, $country, 
            $state, $city, $address, $postcode, $email, $phone, $id);
        $result = $this->databaseInstance->updateRow($query, $values);

        return $result;
    }

    /**
     * @param int $user_id
     * @param int $id
     * @return int
     *
    */ 
    public function setShippingAddressAsDefault($user_id, $id) {

        $checkDetails = $this->getShippingAddress($id);
        if (!$checkDetails) throw new \Exception("Shipping address not found");
        
        $query = "UPDATE $this->shipping_addresses set status = ? where user_id = ?";
        $this->databaseInstance->updateRow($query, array(0, $user_id));

        $query = "UPDATE $this->shipping_addresses set status = ? 
        where id = ? and user_id = ?";
        $result = $this->databaseInstance->updateRow($query, array(1, $id, $user_id));

        if (!$result) throw new \Exception("Shipping address not found");

        return $result;
    }

    /**
     * @param int $user_id
     * @param int $id
     * @return int
     *
    */ 
    public function deleteShippingAddress($user_id, $id) {
        
        $address = $this->getShippingAddress($id);

        $query = "DELETE from $this->shipping_addresses 
            where user_id = ? and id = ?";
        $values = array($user_id, $id);
        $result = $this->databaseInstance->deleteRow($query, $values);

        if (!$result) throw new \Exception("unable to delete");

        $response = $this->getShippingAddresses($user_id);
        if (count($response) == 1 || (count($response) > 1 and $address->status == 1)) {
            $status = 1;
            $query = "UPDATE $this->shipping_addresses set status = ? 
                where user_id = ? LIMIT 1";
            $this->databaseInstance->updateRow($query, array($status, $user_id));
        } 
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function getShippingFee($name) {

        $query = "SELECT * from $this->shipping_fee where name = ?";
        $values = array($name);
        $response = $this->databaseInstance->getRow($query, $values);

        return $response;
    }
}