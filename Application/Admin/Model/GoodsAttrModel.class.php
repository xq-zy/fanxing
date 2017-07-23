<?php
namespace Admin\Model;
class GoodsAttrModel extends CommonModel {

    //获取某商品所有属性信息
    public function delAllAttr($goods_id){
        return $this->where(array('goods_id'=>$goods_id))->delete();
    }
}