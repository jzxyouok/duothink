<?php
namespace app\index\controller;

class Goods extends Common
{
    public function index()
    {
        return $this->fetch();
    }
}
