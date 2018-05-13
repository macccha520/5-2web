<?php

namespace app\vue\controller;

use think\Controller;
use think\Request;
use app\vue\model\House as model;

class House extends Base
{
    protected $NoCheckMethods = [
        'index',
        'read'
    ];
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        return $this->jsonTo( (new model())->getList($request) );
    }


    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

}
