<?php

namespace Users;
    
/**
 * This class authenticate users before logging them in
 *
 * @author DiamondScripts Limited
 * @since April 16, 2018
*/

class Login{

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->ipAddressInstance = new \IPAddress();
        $this->logAttemptInstance = new \LoginAttempts();
        $this->userInstance = new \Users();
        $this->userLogs = new UserLogs();
        $this->wishlists = new Wishlists();
        $this->carts = new Carts();

        $tableNames = $this->tablesAndKeys->getTableNames();
    
        if (!is_array($tableNames))
            throw new \Exception("Can't access the table names");

        $this->unknown_users = $tableNames['unknown_users'];
    }
    
    /**
     * @param int $email
     * @param string $password
     * @param string $transaction_id
     * @param string $device_id
     * @return boolean
     *
     *Function to login a user
    */
    public function loginUsers($email, $password, $device_id, $device_name, $registration_type = null) {

        $phoneExist = $this->userLogs->checkUserLoginState($device_id, $device_name);

        if ($phoneExist) {
            $this->userLogs->setUserId($phoneExist->user_id);
            $login_id = $phoneExist->id;
            $this->userLogs->logoutSession($login_id);
        }

        $no = 2;
        $attempts = $this->logAttemptInstance->checkLoginAttempt();
        if ($attempts) $no = $no - $attempts;

        $canUserLogin = $this->userInstance->getUserByEmail($email);
        $canUserLogin = $canUserLogin['data'];
        
        if(!$canUserLogin) {
            $this->logAttemptInstance->logAttempt();
            throw new \Exception("Invalid login details. Your email/password is not correct. You have ".$no." attempts left");
        }

        if(!password_verify($password, $canUserLogin->password)) {
            $this->logAttemptInstance->logAttempt();
            throw new \Exception("Invalid login details. Your email/password is not correct. You have ".$no." attempts left");
        }

        if($canUserLogin->status != 0) 
            throw new \Exception("Oops! Your account has been deactivated");

        if(password_needs_rehash($canUserLogin->password, PASSWORD_DEFAULT)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $this->userInstance->updatePassword($email, $password);
        }

        if ($registration_type) 
            if ($canUserLogin->registration_type != $registration_type)
                throw new \Exception("This email ($email) has already been registered using another platform");
        
        if ($canUserLogin) {
            
            //assign user_id value of user to the variable
            $user_id = $canUserLogin->id;

            $user_ses_id = $this->getUserIdSession();//Assign user_id of user to session
            
            $login_id = $this->userLogs->loginSession($user_id, $user_ses_id, $device_id, $device_name);

            // update wishlist
            $this->wishlists->updateWishlists($user_id, $device_id);

            // update cart items
            $this->carts->updateCartSession($user_id, $device_id, $user_ses_id);
 
            $canUserLogin->user_id = $user_id;
            $canUserLogin->user_ses_id = $user_ses_id;
            $canUserLogin->login_id = $login_id;

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_ses_id'] = $user_ses_id;
            
            $_SESSION['login_id'] = $login_id;
            $_SESSION['profile_image_url'] = $canUserLogin->profile_image_url;
            $_SESSION['fullname'] = $canUserLogin->fullname;
            $_SESSION['email'] = $canUserLogin->email; 
            $_SESSION['phone'] = $canUserLogin->phone;  
            $_SESSION['gender'] = $canUserLogin->gender;

            $time = time() + (10 * 365 * 24 * 60 * 60);
            setcookie("user_id",$user_id, $time, '/');
            setcookie("user_ses_id", $user_ses_id, $time, '/');

            $this->logAttemptInstance->deleteAttempts();

            return $canUserLogin;  
            
        } else {
            throw new \Exception("Invalid Login details");
        }
        
    }

    /**
     * 
     * @return string
     *
     *function that generate user session id
        */
    public function getUserIdSession() {

        session_regenerate_id();

        return session_id();
    }    
}