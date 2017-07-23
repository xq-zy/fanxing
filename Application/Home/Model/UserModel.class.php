<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model {
    //判断会员用户名和密码
    public function getOneUser($info){
        $name =$info['username']; //获取表单用户名
        $password =$info['password'];//获取表单密码
        //根据用户名查询密码
        $data = $this->where(array('username'=>$name))->find();

        //判断密码
        if($data && $data['password'] == $this->password($password,$data['salt'])){
            //最后登录时间
            $time['last_time']=time();
            //修改登录次数
            $this->where(array('user_id'=>$data['user_id']))->save($time);
            return $data;
        }
        return false;
    }

    //密码加密函数
    private function password($password,$salt){
        return md5(md5($password).$salt);
    }
}