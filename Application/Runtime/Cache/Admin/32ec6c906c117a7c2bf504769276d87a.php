<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Skiyo 后台管理工作平台 by Jessica</title>
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css"/>
<script type="text/javascript" src="/Public/Admin/js/js.js"></script>
<!--引入jQuery-->
<script type="text/javascript" src="/Public/Admin/js/jquery-1.8.2.min.js"></script>
 <script type="text/javascript">
    $(function () {
        $('#login_code').blur(function () {
            var login_code = $('#login_code').val();
            $.ajax({
                url:"<?php echo U('Login/checkVerify');?>",
                type:'post',
                data:{'login_code':login_code},
                dataType:'json',
                success:function(msg) {
                    if(msg.status == 200){
                        $('#login_code').css({"border":"solid" ,'color':'#153966'});
                    }else if(msg.status == 202){
                        $('#login_code').css({"border":"solid" ,"color":"#ff0000"});
                        $('#safecode').attr('src',"/index.php/Admin/Login/getVerify/"+Math.random());
                    }
                }
            })
        })
    });
  </script>
</head>
<body>
<div id="top">  </div>
<form id="login" name="login" action="" method="post">
  <div id="center">
    <div id="center_left"></div>
    <div id="center_middle">
      <div class="user">
        <label>用户名：
        <input type="text" name="name" id="user" />
        </label>
      </div>
      <div class="user">
        <label>密　码：
        <input type="password" name="pwd" id="pwd" />
        </label>
      </div>
      <div class="chknumber">
        <label>验证码：
        <input name="verify" type="text" id="login_code" maxlength="4" class="chknumber_input" style="vertical-align: middle;" />
        </label>
        <img src="<?php echo U('Login/getVerify');?>" id="safecode" title="点击刷新验证码" width="57" height="20" style="vertical-align: middle;" onclick="this.src='/index.php/Admin/Login/getVerify/'+Math.random()" />
      </div>
    </div>
    <div id="center_middle_right"></div>
    <div id="center_submit">
      <div class="button"> <img src="/Public/Admin/images/dl.gif" width="57" height="20" onclick="form_submit()" > </div>
      <div class="button"> <img src="/Public/Admin/images/cz.gif" width="57" height="20" onclick="form_reset()"> </div>
    </div>
    <div id="center_right" style="color: red;"><?php echo ((isset($errorinfo) && ($errorinfo !== ""))?($errorinfo):""); ?></div>
  </div>
</form>
<div id="footer"></div>
</body>
</html>