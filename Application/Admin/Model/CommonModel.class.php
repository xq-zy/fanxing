<?php
namespace Admin\Model;
use Think\Model;
//后台公共模型
class CommonModel extends Model {
    //分页获取信息
    protected function getPage($alias='',$join='',$where='',$field='',$order=''){
        //查询数据
        $count = $this->where(array('flag'=>array('neq',0)))->count();
        $Page = new \Think\Page($count,C('PAGESIZE'));
        $this->_customPage($Page); //定制分页类样式
        $limit = $Page->firstRow.','.$Page->listRows;
        //取得数据
        $admininfo=$this->alias($alias)->join($join)->order($order)->where($where)->field($field)->limit($limit)->select();
        return array(
            'list'=>$admininfo,
            'page' => $Page->show(),
        );
    }

    //定制分页类样式
    private function _customPage($Page){
        $Page->lastSuffix = false;
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');
    }
    //删除
    protected function Del($where){
        $data['flag']=0;
        return $this->where($where)->save($data);
    }
}