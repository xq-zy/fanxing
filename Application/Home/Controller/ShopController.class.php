<?php
namespace Home\Controller;
use Think\Controller;

//购物控制器
class ShopController extends Controller {
    //添加商品到购物车
    function addCart(){
        if(IS_AJAX){
            $goods_id = I('get.goods_id');//被添加商品的goods_id
            //获得被添加商品的相关信息
            $info = D('Goods')->find($goods_id);

            //把被添加的商品信息组织为array数组形式
            //array('goods_id'=>'商品id','goods_name'=>'名称','goods_price'=>'单价','goods_buy_number'=>'购买数量','goods_total_price'=>数量*单价)
            $data['goods_id']          = $info['goods_id'];
            $data['goods_name']        = $info['goods_name'];
            $data['goods_price']       = $info['goods_price'];
            $data['goods_buy_number']  = 1;
            $data['goods_total_price'] = $info['goods_price'];
            //给购物车添加商品
            $cart = new \Org\Util\Cart();
            $cart -> add($data);

            //把更新后的购物车商品总数量和总价格获得并返回
            $number_price = $cart -> getNumberPrice();
            //array('number'=>xx,'price'=>xx)
            echo json_encode($number_price);
        }
    }

    //使得购物车商品数量发生变化
    function changeNumber(){
        if(IS_AJAX){
            //获得客户端传递过来的goods_id和num
            $goods_id = I('post.goods_id');
            $num = I('post.num');

            //使得购物车商品数量发生变化
            $cart = new \Org\Util\Cart();
            $xiaoji_price = $cart -> changeNumber($num,$goods_id);

            //获得目前购物车商品总价格
            $number_price = $cart -> getNumberPrice();

            echo json_encode(array(
                'total_price'=>$number_price['price'],
                'xiaoji_price'=>$xiaoji_price));
        }
    }

    //删除购物车商品
    function delGoods(){
        $goods_id = I('get.goods_id');//获得被删除商品的goods_id

        //删除购物车指定的商品
        $cart = new \Org\Util\Cart();
        $cart -> del($goods_id);

        //获得删除后的购物车商品总金额
        $number_price = $cart -> getNumberPrice();
        echo json_encode($number_price);
    }

    //购物车信息列表显示
    function flow1(){
        //获取购物车商品信息
        $cart = new \Org\Util\Cart();
        $cartinfo = $cart -> getCartInfo();//获得购物车商品信息

        //获得购物车商品的图片信息(数据表字段：goods_small_logo)
        //获得购物车商品的goods_id信息，并拼装为字符串
        $goods_ids = implode(',',array_keys($cartinfo));//string(5) "21,18"

        //通过$goods_ids获取商品的小图信息
        $logoinfo = D('Goods')
            ->field('goods_id,goods_small_logo')
            ->select($goods_ids);
        //dump($logoinfo);

        //整合，使得$logoinfo的图片信息添加进$cartinfo 里边去 
        foreach($cartinfo as $k => $v){
            foreach($logoinfo as $vv){
                if($k == $vv['goods_id']){ //购物车商品 与 图片商品对应上
                    //把logo图片添加进$cartinfo的数组里边
                    $cartinfo[$k]['logo'] = $vv['goods_small_logo'];
                }
            }
        }
        //dump($cartinfo);
        $this -> assign('cartinfo',$cartinfo);

        //获得购物车商品金额总计
        $number_price = $cart -> getNumberPrice();
        $this -> assign('number_price',$number_price);

        $this -> display();
    }
    //生成订单准备页面
    public function flow2(){
        if (IS_POST){
            //获取数据
            $cart = new \Org\Util\Cart();
            $number_price=$cart->getNumberPrice();
            $data=I('post.');
            $data['user_id']=session('user_id');
            $data['order_number']="itcast-shop-".date("YmdHis")."-".mt_rand(1000,9999);
            $data['order_price']=$number_price['price'];
            $data['add_time']=$data['upd_time']=time();
            $order_id=D('Order')->add($data);
            $cartinfo=$cart->getCartInfo();
            $data2=array();
            foreach ($cartinfo as $k=>$v){
                $data2['order_id']=$order_id;
                $data2['goods_id']=$k;
                $data2['goods_price']=$v['goods_price'];
                $data2['goods_number']=$v['goods_buy_number'];
                $data2['goods_total_price']=$v['goods_total_price'];
                D('OrderGoods')->add($data2);
            }
            $cart->delAll();
            echo "订单形成中。。。。。。";
        }else{
            $user_name=session('user_name');
            if (empty($user_name)){
                session('back_url','Shop/flow2');
                $this->redirect('User/login');
            }
            //获取购物车商品信息
            $cart = new \Org\Util\Cart();
            $cartinfo = $cart -> getCartInfo();//获得购物车商品信息

            //获得购物车商品的图片信息(数据表字段：goods_small_logo)
            //获得购物车商品的goods_id信息，并拼装为字符串
            $goods_ids = implode(',',array_keys($cartinfo));//string(5) "21,18"

            //通过$goods_ids获取商品的小图信息
            $logoinfo = D('Goods')
                ->field('goods_id,goods_small_logo')
                ->select($goods_ids);
            //dump($logoinfo);

            //整合，使得$logoinfo的图片信息添加进$cartinfo 里边去
            foreach($cartinfo as $k => $v){
                foreach($logoinfo as $vv){
                    if($k == $vv['goods_id']){ //购物车商品 与 图片商品对应上
                        //把logo图片添加进$cartinfo的数组里边
                        $cartinfo[$k]['logo'] = $vv['goods_small_logo'];
                    }
                }
            }
            //dump($cartinfo);
            $this -> assign('cartinfo',$cartinfo);

            //获得购物车商品金额总计
            $number_price = $cart -> getNumberPrice();
            $this -> assign('number_price',$number_price);
            $this->display();
        }
    }
}
