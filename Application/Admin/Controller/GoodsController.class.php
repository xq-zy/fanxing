<?php
namespace Admin\Controller;
//后台商品控制器
class GoodsController extends CommonController {
    //商品列表
    public function index(){
        //获得商品列表信息
        $info = D('Goods')->getAllGoods();
        $goodsinfo=$info['list'];
        $pageinfo=$info['page'];
        $this->assign('pageinfo',$pageinfo);
        $this->assign('goodsinfo',$goodsinfo);
        $this->display();
    }
    //商品添加
    public function add() {
        $goods=D('Goods');
        if (IS_POST){
            //dump($_FILES);die;
            //给商品实现logo图片上传
            $this -> deal_logo();
            //收集信息
            $data=I('post.');
            //维护时间字段
            //要直接收集原生的富文本编辑器信息(不能使用I()函数)
            //并且使用PreventXSS函数实现信息的过滤处理
            $data['add_time']=$data['edit_time']=time();
            $data['goods_introduce'] = \PreventXSS($_POST['goods_introduce']);
            if ($newid=$goods->add($data)){
                //相册维护
                $this -> deal_pics($newid);
                //属性信息维护
                $this -> deal_attr($newid);
                $this->success('添加商品成功',U('Goods/index'),2);
            }else{
                $this->error('添加商品失败',U('Goods/add'),2);
            }
        }else{
            //展示表单
            //获取类型信息
            $typeinfo = D('Type')->getAllType2();
            $this -> assign('typeinfo',$typeinfo);

            $this->display();
        }
    }

    //商品修改
    public function edit(){
        if(IS_POST){
            //把先前设置好的session的goods_id获得出来
            $goods_edit_id = session('goods_edit_id');

            //判断form表单的隐藏域的goods_id没有被修改
            if($goods_edit_id===$_POST['goods_id']){
                //商品logo图片修改处理
                $this -> deal_logo($_POST['goods_id']);
                //商品相册图片上传处理
                $this -> deal_pics($_POST['goods_id']);
                //实现属性信息收集入库
                //$this -> deal_attr($_POST['goods_id']);

                //收集表单
                //dump($_POST);
                //exit;
                $data = I('post.');//处理收集form表单信息
                $data['edit_time'] = time();//更新upd_time修改时间字段
                //要直接收集原生的富文本编辑器信息(不能使用I()函数)
                //并且使用PreventXSS()函数实现信息的过滤处理
                $data['goods_introduce'] = \PreventXSS($_POST['goods_introduce']);
                if(D('Goods')->save($data)){

                    $this -> success('修改商品成功',U('Goods/index'),2);
                }else{
                    $this -> error('修改商品失败',U('Goods/edit',array('goods_id'=>$data['goods_id'])),2);
                }
            }else{
                //upd.html修改商品的隐藏域goods_id有被动手脚
                $this->error('参数有问题，请联系管理员',U('Goods/index'),3);
            }
        }else{
            //展示表单
            //接收被修改商品的id值
            $goods_id = I('get.goods_id');

            //把当前被修改的商品id信息存储给session,用于后期比较
            session('goods_edit_id',$goods_id);

            //根据$goods_id获得被修改商品的基本信息并传递给模板
            $info = D('Goods')->find($goods_id);
            $this -> assign('info',$info);

            //获取被修改商品的相册，并传递给模板
            $picsinfo = D('GoodsPics')->getAllPics($goods_id);
            $this -> assign('picsinfo',$picsinfo);

            //获得商品类型信息
            $typeinfo = D('Type')->select();
            $this -> assign('typeinfo',$typeinfo);

            $this -> display();
        }
    }

    //实现商品logo图片上传处理
    //$goods_id:为0 表示是新增商品logo处理
    //$goods_id:非0 表示是修改商品logo处理
    private function deal_logo($goods_id=0){
        //给商品实现logo图片上传
        //dump($_FILES);
        if($_FILES['goods_logo']['error']===0){
            //修改商品时，要把该商品原先的logo物理图片文件给删除-start
            if($goods_id!=0){
                $goodsinfo = D('Goods')->find($goods_id);
                if(file_exists('.'.$goodsinfo['goods_big_logo'])){
                    unlink('.'.$goodsinfo['goods_big_logo']);
                }
                if(file_exists('.'.$goodsinfo['goods_small_logo'])){
                    unlink('.'.$goodsinfo['goods_small_logo']);
                }
            }
            //修改商品时，要把该商品原先的logo物理图片文件给删除-end

            //① 上传logo图片
            //有正常上传附件
            $cfg = array(
                'rootPath'      =>  './Public/Uploads/logo/', //保存根路径
            );
            $upload = new \Think\Upload($cfg);
            //uploadOne()方法会返回附件的上传子目录 和 名字信息
            $data = $upload -> uploadOne($_FILES['goods_logo']);
            //dump($z);

            //把上传好的附件存储给数据库,具体存储附件路径名
            //./Public/Uploads/logo/2017-02-09/589be3664197e.jpg
            $_POST['goods_big_logo'] = $upload->rootPath.$data['savepath'].$data['savename'];

            //② 对logo图片制作缩略图
            $img = new \Think\Image();//创建对象
            $img -> open($_POST['goods_big_logo']);//找到被处理原图并打开
            $img -> thumb(130,130,6);//制作缩略图，严格缩放大小为130*130
            //制作好的缩略图存储到服务器
            //./Public/Uploads/logo/2017-02-09/small_589be3664197e.jpg
            $smallPathName = $upload->rootPath.$data['savepath'].'small_'.$data['savename'];
            $img -> save($smallPathName);

            //缩略图存储到数据库中
            $_POST['goods_small_logo'] = substr($smallPathName,1);
            $_POST['goods_big_logo']=substr($_POST['goods_big_logo'],1);
        }
    }

