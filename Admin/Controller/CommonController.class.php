<?php
//声明名字空间
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;
//创建控制器并继承
class CommonController extends Controller{


	//空方法
	public function _empty(){
	$this -> display('Empty/empty');
	}
	/*public function __construct(){
		//先构造父类，不建议
		parent::__construct();
	}*/

	//ThinkPHP的构造方法
	public function _initialize(){
		/*if(!session('?uid')){
			$url = U('Public/login');
			header("location:$url");exit;
		}*/

		$uid = session('uid');
		if(empty($uid)){
			$url = U('Public/login');
			//header("location:$url");exit;
			//使用js跳转
			$script = "<script>window.top.location.href='$url';</script>";
			echo $script;exit;

		}

		//RBAC权限判断，这个是用户已经登录，但是不一定有所有权限
		$cname = strtolower(CONTROLLER_NAME);
		$aname = strtolower(ACTION_NAME);
		//控制器
		//控制器名/方法名
		//获取组的权限，判断这个用户在哪个组
		$auths = C('RBAC_AUTHS');//获取权限级数组
		$role_id = session('role_id');
		$auth = $auths[$role_id];
		//判断用户当前访问的控制器、方法是否是在其权限内
		if(!in_array($cname . "/*", $auth ) && !in_array($cname . '/' . $aname, $auth)){
			$this -> error('您没有权限', U('Index/home'), 3 );
		}
	}
}