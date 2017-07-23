<?php
namespace Admin\Model;
class AdminModel extends CommonModel {
    //判断管理员用户名和密码
    public function checkLogin($info){
        $username =$info['name']; //获取表单用户名
        $password =$info['pwd'];//获取表单密码
        //根据用户名查询密码
        $data = $this->field('id,password,salt,private,regist_time,num')->where(array('username' => $username,'flag'=>array('neq',0)))->find();
        //判断密码
        if($data && $data['password'] == $this->password($password,$data['salt'])){
            //登录次数加1
            $num['num']=$data['num']+1;
            //修改登录次数
            $this->where(array('id'=>$data['id']))->save($num);
            return array('id'=>$data['id'],'private'=>$data['private'],'name'=>$username,'regist_time'=>$data['regist_time'],'login_time'=>time(),'num'=>$num['num']);
        }
        return false;
    }

    //添加管理员
    public function checkRegist($info){
        $info['username']=$info['name'];//获取表单用户名
        $password =$info['pwd'];//获取表单密码
        $password2=$info['pwd2'];
        if ($info['username']!=''){
            if ($password==$password2){
                $info['regist_time'] = time();
                $info['salt'] = substr(md5(time()),5,8);
                $info['password']=$this->password($password,$info['salt']);
                return $this->add($info);
            }
        }
        return false;
    }

    //修改管理员
    public function editAdmin($info){
        $info['username']=$info['name'];//获取表单用户名
        $password =$info['pwd'];//获取表单密码
        $password2=$info['pwd2'];
        if ($info['username']!=''){
            if ($password==$password2){
                $info['salt'] = substr(md5(time()),5,8);
                $info['password']=$this->password($password,$info['salt']);
                return $this->save($info);
            }
        }
        return false;
    }
    //密码加密函数
    private function password($password,$salt){
        return md5(md5($password).$salt);
    }

    //获取管理员角色信息
    public function getOneRole($admin_id){
        $roleinfo=$this->alias('a')->join('__ROLE__ as r on a.role_id=r.role_id')->where(array('a.id'=>$admin_id,'r.flag'=>1))->field('r.role_auth_ids,r.role_name,r.role_auth_ac')->find();
        return $roleinfo;
    }

    //获取所有管理员信息
    public function getAllAdmin(){
        $alias='a';
        $join='__ROLE__ as r on a.role_id=r.role_id';
        $where=array('a.flag'=>1,'a.private'=>1);
        $field='r.role_name,a.*';
        $order='a.id desc';
        return $info=$this->getPage($alias,$join,$where,$field,$order);
    }
    //删除管理员
    public function delAdmin($admin_id){
        $where=array('id'=>$admin_id);
        return $this->Del($where);
    }
}