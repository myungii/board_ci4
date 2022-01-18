<?php
class Reply_model extends CI_Model {

  

    private static $db;

	function __construct($arr = 0) {
		parent::__construct();
		self::$db = &get_instance()->db;

    }

    //리스트 출력
	function get_view($pid) {

        $query = 'SELECT * FROM reply where pid = ' . $pid . ' ORDER BY regdate DESC';
/*
		$this->db->where('pid', $pid);
		$this->db->select('*');
		$this->db->from('reply');
		$this->db->order_by('regdate', 'desc');
        //return $this->db->query($query)->result();                 
*/

		//return $this->db->result();
 
        return $this->db->query($query)->result();                 

	}

    //추가
    function add($data) {

        $param = array(
                    "pid"       => (int)($data->pid),
                    "name"      => $data->name,
                    "content"   => $data->content,
                    "regdate"   => date("Y-m-d H:i:s")
                );
        
        if(empty($data))
        {
            return false;
        }

        $this->db->insert('reply', $param);
        return true;
	}



    //삭제
    function delete($idx) {
   
        if($idx)
        {
            $this->db->where('idx', $idx);
            $this->db->delete('reply');

            $is_valid = '1';

        } else {
            $is_valid = '0';
        }
        
        $this->_call_json($is_valid);

	}

 
    

    //수정
    function modify($data) {

        $dataArr    = array();
        $where      = array (
                                "idx" => $data['idx']
                            );

        if($data['idx'])
        {
            $dataArr['name']         = $data['name'];
            $dataArr['content']      = $data['content'];
            $dataArr['regdate']      = date("Y-m-d H:i:s");

            $this->db->update('reply', $dataArr, $where);

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
		$query = "SELECT COUNT(*) as cnt FROM reply WHERE pid = " . $pid;
		
        
        return $this->db->query($query)->row('cnt');
    }

    private function _call_json($is_valid) {
        $json               = null;
        $json['is_valid']   = $is_valid;


        echo json_encode($json);
    }


}
