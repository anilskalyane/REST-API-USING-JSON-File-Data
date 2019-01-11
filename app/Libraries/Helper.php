<?php

class Helper {

    /**
     * Load the Sample data from storage location
     * @return boolean
     */
    public static function loadJSONData() {
        // read json file and decode json to associative array
        return json_decode(file_get_contents(storage_path() . env('SAMPLE_DATA_PATH')), true);
    }

    /**
     * Write the Sample data to storage location
     * @param boolean $json_arr
     * @return boolean
     */
    public static function writeJSONData($json_arr) {
        // read json file and decode json to associative array
        return file_put_contents(storage_path() . env('SAMPLE_DATA_PATH'), json_encode($json_arr));
    }

    /**
     * Delete the json object key from JSON data
     * @param type $parameters
     * @return type
     */
    public static function deleteJSONDatafromFile($root, $objectKey, $objectValue) {
        //load the sample data
        $json_arr_parent = self::loadJSONData();

        if ($root) {
            $json_arr = $json_arr_parent[$root];
        }
        $searchInArray = array_search($objectValue, array_column($json_arr, $objectKey));

        if (!is_numeric($searchInArray)) {
            return false;
        }
        // delete data            
        if (!$root && !isset($json_arr_parent[$root][$searchInArray])) {
            return false;
        }
        unset($json_arr_parent[$root][$searchInArray]);

        // rebase array
//        $json_arr_parent = array_values($json_arr_parent);
        // encode array to json and save to file
        self::writeJSONData($json_arr_parent);
        return true;
    }

    /**
     * Get the role based permissions
     * @param array $rolePermissions
     * @return array $user_permissions
     */
    public static function getRolePermission($rolePermissions) {
        //load the sample data
        $json_data = self::loadJSONData();
        $user_permissions = [];
        foreach ($rolePermissions as $permission) {
            $searchInArray = array_search($permission, array_column($json_data['Permissions'], 'id'));
            $user_permissions[] = $json_data['Permissions'][$searchInArray];
        }
        return $user_permissions;
    }

    /**
     * Get user's permissions
     * @param array $user
     * @param array $data
     * @return array $data
     */
    public static function getUserPermission($user, $data) {
        //load the sample data
        $json_data = self::loadJSONData();
        foreach ($json_data['Roles'] as $roles) {
            if (in_array($roles['id'], $user['roles'])) {
                $data['user_permissions'][$roles['id']] = self::getRolePermission($roles['permissions']);
            }
        }
        return $data;
    }

}
