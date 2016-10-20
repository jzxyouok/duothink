<?php
// 应用公共文件
/**
 * spm参数
 * @return string
 */
function spm(){
    $requst =mb_substr( str_replace('.html','',str_replace('/','.',request()->baseUrl())),1);
    $timestmap = time();
    $random = rand(1000,9999);
    return strtolower($requst.'.'.$random.'.'.$timestmap);
}

/**
 * 版本号缓存
 * @return string
 */
function vcs(){
    $vcs = cache('vcs');
    if(!$vcs){
        $vcs = mb_substr(sha1(spm()),0,12);
        cache('vcs',$vcs,600);
    }
    return '?v='.$vcs;
}
/**
 * 面包屑导航定位
 * @param $arr /数组
 * @param $id /当前id
 * @return array
 */
function breadcrumb($arr, $id)
{
    static $list = array();
    foreach ($arr as $v) {
        if ($v['id'] == $id) {
            breadcrumb($arr, $v['pid']);
            $list[] = $v;
        }
    }
    return $list;
}
/**
 * 无限极分类
 * @param $category
 * @param int $pid
 * @return array
 */
function unlimitedForChild($category, $pid = 0)
{
    $arr = array();
    foreach ($category as $v) {
        if ($v['pid'] == $pid) {
            $v['child'] = unlimitedForChild($category, $v['id']);
            $arr[] = $v;
        }
    }
    return $arr;
}
/**
 * 无限极分类
 * @param $list
 * @param int $pid
 * @param int $level
 * @return array
 */
function unlimitedForLevel($list, $pid = 0, $level = 0)
{
    $arr = array();
    foreach ($list as $k => $v) {
        if ($v['pid'] == $pid) {
            $v['level'] = $level + 1;
            $arr[] = $v;
            $arr = array_merge($arr, unlimitedForLevel($list, $v['id'], $level + 1));
        }
    }
    return $arr;
}

/**
 * 清除缓存数据
 * @param string $cacheName 缓存名称
 */
function cacheNull($cacheName){
    cache($cacheName,null);
}

function guid(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8) .substr($charid, 8, 4) .substr($charid,12, 4) .substr($charid,16, 4) .substr($charid,20,12);
        return strtolower( $uuid );
    }
}

function mbs($string,$length='40'){
    return mb_substr($string,0,$length,'UTF-8');
}
/**
 * php版本
 * @return string
 */
function phpv()
{
    return 'php' . phpversion();
}

/**
 * 检测mysql版本
 * @return mixed
 */
function sqlv()
{
    $system_info_mysql = \think\Db::query("select version() as v;");
    return $system_info_mysql['0']['v'];
}

function editorJS(){
    $script = '<script src="/static/editor/js/wangEditor.min.js?'.vcs().'"></script>';
    $script .= '<script src="/static/editor/js/wangEditor.config.js'.vcs().'"></script>';
    return $script;
}
function editorCSS(){
    return '<link rel="stylesheet" href="/static/editor/css/wangEditor.min.css?spm='.vcs().'">';
}
function editorTextarea($name,$height='600'){
    return '<textarea name="'.$name.'" id="'.$name.'" style="height:'.$height.'px"></textarea>
    <script> var editorTarget="'.$name.'";</script>';
}
function puploader($many=true){
    $script = '<script src="/static/pupload/plupload.full.min.js"></script>';
    if($many){
        $script .= '<script src="/static/pupload/inc.many.js"></script>';
    }else{
        $script .= '<script src="/static/pupload/inc.one.js"></script>';
    }
    return $script;
}
function puploader_template(){
    return '<link rel="stylesheet" href="/static/pupload/style.css?spm='.vcs().'">'.
    '<div class="am-widget-pupload" id="am-widget-pupload">
        <a id="pickfiles" class="am-pickfiles am-icon-plus" href="javascript:;"> 选择图片</a>
    </div>';
}

function reurl(&$param,$model,$spm=false){
    if($spm)
        $path = '?spm=' . spm();
    else
        $path ='';
    return 'http://'.request()->host().'/'. $model .'/'.$param.'.html' . $path;
}

function uid($tpye = 'mp')
{
    $user = session($tpye);
    if ($user) {
        return $user['uid'];
    }
    return null;
}

function weixin_menus($data, $pid = 0)
{
    $arr = array();
    foreach ($data as $v) {
        if ($v['pid'] == $pid) {
            $v['sub_button'] = weixin_menus($data, $v['id']);
            $arr[] = $v;
        }
    }
    return $arr;
}