    //实现相册上传维护
    private function deal_pics($goods_id){
        //判断是否有上传相册(至少有一个也可以)
        $havePics = false;
        foreach($_FILES['goods_pics']['error'] as $v){
            if($v===0){
                $havePics = true;
                break;
            }
        }

        //有上传相册才处理
        if($havePics === true){
            //dump($_FILES);
            $cfgs = array(
                'rootPath'      =>  './Public/Uploads/pics/', //保存根路径
            );
            $uploads = new \Think\Upload($cfgs);

            //相册批量上传处理，upload(二维数组)
            $datas = $uploads -> upload(array($_FILES['goods_pics']));
            //dump($z2);

            //给相册制作缩略图，遍历$z2获得每个已经上传好的相册图片
            $imgs = new \Think\Image();
            foreach($datas as $k => $v){
                //获得原相册路径名  2017-02-09/589c348a870a9.jpg
                $data_pics = $uploads->rootPath.$v['savepath'].$v['savename'];

                $imgs -> open($data_pics);//打开原图
                //缩略图范围：800*800   350*350   50*50
                //同一个原图可以同时制作多个大小不同的缩略图
                //要求：缩略图由大到小的顺序制作

                $imgs -> thumb(800,800,6);
                //2017-02-09/big_589c348a870a9.jpg
                $pics_big = $uploads->rootPath.$v['savepath'].'big_'.$v['savename'];
                $imgs -> save($pics_big);//存储缩略图

                $imgs -> thumb(350,350,6);
                //2017-02-09/mid_589c348a870a9.jpg
                $pics_mid = $uploads->rootPath.$v['savepath'].'mid_'.$v['savename'];
                $imgs -> save($pics_mid);//存储缩略图

                $imgs -> thumb(50,50,6);
                //2017-02-09/sma_589c348a870a9.jpg
                $pics_sma = $uploads->rootPath.$v['savepath'].'sma_'.$v['savename'];
                $imgs -> save($pics_sma);//存储缩略图

                //删除无用的原图
                unlink($data_pics);

                //把缩略图相册存储给数据库
                $arr = array(
                    'goods_id'=>$goods_id,
                    'pics_big'=>substr($pics_big,1),
                    'pics_mid'=>substr($pics_mid,1),
                    'pics_sma'=>substr($pics_sma,1),
                );
                D('GoodsPics')->add($arr);
            }
        }
    }

    //添加/修改 商品实现属性信息的维护(sp_goods_attr表)
    private function deal_attr($goods_id){
        //如果是修改商品，维护属性信息，则要删除旧属性
        $goodsAttr=D('GoodsAttr');
        $goodsAttr->delAllAttr($goods_id);
        foreach($_POST['attr_info'] as $k => $v){
            //$k是属性id值
            foreach($v as $vv){
                if(!empty($vv)){
                    $arr['goods_id'] = $goods_id;
                    $arr['attr_id'] = $k;
                    $arr['attr_value'] = $vv;
                    //给关联表sp_goods_attr填充数据
                    //D('GoodsAttr')对应数据表sp_goods_attr
                    //D('Goodsattr')对应数据表sp_goodsattr
                    $goodsAttr->add($arr);
                }
            }
        }
    }

    //根据类型获得属性信息[添加商品]
    function getAttrByType(){
        if (IS_AJAX) {
            if (!empty($_GET['goods_id'])) {
                $goods_id = I('get.goods_id');
                $type_id  = I('get.type_id');
                //获得属性列表信息(实体、空壳)
                //sp_attribue 与 sp_goods_attr做联表查询 通过attr_id关联
                //保证sp_attribute属性表的数据是完整的，如果sp_goods_attr关联表有对应数据则一并查出
                $attrinfo = D('Attribute')->getByGTAllAttr($goods_id,$type_id);
                echo json_encode($attrinfo);
            } else {
                //获得客户端传递过来的type_id
                $type_id = I('get.type_id');

                //根据$type_id获得对应的属性信息
                $attrinfo = D('Attribute')->getByTAllAttr($type_id);

                echo json_encode($attrinfo);
            }
        }
    }

    //删除相册图片
    function delPics(){
        $pics_id = I('post.pics_id');//接收pics_id

        //根据$pics_id做条件进行相册查询
        $picsinfo = D('GoodsPics')->find($pics_id);
        //删除物理相册图片
        if(file_exists('.'.$picsinfo['pics_big'])){unlink('.'.$picsinfo['pics_big']);}
        if(file_exists('.'.$picsinfo['pics_mid'])){unlink('.'.$picsinfo['pics_mid']);}
        if(file_exists('.'.$picsinfo['pics_sma'])){unlink('.'.$picsinfo['pics_sma']);}

        //删除数据记录
        if(D('GoodsPics')->delete($pics_id)){
            echo json_encode(array('status'=>200)); //成功
        }else{
            echo json_encode(array('status'=>202)); //失败
        }
    }

    //移除商品
    public function delGoods(){
        if (IS_AJAX){
            if (D('Goods')->delGoods(I('get.goods_id'))){
                echo json_encode(['status'=>200]);
            }else{
                echo json_encode(['status'=>202]);
            }
        }
    }
}