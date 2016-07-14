<?php
namespace Admin\Controller;
use Think\Controller;

class DeptController extends CommonController{

    //空方法
    public function _empty(){
    $this -> display('Empty/empty');
    }
    #showList方法：展示部门列表
    public function showList(){
        $model = M('Dept');
        //$data = $model->select();
        /*foreach ($data as $key => $value) {
            $info = $model -> find($value['pid']);
            //给每个数组中添加一个元素parentName
            $data[$key]['parentName'] = $info['name'];
        }*/
        //使用table连接查询出所有的部门信息和所属部门
        //查询时给字段起个别名时要用小写，如果有大写字母就会转成小写
        $data = $model -> alias('t1') -> field('t1.*,t2.name as parentname')
                -> join('left join tp_dept as t2 on t1.pid=t2.id')
                -> select();
        //引入无限级分类的文件
        load('@/tree');
        $data = getTree($data);
        $this->assign('data',$data);
        $this->display();

    }
    #add方法：展示添加部门的模板文件
    public function add(){
        $model = D('Dept');
        $rst = $model -> select();
        $this->assign('rst', $rst);
        $this->display();
    }

    #addOk方法：用于执行保存数据的操作
    public function addOk(){
       /* $post = I('post.');

        if (M('Dept')->add($post)){
            $this->success('添加成功',U('showList',3));
        } else {
            $this->error('添加失败',U('add'),3);
        }*/

        //使用create创建数据对象
        $model = D('Dept');
        $model -> create();
        if ($model->add()) {
            $this->success('添加成功',U('showList',3));
        } else {
            $this->error('添加失败',U('add'),3);
        }
    }

    #部门删除功能
    public function del(){
        $ids = I('get.ids');
        $model = D('Dept');
        if ($model->delete($ids)) {
            $this->success('删除成功', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList', 3));
        }
    }

    #部门编辑展示
    public function edit(){
        $id = I('get.id');
        $model = D('Dept');
        $rst = $model->find($id);
        $this->assign('rst', $rst);
        $data = $model -> select();
        $this->assign('data', $data);
        $this -> display();
    }

    #用于执行编辑数据的操作
    public function editOk(){
        $post = I('post.');
        $model = D('Dept');
        if ($model -> save($post) !==0) {
            $this -> success('编辑成功', U('showList'), 3);
        } else {
            $this -> error('编辑失败', U('edit', array('id' => $post['id'])));
        }
    }

}