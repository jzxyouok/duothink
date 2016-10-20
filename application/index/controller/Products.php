<?php
namespace app\index\controller;

class Products extends  Common
{
    public function index()
    {
        return $this->fetch();
    }
}
