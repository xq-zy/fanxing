<?php
namespace Admin\Model;
class AuthModel extends CommonModel {
    //获取0,1级权限信息
    public function getAuth($authids=0,$level=2){
        if ($authids!=0){
            $where=array('flag'=>1,'auth_id'=>array('in',$authids));
        }else{
            $where=array('flag'=>1);
        }
        if ($level==3){
            $where['auth_level']=array('in','0,1,2');
        }else{
            $where['auth_level']=array('in','0,1');
        }
        $authinfo = $this->where($where)->select();
        return $authinfo;
    }

    //获取所有权限信息
    public function getAllAuth(){
        $where=array('flag'=>1);
        $order='auth_id desc';
        return $info=$this->getPage('','',$where,'',$order);
    }
    //删除权限
    public function delAuth($auth_id){
        $where=array('auth_id'=>$auth_id);
        return $this->Del($where);
    }
    //获取一条权限信息
    public function getOneAuth($auth_pid){
        return $info=$this->where(array('auth_id'=>$auth_pid))->find();
    }
}