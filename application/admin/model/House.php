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
        protected $sale_status = [0,1];


        public function builder_count()
        {
            $this->builder_count = $this->builder->count();
            $this->builder_page();
        }


        public function builder_page()
        {
            $this->page = new AjaxPage($this->builder_count,10);
        }

        public function set_builder(Request $request)
        {
            $this->builder = self::field('*');

            if( $request->has('is_on_sale') && $request->post('is_on_sale') ) {
                $this->builder = $this->builder
                    ->where('is_on_sale',$request->post('is_on_sale'));
            }
            if( $request->has('key_word') && $request->post('key_word') ) {
                $key_word = strip_tags(trim($request->post('key_word')));
                $this->builder = $this->builder
                    ->where('house_name','like',"%{$key_word}%");
            }
        }


        public function getList(Request $request)
        {
            $this->set_builder($request);
            $this->builder_count();
            $this->set_builder($request);
            return [
                'list' => $this->builder
                            ->limit($this->page->firstRow,$this->page->listRows)
                            ->order('id desc')
                            ->select(),
                'sql'  =>  $this->builder
                            ->limit($this->page->firstRow,$this->page->listRows)
                            ->order('id desc')
                            ->getLastSql(),
                'form' => $request->post(),
                'page' => $this->page->show()
            ];
        }


        public function addEdit(Request $request,$res=true)
        {
            $id = (int) $request->post('id');
            if($id > 0 ) {
                self::where('id',$id)->update($request->post());
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

