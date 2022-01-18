<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class Board_model extends Model {

	function __construct() {
		parent::__construct();
        
        $this->board = new \App\Models\UserModel('board');
    }

    //리스트 출력
	function get_view($start, $rowsPage, $searchText) {
        /*

        $start            = ($start - 1) * $rowsPage;

        if($searchText)
        {
            $query = 'SELECT * FROM board WHERE title like "%' . $searchText.'%" ORDER BY regdate DESC limit ' . $start . ',' . $rowsPage;

            return $this->db->query($query)->result();
        } else {
            $query = 'SELECT * FROM board WHERE title like "%' . $searchText.'%" ORDER BY regdate DESC limit ' . $start . ',' . $rowsPage;
                        
            return $this->db->query($query)->result();                 
        }
        */

	}

    //공지 리스트 출력
    function get_noticeView() {
        //$board = new \App\Models\UserModel('board');
        //$query = 'SELECT * FROM board WHERE notice != 0 or notice !=null';   

        $result = $this->board->where('notice', 1)->findAll();

        return $result;
    }

    //추가
    function add($data = array()) {
        /*
        if($data <= 0)
       {
            return false;
       }

        $data['regdate']    = date("Y-m-d H:i:s");

        $this->db->insert('board', $data);

        if($this->db->affected_rows())
        {
            return true;
        }
        */
        
	}

    //파일 업로드
    function fileUpload($data) {
        /*
        
        if(!$data)
        {
            return false;
        } else {

            $data['regdate']    = date("Y-m-d H:i:s");

			$this->db->insert('board_file', $data);
			return true;
		}
        */
        
    }



    //삭제
    function remove($idx) {
        /*
        if($idx)
        {
            $this->db->where('idx', $idx);
            $this->db->delete('board');

            if($this->db->affected_rows() > 0)
            {
                return true;
            } 
            
        }

        return false;
        */
	}

    //한 건 출력
    function load($idx) {
        /*

        if(!$idx) {
            return false;
        }

        //조회수 추가
        $this->_increaseCnt($idx);

        $query      = "SELECT * FROM board WHERE idx = ". $idx;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        */
        
    }

	//파일 한 건 출력
    function fileLoad($boardId) {
        /*
        if(!$boardId) {
            return "";
        }

        $query      = "SELECT * FROM board_file WHERE boardId = ". $boardId;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        */
        
    }

    //파일 삭제
    function fileDelete($idx) {
        /*
        if($idx)
        {
            $this->db->where('idx', $idx);
            $this->db->delete('board_file');

            if($this->db->affected_rows() > 0)
            {
                return true;
            } 
            
        }

        return false;
        */
	}



    //파일수정
    function fileModify($data = array()) {

        /*
        $dataArr    = array();
        $where      = array (
                        "idx"       => $data['idx']
                    );

        if(!$data['idx'])
        {
			$id_valid = '0';
        } else {

            $dataArr['fileName']            = $data['fileName'];
            $dataArr['fileSize']            = $data['fileSize'];
            $dataArr['filePath']            = $data['filePath'];
            $dataArr['fileType']            = $data['fileType'];
            $dataArr['regdate']             = date("Y-m-d H:i:s");
            $dataArr['fullFilePath']        = $data['fullFilePath'];

            $result = $this->db->update('board_file', $dataArr, $where);
			$is_valid = '1';

        }
		$this->_call_json($is_valid);
        */

    }
    


    private function _increaseCnt($idx) {
        /*
        if(!$idx)
        {
            return false;
        }

        $this->db   ->set('cnt', 'cnt+1', FALSE)
                    ->where('idx', $idx)
                    ->update('board');
        
        if($this->db->affected_rows() > 0)
        {
            return true;
        } 

        return false;
        */
    }

    //수정
    function modify($data = array()) {
        /*
        $dataArr    = array();
        $where      = array (
                        "idx" => $data['idx']
        );

            $dataArr['name']         = $data['name'];
            $dataArr['title']        = $data['title'];
            $dataArr['content']      = $data['content'];
            $dataArr['notice']       = $data['notice'];
            $dataArr['regdate']      = date("Y-m-d H:i:s");

           if($this->db->update('board', $dataArr, $where)) return TRUE ;
           return FALSE;
        */
    
    }

    //등록일 포맷 변경
    static function setRegdate($date)
    {
        if(!$date)
        {
            return "";
        }

        return date("Y-m-d", strtotime($date));

    }

    //새글 표시
    static function displayNew($regdate='')
    {
        //하루 단위
        //$time		= strtotime($regdate);
		//$today		= time();
		//$result = (($today - $time)/60/60/24)*10;

		$time = substr($regdate,0, 10);
		$today = date("Y-m-d");

        //if($result <= 1)
        if($time == $today)
        {
            return " <span id='new'>new</span>";
        }

        return '';
    }

    //lnb 목록 새글 갯수 표시
    static function newCnt() 
    {
        //$query = 'SELECT count(idx) AS cnt FROM board WHERE substr(regdate, 1, 10) = substr(now(), 1, 10)';

        //return self::$db->query($query)->row('cnt');
    }


    //총 게시글 개수
    function getTotal($searchText) {
        
        //$query = 'SELECT count(*) as cnt FROM board WHERE title like "%' . $searchText.'%" ';
        
        //return $this->db->query($query)->row('cnt');
    }

    //총 페이지 개수
    function totalPage($num, $rowPage){
        return intval(($num-1)/$rowPage)+1;
    }



    private function _call_json($is_valid) {
        $json               = null;
        $json['is_valid']   = $is_valid;

        echo json_encode($json);
    }

}
