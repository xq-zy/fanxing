<?php
namespace Admin\Controller;
use Think\Controller;
//后台管理员登录
class LoginController extends Controller {
    //登录页
    public function index(){
        if (IS_POST) {
            // 检查验证码
            $code=session('login_code');
            session('login_code',null);
            if (!I('post.verify')==$code) {
                $this->assign('errorinfo', '验证码错误');
            }else{
                // 实例化模型
                $Admin = D('Admin');
                // //检查用户名密码
                $userinfo = $Admin->checkLogin(I('post.'));
                if ($userinfo) {
                    // 登录成功
                    session('userinfo', $userinfo); // 将登录信息保存到Session

                    $this->redirect('Index/index');
                }else{
                    $this->assign('errorinfo', '登录失败：用户名或密码错误');
                }
            }
        }
        $this->display();
    }
    //生成验证码
    public function getVerify() {
        $cfg=array(
            'fontSize'  =>  20,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  true,            // 是否添加杂点
            'imageH'    =>  42,               // 验证码图片高度
            'imageW'    =>  150,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',
        );
        $Verify = new \Think\Verify($cfg);
        $Verify->entry();
    }

    //退出系统
    public function logout(){
        session(null); //清空后台所有会话
        $this->redirect('Login/index');
    }

    //验证码验证
    public function checkVerify() {
        if (IS_AJAX){
            $code=I('post.login_code');
            $Verify = new \Think\Verify();
            if ($Verify->check($code)) {
                session('login_code',$code);
                echo json_encode(['status'=>200]);
            }else{
                echo json_encode(['status'=>202]);
            }
        }
    }

    public function _empty($name){
        $this->error('无效的操作：'.$name);
    }
}