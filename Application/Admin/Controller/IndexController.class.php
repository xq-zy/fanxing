<?php
namespace Admin\Controller;
//首页控制器
class IndexController extends CommonController {
    //后台首页主框
    public function index(){
        $this->display();
    }
    //后台首页左侧
    public function left(){
        //获取管理员信息
        $admin_id=session('userinfo')['id'];
        $admin_private=session('userinfo')['private'];
        if($admin_private==1){
            //普通管理员
            $roleinfo = D('Admin')->getRole($admin_id);
            $authids = $roleinfo['role_auth_ids'];
            $authinfo = D('Auth')->getAuth($authids);
        }else{
            //系统超级管理员
            $authinfo = D('Auth')->getAuth();
        }
        foreach($authinfo as $k=>$v){
            if (1==$v['auth_level']){
                $authinfoB[]=$v;
            }else{
                $authinfoA[]=$v;
            }
        }
        $this -> assign('authinfoA',$authinfoA);
        $this -> assign('authinfoB',$authinfoB);
        $this->display();
    }
    //后台首页右侧
    public function right(){
        $serverInfo = array(
            //获取服务器信息（操作系统、Apache版本、PHP版本）
            'server_version' => $_SERVER['SERVER_SOFTWARE'],
            //用户IP地址
            'server_ip' => $_SERVER['REMOTE_ADDR'],
            //获取MySQL版本信息
            'mysql_version' => $this->getMySQLVer(),
            //获取服务器时间
            'server_time' => date('Y-m-d H:i:s', time()),
            //上传文件大小限制
            'max_upload' => ini_get('file_uploads') ? ini_get('upload_max_filesize') : '已禁用',
            //脚本最大执行时间
            'max_ex_time' => ini_get('max_execution_time').'秒',
            //注册时间
            'regist_time'=>session('userinfo')['regist_time'],
            //上线时间
            'login_time'=>session('userinfo')['login_time'],
            //登录账号
            'admin_name'=>session('userinfo')['name'],
            //登录次数
            'num'=>session('userinfo')['num'],
        );
        //dump(session('userinfo'));die;
        $this->assign('serverInfo',$serverInfo);
        $this->display();
    }
    //后台首页头部
    public function top(){
        $admin_id=session('userinfo')['id'];
        $info['admin_name']=session('userinfo')['name'];
        $info['role_name']=D('Admin')->getOneRole($admin_id);
        $this->assign('info',$info);
        $this->display();
    }
    //后台首页主体
    public function center(){
        $this->display();
    }
    //后台首页底部
    public function down(){
        $this->display();
    }

    //获取MySQL版本
    private function getMySQLVer(){
        $rst = M()->query('select version() as ver');
        return isset($rst[0]['ver']) ? $rst[0]['ver'] : '未知';
    }
}