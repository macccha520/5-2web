<?php

    namespace app\vue\controller;

    use think\Controller;
    use think\Request;
    use app\vue\model\Ad;

    class Banner extends Base
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
        public function index()
        {
             $this->jsonTo( (new Ad())->getList() );
        }

    }
