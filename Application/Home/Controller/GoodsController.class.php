<?php
namespace Home\Controller;
use Think\Controller;
//前台商品控制器
class GoodsController extends Controller {
    //商品列表
    public function index(){
        //获得商品列表信息
        $goodsinfo = D('Goods')->getAllGoods();
        $this -> assign('goodsinfo',$goodsinfo);

        $this -> display();
    }

    public function detail(){
        $goods_id = I('get.goods_id');//获得被查看商品的$goods_id信息
        //把被查看商品的基本信息查询出来
        $goodsinfo = D('Goods')->find($goods_id);
        $this -> assign('goodsinfo',$goodsinfo);

        //获得商品的唯一属性(sp_goods_attr和sp_attribute联表)
        //获取某商品(1,唯一属性，2，单选属性)属性信息
        $onlyinfo = D('GoodsAttr')->getAllArr($goods_id,1);
        $this -> assign('onlyinfo',$onlyinfo);

        //获得商品的单选属性(sp_goods_attr和sp_attribute联表)
        //获取某商品(1,唯一属性，2，单选属性)属性信息
        $manyinfo = D('GoodsAttr')->getAllArr($goods_id,2);

        //对$manyinfo数组进行整理，以方便模板的使用
        foreach($manyinfo as $k => $v){
            $manyinfo[$k]['values'] = explode(',',$v['attr_values']);//String-->Array
        }
        //dump($manyinfo);
        $this -> assign('manyinfo',$manyinfo);

        //获取商品的相册图片信息
        $picsinfo = D('GoodsPics')->getAllPics($goods_id);
        $this -> assign('picsinfo',$picsinfo);

        $this -> display();
    }
}