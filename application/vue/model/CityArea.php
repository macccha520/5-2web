<?php

    namespace app\vue\model;

    use think\Model;
    use think\Request;

    class CityArea extends Model
    {
        const IS_PROVICE = 0;

        public static function getAddres($citycode='')
        {
            if($citycode)
            {
                return self::where('pcode',$citycode)
                    ->getField('cityname');
            }
            return self::where('pid',self::IS_PROVICE)
                    ->getField('cityname');

        }

    }
