<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller{

	
	//空方法
	public function _empty(){
	$this -> display('Empty/empty');
	}

    public function index(){
        //展示后台列表
        $this->display();
    }

    //home方法，展示home模板
    public function home(){
    	$this -> display();
    }
}