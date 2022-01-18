<?php
class Ajax_model extends CI_Model {

    private $idx;
    private $title;
    private $name;
    private $content;
    private $regdate;
    private $cnt;
    private $fileid;

    private static $db;

	function __construct($arr = 0) {
		parent::__construct();
		self::$db = &get_instance()->db;

    }


    //리스트 출력
	function pluginList($param, $start, $rowsPage) {

		$start = ($start - 1) * $rowsPage;

		if(is_array($param)) {
			$whereArr =	$this->_whereParam($param);

		}

		$query = 'SELECT * FROM board ';

		if(is_array($param)) {
			$query .= 'WHERE ' . $whereArr;
		}

		$query .= 'ORDER BY notice DESC, regdate DESC limit ' . $start . ', ' . $rowsPage;

		return $this->db->query($query)->result();
	}

    //리스트 출력
	function get_view($param, $start, $rowsPage) {

		$start = ($start - 1) * $rowsPage;

		if(is_array($param)) {
			$whereArr =	$this->_whereParam($param);

		}

//		$this->db->select("*");
//		$this->db->from("board");

		$query = 'SELECT * FROM board ';

		if(is_array($param)) {
//			$this->db->where($whereArr); 
			$query .= 'WHERE ' . $whereArr;
		}

		$query .= 'ORDER BY regdate DESC limit ' . $start . ', ' . $rowsPage;

//		$this->db->order_by('regdate', 'DESC');
//		$this->db->limit($start, $rowsPage);

	
//		$result = $this->db->get();


//		return $result->result();


		return $this->db->query($query)->result();
	}

    //공지 리스트 출력
    function get_noticeView() {
        $query = 'SELECT * FROM board WHERE notice != 0 or notice !=null';   

        return $this->db->query($query)->result();
    }

	//where 절
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
				$where[] .=  substr(regdate, 1, 10) . '>= "' .  $param["reg_start"] .'"' ; 
			} else if($param['reg_end'] && !$param['reg_start'])
			{
				$where[] .=   'substr(regdate, 1, 10) <= "' . $param["reg_end"] . '"'  ;
			} 

			$whereArr = implode(' AND ', $where);

			return $whereArr;
	}


    //추가
    function add($data = array()) {
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
        
	}

    //파일 업로드
    function fileUpload($data) {
        
        if(!$data)
        {
            return false;
        } else {

            $data['regdate']    = date("Y-m-d H:i:s");

			$this->db->insert('board_file', $data);
			return true;
		}
        
    }


    //수정
    function modify($data = array()) {

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
    
    }


    //파일 삭제
    function fileDelete($idx) {
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
	}


    //삭제
    function delete($idx) {
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
	}



    //총 게시글 개수
    function getTotal($param) {

		if(is_array($param)){
			$where = $this->_whereParam($param);
			$query = 'SELECT count(*) as cnt FROM board where ' . $where;

		} else {
			$query = 'SELECT count(*) as cnt FROM board ';
		}
        
        return $this->db->query($query)->row('cnt');
    }

    //한 건 출력
    function load($idx) {

        if(!$idx) {
            return false;
        }

        //조회수 추가
        $this->_increaseCnt($idx);

        $query      = "SELECT * FROM board WHERE idx = ". $idx;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        
    }


    private function _increaseCnt($idx) {

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
    }


	//파일 한 건 출력
    function fileLoad($boardId) {

        if(!$boardId) {
            return "";
        }

        $query      = "SELECT * FROM board_file WHERE boardId = ". $boardId;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        
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



    private function _call_json($is_valid) {
        $json               = null;
        $json['is_valid']   = $is_valid;

        echo json_encode($json);
    }

}
