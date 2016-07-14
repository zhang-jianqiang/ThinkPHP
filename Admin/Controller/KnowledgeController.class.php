<?php
//命名名字空间
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;

class KnowledgeController extends CommonController{

	//空方法
    public function _empty(){
    $this -> display('Empty/empty');
    }
	//add方法，展示模板
	public function add(){
		$this->display();
	}

	//addOk方法，接收数据并保存到数据表中
	public function addOk(){
		$post = I('post.');
		//上传操作
		if($_FILES['thumb']['size'] > 0){
			$cfg = array(
					'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
				);
			//实例化上传类
			$upload = new \Think\Upload($cfg);
			$info = $upload -> uploadOne($_FILES['thumb']);
		}

		if($info){
			//上传成功的处理
			$post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
			$img = new \Think\Image();
			$pic = WORKING_PATH . $post['picture'];
			$img -> open($pic);
			//制作缩略图
			$img -> thumb(100,100);
			//保存图片
			$pos = WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
			$img -> save($pos);
			//并凑thumb字段的数据
			$post['thumb'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
		}
		//实例化
		$model = M('Knowledge');
		//添加当前时间戳
		$post['addtime'] = time();
		//添加操作
		$rst = $model -> add($post);
		if($rst){
			$this -> success('添加成功', U('showList'), 3);
		}else{
			$this -> error('添加失败', U('add'), 3);
		}
	}

	//showList
	public function showList(){
		//获取数据
		$model = M('Knowledge');
		//查询
		$data = $model -> select();
		//分配变量
		$this -> assign('data',$data);
		$this->display();
	}

	//edit方法，用于数据回显，并展示模板
	public function edit(){
		$id = I('get.id');
		//实例化
		$model = M('Knowledge');
		$data = $model -> find($id);
		//分配变量
		$this -> assign('data',$data);
		$this->display();
	}

	//editOk方法，接收post数据，附件上传、缩略图，保存
	public function editOk(){
		$post = I('post.');
		$post['addtime'] = time();
		if($_FILES['thumb']['size'] > 0){
			$cfg = array(
					'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
				);
			//实例化文件上传类
			$upload = new \Think\Upload($cfg);
			//调用上传方法
			$info = $upload -> uploadOne($_FILES['thumb']);
			//判断上传结果
			if($info){
				//修改picture字段
				$post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
				$img = new \Think\Image();
				//打开图片
				$pic = WORKING_PATH . $post['picture'];
				$img -> open($pic);
				//制作缩略图
				$img -> thumb(100,100);
				//保存缩略图
				$pos = WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
				$img -> save($pos);
				$post['thumb'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
	
			}
		}

		//数据保存
		$model = M('Knowledge');
		$rst = $model -> save($post);
		if($rst !== false){
			$this -> success('修改成功', U('showList'), 3);
		}else{
			$this -> error('修改失败', U('showList'), 3);
		}
	}

	//del方法，接收id，删除数据
	public function del(){
		$id = I('get.id');
		//实例化
		$model = M('Knowledge');
		//调用删除的方法
		$rst = $model -> delete($id);
		if($rst){
			$this -> success('删除成功', U('showList'), 3);
		}else{
			$this -> error('删除失败', U('showList'), 3);
		}
	}

}