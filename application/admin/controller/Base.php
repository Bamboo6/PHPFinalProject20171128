<?php
/**
 * Created by PhpStorm.
 * Admin: lt
 * Date: 2017/12/5
 * Time: 14:25
 */

namespace app\index\controller;


use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

        //判断登录
        if($this->isLogin()){

        }else{
            //返回登录界面
            $this->redirect('Admin/login');
        }
    }

    //判断是否登录
    public function isLogin(){
        //写入缓存，判断是否已登录
        $data = json_decode(cookie('admin'),true);
        if (!$data){
            return false;
        }
        return true;
    }
}