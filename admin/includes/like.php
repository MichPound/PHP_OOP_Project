<?php

class Like extends Db_object{

    protected static $db_table = "likes";
    protected static $db_table_fields = array('id', 'photo_id', 'user_id');
    public $id;
    public $photo_id;
    public $user_id;

    public static function find_like($photo_id, $user_id){
        global $database;

        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE photo_id = " . $database->escape_string($photo_id);
        $sql .= " AND user_id = " . $database->escape_string($user_id);
        $sql .= " LIMIT 1";

        $the_result_array = self::find_by_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_the_likes($photo_id=0){
        global $database;

        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " Where photo_id = " . $database->escape_string($photo_id);
        $sql .= " ORDER BY photo_id ASC";

        return self::find_by_query($sql);
    }

}

?>