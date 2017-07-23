<?php
namespace Admin\Model;
class GoodsModel extends CommonModel {

    //获取所有商品信息
    public function getAllGoods(){
        $where=array('flag'=>1);
        $order='goods_id desc';
        return $info=$this->getPage('','',$where,'',$order);
    }
    //删除商品
    public function delGoods($goods_id){
        $where=array('goods_id'=>$goods_id);
        return $this->Del($where);
    }
}