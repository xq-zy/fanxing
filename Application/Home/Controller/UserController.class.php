<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    //会员登录
    public function login(){
        if(IS_POST){

            //判断用户名和密码(返回null则说明用户名和密码是错误的)
            $info = D('User')->getOneUser($_POST);
            if($info !== null){
                //持久化用户信息
                session('user_name',$info['username']);
                session('user_id',$info['user_id']);

                $back_url=session('back_url');
                if (!empty($back_url)){
                    session('back_url',null);
                    $this->redirect($back_url);
                }
                //页面跳转到首页
                $this -> redirect('Index/index');
            }
            //把用户名和密码错误的信息传递给模板显示
            $this -> assign('errorinfo','用户名或密码错误');
        }
        $this -> display();
    }

    //会员注册
    public function regist(){
        $this->display();
    }

    //会员退出
    function logout(){
        session(null);
        $this -> redirect("User/login");
    }
}