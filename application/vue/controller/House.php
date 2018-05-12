<?php

namespace app\vue\controller;

use think\Controller;
use think\Request;
use app\vue\model\House as model;

class House extends Base
{
    protected $NoCheckMethods = [
        'index',
        ''
    ];
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $this->jsonTo( (new model())->getList($request) );
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

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
