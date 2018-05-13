<?php

    namespace app\vue\model;

    use think\Model;
    use think\Db;
    use think\Request;

    class Coupon extends Model
    {
        const FREE_SEND = 2;
        const UNUSED_STATUS = 0;
        const UNUSED_TYPE = 1;
        const OVERTIME_TYPE = 2;
        const COUPON_STATUS_USEFUL = 1;
        protected $builder;

        public function sendCoupons($Uid)
        {
            $coupon = self::where('send_end_time','>',time())
                        ->where('createnum - send_num','>',0)
                        ->whereOr('createnum',0)
                        ->where("type",self::FREE_SEND)
                        ->select();
            foreach ($coupon as $key => $val)
            {
                // 送券
                Db::name('coupon_list')->add([
                    'cid'       =>  $val->id,
                    'type'      =>  self::FREE_SEND,
                    'uid'       =>  $Uid,
                    'send_time' =>  time()
                ]);
                // 优惠券领取数量加一
                self::where('id',$val->id)->setInc('send_num');
            }
        }


        public function getList($Uid=1,Request $request)
        {
            return $this->getBuilders($Uid,$request);

            //return $this->builder->select();
        }


        protected function getBuilders($Uid,Request $request)
        {
            $this->builder = self::field('l.*,c.name,c.money,c.use_start_time,c.use_end_time,c.condition')
                                            ->alias('c')
                                            ->join('__COUPON_LIST__ l','l.cid = c.id')
                                            ->where('c.status',self::COUPON_STATUS_USEFUL)
                                            ->where('l.uid','<>',0);


            $type = $request->has('type') ? $request->post('type') : 0;
            switch ( $type ) {
                case self::UNUSED_TYPE:
                    $this->builder = $this->builder
                                            ->where('l.order_id','>',0)
                                            ->where('l.use_time','>',0);
                    break;
                case self::OVERTIME_TYPE:
                    $this->builder = $this->builder
                                            ->where('c.use_end_time','<',time());
                    break;
                default:
                    $this->builder = $this->builder
                                            ->where('l.order_id',0)
                                            ->where('c.use_end_time','>',time())
                                            ->where('l.status',self::UNUSED_STATUS);
                    break;
            }
            return [
                'data'=>$this->builder->order(['l.send_time' => 'DESC', 'l.use_time'])->select(),
                'sql'=>$this->builder->order(['l.send_time' => 'DESC', 'l.use_time'])->getLastSql()
            ];
        }
    }
