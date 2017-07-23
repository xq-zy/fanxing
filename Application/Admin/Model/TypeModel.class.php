<?php
namespace Admin\Model;
class TypeModel extends CommonModel {

    //获取所有类型信息
    public function getAllType(){
        $where=array('flag'=>1);
        $order='type_id desc';
        return $info=$this->getPage('','',$where,'',$order);
    }

    public function getAllType2(){
        return $this->where(array('flag'=>1))->select();
    }
    //删除类型
    public function delType($type_id){
        $where=array('type_id'=>$type_id);
        return $this->Del($where);
    }
}