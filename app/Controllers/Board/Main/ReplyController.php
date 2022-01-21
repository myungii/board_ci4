<?php

namespace App\Controllers\Board\Main;
use App\Models\Board_model;
use App\Models\Paging;
use App\Models\Reply_model;

class ReplyController extends \CodeIgniter\Controller
{
	
	
	public function index()
	{

		$pid 		= $_GET['pid'];
		$name 		= $_GET['name'];
		$content 	= $_GET['content'];

		$this->Reply_model->get_view($pid);


		return view('reply');
	
	}

	public function save()
	{
		$reply 		= new Reply_model();

		$dataList = json_decode( $_POST['dataObj']);

		$result = $reply->add($dataList);

		if($result == true)
		{
			echo "200";
			exit;
		}
		else {
			echo "99";
		}

	}

	public function delete()
	{
		$idx 		= $_GET['replyId'];
		$reply 		= new Reply_model();
		$result 	= $reply->remove($idx);
		
	}

	public function modify()
	{
		$data['idx'] 		= $_GET['replyId'];
		$data['name'] 		= $_GET['name'];
		$data['content'] 	= $_GET['content'];
		$data['date'] 		= date("Y-m-d H:i:s");

		$reply 		= new Reply_model();
		$result 	= $reply->modify($data);
		

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
