<?php
namespace app\index\model;
use think\Model;
use think\Input;
class Admin extends Model
{
	/*protected $auto = ['user_name'];
	protected $insert = ['user_logintimes' => 0];  

	protected function setUserNameAttr($value)
    {
        return strtolower($value);
    }*/

    public static function login($name, $password)
    {
        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        $where['admin_name'] = $name;
        $where['admin_password'] = md5($password);

        $user=Admin::where($where)->find();
        if ($user) {
            unset($user["password"]);
            session("ext_user", $user);
            return true;
        }else{
            $fa = isset($_COOKIE['failed-attempts']) ? $_COOKIE['failed-attempts'] : 0;
            $fa++;
            setcookie('failed-attempts', $fa);
            // Error message
            $resp['errors'] = '<strong>登录失败！</strong><br />忘记密码？.<br />请点击下方忘记密码 ' . $fa;
            return false;
        }
    }



    // 退出登录
    public static function logout(){
        session("ext_user", NULL);
        return [
            "code" => 0,
            "desc" => "退出成功"
        ];
    }

    // 查询一条数据
    public static function search($name){
        $where['user_email'] = $name;
        $user=Admin::where($where)->find();
        return $user;
        // dump($user['admin_password']);
    }

    //更改用户密码

    public static function updatepassword($name,$newpassword){
        $where['user_email'] = $name;
        $user=Admin::where($where)->update(['user_password' => md5($newpassword)]);
        if ($user) {
            return true;
        }else{
            return false;
        }
    }
}