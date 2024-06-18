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
            $this->redirect('user.profile');
        }
        $user = new User($_POST);
        if($_POST){
            if($user->validate()){
                unset($_POST['password_confirm']);
                $_POST['avatar'] = upload_file($_FILES['avatar'], 'image/users_ava');
                $_POST['password'] = md5($_POST['password']);
                $new_user = $user->create($_POST);
                Auth::auth($new_user);
                $this->redirect('user.profile');
            }
        }
        $this->render('user/register', ['title'=>'Регистрация', 'user'=>$user]);
    }
    public function profile()
    {
        if(!Auth::auth_user()){
            $this->redirect('user.login');
        }
        $this->render('user/profile', ['title'=>'Регистрация', 'user'=>Auth::user()]);
    }
    public function logout()
    {
        Auth::logout();
        $this->redirect('user.login');
    }
    public function login()
    {
        if(Auth::auth_user()){
            $this->redirect('user.profile');
        }
        $user = new User();

        if($_POST){
            $where = [['email'=>$_POST['email']], ['password'=>md5($_POST['password'])]];
            $new_user = $user->where($where)->one();
            if($new_user->id){
                Auth::auth($new_user);
                $this->redirect('user.profile');
            }else{
                $user->add_messages('email', 'Неверный email или пароль');
            }
        }

        $this->render('user/login', ['title'=>'Вход', 'user'=>$user]);
    }
}