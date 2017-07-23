<?php
namespace Home\Model;
use Think\Model;
class GoodsAttrModel extends Model {

    //获取某商品(1,唯一属性，2，单选属性)属性信息
    public function getAllArr($goods_id,$type){
        if ($type==1){
            $where=array('ga.goods_id'=>$goods_id,'a.attr_sel'=>1);
            $find='a.attr_id,a.attr_name,ga.attr_value';
            $group='';
        }else{
            $where=array('ga.goods_id'=>$goods_id,'a.attr_sel'=>2);
            $find='a.attr_id,a.attr_name,group_concat(ga.attr_value) attr_values';
            $group='a.attr_id';
        }
        return $this->alias('ga')->join('__ATTRIBUTE__ a on ga.attr_id=a.attr_id')->where($where)->field($find)->group($group)->select();
    }
}