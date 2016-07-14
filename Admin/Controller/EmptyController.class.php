<?php
//命名名字空间
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;
//创建控制器并继承父类
class EmptyController extends Controller{

	public function _empty(){
		$this -> display('Empty/empty');
	}
}