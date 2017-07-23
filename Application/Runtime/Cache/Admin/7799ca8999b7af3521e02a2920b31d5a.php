<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
  <!--引入jquery-->
<script type="text/javascript" src="/Public/Admin/js/jquery-1.8.2.min.js"></script>
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
</head>

<body>

<script type="text/javascript">
//类型变化显示对应的属性列表信息

//声明全局变量，用于缓存Ajax请求回来的信息
var attr_info_cache = new Array();
function show_attr_info(){
  //① 获取当前选中的类型信息
  var type_id = $('#type_id').val();

  //判断attr_info_cache缓存变量里边如果没有需要信息，才发起Ajax请求
  //如果有，就直接追加给页面即可
  if(typeof attr_info_cache[type_id]=== 'undefined'){
    //② 通过Ajax去服务器端获得type_id类型对应的属性列表信息
    $.ajax({
      url:'/index.php/Admin/Attribute/getAttrInfoByType',
      data:{'type_id':type_id},
      dataType:'json',
      type:'get',
      async:false,
      success:function(msg){
        //console.log(msg);
        //把"msg"与"html标签"结合后显示给页面
        //[{"attr_id":"1","attr_name":"cpu","type_id":"1","attr_sel":"only","attr_write":"manual","attr_vals":"","type_name":"u7cbeu54c1u624bu673a"},{"attr_id":"2","attr_name":"u5916u89c2u6837u5f0f","type_id":"1","attr_sel":"many","attr_write":"list","attr_vals":"u7ffbu76d6,u6ed1u76d6,u76f4u677f,u6298u53e0","type_name":"u7cbeu54c1u624bu673a"},{"attr_id":"3","attr_name":"u5185u5b58u5bb9u91cf","type_id":"1","attr_sel":"only","attr_write":"manual","attr_vals":"","type_name":"u7cbeu54c1u624bu673a"},{"attr_id":"4","attr_name":"u5c4fu5e55u5927u5c0f","type_id":"1","attr_sel":"many","attr_write":"list","attr_vals":"5.0u82f1u5bf8,5.5u82f1u5bf8,6.0u82f1u5bf8","type_name":"u7cbeu54c1u624bu673a"}]

        //遍历msg
        //$.each(msg,function(n,v){});
        //msg:是被遍历的数组对象
        //n:遍历出来子单元的序号
        //v:遍历出来字单元对象
        var s = "";
        $.each(msg,function(n,v){
          s += '<tr> <td height="20" bgcolor="#FFFFFF"><div align="center"> <input type="checkbox" name="checkbox2" id="checkbox2" /> </div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">';
          s += v.attr_id;
          s += '</span></div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
          s += v.attr_name;
          s += '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
          s += v.type_name;
          s += '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
          s += v.attr_sel=='1'?'唯一属性':'单选属性';
          s += '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
          s += v.attr_write=='1'?'手工':'列表选取';
          s += '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">'
          s += v.attr_vals;
          s += '</div></td> <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21"> <img src="/Public/Admin/images/del.gif" width="10" height="10" /> 删除 | 查看 | <a href="/index.php/Admin/Attribute/upd/type_id/1.html" style="color:rgb(59,99,117)"><img src="/Public/Admin/images/edit.gif" width="10" height="10" /> 编辑</a> </div></td> </tr>';<!--?????-->
        });

        //缓存制作好的属性列表信息
        attr_info_cache[type_id] = s;

        //把页面已经显示的属性列表信息删除
        //$('#attr_show tr:gt(1)').remove();
        //把上边设置好的s字符串追加给页面
        //$('#attr_show').append(s);
      }
    });
  }
  //把页面已经显示的属性列表信息删除
  $('#attr_show tr:gt(1)').remove();
  //把上边设置好的s字符串追加给页面
  $('#attr_show').append(attr_info_cache[type_id]);
}
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="/Public/Admin/images/tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 商品管理 -> 属性列表</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <a href="<?php echo U('Attribute/add');?>"><img src="/Public/Admin/images/add.gif" width="10" height="10" /> 添加属性</a>   &nbsp;
              </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
      <input type="hidden" id="chuan_type_id" value="<?php echo ($_GET['type_id']); ?>" />
      <script type="text/javascript">
      //页面加载完毕，就获取上边隐藏域的type_id信息，并设置商品类型下拉列表选中该type_id对应的类型
      $(function(){
        //获得类型列表传递过来的type_id
        var chuan_type_id = $('#chuan_type_id').val(); 
        //使得商品类型选中该chuan_type_id对应的类型
        $('#type_id').val([chuan_type_id]);

        //使得当前商品类型对应的“属性列表”信息展示
        show_attr_info();
      });
      </script>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="attr_show">
      <tr><td colspan='100' width="4%" height="20" bgcolor="d3eaef" class="STYLE10">
        按商品类型显示：
        <select id="type_id" onchange="show_attr_info()">
          <option value="0">-请选择-</option>
          <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): ?><option value="<?php echo ($v["type_id"]); ?>"><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
        </select>
        </td>
      </tr>
      <tr>
        <td width="4%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
          <input type="checkbox" name="checkbox" id="checkbox" />
        </div></td>
        <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">属性id</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">名称</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品类型</span></div></td>
        <td width="12%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">是否可选</span></div></td>
        <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">录入方式</span></div></td>
        <td width="20%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">可选值列表</span></div></td>
        <td width="*" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">基本操作</span></div></td>
      </tr>
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