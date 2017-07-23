<?php
namespace Admin\Controller;
use Think\Controller;
//后台管理员控制器
class AdminController extends CommonController {
    //管理员列表
    public function index(){
        $info=D('Admin')->getAllAdmin();
        $admininfo=$info['list'];
        $pageinfo=$info['page'];
        $this->assign('pageinfo',$pageinfo);
        $this->assign('admininfo',$admininfo);
        $this->display();
    }

    //移除管理员
    public function delAdmin(){
        if (IS_AJAX){
            if (D('Admin')->delAdmin(I('get.admin_id'))){
                echo json_encode(['status'=>200]);
            }else{
                echo json_encode(['status'=>202]);
            }
        }
    }

    //添加管理员
    public function add(){
        $admin = D('Admin');
        if (IS_POST){
            $data = I('post.');
            if ($admin->checkRegist($data)){
                $this -> success('添加管理员成功',U('Admin/index'),2);
            }else{
                $this -> error('添加管理员失败',U('Admin/add'),2);
            }
        }else{
            $role = D('Role');
            $roleinfo = $role -> where(array('flag'=>1))->select();
            $this -> assign('roleinfo',$roleinfo);
            $this -> display();
        }
    }
    //修改管理员
    public function edit(){
        $admin = D('Admin');
        if (IS_POST){
            $id = session('admin_dis_id');
            session('admin_dis_id',null);
            if ($id === $_POST['id']){
                //收集数据
                $data = I('post.');
                if ($admin->editAdmin($data)){
                    $this -> success('修改管理员成功',U('Admin/index'),2);
                }else{
                    $this -> error('修改管理员失败',U('Admin/edit'),2);
                }
            }else{
                $this -> error('相关参数出问题，请联系管理员',U(('Admin/index')),2);
            }
        }else{
            $id = I('get.admin_id');
            $info = $admin->find($id);
            session('admin_dis_id',$id);

            $role = D('Role');
            $roleinfo = $role -> where(array('flag'=>1))->select();

            $this -> assign('roleinfo',$roleinfo);
            $this -> assign('info',$info);

            $this -> display();
        }
    }
}