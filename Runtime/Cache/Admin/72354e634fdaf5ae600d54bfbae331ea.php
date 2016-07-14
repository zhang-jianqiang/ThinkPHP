<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<title>移动办公自动化系统</title>
</head>

<body>
<div class="title"><h2>信息登记</h2></div>
<form action="/index.php/Admin/Dept/editOk" method="post">
	<div class="main">
	    <p class="short-input ue-clear">
	    	<label>部门名称：</label>
	        <input type="text" name="name" placeholder="部门名称" value="<?php echo ($rst["name"]); ?>" />
	    </p>
	    <div class="short-input select ue-clear">
	    	<label>上级部门：</label>
	        <div class="select-wrap">
	        	<select name="pid">
					<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["id"]); ?>"
					<?php if($vol['id'] == $rst['id']): ?>selected;<?php endif; ?>
					><?php echo ($vol["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	            </select>
	        </div>
	    </div>
	    <p class="short-input ue-clear">
	    	<label>排序：</label>
	        <input type="text" name="sort" placeholder="排序" value="<?php echo ($rst["sort"]); ?>" />
			<input type="hidden" value="<?php echo ($rst["id"]); ?>" name="id">
	    </p>
	    <p class="short-input ue-clear">
	    	<label>备注：</label>
	        <textarea placeholder="备注" name="remark"><?php echo ($rst["remark"]); ?></textarea>
	    </p>
	</div>
	<div class="btn ue-clear">
		<a href="javascript:;" id="btnsubmit" class="confirm">确定</a>
	    <a href="javascript:;" id="btncancel" class="clear">清空内容</a>
	</div>
</form>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript">
$(".select-title").on("click",function(){
	$(".select-list").toggle();
	return false;
});
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(".select-title").find("span").text(txt);
});

//确定、清空操作
$(function(){
	//确定提交操作
	$('#btnsubmit').click(function(){
		$('form').submit();
	});

	//清空操作
	$('#btncancel').click(function(){
		$('form')[0].reset();
	});
});
showRemind('input[type=text], textarea','placeholder');
</script>
</html>