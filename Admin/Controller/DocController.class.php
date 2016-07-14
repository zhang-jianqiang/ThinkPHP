<?php
//命名名字空间
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;
//创建类并继承父类
class DocController extends CommonController{

	//空方法
    public function _empty(){
    $this -> display('Empty/empty');
    }
	//add方法，展示模板
	public function add(){
		$this->display();
	}

	//addOk方法，保存添加数据
	public function addOk(){
		//接收表单提交的post数据
		$post  = I('post.');
		//实例化
		$model = M('Doc');
		//添加公文提交时间 
		$post['addtime'] = time();
		//实例化上传类
		$cfg = array(
				'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
			);
		$upload = new \Think\Upload($cfg);
		//开始上传
		$info = $upload -> uploadOne($_FILES['file']);
		//判断上传的结果
		if($info){
			//设置表中的filepath字段
			$post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
			//设置表中的filename字段
			$post['filename'] = $info['savename'];
			//设置表中的hasfile字段
			$post['hasfile'] = 1;
		}
		//添加
		$rst = $model -> add($post);
		//判断添加操作是否成功
		if($rst){
			//添加成功 
			$this -> success('添加成功', U('showList'), 3);

		}else{
			$this -> error('添加失败', U('add'), 3);
		}

	}

	//showList方法，获取公文信息展示模板
	public function showList(){
		$model = M('Doc');
		//查询总的记录数
		$count = $model -> count();//查询总的记录数
		$page = new \Think\Page($count,4);//实例化分页类
		$page -> rollPage   = 3;// 分页栏每页显示的页数
		$page -> lastSuffix = false; // 最后一页是否显示总页数
		$page -> setConfig('prev','上一页');//上一页符号修改
		$page -> setConfig('next','下一页');//下一页符号修改
		$page -> setConfig('first', '首页');
		$page -> setConfig('last', '末页');
		$show = $page -> show();//分页显示输出
		$data = $model -> limit($page -> firstRow . ',' . $page -> listRows) -> select();
		$this -> assign('show', $show);
		$this -> assign('data', $data); 
		$this->display();

		/*//实例化
		$model = M('Doc');
		$data = $model -> select();
		//分配变量
		$this -> assign('data', $data);
		$this -> display();*/
	}

	//layer方法，查询弹窗的数据
	public function layer(){
		$id = I('get.id');
		$model = M('Doc');
		$data = $model -> find($id);
		echo $data['content'];
	}

	//文件下载的方法
	public function download(){
		$id = I('get.id');
		//实例化模型
		$model = M('Doc');
		$data = $model -> find($id);
		//并凑文件的完整路径
		$filepath = WORKING_PATH . $data['filepath'];
		//将文件输出
		header("content-type:application/octet-stream");
		header("content-disposition:attachment;filename=" . "'" . basename($filepath) . "'");
		header("content-length: " . filesize($file));
		readfile($filepath);

	}

	//edit方法，用于展示编辑列表
	public function edit(){
		$id = I('get.id');
		$model = M('Doc');
		$data = $model -> find($id);
		$this -> assign('data',$data);
		$this->display();
	}

	//editOk，用于接收数据并保存
	public function editOk(){
		$post = I('post.');
		//判断是否有上传文件
		if($_FILES['file']['size'] > 0){
			$cfg = array(
					'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
				);
			//实例化
			$upload = new \Think\Upload($cfg);
			$info = $upload -> uploadOne($_FILES['file']);

		}
		if($info){
			$post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
			$post['filename'] = $info['savename'];
			$post['hasfile'] = 1;
			dump($info);die;
		}
		//实例化
		$model = M('Doc');
		$rst = $model -> save($post);
		if($rst !== false){
			$this -> success('编辑成功', U('showList'), 3);
		}else{
			$this -> success('编辑失败', U('edit',array('id' => $post.id)), 3);
		}
	}

	//del删除方法
	public function del(){
		$id = I('get.ids');
		//实例化
		$model = M('Doc');
		//执行删除操作
		$rst = $model -> delete($id);
		if($rst){
			$this -> success('删除成功', U('showList'), 3);
		}else{
			$this -> error('删除失败', U('showList'), 3);
		}
	}
}