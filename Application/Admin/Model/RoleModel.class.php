<?php
namespace Admin\Model;
class RoleModel extends CommonModel {

    //获取所有角色信息
    public function getAllRole(){
        $where=array('flag'=>1);
        $order='role_id desc';
        return $info=$this->getPage('','',$where,'',$order);
    }
    //删除角色
    public function delAuth($role_id){
        $where=array('role_id'=>$role_id);
        return $this->Del($where);
    }
    //将 “控制器“ ”方法” 组装成 “控制器-方法”
    public function saveAuth($role_id,$auth_id){
        $auth_ids = implode(',',$auth_id);
        $authinfo = D('Auth')-> where(array('auth_id'=>array('in',$auth_ids),'auth_level'=>array('neq','0')))-> select();
        $tmp = array();
        foreach($authinfo as $v){
            $tmp[] = $v['auth_c']."-".$v['auth_a'];
        }
        $acs = implode(',',$tmp);

        $arr = array(
            'role_id' => $role_id,
            'role_auth_ids' => $auth_ids,
            'role_auth_ac' => $acs
        );
        return $this -> save($arr);
    }
}