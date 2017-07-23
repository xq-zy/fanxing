<?php
namespace Admin\Controller;
//后台类型控制器
class TypeController extends CommonController {
    //类型列表
    public function index(){
        //获得类型列表信息
        $info = D('Type')->getAllType();
        $typeinfo=$info['list'];
        $pageinfo=$info['page'];
        $this->assign('pageinfo',$pageinfo);
        $this->assign('typeinfo',$typeinfo);
        $this->display();
    }
    //类型添加
    public function add() {
        $type = D('Type');
        if(IS_POST){
            $data = I('post.');
            if($type->add($data)){
                $this -> success('添加类型成功',U('Type/index'),2);
            }else{
                $this -> error('添加类型失败',U('Type/add'),2);
            }
        }else{
            $this -> display();
        }
    }

    //类型修改
    public function edit(){
        $type = D('Type');
        if(IS_POST){
            //把先前设置好的session的type_id获得出来
            $type_edit_id = session('type_edit_id');

            //判断form表单的隐藏域的type_id没有被修改
            if($type_edit_id===$_POST['type_id']) {
                $data = I('post.');
                if ($type->save($data)) {
                    $this->success('修改类型成功', U('Type/index'), 2);
                } else {
                    $this->error('修改类型失败', U('Type/edit',array('type_id'=>$data['type_id'])), 2);
                }
            }else{
            //修改商品的隐藏域type_id有被动手脚
            $this->error('参数有问题，请联系管理员',U('Type/index'),3);
            }
        }else{
            //展示表单
            //接收被修改商品的id值
            $type_id = I('get.type_id');

            //把当前被修改的商品id信息存储给session,用于后期比较
            session('type_edit_id',$type_id);

            //根据$goods_id获得被修改商品的基本信息并传递给模板
            $typeinfo = D('Type')->find($type_id);
            $this -> assign('typeinfo',$typeinfo);
            $this -> display();
        }
    }

    //移除类型
    public function delType(){
        if (IS_AJAX){
            if (D('Type')->delType(I('get.type_id'))){
                echo json_encode(['status'=>200]);
            }else{
                echo json_encode(['status'=>202]);
            }
        }
    }
}