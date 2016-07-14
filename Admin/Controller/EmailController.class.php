<?php
//命名空间
namespace Admin\Controller;
//引入父类
use Think\Controller;
//创建类并继承父类
class EmailController extends CommonController{
	
	//空方法
    public function _empty(){
    $this -> display('Empty/empty');
    }
	//send方法，用于展示发送站内信的模板
	public function send(){
		//列出收件人
		$model = M('User');
		$data = $model -> select();
		//展示到模板
		$this -> assign('data',$data);
		$this->display();
	}

	//sendOk方法，接收数据，保存发送的信件到数据表中去
	public function sendOk(){
		$post = I('post.');
		//处理上传
		if($_FILES['file']['size'] > 0){
			$cfg = array(
					'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH
				);
			//实例化
			$upload = new \Think\Upload($cfg);
			//上传操作
			$info = $upload -> uploadOne($_FILES['file']);
			//判断上传结果
			if($info){
				$post['file'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
				$post['hasfile'] = 1;
				$post['filename'] = $info['savename'];

			}
		}
		//保存数据
		$model = M('Email');
		//补伯数据表中的id
		$post['from_id'] = session('uid');
		$post['addtime'] = time();
		$rst = $model -> add($post);

		if($rst){
			$this -> success('发送成功', U('sendBox'), 3);
		}else{
			$this -> error('发送失败', U("send"), 3);
		}
	}

	//sendBox方法，用于输出已存在的信件
	public function sendBox(){
		//实例化
		$model = M('Email');
		$data = $model -> field('t1.*,t2.username') 
						-> table('tp_email as t1,tp_user as t2') 
						-> where('t1.to_id=t2.id and t1.from_id=' . session('uid')) 
						->select();
		//分配变量
		$this -> assign('data', $data);
		$this -> display();
	}

	//download方法，用于下载附件
	public function download(){
		//获取id
		$id = I('get.id');
		//实例化、查询附件信息
		$model = M('Email');
		$data = $model -> find($id);
		//文件下载
		//拼凑下载的文件路径
		$file = WORKING_PATH . $data['file'];
		header("content-type:application/octet-stream");
		header("content-disposition:attachment;filename=" . "'" . basename($file) . "'");
		header("content-length:" . filesize($file));
		readfile($file);
	}

	//删除的方法
	public function del(){
		//接收id
		$id = I('get.id');
		//实例化
		$model = M('Email');
		//调用删除的方法
		$rst = $model -> delete($id);
		if($rst){
			$this -> success('删除成功',U('sendBox'), 3);
		}else{
			$this -> error('删除失败', U('sendBox'), 3);
		}
	}

	//recBox，用示收件箱模板
	public function recBox(){
		//读取数据
		$model = M('Email');
		$data = $model -> field('t1.*,t2.truename') 
						-> table('tp_email as t1,tp_user as t2') 
						->where('t1.from_id = t2.id and to_id = ' . session('uid')) 
						-> select();
		//展示模板
		$this -> assign('data',$data);
		$this->display();
	}

	//getContent方法，查询数据，并echo出来
	public function getContent(){
		$id = I('get.id');
		//实例化、查询、并echo出来
		$model = M('Email');
		$data = $model -> where("id=$id and to_id = " . session('uid')) -> find($id);
		if($data){
			$model -> save(array('id' => $id, 'isread' => 1));
		}

		echo $data['content'];
	}
	

	//getMsgConut方法，获取未读邮件数量
	public function getMsgCount(){
		if(IS_AJAX){
			$model = M('Email');
			$count = $model -> where('isread = 0 and to_id =' . session('uid'))
					-> count();
			echo $count;
		}
		
	}

}