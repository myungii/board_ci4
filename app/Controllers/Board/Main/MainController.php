<?php

namespace App\Controllers\Board\Main;
use App\Models\Board_model;

class MainController extends \CodeIgniter\Controller
{

	
	public function index()
	{
		$board 	= new Board_model();
		$notice = $board->get_noticeView();
		//$list 	= $board->get_view();

		return view('home', [
							  'noticeList' => $notice
					]);
	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
