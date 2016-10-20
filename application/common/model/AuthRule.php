<?php
/**
 * Created by PhpStorm.
 * User: imdante
 * Date: 2016/10/9
 * Time: 17:07
 */

namespace app\common\model;

use think\Model;

class AuthRule extends Model
{
    public static function datalist(){
        $auth_rule = cache('auth_rule');
        if(!$auth_rule){
            $auth_rule = db('auth_rule')->order('sort')->select();
            cache('auth_rule',$auth_rule,0);
        }
        return $auth_rule;
    }
    /**
     * 返回数据格式
     * @param $type
     * @return array|false|mixed|\PDOStatement|string|\think\Collection
     */
    public static function data_formcat($type,$key='',$value='')
    {
        $data = self::datalist();
        switch ($type){
            case 1:
                return unlimitedForLevel($data);
            case 2:
                return unlimitedForChild($data);
            case 3:
                return self::search_array('pid',0);
            case 4:
                return self::search_array($key,$value);
            default:
                return $data;
        }
    }

    /**
     * 根据条件查询数据
     * @param $key
     * @param $val
     * @return array
     */
    public static function search_array($key,$val,$data='')
    {
        $data = $data ?: self::datalist();
        $result = [];
        foreach ($data as $item => $value) {
            if ($value[$key] == $val) {
                $result[] = $value;
            }
        }
        return $result;
    }

    public static function naction(){
        $data = self::search_array('status',1);
        $dataName = self::requestLocal();
        if($dataName)
            $result = self::search_array('pid',$dataName['0']['id'],$data);
        else
            $result = null;
        return $result;
    }

    public static function requestLocal(){
        $requestName = strtolower(request()->module().'/'.request()->controller().'/index');
        return self::search_array('name',$requestName);
    }
}