<?php

namespace app\admin\controller;
use think\Page;
use think\AjaxPage;
use think\Db;
use think\Request;
use app\admin\model\House as model;
use app\admin\model\CityArea;


class House extends Base {

    protected static $model;

    public function __construct()
    {
        parent::__construct();
        if( !self::$model)  self::$model = new model();
    }


    public function Lists(Request $request)
    {
        if( $request->isPost() ) {

            $this->assign('lists',self::$model->getList($request));
            return $this->fetch('ajaxLists');
        }
        return $this->fetch();
    }


    //
    public function add_edit(Request $request)
    {
        if( $request->isPost() ) {
            $r = self::$model->addEdit($request);
            if($r) {
                $return_arr = array(
                    'status' => 1,
                    'msg'   => '操作成功',
                    'data'  => array('url'=>U('Admin/House/Lists')),
                );
                $this->ajaxReturn($return_arr);
            }
        }
        $this->assign('area',CityArea::getProvice($request));
        return $this->fetch('_goods');
    }


    //
    public function get_area(Request $request)
    {
        $data = CityArea::getProvice($request);
        $string = "<option value='0'>请选择</option>";
        foreach ($data as $k=>$val) {
            $string .= "<option value='".$val->citycode."'>".$val->cityname."</option>";
        }
        return json(['list'=>$string]);
    }


    public function test(Request $request)
    {
        dump(self::$model->getList($request));
    }

}