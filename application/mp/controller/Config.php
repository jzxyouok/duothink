<?php
namespace app\mp\controller;

use app\common\model\Api;
use app\common\model\AuthRule;

class Config extends Common
{
    /**
     * 基础信息设置控制器
     * @return mixed
     */
    public function index()
    {
        $config = Api::config();
        if(request()->isPost()){
            $data = input('post.');
            if($data['id']){
                $status = db('config')->update($data);
            }else{
                $status = db('config')->insert($data);
            }

            if($status){
                cache('config',null);
                $this->result('insert success',200,'设置信息保存成功');
            }else{
                $this->result('insert error',500,'保存失败！');
            }
        }
        $this->assign('config',$config);
        return $this->fetch();
    }


    /**
     * 菜单
     * @return mixed
     */
    public function menus()
    {
        $auth_rule = AuthRule::datalist();
        $this->assign('list',unlimitedForLevel($auth_rule));
        return $this->fetch();
    }

    /**
     * 添加菜单
     */
    public function add_auth_rule(){
        $data = input('post.');
        $status= db('auth_rule')->insert($data);
        if($status) {
            cache('auth_rule', null); //清空菜单缓存
            $this->result('ok', 200, '菜单添加成功', 'json');
        }else {
            $this->result('error', 500, '菜单添加失败，请重试或是联系技术', 'json');
        }
    }

    /**
     * 删除菜单
     */
    public function del_auth_rule(){
        $id = input('get.id');
        $status = db('auth_rule')->where('id',$id)->delete();
        if($status){
            cache('auth_rule',null);
            $this->result('ok',200,'删除成功','json');
        }else{
            $this->result('error',500,'删除失败，请重试或是联系技术支持','json');
        }
    }

    /**
     * 请求菜单信息数据
     */
    public function ed_auth_rule_calldata(){
        $id= input('get.id');
        $data = AuthRule::search_array('id',$id);
        $this->result($data['0'],200,'查询数据返回成功');
    }
    public function ed_auth_rule(){
        $data = input('post.');
        $status = db('auth_rule')->update($data);
        if($status){
            cache('auth_rule',null);
            $this->result('ok',200,'修改保存成功，正在刷新','json');
        }else{
            $this->result('error',500,'修改失败，请重试或是反馈技术人员');
        }
    }

    /**
     * 路由配置
     * @return mixed
     */
    public function routes()
    {
        $rules = \think\__include_file(APP_PATH . '/route.php');
        $reuslt = [];
        $i = 0;
        foreach ($rules as $item => $value) {
            $reuslt[$i]['key'] = $item;
            $reuslt[$i]['value'] = $value;
            $i++;
        }
        $this->assign('ro', $reuslt);
        return $this->fetch();
    }
}