<?php

    namespace app\admin\model;
    use think\Model;
    use think\AjaxPage;
    use think\Db;
    use think\Request;

    class House extends Model
    {
        protected $builder;
        protected $builder_count;
        protected $page;

        public function builder_count()
        {
            $this->builder_count = $this->builder->count();
            $this->builder_page();
        }


        public function builder_page()
        {
            $this->page = new AjaxPage($this->builder_count,10);
        }


        public function getList(Request $request)
        {
            //$this->builder = Db::name('house')->field('*');
            $this->builder = self::field('*');
            $this->builder_count();

            return [
                'list' => $this->builder
                            ->limit($this->page->firstRow,$this->page->listRows)
                            ->select(),
                'page' => $this->page->show()
            ];
        }


        public function addEdit(Request $request)
        {
            $id = (int) $request->post('id');
            if($id > 0 ) {
                $res = self::where('id',$id)->update($request->post());
                $this->dealImg($id,$request);
            }else {

                $model = new self();
                $res = $model->data( $request->post() )->save();
                $this->dealImg($model->getLastInsID(),$request);
            }
            return $res ? true : false;
        }


        public function dealImg($hid,Request $request)
        {
            HouseImg::where('hid',$hid)->delete();
            $imgArr =   array_filter($request->post('goods_images/a'));

            foreach ($imgArr as $key => $value ) {
                $model = new HouseImg();
                $model->data([
                    'hid'   =>  $hid,
                    'img_path'=> $value
                ])->save();
            }
        }

    }

