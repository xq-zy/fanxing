<?php
namespace Admin\Model;
class GoodsPicsModel extends CommonModel {

    //获取某商品所有相册信息
    public function getAllPics($goods_id){
        return $this->where(array('goods_id'=>$goods_id))->select();
    }
}