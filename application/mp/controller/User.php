<?php
namespace app\mp\controller;

class User extends Common
{
    public function index()
    {
        return $this->fetch();
    }
}