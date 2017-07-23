<?php
namespace Admin\Controller;
//权限控制器
class AuthController extends CommonController {
    //列表展示
    function index(){
        //获得权限列表信息
        $info = D('Auth')->getAllAuth();
        $authinfo=$info['list'];
        //对$info进行递归分类排序处理
        $authinfo = generateTree($authinfo);
        $pageinfo=$info['page'];
        $this->assign('pageinfo',$pageinfo);
        $this->assign('authinfo',$authinfo);

        $this -> display();
    }

    //移除权限
    public function delAuth(){
        if (IS_AJAX){
            if (D('Auth')->delAuth(I('get.auth_id'))){
                echo json_encode(['status'=>200]);
            }else{
                echo json_encode(['status'=>202]);
            }
        }
    }
    //添加权限
    public function add(){
        $auth=D('Auth');
        if (IS_POST){
            $data=I('post.');
            $auth_pid=$data['auth_pid'];
            if ($auth_pid=='0'){
                $data['auth_level']=0;
            }else{
                $auth_level=$auth->getOneAuth($auth_pid);
                $data['auth_level']=$auth_level['auth_level']+1;
            }
            if ($auth->add($data)){
                $this->success('添加权限成功',U('Auth/index'),2);
            }else{
                $this->success('添加权限失败',U('Auth/add'),2);
            }
        }else{
            //获得权限列表信息
            $authinfo = $auth->getAuth();
            //对$info进行递归分类排序处理
            $authinfo = generateTree($authinfo);
            $this->assign('authinfo',$authinfo);
            $this->display();
        }
    }

    //修改权限
    public function edit(){
        $auth = D('Auth');
        if (IS_POST){
            $auth_dis_id = session('auth_dis_id');
            session('auth_dis_id',null);
            if ($auth_dis_id === $_POST['auth_id']){
                //收集数据
                $data = I('post.');
                $auth_pid=$data['auth_pid'];
                if ($auth_pid=='0'){
                    $data['auth_level']=0;
                }else{
                    $auth_level=$auth->getOneAuth($auth_pid);
                    $data['auth_level']=$auth_level['auth_level']+1;
                }
                if ($auth->save($data)){
                    $this -> success('修改权限成功',U('Auth/index'),2);
                }else{
                    $this -> error('修改权限失败',U('Auth/edit',array('auth_id'=>$_POST['auth_id'])),2);
                }
            }else{
                $this -> error('相关参数出问题，请联系管理员',U(('Auth/index')),2);
            }
        }else{
            $auth_id = I('get.auth_id');
            $info = $auth->find($auth_id);

            //获得权限列表信息
            $authinfo = $auth->getAuth();
            //对$info进行递归分类排序处理
            $authinfo = generateTree($authinfo);
            $this->assign('authinfo',$authinfo);

            session('auth_dis_id',$auth_id);

            $this -> assign('info',$info);

            $this -> display();
        }
    }
}
