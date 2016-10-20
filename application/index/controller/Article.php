<?php
namespace app\index\controller;

use app\common\model\Api;

class Article extends Common
{
    public function index()
    {
        $openid = input('param.openid');
        Api::openidValidator($openid); //验证openid有效性

        //查询文章
        $article = db('article')->where(['openid' => $openid, 'status' => 1])->find();
        if (!$article) {
            abort('404', '访问内容不存在，已经删除或是被禁用');
        }

        $this->assign('article', $article);

        return $this->fetch();
    }
}
