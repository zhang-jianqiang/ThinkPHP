<?php
//命名名字空间
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;
//创建类并继承父类
class UserController extends CommonController{

	//空方法
    public function _empty(){
    $this -> display('Empty/empty');
    }
    
	//add方法，展示添加模板
	public function add(){
		$model = M('Dept');
		$data = $model -> select();
		//处理数据，实现无限级分类效果
		load('@/tree');
		$data = getTree($data);
		$this -> assign('data', $data);
		$this->display();
	}

	//addOk方法，保存添加数据
	public function addOk(){
		$_POST['addtime'] = time();
		$model = M('User');
		$rst = $model -> create();
		if ($rst) {
			$this -> success('添加成功', U('showList'), 3);
		} else {
			$this -> error('添加失败', U('add'), 3);
		}
	}

	//showList方法，展示模板
	public function showList(){
		$model = M('User');//实例化模型
		$count = $model -> count();//查询总的记录数
		$page = new \Think\Page($count,1);//实例化分页类
		$page -> rollPage   = 3;// 分页栏每页显示的页数
		$page -> lastSuffix = false; // 最后一页是否显示总页数
		$page -> setConfig('prev','上一页');//上一页符号修改
		$page -> setConfig('next','下一页');//下一页符号修改
		$page -> setConfig('first', '首页');
		$page -> setConfig('last', '末页');
		$show = $page -> show();//分页显示输出
		$data = $model -> limit($page -> firstRow . ',' . $page -> listRows) -> select();
		$dept = M('Dept');
		foreach ($data as $key => $value) {
			$depts = $dept -> find($value['dept_id']);
			$data[$key]['dept_name'] = $depts['name'];
		}
		$this -> assign('show', $show);
		$this -> assign('data', $data); 
		$this->display();
	}

	//edit方法，展示编辑列表
	public function edit(){
		$id = I('get.id');
		$model = M('User');
		$data = $model -> find($id);
		$model = M('Dept');
		$depts = $model -> select();
		load('@/tree');
		$depts = getTree($depts);
		$this -> assign('data',$data);
		$this -> assign('depts', $depts);
		$this -> display();
	}

	//editOk方法，保存编辑数据
	public function editOk(){
		$post = I('post.');
		if ($post['password'] == '') {
			unset($post['password']);
		}
		//实例化
		$model = M('User');
		$rst = $model -> save($post);
		if ($rst){
			$this -> success('修改成功', U('showList'), 3);
		}else {
			$this -> error('修改失败', U('edit', array('id' => $post['id'])), 3);
		}
	}

	//delete方法，删除用户信息
	public function delete(){
		$id = I('get.id');
		//实例化模型
		$model = M('User');
		//执行delete方法
		$rst = $model -> delete($id);
		if ($rst){
			$this -> success('删除成功', U('showList'), 3);
		}else{
			$this -> error('删除失败', U('showList'), 3);
		}
		
	}

	//charts方法，用于统计每个部门有多少人
	public function charts(){
		//实例化模型
		$model = M();
		$sql = "select t1.name as dept_name,count(t2.id) as count from tp_dept as t1 left join tp_user as t2 on t1.id = t2.dept_id  group by dept_name having count > 0;";
		//执行aql语句
		$data = $model -> query($sql);
		//拼凑数据,按照原表的数据进行格式
		$str = '[';
		foreach ($data as $key => $value) {
			$str .= "['" . $value['dept_name'] . "'," . $value['count'] . "],";
		}
		//去除最后一个多余的逗号
		$str = rtrim($str, ',');
		$str .= ']';
		dump($str);
		//变量分配 
		$this -> assign('str', $str);
		$this -> display();
	}


}