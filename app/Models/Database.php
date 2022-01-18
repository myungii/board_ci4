<?php
namespace App\Models;

class Database {

   public function getTable($name) {
       return self::$name();
   }

   public static function board() {
        $fields = [
            'idx'               =>  ['type' => 'int'       , 'constraint' => 11    , 'unsigned' => true, 'auto_increment' => true,],
            'name'              =>  ['type' => 'varchar'   , 'constraint' => 20],
            'title'             =>  ['type' => 'varchar'   , 'constraint' => 50],
            'content'           =>  ['type' => 'varchar'   , 'constraint' => 4000],
            'cnt'               =>  ['type' => 'int'       , 'constraint' => 10    , 'unsigned' => true, 'default' => 0],
            'notice'            =>  ['type' => 'int'       , 'constraint' => 2     , 'unsigned' => true, 'default' => 0],
            'fileid'            =>  ['type' => 'int'       , 'constraint' => 10    , 'null' => true],
            'regdate'           =>  ['type' => 'datetime'  , 'null' => true],
            'modidate'          =>  ['type' => 'datetime'  , 'null' => true],
            'deleted_at'        =>  ['type' => 'datetime'  , 'null' => true],
        ];

        return $fields;
   }

    public static function board_file() {
        $fields = [
            'idx'               =>  ['type' => 'int'        , 'constraint' => 10    , 'unsigned' => true, 'auto_increment' => true,],
            'boardId'           =>  ['type' => 'int'        , 'constraint' => 10    , 'unsigned' => true],
            'fileName'          =>  ['type' => 'varchar'    , 'constraint' => 50    , 'null' => true],
            'fileSize'          =>  ['type' => 'varchar'    , 'constraint' => 30    , 'null' => true],
            'filePath'          =>  ['type' => 'varchar'    , 'constraint' => 255   , 'null' => true],
            'fileType'          =>  ['type' => 'varchar'    , 'constraint' => 30    , 'null' => true],
            'fullFilePath'      =>  ['type' => 'int'        , 'constraint' => 255   , 'null' => true],
            'regdate'           =>  ['type' => 'datetime'   , 'null' => true],
            'modidate'          =>  ['type' => 'datetime'   , 'null' => true],
            'deleted_at'        =>  ['type' => 'datetime'   , 'null' => true],
        ];

        return $fields;
    }

    public static function reply() {
        $fields = [
            'idx'              =>  ['type' => 'int'        , 'constraint' => 10    , 'unsigned' => true, 'auto_increment' => true,],
            'pid'              =>  ['type' => 'int'        , 'constraint' => 10    , 'unsigned' => true],
            'name'             =>  ['type' => 'varchar'    , 'constraint' => 20    , 'unsigned' => true],
            'content'          =>  ['type' => 'varchar'    , 'constraint' => 255   , 'unsigned' => true],
            'regdate'          =>  ['type' => 'datetime'   , 'null' => true],
            'modidate'         =>  ['type' => 'datetime'   , 'null' => true],
            'deleted_at'       =>  ['type' => 'datetime'   , 'null' => true],
        ];

        return $fields;
    }


}
