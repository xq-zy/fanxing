<?php
namespace Admin\Model;
class AttributeModel extends CommonModel {

    //添加属性时，给表单域设置验证效果
    // 是否批处理验证
    protected $patchValidate    =   true;//对多个项目同时验证
    // 自动验证定义
    protected $_validate        =   array(
        //属性名称验证
        array('attr_name','require','属性名称必须设置'),
        //商品类型验证
        array('type_id','0','商品类型必须选取',0,'notequal'),
    );

    //获取某类型所有属性信息
    public function getByAllAttr($type_id){
        return $this->alias('a')->join('__TYPE__ t on a.type_id=t.type_id')->field('a.*,t.type_name')->where(array('a.type_id'=>$type_id))->select();
    }
    public function getAllAttr(){
        return $this->alias('a')->join('__TYPE__ t on a.type_id=t.type_id')->field('a.*,t.type_name')->select();
    }

    //获得属性列表信息(实体、空壳)
    //sp_attribue 与 sp_goods_attr做联表查询 通过attr_id关联
    //保证sp_attribute属性表的数据是完整的，如果sp_goods_attr关联表有对应数据则一并查出
    public function getByGTAllAttr($goods_id,$type_id){
        return $this->alias('a')->field('a.attr_id,a.attr_name,a.attr_sel,a.attr_vals,(select group_concat(ga.attr_value) from fs_goods_attr ga where ga.attr_id=a.attr_id and ga.goods_id=' . $goods_id . ') attr_values')->where(['a.type_id' => $type_id])->select();
    }

    //根据$type_id获得对应的属性信息
    public function getByTAllAttr($type_id){
        return $this ->where(['type_id' => $type_id])->select();
    }
}