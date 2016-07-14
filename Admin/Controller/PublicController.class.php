<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller{

    //空方法
    public function _empty(){
    $this -> display('Empty/empty');
    }
    
    public function login(){
        $this->display();

    }

    //生成验证码
    public function captcha(){
        //配置
        $cfg = array(
            'fontSize'  =>  14,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  50,               // 验证码图片高度
            'imageW'    =>  120,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              //
        );
        //实例化
        $verify = new \Think\Verify($cfg);
        //生成输出保存验证码
        $verify -> entry();
    }

    //index方法用于处理用户登录
    public function index(){
        $post = I('post.');
        $verify = new \Think\Verify();
        $rst = $verify -> check($post['captcha']);
        if($rst){
            $model = D('User');
            $result = $model -> where(array('username' => $post['username'], 'password' => $post['password'])) ->  find();
            if($result){
                session('uid', $result['id']);
                session('username', $result['username']);
                session('role_id', $result['role_id']);
                echo '1';


            }else{
                echo '2';
            }

        }else{
            echo '3';
        }
        
    }

    public function loginOk(){
        $this -> success('登录成功',U('Index/index'),3);
    }

    //用户退出的方法
    public function logout(){
        session(null);
        $this -> success('退出成功', U('login'), 3);
    }
}
