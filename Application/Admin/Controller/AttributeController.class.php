<?php
namespace Admin\Controller;
//后台属性控制器
class AttributeController extends CommonController {
    //属性列表
    public function index(){
        //获取下拉列表展示的“商品类型”信息
        $typeinfo = D('Type')->getAllType2();
        $this -> assign('typeinfo',$typeinfo);

        $this -> display();
    }

    //根据类型type_id获得对应的属性列表信息
    public function getAttrInfoByType(){
        if(IS_AJAX){
            //获取传递过来的类型type_id
            $type_id = I('get.type_id');

            //根据$type_id获取对应的属性列表信息
            if($type_id>0){
                //获得具体类型的属性信息
                $info = D('Attribute')->getByAllAttr($type_id);
            }else{
                //获得"全部"的属性信息
                $info = D('Attribute')->getAllAttr();
            }
            echo json_encode($info);
        }
    }

    //添加属性
    public function add(){
        $Attribute = D('Attribute');
        if(IS_POST){
            //$shuju = I('post.');
            //create()方法可以触发自动验证执行，如果返回false则说明验证失败
            $data = $Attribute->create();
            if($data!==false){
                //把可选值的"中文逗号" 替换为 "英文逗号"
                $data['attr_vals'] = str_replace('，',',',$data['attr_vals']);
                if($Attribute->add($data)){
                    $this -> success('添加属性成功',U('Attribute/index'),2);
                }else{
                    $this -> error('添加属性失败',U('Attribute/add'),2);
                }
                exit;
            }else{
                //验证出现问题，把错误信息传递给模板展示
                //getError()会把验证的错误信息通过关联数组形式返还
                //array('attr_name'=>'属性名称必须设置','type_id'=>'商品类型必须选取')
                $this -> assign('errorinfo',$Attribute->getError());
            }
        }
        //获取可供选取的商品属性信息
        $typeinfo = D('Type')->getAllType2();
        $this -> assign('typeinfo',$typeinfo);

        $this -> display();
    }
}