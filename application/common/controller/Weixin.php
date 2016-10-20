<?php
/**
 * Created by PhpStorm.
 * User: imdante
 * Date: 2016/10/17
 * Time: 14:41
 */

namespace app\common\controller;
use think\Controller;
use com\wechat\Wechat;
class Weixin extends Controller
{
    /**
     * 微信验证 和数据接口
     */
    public function api(){
        $wechat = new Wechat();
        $wechat::vaild();
    }
}