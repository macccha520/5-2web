<?php


    namespace app\common\command;

    use think\console\Command;
    use think\console\Input;
    use think\console\Output;
    use app\admin\model\CityArea;

    class Test extends Command
    {
        protected static $url = 'http://www.stats.gov.cn/tjsj/tjbz/tjyqhdmhcxhfdm/2016/';
        protected static $pix = '.html';


        protected function configure()
        {
            $this->setName('test')->setDescription('Here is the remark ');
        }


        protected function execute(Input $input, Output $output,$pid=0, $pName = '',$thisId = '',$subUrl='',$pCode=0)
        {
            //省
            if( !$pid && !$thisId) {
//                 foreach($this->returnArray() as $key=>$pName)
//                 {
//                     $this->execute($input,$output,$key,$pName);
//                 }
                $url = self::$url . 'index' . self::$pix;
                $res = $this->stringEncode( self::curl_get($url) );

                preg_match('/<table class=\'provincetable\'.*?>(.*?)<\/table>/s',$res,$match);
                preg_match_all('/<a .*?>.*?<\/a>/',$match[0],$mat);

                $reg2="/href=\'([^\']+)/";
                $reg3="/>(.*)<br\/>/";
                $arr = [];
                $brr = [];
                foreach($mat[0] as $key => $v)
                {
                    preg_match($reg2,$v,$hrefarray);
                    preg_match($reg3,$v,$acontent);

                    $arr[ $key ] = str_replace( self::$pix ,'',$hrefarray[1]);
                    $brr[ $key ] = $acontent[1];
                }

                foreach(array_combine($arr,$brr) as $key=>$pName )
                {
                    //$this->handle($key,$pName);
                     $model = new CityArea();
                     if( $model::where("citycode",$key)->count() <= 0)
                     {
                         $model->cityname = $pName;
                         $model->citycode = $key;
                         $model->save();
                     }
                }
            }

//            else {     //地区
//                if(!$subUrl) {
//                    $subUrl = self::$url . $pid . self::$pix;
//                }
//                $htmlContent    =   self::curl_get($subUrl);
//                if(!$htmlContent) {
//                    var_dump($subUrl);die;
//                }
//
//                preg_match('/<table class=\'.*?\'>(.*?)<\/table>/s',$this->stringEncode( $htmlContent ),$match);
/*                preg_match_all('/<a .*?>.*?<\/a>/',$match[0],$mat);*/
//
//                if (empty($mat[0]) || count($mat[0]) <= 0) {
//                    //$this->tdHandle($match[0],$pid,$pName);
//                }else {
//                    $this->nextHandle($input,$output,$pid,$pName,$subUrl,$mat,$pCode);
//                }
//            }
        }


        //nextHandle
        private function nextHandle($input,$output,$pid=0, $pName = '',$subUrl='',array $mat,$pCode=0)
        {
            $reg2="/href=\'([^\']+)/";
            $reg3="/>([\W]*)<\/a>/";
            $reg4="/>([\d]*)<\/a>/";
            $arr = [];
            $cityName = [];
            $cityCode = [];
            foreach($mat[0] as $key => $v) {
                preg_match($reg2,$v,$hrefarray);
                preg_match($reg3, $v, $acontent);  //cityName
                preg_match($reg4,$v,$bcontent);    //cityCode
                $arr[ $key ] = str_replace( self::$pix ,'',$hrefarray[1]);

                if(! empty($acontent) && count($acontent) > 0 ) {
                    $cityName[ $key ] = $acontent[1];
                }
                if( ! empty($bcontent) && count($bcontent) > 0 ) {
                    $cityCode[ $key ] = $bcontent[1];
                }
            }
            $cityName = array_values($cityName);
            $cityCode = array_values($cityCode);
            $arr = array_values(array_unique($arr));
            $tmp = [];
            foreach($arr as $k=>$value)
            {
                $tmp[ $k ] = [
                    'pid'       =>  $pid,
                    'pName'     =>  $pName,
                    'pCode'     =>  $pCode==0?$pid:$pCode,
                    'thisId'    =>  $value,
                    'cityName'  =>  $cityName[ $k ],
                    'cityCode'  =>  $cityCode[ $k ],
                    'url'       =>  $subUrl,
                ];
            }

            foreach( $tmp as $item=>$vss){
                 dump($vss);
                 $model = new CityArea();
                 if( $model::where("citycode","{$vss['cityCode']}")->count() <= 0)
                 {
                     $model->pid = $vss['pid'];
                     $model->pname = $vss['pName'];
                     $model->pcode = $vss['pCode'];
                     $model->cityname = $vss['cityName'];
                     $model->citycode = $vss['cityCode'];
                     $model->save();
                 }
                if(is_string($vss['url'])){
                    $subUrl = explode('/',$vss['url']);
                    array_pop($subUrl);
                    $url = implode('/',$subUrl) . '/'. $vss['thisId'] . self::$pix;

                    $htmlContent    =   self::curl_get($url);
                    preg_match('/<table class=\'villagetable\'>(.*?)<\/table>/s',$this->stringEncode( $htmlContent ),$match);

                    if(!$match) {
                        $this->execute($input,$output, $pid, $vss['cityName'],$vss['thisId'], $url,$vss['cityCode']);
                    }
                }
            }
        }



        //
        private function stringEncode($str)
        {
            $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }


        //
        private static function curl_get($url)
        {
            $ch=curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch,CURLOPT_HEADER,1);
            $result=curl_exec($ch);
            $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
            if($code!='404' && $result){
                return $result;
            }
            curl_close($ch);
        }


        public function returnArray()
        {
            return array (
//                11 => '北京市',
//                12 => '天津市',
//                13 => '河北省',
//                14 => '山西省',
//                15 => '内蒙古自治区',
//                21 => '辽宁省',
//                22 => '吉林省',
//                23 => '黑龙江省',
//                31 => '上海市',
//                32 => '江苏省',
//                33 => '浙江省',
//                34 => '安徽省',
//                35 => '福建省',
//                36 => '江西省',
//                37 => '山东省',
//                41 => '河南省',
//                42 => '湖北省',
//                43 => '湖南省',
                44 => '广东省',
//                45 => '广西壮族自治区',
//                46 => '海南省',
//                50 => '重庆市',
//                51 => '四川省',
//                52 => '贵州省',
//                53 => '云南省',
//                54 => '西藏自治区',
//                61 => '陕西省',
//                62 => '甘肃省',
//                63 => '青海省',
//                64 => '宁夏回族自治区',
//                65 => '新疆维吾尔自治区',
            );
        }
    }