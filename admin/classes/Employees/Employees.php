<?php

namespace Employees;

/**
 *
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Employees {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames))
            throw new \Exception("Can't access the table names");

        $this->employees = $tableNames['employees'];
        $this->tbl_states = $tableNames['tbl_states'];
        $this->tbl_lga = $tableNames['tbl_lga'];
        $this->departments = $tableNames['departments'];
        $this->designations = $tableNames['designations'];
        $this->employee_bank = $tableNames['employee_bank'];
        $this->employee_family_info = $tableNames['employee_family_info'];
        $this->tbl_country = $tableNames['tbl_country'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
     *
    */
    public function getEmployees($pagination, $sort, $format_query, $request) {
        
        $query = "SELECT e.*, l.name AS lga, s.name AS state, dept.name AS department, 
            b.bank_name, b.acc_name, b.acc_no, b.bank_sort_code 
            FROM $this->employees e 
            LEFT JOIN $this->tbl_states s ON e.state=s.id 
            LEFT JOIN $this->tbl_lga l ON e.lga=l.id 
            LEFT JOIN $this->departments dept ON e.department=dept.id 
            LEFT JOIN $this->employee_bank b ON e.id=b.employee_id 
            ORDER BY e.id ASC";
        $values = array();
        $response = $this->databaseInstance->getRows($query, $values);
        
        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);
    }

    /**
     * @return array
     *
    */
    public function getRecentEmployees() {
        
        $query = "SELECT e.*, l.name AS lga, s.name AS state, dept.name AS department, 
            b.bank_name, b.acc_name, b.acc_no, b.bank_sort_code 
            FROM $this->employees e 
            LEFT JOIN $this->tbl_states s ON e.state=s.id 
            LEFT JOIN $this->tbl_lga l ON e.lga=l.id 
            LEFT JOIN $this->departments dept ON e.department=dept.id 
            LEFT JOIN $this->employee_bank b ON e.id=b.employee_id 
            ORDER BY e.id DESC LIMIT 5";
        $values = array();
        $response = $this->databaseInstance->getRows($query, $values);
        
        return $this->library->formatResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getEmployeeById($employee_id) {
        
        $query = "SELECT e.*, l.name AS lga, s.name AS state, dept.name AS department, 
            dept.id AS department_id, 
            b.bank_name, b.acc_name, b.acc_no, b.bank_sort_code, l.id AS lga_id, s.id AS state_id, 
            c.name AS nationality 
            FROM $this->employees e 
            LEFT JOIN $this->tbl_states s ON e.state=s.id 
            LEFT JOIN $this->tbl_lga l ON e.lga=l.id 
            LEFT JOIN $this->tbl_country c ON e.country=c.id 
            LEFT JOIN $this->departments dept ON e.department=dept.id 
            LEFT JOIN $this->employee_bank b ON e.id=b.employee_id  
            WHERE e.id = ?";
        $response =  $this->databaseInstance->getRow($query, array($employee_id));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getEmployeeByEmail($email) {
        
        // $query = "SELECT * FROM $this->employees WHERE email = ?";
        $query = "SELECT e.* FROM $this->employees e WHERE e.email = ?";
        $response = $this->databaseInstance->getRow($query, array($email));
        
        return $response;
    }

    /**
     * @return array
     *
    */
    public function getEmployeeByUuid($uuid) {
        
        $query = "SELECT e.*, l.name AS lga, s.name AS state, dept.name AS department, 
            dept.id AS department_id, 
            b.bank_name, b.acc_name, b.acc_no, b.bank_sort_code, l.id AS lga_id, s.id AS state_id, 
            c.name AS nationality 
            FROM $this->employees e 
            LEFT JOIN $this->tbl_states s ON e.state=s.id 
            LEFT JOIN $this->tbl_lga l ON e.lga=l.id 
            LEFT JOIN $this->tbl_country c ON e.country=c.id 
            LEFT JOIN $this->departments dept ON e.department=dept.id 
            LEFT JOIN $this->employee_bank b ON e.id=b.employee_id  
            WHERE e.uuid = ?";
        $response =  $this->databaseInstance->getRow($query, array($uuid));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getEmployeeByIDNo($employee_id_no) {
        
        $query = "SELECT * FROM $this->members WHERE employee_id_no = ?";
        $response = $this->databaseInstance->getRow($query, array($employee_id_no));
        
        return $response;
    }

    /**
     * @return array
     *
    */
    public function getEmployeeByUsername($username) {
        
        $query = "SELECT * FROM $this->employees WHERE username = ?";
        $response = $this->databaseInstance->getRow($query, array($username));
        
        return $response;
    }

    /**
     * @return array
     *
    */
    public function getEmployeeByPhone($phone1) {
        
        $query = "SELECT * FROM $this->employees WHERE phone1 = ?";
        $response = $this->databaseInstance->getRow($query, array($phone1));
        
        return $response;
    }

    /**
     * @return array
     *
    */
    public function getEmployeeBankByAccNoAndBankName($acc_no, $bank_name) {
        
        $query = "SELECT * FROM $this->employee_bank 
            WHERE (bank_name = ? AND acc_no = ?) OR acc_no = ?";
        $response = $this->databaseInstance->getRow($query, array($bank_name, $acc_no, $acc_no));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getEmployeeBank($employee_id) {
        
        $query = "SELECT * FROM $this->employee_bank WHERE employee_id = ?";
        $response = $this->databaseInstance->getRow($query, array($employee_id));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getEmployeeFamilyMembers($employee_id) {
        
        $query = "SELECT * FROM $this->employee_family_info WHERE employee_id = ?";
        $response = $this->databaseInstance->getRows($query, array($employee_id));
        
        return $this->library->formatResponse($response);;
    }

    /**
     * @return array
     *
    */
    public function getEmployeeFamilyMemberById($id) {
        
        $query = "SELECT * FROM $this->employee_family_info WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));
        
        return $this->library->formatSingleResponse($response);;
    }

    /**
     * @return array
     *
    */
    public function getEmployeeFamilyMemberByNameOrPhone($employee_id, $name, $phone) {
        
        $query = "SELECT * FROM $this->employee_family_info 
            WHERE employee_id = ? AND (name = ? OR phone = ?)";
        $response = $this->databaseInstance->getRows($query, array($employee_id, $name, $phone));
        
        return $this->library->formatSingleResponse($response);;
    }

    /**
     * @return array
     *
    */
    public function updatePassword($email, $password) {
        
        $query = "UPDATE $this->employees set password = ? WHERE email = ?";
        $values = array($email, $password);
        $response = $this->databaseInstance->updateRow($query, $values);
        
        return $response;
    }
    
    /**
     * @param string $email
     * @return boolean
     *
    */    
    public function isValidEmail($email){
        //e.g info@diamondscripts.ng
         if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;

        throw new \Exception("Invalid email address");
    }

    private function getUuid(){
        return $this->databaseInstance->getRow("SELECT uuid() as uuid", array());
    }

    /**
     * @return array
     *
    */
    public function newEmployee($title, $first_name, $last_name, $gender, $marital_status, $dob, $place_of_birth, $email, $phone1, $phone2, $address1, $address2, $post_code, $city, $state, $lga, $country, $contact_name, $contact_address, $contact_phone, $contact_email, $contact_relationship, $joined_date, $designation, $department, $acc_name, $acc_no, $bank_name, $bank_sort_code, $referee_name_1, $referee_address_1, $referee_phone_1, $referee_occupation_1, $referee_name_2, $referee_address_2, $referee_phone_2, $referee_occupation_2, $image, $imageDestination, $path) { 

        $this->isValidEmail($email);
        $this->isValidEmail($contact_email);

        $response = $this->getEmployeeByEmail($email);                   
        if($response)
            throw new \Exception("Email address provided already exist");

        $response = $this->getEmployeeByPhone($phone1);                   
        if($response)
            throw new \Exception("Phone no already exist");

        $password = $this->library->generateCode(8);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $uploader = new \ImageUploader(
            $path, 
            $image,  
            microtime(), 
            array("image/jpeg", "image/png")
        );
        $profile_image_name = $uploader->moveUploadedImage();
        $profile_image = $imageDestination.$profile_image_name;

        $result = $this->getUuid();
        $uuid = $result->uuid;

        $query = "INSERT into $this->employees 
            set title = ?, first_name = ?, last_name = ?, gender = ?, marital_status = ?, dob = ?, place_of_birth = ?, email = ?, 
            phone1 = ?, phone2 = ?, address1 = ?, address2 = ?, post_code = ?, city = ?, state = ?, lga = ?, 
            country = ?, contact_name = ?, contact_address = ?, contact_phone = ?, contact_email = ?, 
            contact_relationship = ?, joined_date = ?, department = ?, password = ?, profile_image = ?, 
            profile_image_name = ?, date_time = ?, uuid = ?, referee_name_1 = ?, referee_address_1 = ?, 
            referee_phone_1 = ?, referee_occupation_1 = ?, referee_name_2 = ?, referee_address_2 = ?, 
            referee_phone_2 = ?, referee_occupation_2 = ?";
        $values = array($title, $first_name, $last_name, $gender, $marital_status, $dob, $place_of_birth, $email, 
            $phone1, $phone2, $address1, $address2, $post_code, $city, $state, $lga, $country, 
            $contact_name, $contact_address, $contact_phone, $contact_email, $contact_relationship, 
            $joined_date, $department, $hashed_password, $profile_image, $profile_image_name, 
            $this->date_time, $uuid, $referee_name_1, $referee_address_1, $referee_phone_1, $referee_occupation_1, $referee_name_2, $referee_address_2, $referee_phone_2, $referee_occupation_2);
        $employee_id = $this->databaseInstance->insertRow($query, $values);

        $this->updateEmployeeId($employee_id);
        $this->newBank($acc_name, $acc_no, $bank_name, $bank_sort_code, $employee_id);

        $result = array(
            "employee_id" => $employee_id,
            "password" => $password,
            "success" => true, 
            "message" => "Account created successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function updateBasicInfo($title, $first_name, $last_name, $gender, $marital_status, $place_of_birth, $dob, $image, $imageDestination, $path, $employee_id) { 

        $response = $this->getEmployeeById($employee_id);                   
        if(!$response['data']) 
            throw new \Exception("Employee does not exist");

        $profile_image_name = $response['data']->profile_image_name;
        $profile_image = $response['data']->profile_image;

        if ($image) {
            $uploader = new \ImageUploader(
                $path, 
                $image, 
                microtime(), 
                array("image/jpeg", "image/png")
            );
            $file_name = $uploader->moveUploadedImage();
            if ($file_name) {
                if ($profile_image_name) unlink($path.$profile_image_name);
                $profile_image_name = $file_name;
                $profile_image = $imageDestination.$profile_image_name;
            }
                
        }
            
        $query = "UPDATE $this->employees 
            set title = ?, first_name = ?, last_name = ?, gender = ?, place_of_birth = ?, dob = ?, 
            marital_status = ?, profile_image = ?, profile_image_name = ? WHERE id = ?";
        $values = array($title, $first_name, $last_name, $gender, $place_of_birth, $dob, 
            $marital_status, $profile_image, $profile_image_name, $employee_id);
        $this->databaseInstance->updateRow($query, $values);

        $response = $this->getEmployeeById($employee_id); 
        $result = array(
            "data" => $response['data'],
            "success" => true, 
            "message" => "Basic info updated successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function updateContactInfo($phone1, $phone2, $email, $address1, $address2, $post_code, $city, $lga, $state, $country, $employee_id) { 

        $response = $this->getEmployeeById($employee_id);                   
        if(!$response['data']) 
            throw new \Exception("Employee does not exist");

        $this->isValidEmail($email);
        $response = $this->getEmployeeByEmail($email);                   
        if($response)
            if ($response->id != $employee_id)
                throw new \Exception("Email address provided already exist");

        $response = $this->getEmployeeByPhone($phone1);                   
        if($response)
            if ($response->id != $employee_id)
                throw new \Exception("Phone no already exist");
            
        $query = "UPDATE $this->employees 
            set  phone1 = ?, phone2 = ?, email = ?, address1 = ?, address2 = ?, 
            post_code = ?, city = ?, lga = ?, state = ?, country = ? WHERE id = ?";
        $values = array($phone1, $phone2, $email, $address1, $address2, $post_code, $city, $lga, $state, $country, $employee_id);
        $this->databaseInstance->updateRow($query, $values);

        $response = $this->getEmployeeById($employee_id); 
        $result = array(
            "data" => $response['data'],
            "success" => true, 
            "message" => "Contact info updated successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function updateEmergencyInfo($contact_name, $contact_phone, $contact_email, $contact_address, $contact_relationship, $employee_id) { 

        $response = $this->getEmployeeById($employee_id);                   
        if(!$response['data']) 
            throw new \Exception("Employee does not exist");

        $query = "UPDATE $this->employees 
            set contact_name = ?, contact_phone = ?, contact_email = ?, contact_address = ?, 
            contact_relationship = ? WHERE id = ?";
        $values = array($contact_name, $contact_phone, $contact_email, $contact_address, 
            $contact_relationship, $employee_id);
        $this->databaseInstance->updateRow($query, $values);

        $result = array(
            "success" => true, 
            "message" => "Emergency info updated successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function updateRefereeInfo($referee_name_1, $referee_address_1, $referee_phone_1, $referee_occupation_1, $referee_name_2, $referee_address_2, $referee_phone_2, $referee_occupation_2, $employee_id) { 

        $response = $this->getEmployeeById($employee_id);                   
        if(!$response['data']) 
            throw new \Exception("Employee does not exist");

        $query = "UPDATE $this->employees 
            set referee_name_1 = ?, referee_address_1 = ?, referee_phone_1 = ?, referee_occupation_1 = ?, 
            referee_name_2 = ?, referee_address_2 = ?, referee_phone_2 = ?, referee_occupation_2 = ? WHERE id = ?";
        $values = array($referee_name_1, $referee_address_1, $referee_phone_1, $referee_occupation_1, $referee_name_2, $referee_address_2, $referee_phone_2, $referee_occupation_2, $employee_id);
        $this->databaseInstance->updateRow($query, $values);

        $result = array(
            "success" => true, 
            "message" => "Referee info updated successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function updateOtherInfo($department, $joined_date, $engagement_date, $employee_id) { 

        $response = $this->getEmployeeById($employee_id);                   
        if(!$response['data']) 
            throw new \Exception("Employee does not exist");

        $query = "UPDATE $this->employees 
            set department = ?, joined_date = ?, engagement_date = ? WHERE id = ?";
        $values = array($department, $joined_date, $engagement_date, $employee_id);
        $this->databaseInstance->updateRow($query, $values);

        $result = array(
            "success" => true, 
            "message" => "Other info updated successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function updateEmployeeId($employee_id) {

        $employee_id_no = 'GC-0000'.$employee_id;
        if (strlen($employee_id) == 3) 
            $employee_id_no = 'GC-00'.$employee_id;
        elseif (strlen($employee_id) == 2)
            $employee_id_no = 'GC-000'.$employee_id; 

        $query = "UPDATE $this->employees set employee_id_no = ? WHERE id = ?";
        $values = array($employee_id_no, $employee_id);
        $this->databaseInstance->updateRow($query, $values);
        
        return true;
    }

    /**
     * @return array
     *
    */
    public function newBank($acc_name, $acc_no, $bank_name, $bank_sort_code, $employee_id) { 

        $response = $this->getEmployeeBankByAccNoAndBankName($acc_no, $bank_name);                   
        if($response['data']) {
            throw new \Exception("Bank details already exist");
        }

        $query = "INSERT into $this->employee_bank 
            set acc_name = ?, acc_no = ?, bank_name = ?, bank_sort_code = ?, employee_id = ?, date_time = ?";
        $values = array($acc_name, $acc_no, $bank_name, $bank_sort_code, $employee_id, $this->date_time);
        $bank_details_id = $this->databaseInstance->insertRow($query, $values);

        $response = $this->getEmployeeBank($employee_id);

        $result = array(
            "data" => $response['data'],
            "bank_details_id" => $bank_details_id,
            "success" => true, 
            "message" => "Bank added successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function updateBank($acc_name, $acc_no, $bank_name, $bank_sort_code, $employee_id) { 

        $response = $this->getEmployeeBankByAccNoAndBankName($acc_no, $bank_name);                   
        if($response['data']) {
            if ($response['data']->employee_id != $employee_id) 
                throw new \Exception("Bank details already exist");
        }

        $response = $this->getEmployeeBank($employee_id);
        if (!$response['data']) 
            return $this->newBank($acc_name, $acc_no, $bank_name, $bank_sort_code, $employee_id);

        $query = "UPDATE $this->employee_bank 
            set acc_name = ?, acc_no = ?, bank_name = ?, bank_sort_code = ? WHERE employee_id = ?";
        $values = array($acc_name, $acc_no, $bank_name, $bank_sort_code, $employee_id);
        $this->databaseInstance->updateRow($query, $values);

        $response = $this->getEmployeeBank($employee_id);

        $result = array(
            "data" => $response['data'],
            "success" => true, 
            "message" => "Bank updated successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function newFamilyMember($name, $phone, $address, $relationship, $employee_id) { 

        $response = $this->getEmployeeFamilyMemberByNameOrPhone($employee_id, $name, $phone);                   
        if($response['data']) {
            throw new \Exception("Family member already exist");
        }

        $query = "INSERT into $this->employee_family_info
            set name = ?, phone = ?, address = ?, relationship = ?, employee_id = ?, date_time = ?";
        $values = array($name, $phone, $address, $relationship, $employee_id, $this->date_time);
        $family_member_id = $this->databaseInstance->insertRow($query, $values);

        $result = array(
            "family_member_id" => $family_member_id,
            "success" => true, 
            "message" => "Family Member added successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function updateFamilyMember($name, $phone, $address, $relationship, $employee_id, $family_member_id) { 

        $response = $this->getEmployeeFamilyMemberByNameOrPhone($employee_id, $name, $phone);                   
        if($response['data']) {
            if ($response['data']->id != $family_member_id)
                throw new \Exception("Family member already exist");
        }

        $query = "UPDATE $this->employee_family_info
            set name = ?, phone = ?, address = ?, relationship = ? WHERE employee_id = ?";
        $values = array($name, $phone, $address, $relationship, $employee_id);
        $this->databaseInstance->updateRow($query, $values);

        $result = array(
            "success" => true, 
            "message" => "Family Member added successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function deleteFamilyMember($employee_id, $family_member_id) { 

        $response = $this->getEmployeeFamilyMemberById($employee_id, $family_member_id);                   
        if(!$response['data']) {
            throw new \Exception("Family member does not exist");
        }

        $query = "DELETE FROM $this->employee_family_info WHERE employee_id = ? AND id = ?";
        $values = array($employee_id, $family_member_id);
        $this->databaseInstance->deleteRow($query, $values);

        $result = array(
            "success" => true, 
            "name" => $response['data']->name,
            "message" => "Family Member deleted successfully"
        );
        
        return $result;
    }

    /**
     * @return array
     *
    */
    public function resetEmployeePassword($uuid) {

        $response = $this->getEmployeeByUuid($uuid);
        if (!$response['data']) throw new \Exception("Employee not found");

        $password = $this->library->generateCode(8);
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE $this->employees SET password = ? WHERE uuid = ?";
        $values = array($hash_password, $uuid);
        $this->databaseInstance->updateRow($query, $values);

        if ($response['data']->email) {
            $emailInstance = new \Email();
            $emailDetails = $emailInstance->getEmailTemplateByType("change of password");
            if ($emailDetails) {
                $title = $emailDetails->title;
                $content = $emailDetails->content;
                $from = $emailDetails->from_email;
                $first_name = explode(" ", $response['data']->first_name);

                $content = str_replace("{date}",date("l jS M, Y g:iA"),$content);
                $content = str_replace("{email}", $response['data']->email, $content);
                $content = str_replace("{password}", $password, $content);
                $subject = " Password Reset";
                $emailInstance->sendHTMLEmail($from, $response['data']->email, $subject, $content, $title, $first_name[0]);
            }
        }

        $response = array(
            "uuid" => $uuid,
            "password" => $password,
            "success" => true, 
            "message" => "Password reset was successful"
        );

        return $response;
    }
}