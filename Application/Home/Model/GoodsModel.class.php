<?php
namespace Home\Model;
use Think\Model;
class GoodsModel extends Model {

    //获取商品所有信息
    public function getAllGoods(){
        return $this->order('goods_id desc')->field('goods_id,goods_name,goods_price,goods_members_price,goods_small_logo')->select();
    }
}