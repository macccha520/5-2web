<?php

    namespace app\vue\model;

    use think\Model;

    class Ad extends Model
    {
        const ISENABLED = 1;
        public function getList()
        {
            $data = self::field('ad_name,ad_link,ad_code,enabled')
                ->where('enabled',self::ISENABLED)
                ->where('start_time','<=',time())
                ->where('end_time','>=',time())
                ->order('orderby','asc')
                ->select();

            foreach ($data as $k=>$val) {
                $data[$k]['ad_code'] = SITE_URL. $val->ad_code;
            }
            return $data;
        }
    }
