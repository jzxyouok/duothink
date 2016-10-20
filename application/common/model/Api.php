<?php
namespace app\common\model;
use think\Model;
class Api extends Model{

    /**
     * 全局文件配置
     * @return array|false|mixed|\PDOStatement|string|Model
     */
    public static function config(){
        $config = cache('config');
        if(!$config){
            $config = db('config')->find();
            cache('config',$config,0);
        }
        return $config;
    }

    /**
     * 微信接口配置文件
     * @return array|false|mixed|\PDOStatement|string|Model
     */
    public static function weixin_config()
    {
        $api = cache('weixin_config');
        if (!$api) {
            $api = db('weixin_config')->find();
            cache('weixin_config');
        }
        return $api;
    }

    /**
     * 验证文章或是栏目openid
     * @param $openid
     */
    public static function openidValidator($openid)
    {
        $openidLenth = strlen($openid);
        $isNumber = is_numeric($openid);
        if ($openidLenth != 32 || $isNumber) {
            abort('404', '您访问的内容不存，删除或是已经禁用');
        }
    }
}