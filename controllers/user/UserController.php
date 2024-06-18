<?php
namespace controllers\user;


use models\Post;
use models\User;
use vendor\auth\Auth;
use vendor\controller\Controller;

class UserController extends Controller
{
    protected $layout = 'layout/base';
    public function register()
    {
        if(Auth::auth_user()){
            $this->render('user.profile');
        }
        $user = new User($_POST);
        if($_POST){
            if($user->validate()){
                unset($_POST['password_confirm']);
                $_POST['avatar'] = upload_file($_FILES['avatar'], 'image/users_ava');
                $new_user = $user->create($_POST);
                Auth::auth($new_user);
                $this->render('user.profile');
            }
        }
        $this->render('user/register', ['title'=>'Регистрация', 'user'=>$user]);
    }
    public function profile()
    {

        $this->render('user/profile', ['title'=>'Регистрация', 'user'=>Auth::user()]);
    }
    public function login()
    {

        $user = new User();

        if($_POST){
            $where = [['email'=>$_POST['email']], ['password'=>$_POST['password']]];
            $new_user = $user->where($where);

            if($new_user->id){
                debug($new_user->id);
                Auth::auth($new_user);
                $this->render('user.profile');
            }
        }

        $this->render('user/login', ['title'=>'Вход', 'user'=>$user]);
    }
}