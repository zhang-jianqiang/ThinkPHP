<?php
namespace Home\Controller;
use Think\Controller;

class TestController extends Controller{
    public function test(){
       /* $name = '张三丰';
        $this->assign('name', $name);
        $arr = $this->fetch();
        echo $arr;*/
        //一维数组
        $arr = array(
            'name' => '张三丰',
            'sex' => '男',
            'age' => 24,
        );
        $this->assign('arr', $arr);
        $this->display();
    }
}