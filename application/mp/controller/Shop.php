<?php
namespace app\mp\controller;

class Shop extends Common
{
    public function index()
    {
        return $this->fetch();
    }
}