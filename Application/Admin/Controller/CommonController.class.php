<?php
namespace Admin\Controller;
use Think\Controller;
//后台公共控制器
class CommonController extends Controller {
    //构造方法
    public function __construct(){
        parent::__construct();//先执行父类构造方法
        $this->checkUser();//登录检查
        //已经登录，为模板分配用户名变量
        $admin_id=session('userinfo')['id'];
        $admin_private=session('userinfo')['private'];
        if ($admin_private==1){
            //获取角色信息
            $roleinfo=D('Admin')->getOneRole($admin_id);
            session('userinfo.role',$roleinfo['role_name']);

            //当前访问的控制器-操作方法
            //MODULE_NAME:分组名称
            //CONTROLLER_NAME:控制器名称
            //ACTION_NAME:操作方法名称
            $nowAC=CONTROLLER_NAME.'-'.ACTION_NAME;

            //角色权限
            $have_auth=$roleinfo['role_auth_ac'];
            //登录者公共权限
            $allow_auth="Index-top,Index-left,Index-center,Index-down,Index-right,Index-index";
            if (strpos($have_auth,$nowAC)===false&&strpos($allow_auth,$nowAC)===false &&!IS_AJAX){
                exit('没有权限访问');
            }
        }
    }
    //检查用户是否已经登录
    private function checkUser(){
        if(!session('?userinfo')){
            //未登录，请先登录
            $js = <<<eof
                    <script type="text/javascript">
                        window.top.location.href="/index.php/Admin/login/index";
                    </script>
eof;
            echo $js;
        }
    }
    public function _empty($name){
        $this->error('无效的操作：'.$name);
    }
}