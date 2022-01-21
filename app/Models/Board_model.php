<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class Board_model extends Model {

	function __construct() {
		parent::__construct();
        
        $this->board        = new \App\Models\UserModel('board');
        $this->board_file   = new \App\Models\UserModel('board_file');
    }

    //일반 게시판 리스트 출력
	function get_view($start, $rowsPage, $searchText) {
        
        $start      = ($start - 1) * $rowsPage;

        $result     = $this->board->select('*')->like('title',	$searchText)->orderBy('regdate', 'desc')->findAll($rowsPage, $start);
        
        return $result;

	}

    //ajax table 리스트 출력
    function getViewForAjax($start, $rowsPage, $param) {
        $start = ($start - 1) * $rowsPage;

		if(is_array($param)) {
			$whereArr   =	$this->_whereParam($param);

            $result     = $this->board->where($whereArr)->orderBy('regdate', 'desc')->findAll($rowsPage, $start);

		} else {
            $result     = $this->board->select('*')->orderBy('regdate', 'desc')->findAll($rowsPage, $start);
        }

        return $result;
    }


    //검색 where 절
	private function _whereParam($param) {

        $whereArr	= '';
        $where		= array();

        if($param['notice'] == 'Y') {

            $where[] .= 'notice = 1 ';	

        } else if($param['notice'] == 'N') {

            $where[] .= 'notice is null';

        } 

        if($param['name'])
        {
            $where[] .= 'name like "%' . $param['name'] . '%" ';
        } 
        if($param['title'])
        {
            $where[] .= 'title like "%' . $param['title'] . '%" ';
        } 
        if($param['reg_start'] && $param['reg_end'])
        {
            $where[] .= '(substr(regdate, 1, 10) >= "' . $param["reg_start"] .'"
                        AND substr(regdate, 1, 10) <= "' . $param["reg_end"] .'") ';
        } else if($param['reg_start'] && !$param['reg_end'])
        {
            $where[] .=  'substr(regdate, 1, 10) >= "' .  $param["reg_start"] .'"' ; 
        } else if($param['reg_end'] && !$param['reg_start'])
        {
            $where[] .=   'substr(regdate, 1, 10) <= "' . $param["reg_end"] . '"'  ;
        } 

        $whereArr = implode(' AND ', $where);

        return $whereArr;
    }


    //공지 리스트 출력
    function get_noticeView() {

        $result = $this->board->where('notice', 1)->findAll();

        return $result;
    }

    //추가
    function add($data = array()) {
        
        if($this->board->save($data)) {
            return (int)$this->db->insertId();    
        }

        return '';
        
	}

    //파일 업로드
    function fileUpload($data) {

        if($this->board_file->save($data)) {
            $this->board->update($data['boardId'], [ "fileid" => (int)$this->db->insertId() ]);
            $is_valid = '1';
        } else {
            $is_valid = '0';

        }

        $this->_call_json($is_valid);
 
        
    }



    //삭제
    function remove($idx) {
        
        if($idx)
        {
            $this->board->delete($idx);

            $is_valid = '1';

        } else {
            $is_valid = '0';
        }
        
        $this->_call_json($is_valid);

	}

    //한 건 출력
    function load($idx, $mode) {
        
        if(!$idx) {
            return false;
        }

        //조회수 추가
        if($mode !== 'edit') {
            $this->_increaseCnt($idx);
        }
       
        /*
        $query      = "SELECT * FROM board WHERE idx = ". $idx;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        */

        return $this->board->find($idx);
        
    }

	//파일 한 건 출력
    function fileLoad($id) {
        
        if(!$id) {
            return "";
        }

        /*
        $query      = "SELECT * FROM board_file WHERE boardId = ". $boardId;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        */
        else {
            //$result =  $this->board_file->where('boardId', $boardId)->first();
            $result =  $this->board_file->find($id);

            if( isset($result) ) {
                return $result;
            } else {
                return "";
            }
        }
        
    }

    //파일 삭제
    function fileDelete($idx) {

        if($idx)
        {
            $this->board_file->delete($idx);
            return true;
        } 

        return false;

	}
    

    private function _increaseCnt($idx) {

        if( $this->board->set('cnt', 'cnt+1', FALSE)->where('idx', $idx)->update() ) {
            return true;
        }

        return false;
        
    }

    //수정
    function modify($data = array()) {
        
        $dataArr    = array();

        $dataArr['name']         = $data['name'];
        $dataArr['title']        = $data['title'];
        $dataArr['content']      = $data['content'];
        $dataArr['notice']       = $data['notice'];
        $dataArr['regdate']      = date("Y-m-d H:i:s");

        if($this->board->update($data['idx'], $dataArr)) return TRUE ;
        return FALSE;
        

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
        $board = new \App\Models\UserModel('board');

        $where = ' substr(regdate, 1, 10) = substr(now(), 1, 10) ';

        return $board->where($where)->countAllResults();
        
    }


    //총 게시글 개수
    function getTotal($searchText) {
        
        //$query = 'SELECT count(*) as cnt FROM board WHERE title like "%' . $searchText.'%" ';
        
        //return $this->db->query($query)->row('cnt');

        $result = $this->board->select('*')->like('title',	$searchText)->countAllResults();

        return $result;

    }

    function getTotalForAjax($param) {

        if(is_array($param)) {
			$whereArr   =	$this->_whereParam($param);
            $result     = $this->board->where($whereArr)->countAllResults();
        } else {
            $result     = $this->board->countAllResults();
        }
        return $result;
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
