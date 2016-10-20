<?php
namespace app\mp\controller;

class Message extends Common
{
    public function index(){
        return $this->fetch();
    }
}