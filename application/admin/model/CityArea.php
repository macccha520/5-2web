<?php

    namespace app\admin\model;

    use think\Model;
    use think\Request;

    class CityArea extends Model
    {
        const IS_PROVICE = 0;

        public static function getProvice(Request $request)
        {
            if($request->has('citycode') && strlen($request->get('citycode')) >0)
            {
                return self::where('pcode',$request->get('citycode'))
                    ->field('cityname,citycode')
                    ->select();
            }
            return self::where('pid',self::IS_PROVICE)
                    ->field('cityname,citycode')
                    ->select();
        }

    }
