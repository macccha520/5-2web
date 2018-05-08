<?php

    namespace app\vue\controller;

    use think\Controller;
    use think\Request;
    use EasyWeChat\Factory;

    class WechatPay extends Base
    {
        protected static $config = [
            // 必要配置
            'app_id'             => 'xxxx',
            'mch_id'             => 'your-mch-id',
            'key'                => 'key-for-signature',   // API 密钥

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！

            'notify_url'         => '默认的订单回调地址',     // 你也可以在下单时单独设置来想覆盖它
        ];
        protected $app;
        protected $payjssdk;

        public function __construct()
        {
            parent::__construct();
            $this->app = Factory::payment( self::$config );
            $this->payjssdk = $this->app->jssdk;
        }

        //统一下单
        public function unifyOrder()
        {
            $result = $this->app->order->unify([
                'body' => '腾讯充值中心-QQ会员充值',
                'out_trade_no' => '20150806125346',
                'total_fee' => 88,
                'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
                'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                'trade_type' => 'JSAPI',
                'openid' => 'oUpF8uMuAJO_M2pxb1Q9zNjWeS6o',
            ]);
        }

        //1.WeixinJSBridge:
        public function getWeixinJSBridge()
        {
            $this->payjssdk->bridgeConfig($prepayId);
        }

        //2.Jssdk
        public function getJsSdk()
        {
            $this->payjssdk->bridgeConfig($prepayId);
        }


        //申请退款  根据微信订单号退款
        public function refundbyTransactionId()
        {
            $result = $this->app->refund->byTransactionId(
                'transaction-id-xxx', 'refund-no-xxx', 10000, 10000, [
                // 可在此处传入其他参数，详细参数见微信支付文档
                'refund_desc' => '商品已售完',
            ]);
        }

        //根据商户订单号退款
        public function refundbyOutTradeNumber()
        {
            // Example:
            $result = $this->app->refund->byOutTradeNumber(
                'out-trade-no-xxx', 'refund-no-xxx', 20000, 1000, [
                // 可在此处传入其他参数，详细参数见微信支付文档
                'refund_desc' => '退运费',
            ]);
        }

        //支付结果通知
        public function handlePaidNotify()
        {
            $response = $this->app->handlePaidNotify(function($message, $fail){
                // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
                $order = 查询订单($message['out_trade_no']);

                if (!$order || $order->paid_at) { // 如果订单不存在 或者 订单已经支付过了
                    return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
                }

                ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

                if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                    // 用户是否支付成功
                    if (array_get($message, 'result_code') === 'SUCCESS') {
                        $order->paid_at = time(); // 更新支付时间为当前时间
                        $order->status = 'paid';

                        // 用户支付失败
                    } elseif (array_get($message, 'result_code') === 'FAIL') {
                        $order->status = 'paid_fail';
                    }
                } else {
                    return $fail('通信失败，请稍后再通知我');
                }

                $order->save(); // 保存订单

                return true; // 返回处理完成
            });

            $response->send(); // return $response;
        }

    }
