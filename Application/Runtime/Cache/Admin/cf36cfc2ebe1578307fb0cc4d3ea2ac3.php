<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
  <!--引入jquery-->
<script type="text/javascript" src="/Public/Admin/js/jquery-1.8.2.min.js"></script>
  <!--引入layer-->
<script type="text/javascript" src="/Public/Public/layer/layer.js"></script>

<style type="text/css">
<!--
body { 
    margin-left: 3px;
    margin-top: 0px;
    margin-right: 3px;
    margin-bottom: 0px;
}
.STYLE1 {
    color: #e1e2e3;
    font-size: 12px;
}
.STYLE6 {color: #000000; font-size: 12px; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 {
    color: #344b50;
    font-size: 12px;
}
.STYLE21 {
    font-size: 12px;
    color: #3b6375;
}
.STYLE22 {
    font-size: 12px;
    color: #295568;
}
a:link{
    color:#e1e2e3; text-decoration:none;
}
a:visited{
    color:#e1e2e3; text-decoration:none;
}
-->
</style>

<script type="text/javascript">
  $(function () {
      $('#role').click(function () {
          $.ajax({
              url:"<?php echo U('Role/add');?>",
              data:{'role_name':$('#role_name').val(),'role_id':$('[type=hidden]').val()},
              dataType:'json',
              type:'post',
              success:function (msg) {
                  if(msg.status ==200){
                      layer.msg(msg.message);
                      setTimeout( 'window.location.href="<?php echo U('Role/redirectUrl');?>"',3000);
                  }else if(msg.status ==202){
                      layer.msg(msg.message);
                      setTimeout('window.location.href ="<?php echo U('Role/add/"+role_id+"/msg.role_id');?>"',2000);
                  }
              }
          })
      })
  })
</script>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo C('AD_IMG_URL');?>tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 权限管理 -> 修改角色</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1"> 
            <a href="<?php echo U('Role/index');?>">角色列表</a>   &nbsp; </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
      <form action="" method="post">
        <input type="hidden" value="<?php echo ($info["role_id"]); ?>" />
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="general-tab-show">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">角色名称：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" id="role_name" name="role_name" value="<?php echo ($info["role_name"]); ?>"/>
        </div></td>
      </tr>
    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td colspan='100'  bgcolor="#FFFFFF"  class="STYLE6" style="text-align:center;">
        <input type="button" value="添加角色" id="role" />
        </td>
      </tr>
    </table>

    </form>
    </td>
  </tr>
</table>
</body>
</html>