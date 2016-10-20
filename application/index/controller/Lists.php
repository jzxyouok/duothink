<?php
namespace app\index\controller;

class Lists extends Common
{
    public function index()
    {
        $openid = input('openid');
        if(strlen($openid) != 32 || !isset($openid)){
            abort(404,'访问栏目不存在，禁用或是被删除');
        }
        return $this->fetch();
    }
}
