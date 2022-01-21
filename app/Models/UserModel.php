<?php

namespace App\Models;

class UserModel extends \CodeIgniter\Model {

    protected $table                = '';
    protected $primaryKey           = '';

    protected $useAutoIncrement     = true;

    protected $tempReturnType       = 'array';
    protected $useSoftDeletes       = true;

    protected $useTimestamps        = true;
    protected $allowedFields        = [];
    protected $createdField         = 'regdate';
    protected $updatedField         = 'modidate';
    protected $validationRules      = [];
    protected $jsonField            = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $afterFind            = ['jsonToArray']; //json 형식으로 되어 있는 데이터를 array로 변환 


	function __construct(string $table) {
		parent::__construct();
	
        $this->table        = $table;
        $this->_db          = new Database;
        $this->fields       = $this->_db->getTable($table);

        
        if( is_array($this->fields) ) {
            foreach( $this->fields as $key => $row ) {
                if( isset($row['auto_increment']) && $row['auto_increment'] === true ) {
                    $this->primaryKey   = $key;
                } 
                else if ( $key != 'regdate' && $key != 'modidate' ) {
                    $this->allowedFields[] = $key;
                }
                
                if( $row['type'] == 'json' )
                    $this->jsonField[] = $key;
            }

            //실제 테이블이 존재하지 않으면 새로 생성
            $cnt  = $this->db->query("SHOW TABLES LIKE '{$table}'")->getResultArray();
            if( isset($cnt) && !count($cnt) ) {
                $this->create_table();
            }
            
        }

    }

    public function create_table() {
        $forge = \Config\Database::forge();
        $forge->addField($this->fields)->addPrimaryKey($this->primaryKey)
               ->createTable($this->table, false, ['ENGINE' => 'InnoDB']);
    }

    public function jsonToArray(array $data) {
        foreach( $data['data'] as $key => $val )
            if( is_array($val) ) {
                foreach( $val as $k_ => $v_ )
                if( in_array($k_, $this->jsonField) ) $data['data'][$key][$k_]  = json_decode($v_, true);
            } else {
                if( in_array($key, $this->jsonField) ) $data['data'][$key]      = json_decode($val, true);
            }
            return $data;
    }

    public function save($data): bool
    {
        if( is_array($data) )
            foreach($data as $key => $val)
                if( in_array($key, $this->jsonField) )
                    $data[$key] = json_encode($val, JSON_UNESCAPED_UNICODE|JSON_NUMERIC_CHECK);
            return parent::save($data);
    }


}
