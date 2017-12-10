<?php
/**
 * Created by PhpStorm.
 * Admin: lt
 * Date: 2017/11/30
 * Time: 18:39
 */
namespace app\admin\controller;


use think\Controller;
use think\Db;

use think\Input;
use Captcha;

class Admin extends Controller
{
    //显示注册页
    public function reg(){
        return $this->fetch();
    }

    public function login(){
        return $this->fetch();
    }

    public function logindo(){
        $view = new View();
        $data1['name'] = input('request.username');
        $data1['password']  = input('request.password');
        $data = input('request.captcha');
        dump($data);
        if(!captcha_check($data)){
            //验证失败
            return $this->error("验证码错误");
        }

        /*$check=\app\index\model\Admin::login($name, $password);
        if ($check) {
            // header(strtolower("location:"));
            header(strtolower("location: ".config('web_root')."/index/Index/index.html"));
            exit();
        }
        if (!$check){
            $this->error("用户名密码错误！");
        }

        return $view->fetch('logining');*/

        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response

            $check=\app\index\model\User::login($data1['name'], $data1['password']);
            if ($check) {
                $datetime = date("Y-m-d H:i:s");
                $request = Request::instance();
                $ip = $request->ip();
                Db::execute('UPDATE tp_admin SET admin_time = ? WHERE admin_name = ?',[$datetime,$data1['name']]);
                Db::execute('UPDATE tp_admin SET admin_ip = ? WHERE admin_name = ?',[$ip,$data1['name']]);
                $username = $data1['name'];
                session('username',$username);
                $this->assign('name',$data1['name']);
                $resp['accessGranted'] = true;
                header(strtolower("location: ".config('web_root')."/index/Index/indexlogin.html"));
                exit();
            }else if(!$check){
                $this->error("<h1>用户名或密码错误！</h1>","index/user/login");
            }

        echo json_encode($resp);
    }

    function captcha_img($id = "")
    {
        return '<img src="' . captcha_src($id) . '" alt="captcha" />';
    }
    /*//登录方法
    public function login(){
        //获取登录信息
        $data = input('post');
        //密码md5加密
        $data['password'] = md5($data['password']);
        //验证登录账号密码
        $bool = Db::table('user')->where('')->find();

        if (!$bool){
            return ['state'=>false,'meg'=>'帐号密码错误'];
        }

        //登录信息写入缓存
        cookie('admin',$bool);

        return['state'=>true,'msg'=>'登录成功，请稍候'];
    }*/


}