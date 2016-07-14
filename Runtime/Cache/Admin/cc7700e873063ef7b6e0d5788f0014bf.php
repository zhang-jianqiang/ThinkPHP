<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/Admin/css/base.css" />
	<link rel="stylesheet" href="/Public/Admin/css/login.css" />
	<title>移动办公自动化系统</title>
<style type="text/css">
    .login1 .login-input p input {
        padding: 0 0 0 49px;
        margin-left: 16px;
        width: 183px;
        height: 39px;
        line-height: 39px\0;
        border: none;
        outline: none;
    }    

</style>


</head>
<body>
	<form action="/index.php/Admin/Public/index" method="post">
    <div id="container">
        <div id="bd">
			<div class="login1">
            	<div class="login-top"><h1 class="logo"></h1></div>
                <div class="login-input">
                	<p class="user ue-clear">
                    	<label>用户名</label>
                        <input type="text" name="username" id="username"/><span id="span1"></span>
                    </p>
                    <p class="password ue-clear">
                    	<label>密&nbsp;&nbsp;&nbsp;码</label>
                        <input type="text" name="password" id="password"/><span id="span2"></span>
                    </p>
                    <p class="yzm ue-clear">
                    	<label>验证码</label>
                        <input type="text"  name="captcha" id="captcha" />
                        <cite ><img id="img" style="width:90px;" src="/index.php/Admin/Public/captcha" onclick="src='/index.php/Admin/Public/captcha/num/' + Math.random()" maxlength='4'/></cite><span id="span3"></span>
                    </p>
                </div>
                <div class="login-btn ue-clear">
                	<a href="javascript:;" class="btn" id="btnlogin">登录</a>
                    <div class="remember ue-clear">
                    	<input type="checkbox" id="remember" />
                        <em></em>
                        <label for="remember">记住密码</label>
                    </div>
                </div>
            </div>
        
		</div>
	</div>
    </form>
    <div id="ft">CopyRight&nbsp;2014&nbsp;&nbsp;版权所有&nbsp;&nbsp;uimaker.com专注于ui设计&nbsp;&nbsp;苏ICP备09003079号</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/layer/layer.js"></script>
<script type="text/javascript">
var height = $(window).height();
$("#container").height(height);
$("#bd").css("padding-top",height/2 - $("#bd").height()/2);

$(window).resize(function(){
	var height = $(window).height();
	$("#bd").css("padding-top",$(window).height()/2 - $("#bd").height()/2);
	$("#container").height(height);
	
});

$('#remember').focus(function(){
   $(this).blur();
});

$('#remember').click(function(e) {
	checkRemember($(this));
});

function checkRemember($this){
	if(!-[1,]){
		 if($this.prop("checked")){
			$this.parent().addClass('checked');
		}else{
			$this.parent().removeClass('checked');
		}
	}
}

    //点击登录
   /* $(function(){
       $('#btnlogin').click(function(){
           $('form').submit();
       });
    });*/

    $(function(){
        //判断用户名不能为空
 /*       $('#useranme').on('blur',function(){
            var a = $(this).val();
            if(a == ''){
                $('#span1').css('color','red');
                $('#span1').html('用户名不能为空');
            }

        });
         $('#useranme').on('focus',function(){
                $('#span1').html('');
        });
        //判断密码不能为空
        $('#password').on('blur',function(){
            var a = $(this).val();
            if(a == ''){
                $('#span2').css('color','red');
                $('#span2').html('密码不能为空');
            }

        });*/
  /*      $('#password').on('focus',function(){
                $('#span2').html('');
        });
        //用户名密码或验证码有空时，阻止提交
        $('#btnlogin').on('click',function(){
            if($('#username').val() == '' || $('#password').val() == '' || $('#captcha').val() == '' ){
                //alert('用户名、密码、验证都不能为空');
            //第三方扩展皮肤
            layer.alert('内容', {
              icon: 1,
              skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
            })

            event.preventDefault();
            }else{
                $('form').submit();
            }
        });*/
        $('#btnlogin').on('click',function(){
            var username = $('#username').val();
            var password = $('#password').val();
            var captcha  = $('#captcha').val();
            $.post('/index.php/Admin/Public/index',{username:username,password:password,captcha:captcha},function(data){
                switch(data){
                    case '3':
                        $('#img').attr('src','/index.php/Admin/Public/captcha/num/' + Math.random());
                        //window.location.reload();
                        layer.alert('验证码不正确', {
                          icon: 2,
                          skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                        })
                        $('#img').attr('src','/index.php/Admin/Public/captcha/num/' + Math.random());
                        break;
                    case '2':
                        //window.location.reload();
                        layer.alert('用户名或密码不正确', {
                            icon: 2,
                            skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                            
                        })
                        $('#img').attr('src','/index.php/Admin/Public/captcha/num/' + Math.random());
                        
                        break;
                    case '1':
                        window.location.href = "/index.php/Admin/Public/loginOk";
                        break;
                }
            });

        });
        




    });
    
   


</script>
</html>