<?php
namespace Admin\Controller;
use Think\Controller;

class TestController extends Controller{
    public function test(){
        $data = array(
            'name' => '张三丰',
            'sex' => '男',
            'age' => 24,
        );
        $this->assign('data',$data);
        $this->display();
    }

    public function test1(){
        $model = M('Dept');
        $model -> select();
        //$rt = $model -> getLastSql();
        $rt = $model ->_sql();
        echo $rt;
    }

    public function test2(){
        G('start');
        $model = M('Dept');
        $rt = $model -> select();
        echo $model -> _sql();
        G('end');
        echo G('start', 'end', 7);
    }

    //AR模式
    public function test3() {
        $model = M('Dept');
        $model -> name = '公关部';
        $model -> pid = '0';
        $model -> sort = '3';
        $model -> remark = '这是公司妹纸最多的的部门';
        $model ->add();


    }

    public function test4(){
        $model = D('Dept');
        $model -> where('id=1');//这个方法返回的是$this
        dump($model -> find());
    }

    public function test5(){
        /*$model = D('Dept');
        $model -> limit(2);
        dump($model -> select());*/
        $model = M('Dept');
        $model -> limit(1,2);
        dump($model->select());

    }

   public function test6(){
       $model = D('Dept');
       $model -> where(array('id'=> 1));
       $model -> field('id,name as haha');
       dump($model -> select());
   }

    public function test7(){
        $model = M('Dept');
        $model -> order('id desc');
        dump($model->select());
    }

    public function test8(){
        $model = D('Dept');
        $model -> field('name,count(*) as count');
        $model -> group('sort');
        dump($model -> select());
    }

    public function test9(){
        $model = D('Dept');
        $rt = $model -> field('name,count(*) as count') -> group('sort') ->select();
        dump($rt);
    }

    public function test10(){
        $model = D('Dept');
        dump($model -> count());
    }

    public function test11(){
        $model = D('Dept');
        dump($model -> field('count(*) as count') ->select());
    }

    public function test12(){
        $model = D('Dept');
        dump($model -> max('sort'));
    }

    public function test13()
    {
        G('start');
        $model = D('Dept');
        $model = D('Dept');
        dump($model->sum('id'));
        G('end');
        echo G('start', 'end', 'm');
    }

    public function test14()
    {
        $model = D('Dept');
        $rt = $model -> field('id, name') ->select();
        dump($rt);

    }

    public function test15()
    {
        $model = D('Dept');
        $rt = $model->order('id desc') -> select();
        dump($rt);
    }

    public function test16()
    {
        $model = D('Dept');
        $rt = $model -> count();
        dump($rt);
    }

    public function test17(){
        info();
    }

    public function test18(){
        load('@/phpinfo');
        info();
    }

    public function test19(){
        $model = M();
        $rst = $model -> field('t1.*,t2.name') -> where('t1.dept_id=t2.id') -> table('tp_user as t1,tp_dept as t2') -> select();
        dump($rst);
    }

    public function test20(){
        //获取用户的Ip
        echo get_client_ip();
        echo "<hr/>";
        echo get_client_ip(1);
       
    }

    //获取ip地址对应的实际地区
    public function test21(){
        //实例化
        $class = new \Org\Net\IpLocation('qqwry.dat');
        $rst = $class -> getLocation('114.215.159.214');
        dump($rst);
    }

    public function test22(){
        $this -> display('test');
    }

    //用于ajax的测试
    public function test23(){
        $arr = array(
                'name' => '张三丰',
                'status' => 1
            );
        echo json_encode($arr);
    }

    public function test24(){
          

    }












}