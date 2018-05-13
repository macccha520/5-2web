<?php

    namespace app\vue\model;

    use think\Request;
    use think\Model;

    class House extends Model
    {
        const IS_ON_SALE = 1;
        protected $fields = "id,shop_price,house_name,original_img,
                             house_standard,house_introduce,
                             around_introduce,in_house_time,out_house_time";

        public  function getList(Request $request)
        {
            $info = self::field( '*' )
                        ->where('is_on_sale',self::IS_ON_SALE)
                        ->select();

            foreach ($info as $key => $value ) {
                $info[$key]['original_img'] = SITE_URL . $value->original_img;
            }

            return $info;
        }


        public static function getOne($id)
        {
            $info = self::field( '*' )
                ->where('is_on_sale',self::IS_ON_SALE)
                ->select();

            foreach ($info as $key => $value ) {
                $info[$key]['original_img'] = SITE_URL . $value->original_img;
            }

            return $info;
        }
    }
