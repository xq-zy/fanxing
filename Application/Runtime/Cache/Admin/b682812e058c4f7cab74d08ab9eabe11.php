<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
  <!--引入jquery-->
<script type="text/javascript" src="/Public/Admin/js/jquery-1.8.2.min.js"></script>
  <!--引入layer-->
<script type="text/javascript" src="/Public/Public/layer/layer.js"></script>
<script type="text/javascript">
  $(function () {
     $('.delAdmin').click(function () {
         var admin=$(this).parent().parent().parent().find('td:eq(2) div').html();
         var admin_id=$(this).parent().parent().parent().find('td:eq(1) input').val();
         layer.confirm('你确认要移除管理员：'+admin, {
             btn: ['确认','取消'] //按钮
         }, function(){
             $.ajax({
                 url:'<?php echo U("Admin/delAdmin");?>',
                 data:{'admin_id':admin_id},
                 dataType:'json',
                 type:'get',
                 success:function (msg) {
                     if (msg.status==200){
                         layer.confirm('移除成功', {
                             btn: ['确认'] //按钮
                         },function () {
                             location.reload();
                         });
                     }else if(msg.status==202){
                         layer.confirm('移除失败', {
                             btn: ['确认'] //按钮
                         },function () {
                             layer.msg({
                                 time: 1000, //20s后自动关闭
                             });
                         });
                     }
                 }
             });
         }, function(){
             layer.msg({
                 time: 1000, //20s后自动关闭
             });
         });
     });
  });
</script>
<style type="text/css">
  
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
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="/Public/Admin/images/tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 权限管理 -> 管理员列表</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <a href="<?php echo U('Admin/add');?>"><img src="/Public/Admin/images/add.gif" width="10" height="10" /> 添加管理员</a>   &nbsp;
              </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td width="4%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
          <input type="checkbox" name="checkbox" id="checkbox" />
        </div></td>
        <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">序号</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">名称</span></div></td>
        <td width="7%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">角色</span></div></td>
        <td width="30%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">注册时间</span></div></td>
        <td width="*%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">基本操作</span></div></td>
      </tr>
      <?php if(is_array($admininfo)): foreach($admininfo as $key=>$v): ?><tr>
        <td height="20" bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" name="checkbox2" id="checkbox2" />
        </div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19"><?php echo ($v["id"]); ?><input type="hidden" value="<?php echo ($v["id"]); ?>" /></span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["username"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["role_name"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
          <div align="center">
            <?php if(($v["regist_time"]) == "0"): ?>无
            <?php else: ?>
               <?php echo (date('Y-m-d H:i:s',$v["regist_time"])); endif; ?>
          </div>
        </td>
        <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21">
          <a href="javascript:;" style='color:red;' class="delAdmin">移除</a> | <a href="<?php echo U('Admin/edit',array('admin_id'=>$v['id']));?>" style="color:rgb(59,99,117)"> 修改 </a></div></td>
      </tr><?php endforeach; endif; ?>
    </table></td>
  </tr>
  <tr>
    <td height="30">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><?php echo ($pageinfo); ?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>