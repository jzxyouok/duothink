<?php
namespace app\mp\controller;

use think\Controller;
use app\common\model\AuthRule;
use app\common\model\Api;

class Common extends Controller
{
    public function _initialize()
    {
        $mp_session = session('mp');
        if (!$mp_session) {
            $this->redirect(url('common/helper/account'));
        } else {
            $this->assign('user', $mp_session);
        }
        $this->assign('rqst',self::rqst());
        $this->assign('top_auth_rule',AuthRule::data_formcat(3));
        $this->assign('sub_auth_rule',AuthRule::naction());
        $this->assign('now_auth_rule',AuthRule::requestLocal());
        $this->assign('config',Api::config());
    }

    public static function rqst(){
        return [
            'controller' => request()->controller(),
            'action' => request()->action(),
            'name'  => strtolower( request()->module().'/'.request()->controller().'/'.request()->action() ),
        ];
    }
}