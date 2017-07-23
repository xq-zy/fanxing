<?php
namespace Admin\Controller;
//角色控制器
class RoleController extends CommonController {
    //列表展示
    function index(){
        //获得角色列表信息
        $info = D('Role')->getAllRole();
        $roleinfo=$info['list'];
        $pageinfo=$info['page'];
        $this->assign('pageinfo',$pageinfo);
        $this->assign('roleinfo',$roleinfo);

        $this -> display();
    }

    //移除角色
    public function delRole(){
        if (IS_AJAX){
            if (D('Role')->delRole(I('get.role_id'))){
                echo json_encode(['status'=>200]);
            }else{
                echo json_encode(['status'=>202]);
            }
        }
    }
    //添加角色
    public function add(){
        if (IS_AJAX){
            $role=D('Role');
            $data=I('post.');
            if($newId=$role->add($data)){
                session('newId',$newId);
                echo json_encode(array('status'=>200,'message'=>'添加角色成功，即将跳转到分配权限'));
            }else{
                echo json_encode(array('status'=>202,'message'=>'添加角色失败'));
            }
        }
        $this -> display();
    }
    //分配权限跳转
    public function redirectUrl(){
        $role_id = session('newId');
        session('newId',null);
        $this->redirect('Role/distribute',array('role_id'=>$role_id));
    }
    //分配权限
    function distribute(){
        $role = D('Role');
        if (IS_POST){
            $role_dis_id = session('role_dis_id');
            session('role_dis_id',null);
            if ($role_dis_id === $_POST['role_id']){
                //收集数据
                $info = $role -> saveAuth($_POST['role_id'],$_POST['auth_id']);
                if ($info){
                    $this -> success('分配权限成功',U('Role/index'),2);
                }else{
                    $this -> error('分配权限失败',U('Role/distribute',array('role_id'=>$_POST['role_id'])),2);
                }
            }else{
                $this -> error('相关参数出问题，请联系管理员',U(('Role/index')),2);
            }
        }else{
            //获取被分配权限的角色的role_id，并进一步获取该角色的详情信息
            $role_id = I('get.role_id');
            $roleinfo = $role->find($role_id);

            session('role_dis_id',$role_id);
            //把可以用于分配的权限信息获取出来并传递给模板展示
            //获取所有权限
            $info=D('Auth')->getAuth('0','3');
            //分离0,1,2级权限
            foreach($info as $k=>$v){
                if ($v['auth_level']==0){
                    $authinfoA[$k]=$v;
                }else if ($v['auth_level']==1){
                    $authinfoB[$k]=$v;
                }else{
                    $authinfoC[$k]=$v;
                }
            }
            $this -> assign('authinfoA',$authinfoA);
            $this -> assign('authinfoB',$authinfoB);
            $this -> assign('authinfoC',$authinfoC);
            $this -> assign('roleinfo',$roleinfo);

            $this -> display();
        }
    }
}
