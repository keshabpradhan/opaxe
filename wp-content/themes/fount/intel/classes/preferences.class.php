<?php

/**
 * @author Shahzaib Ali Hassan
 */
class preferences
{

    function __construct()
    {
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $this->user = wp_get_current_user();
        $this->db = new RscPDO(DSN, DBUSER, DBPASSWORD);
        $this->db2 = new RscPDO(DSN2, DBUSER2, DBPASSWORD2, host);
        $this->pdo = new PDO('mysql:host=' . host . ';dbname=' . DSN2, DBUSER2, DBPASSWORD2);
        $this->table = 'user_modes';
    }

    function savePreferences($data)
    {
        $id = $this->user->ID;
        $default_mode = true;
        $this->resetDeaultmodes($id);
        $query['query'] = 'INSERT INTO user_map_preferences(user_id, zoom_level, map_centre,filters_json,is_default,is_trans)
                            VALUES (:userId,:zoom_level,:map_centre,:filters_json,:is_default,:is_trans)';
        $query['values'] = array('userId' => $id, 'zoom_level' => $data['zoom_level'], 'map_centre' => $data['map_position'], 'filters_json' => $data['filters'], 'is_default' => $default_mode, 'is_trans' => $data['is_trans']);
        $save = $this->db->insert($query);
        return $save;
    }

    function resetDeaultmodes($id)
    {
        $query['query'] = 'UPDATE user_map_preferences set is_default =false where user_id=:user_id';
        $query['values'] = array('user_id' => $id);
        $update = $this->db->update($query);
    }

    function getActivemode()
    {
        $id = $this->user->ID;
        $query['query'] = "SELECT * FROM  user_map_preferences WHERE user_id='$id' AND is_default=true";
        return $this->db->getArrayFromSelect($query);
    }

    function getSavedpreferences()
    {

        $id = $this->user->ID;
        $query['query'] = "SELECT * FROM  user_map_preferences WHERE user_id='$id'";
        return $this->db->getArrayFromSelect($query);

    }

    function updateDefaultmode($id, $is_trans)
    {

        $user_id = $this->user->ID;
        $this->resetDeaultmodes($user_id, $is_trans);
        $query['query'] = "UPDATE user_map_preferences set is_default =true where id=$id AND is_trans=$is_trans";
        $update = $this->db->update($query);
        return $update;
    }

    function deleteModes($data)
    {
        $ids = $data['preferences-list'];
        $user_id = $this->user->ID;
        $query['query'] = "DELETE from user_map_preferences where id IN ($ids)";
        $delete = $this->db->delete($query);
        return $delete;

    }
}