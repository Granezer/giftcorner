<?php

namespace Settings;

/**
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Roles {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->roles = $tableNames['roles'];
        $this->employees = $tableNames['employees'];
        $this->roles_and_module_access = $tableNames['roles_and_module_access'];
        $this->module_access = $tableNames['module_access'];
        $this->module_permission = $tableNames['module_permission'];
        $this->roles_and_permissions = $tableNames['roles_and_permissions'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
    */
    public function getRoles() {

        $query = "SELECT * FROM $this->roles ";
        $values = array();
        $response = $this->databaseInstance->getRows($query, $values);
        
        return $this->library->formatResponse($response, $pagination = array(), $sort = array("sort" => "asc"));
    }

    /**
     * @return array
    */
    public function getRole($id) {

        $query = "SELECT * FROM $this->roles WHERE id = ?";
        $values = array($id);
        $response = $this->databaseInstance->getRow($query, $values);
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
    */
    public function getRoleByName($name) {

        $query = "SELECT * FROM $this->roles WHERE name = ?";
        $values = array($name);
        $response = $this->databaseInstance->getRow($query, $values);
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * gets role and module accesses
     * @return array
    */
    public function getRoleModuleAccesses($role_id) {

        $query = "SELECT r.name, ma.name AS module_name, rm.*  
            FROM $this->roles r 
            INNER JOIN $this->roles_and_module_access rm ON r.id=rm.role_id 
            INNER JOIN $this->module_access ma ON rm.module_access_id=ma.id 
            WHERE r.id = ?";
        $values = array($role_id);
        $results = $this->databaseInstance->getRows($query, $values);

        $response = array();
        foreach ($results as $value) {
            $result = $this->getRoleModuleAccessPermissions($role_id, $value->module_access_id);
            $value->module_access = $result['data'];
            array_push($response, $value);
        }
        
        return $this->library->formatResponse($response);
    }

    /**
     * gets role and module accesses
     * @return array
    */
    public function getRoleModuleAccess($role_id, $module_access_id) {

        $query = "SELECT r.name, ma.name AS module_name, rm.*  
            FROM $this->roles r 
            INNER JOIN $this->roles_and_module_access rm ON r.id=rm.role_id 
            INNER JOIN $this->module_access ma ON rm.module_access_id=ma.id 
            WHERE r.id = ? AND module_access_id = ?";
        $values = array($role_id, $module_access_id);
        $response = $this->databaseInstance->getRow($query, $values);
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * gets role, module access and permissions
     * @return array
    */
    public function getRoleModuleAccessPermissions($role_id, $module_access_id) {

        $query = "SELECT rp.*, r.name, ma.name AS module_name, mp.name AS module_permission_name  
            FROM $this->roles_and_permissions rp 
            INNER JOIN $this->roles r ON rp.role_id=r.id 
            INNER JOIN $this->module_access ma ON rp.module_access_id=ma.id 
            INNER JOIN $this->module_permission mp ON rp.module_permission_id=mp.id
            WHERE rp.role_id = ? AND rp.module_access_id = ?";
        $values = array($role_id, $module_access_id);
        $response = $this->databaseInstance->getRows($query, $values);
        
        return $this->library->formatResponse($response);
    }

    /**
     * gets role, module access and permission
     * @return array
    */
    public function getRoleModuleAccessPermission($role_id, $module_access_id, $module_permission_id) {

        $query = "SELECT rp.*, r.name, ma.name AS module_name, mp.name AS module_permission_name  
            FROM $this->roles_and_permissions rp 
            INNER JOIN $this->roles r ON rp.role_id=r.id 
            INNER JOIN $this->module_access ma ON rp.module_access_id=ma.id 
            INNER JOIN $this->module_permission mp ON rp.module_permission_id=mp.id
            WHERE rp.role_id = ? AND rp.module_access_id = ? AND module_permission_id = ?";
        $values = array($role_id, $module_access_id, $module_permission_id);
        $response = $this->databaseInstance->getRow($query, $values);
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * gets module accesses
     * @return array
    */
    public function getModuleAccesses() {

        $query = "SELECT * FROM $this->module_access ";
        $values = array();
        $response = $this->databaseInstance->getRows($query, $values);
        
        return $this->library->formatResponse($response);
    }

    /**
     * gets module access by id
     * @return array
    */
    public function getModuleAccess($id) {

        $query = "SELECT * FROM $this->module_access WHERE id = ?";
        $values = array($id);
        $response = $this->databaseInstance->getRow($query, $values);
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * gets module permissions
     * @return array
    */
    public function getModulePermissions() {

        $query = "SELECT * FROM $this->module_permission ";
        $values = array();
        $response = $this->databaseInstance->getRows($query, $values);
        
        return $this->library->formatResponse($response, $pagination = array(), $sort = array("sort" => "asc"));
    }

    /**
     * gets module permission by id
     * @return array
    */
    public function getModulePermission($id) {

        $query = "SELECT * FROM $this->module_permission WHERE id = ?";
        $values = array($id);
        $response = $this->databaseInstance->getRow($query, $values);
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * creates new role
     * @return boolean
     *
    */
    public function newRole($name) {

        $result = $this->getRoleByName($name);
        if ($result['data']) throw new \Exception("Role has been created before");

        $query = "INSERT INTO $this->roles SET name = ?, date_time = ?";
        $values = array($name, $this->date_time);
        $role_id = $this->databaseInstance->insertRow($query, $values);

        $module_accesses = $this->getModuleAccesses();
        $module_permissions = $this->getModulePermissions();
        foreach ($module_accesses['data'] as $module_access) {
            $query = "INSERT INTO $this->roles_and_module_access 
                SET role_id = ?, module_access_id = ?";
            $values = array($role_id, $module_access->id);
            $this->databaseInstance->insertRow($query, $values);

            foreach ($module_permissions['data'] as $module_permission) {
                $query = "INSERT INTO $this->roles_and_permissions 
                    SET role_id = ?, module_access_id = ?, module_permission_id = ?";
                $values = array($role_id, $module_access->id, $module_permission->id);
                $this->databaseInstance->insertRow($query, $values);
            }
        }   

        return array("success" => true, "message" => "Role created successfully");
    }

    /**
     * update existing role
     * @return boolean
     *
    */
    public function editRole($id, $name) {

        $result = $this->getRole($id);
        if (!$result['data']) 
            throw new \Exception("Role does not exist");

        $old_role_name = $result['data']->name;

        $result = $this->getRoleByName($name);
        if ($result['data']) 
            if ($result['data']->id != $id) 
                throw new \Exception("Role has been created before");

        $message = "No changes made";
        if ($old_role_name != $name) {
            $query = "UPDATE $this->roles SET name = ? WHERE id = ?";
            $values = array($name, $id);
            $this->databaseInstance->updateRow($query, $values);  

            $this->updateEmployeesRoles($name, $old_role_name);

            $message = "Role updated successfully";
        }           

        return array("success" => true, "message" => $message);
    }

    /**
     * delete role
     * @return boolean
     *
    */
    public function deleteRole($role_id) {

        $result = $this->getRole($role_id);
        if (!$result['data']) 
            throw new \Exception("Role does not exist");

        $query = "DELETE FROM $this->roles WHERE id = ?";
        $values = array($role_id);
        $this->databaseInstance->deleteRow($query, $values); 

        $query = "DELETE FROM $this->roles_and_module_access WHERE role_id = ?";
        $values = array($role_id);
        $this->databaseInstance->deleteRow($query, $values);

        $query = "DELETE FROM $this->roles_and_permissions WHERE role_id = ?";
        $values = array($role_id);
        $this->databaseInstance->deleteRow($query, $values);

        $this->deleteEmployeesRoles($result['data']->name);

        return array(
            "name" => $result['data']->name,
            "success" => true, 
            "message" => "Role deleted successfully"
        );
    }

    /**
     * update existing role
     * @return boolean
     *
    */
    public function updateEmployeesRoles($role_name, $old_role_name) {

        $result = $this->getRoleByName($role_name);
        if (!$result['data']) 
            throw new \Exception("Role does not exist");

        $query = "UPDATE $this->employees SET employee_type = ? 
            WHERE id > ? AND employee_type = ?";
        $values = array($role_name, 0, $old_role_name);
        $this->databaseInstance->updateRow($query, $values);  

        return true;
    }

    /**
     * update existing role
     * @return boolean
     *
    */
    public function deleteEmployeesRoles($role_name) {

        $result = $this->getRoleByName($role_name);
        if (!$result['data']) 
            return false;

        $query = "UPDATE $this->employees SET employee_type = ? 
            WHERE id > ? AND employee_type = ?";
        $values = array("employee", 0, $role_name);
        $this->databaseInstance->updateRow($query, $values);  

        return true;
    }

    /**
     * @return array
     *
    */
    public function updateRoleModuleAccessStatus($role_id, $module_access_id) {

        $response = $this->getRoleModuleAccess($role_id, $module_access_id);
        if (!$response['data']) {
            throw new \Exception("Role does not exist");
        }

        $status = 1;
        if ($response['data']->status) $status = 0;

        $query = "UPDATE $this->roles_and_module_access SET status = ? 
            WHERE role_id = ? AND module_access_id = ?";
        $values = array($status, $role_id, $module_access_id);
        $this->databaseInstance->updateRow($query, $values);
        
        return array(
            "name" => $response['data']->name,
            "module_name" => $response['data']->module_name,
            "success" => true, 
            "message" => "Role module access status updated successfully"
        );
    }

    /**
     * @return array
     *
    */
    public function updateRoleModuleAccessPermissionStatus($role_id, $module_access_id, $module_permission_id) {

        $response = $this->getRoleModuleAccessPermission($role_id, $module_access_id, $module_permission_id);
        if (!$response['data']) {
            throw new \Exception("Role does not exist");
        }

        $status = 1;
        if ($response['data']->status) $status = 0;

        $query = "UPDATE $this->roles_and_permissions SET status = ? 
            WHERE role_id = ? AND module_access_id = ? AND module_permission_id = ?";
        $values = array($status, $role_id, $module_access_id, $module_permission_id);
        $this->databaseInstance->updateRow($query, $values);
        
        return array(
            "name" => $response['data']->name,
            "module_name" => $response['data']->module_name,
            "module_permission_name" => $response['data']->module_permission_name,
            "success" => true, 
            "message" => "Role module access status updated successfully"
        );
    }

}