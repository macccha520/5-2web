<?php

    namespace app\vue\controller;

    use think\Controller;
    use think\Request;
    use app\vue\model\Coupon as model;

    class Coupon extends Base
    {

        protected $NoCheckMethods = ['index'];
        /**
         * 显示资源列表
         *
         * @return \think\Response
         */
        public function index(Request $request)
        {
            return $this->jsonTo((new model())->getList(1,$request));
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
