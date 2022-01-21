<?php
namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class Reply_model extends Model {

  
	function __construct($arr = 0) {
		parent::__construct();
		
        $this->reply = new \App\Models\UserModel('reply');
    }

    //리스트 출력
	function get_view($pid) {

        //$query = 'SELECT * FROM reply where pid = ' . $pid . ' ORDER BY regdate DESC';

        return $this->reply->where('pid', $pid)->orderBy('regdate', 'desc')->findAll();                 

	}

    //추가
    function add($data) {

        if($this->reply->save($data)) {
            return (int)$this->db->insertId();    
        }

        return '';
	}



    //삭제
    function remove($idx) {
   
        if($idx)
        {
            $this->reply->delete($idx);

            $is_valid = '1';

        } else {
            $is_valid = '0';
        }
        
        $this->_call_json($is_valid);


	}

 
    

    //수정
    function modify($data) {

        $dataArr    = array();

        if($data['idx'])
        {
            $dataArr['name']         = $data['name'];
            $dataArr['content']      = $data['content'];
            $dataArr['regdate']      = date("Y-m-d H:i:s");

            $this->reply->update($data['idx'], $dataArr);

            $is_valid = '1';
        } else {
            $is_valid = '0';
        }


        $this->_call_json($is_valid);


    }


    //등록일 포맷 변경
    static function setRegdate()
    {
        return '';

    }

    //새글 표시
    static function displayNew()
    {
     

        return '';
    }



    //총 게시글 개수
    function getTotal($pid) {
		//$query = "SELECT COUNT(*) as cnt FROM reply WHERE pid = " . $pid;
        //return $this->db->query($query)->row('cnt');

        $result = $this->reply->where('pid', $pid)->countAllResults();
		
        return $result;
        
    }

    private function _call_json($is_valid) {
        $json               = null;
        $json['is_valid']   = $is_valid;


        echo json_encode($json);
    }


}
