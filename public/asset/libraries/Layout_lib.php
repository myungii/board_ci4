<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout_lib {
	private $ci;
	private $default;
	private $assign = array();

	public  function __construct() {
		$this->ci =& get_instance();
	}

	private function init() {
		$menu_tree = $this->ci->menu_lib->set_tree('all'); //메뉴
		$assign_cfg = array(
			'menu'=>$menu_tree[1]['children']
			// 'company'=>$this->ci->config->item('ru_company')
		);

		// pre($assign_cfg);

		$page_id = strtolower($this->ci->router->fetch_class()).'_'.strtolower($this->ci->router->fetch_method());

		$assign_default = array(
			'page'=>array(
				'querystring' => $_SERVER['QUERY_STRING'],
				'controller'=> strtolower($this->ci->router->fetch_class()),
				'id'=>$page_id,
				'info'=>$this->ci->menu_lib->get_menu_by_href()
			),
			'path'=>array(
				'image'=>'/views/images'
			),
			'login' => array(
				'is'=> $this->ci->login_lib->is_logged_in(),
				'info'=>$this->ci->login_lib->get_login_infos()
			),
			'cfg'=>$assign_cfg
		);


		
		$assign_default = array('layout'=>$assign_default);
		$this->assign_($assign_default);
	}

	public function default_($body, $assign=array(), $layout='default') {

		if($layout=='default') $this->init();

		if(count($assign)>0) {
			$this->assign_($assign);
		}

		$config_layout = $this->ci->config->item('zg_layout');
		if(array_key_exists($layout, $config_layout)) {
			$bundle = $config_layout[$layout];
		}
		else {
			//존재하지 않는 레이아웃 경고
			// display_warning('board','board_no_contents');
		}

		$msg_type = (isset($this->ci->msg_type))?$this->ci->msg_type:'normal';
		if(in_array($msg_type, array('error','warning'))) {
			$body = 'common/'.$msg_type.'.html';
			$this->assign_( array(
				'msg'=>$this->ci->msg
			));
		}

		$define = array_change_key_case(array_merge(array('BODY'=>$body), $bundle), CASE_UPPER);
		$this->ci->template_->define($define);


		$this->ci->template_->assign($this->assign);
		// pre($this->assign);
	}

	public function define_($key,$path) {
		$this->ci->template_->define(array(
			$key=>$path
		));
	}

	public function assign_($assign=array()) {
		if(count($assign)>0) {
			$this->assign = array_merge($this->assign, $assign);
		}
	}

	public function print_() {
		//header("Content-Type:text/html");
		$this->ci->template_->print_('LAYOUT');
	}

	public function print_error($title, $msg) {
		$assign = array(
			'title'=>$title,
			'msg'=>$msg
		);
		$this->default_('/common/error.html',$assign);
		$this->print_();
	}

	function fetch_($tpl, $assign) {
		$this->init();
		$this->ci->template_->define('fetch',$tpl);
		$assign = array_merge($this->assign, $assign);
		$this->ci->template_->assign($assign);
		return $this->ci->template_->fetch('fetch');
	}
}
?>
