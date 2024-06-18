<?php
namespace controllers\post;

use models\Post;
use vendor\auth\Auth;
use vendor\controller\Controller;

class PostController extends Controller
{
    protected $layout = 'layout/base';

    public function add_post()
    {
        if(!Auth::auth_user()){
            $this->redirect('user.login');
        }
        $post  = new Post();
        if ($_POST){
            $post->load($_POST);
            if($post->validate()){
                $post->create($_POST);
                $this->redirect('index');
            }
        }
        return $this->render('post/add_post', ['title'=>'Создание поста', 'post'=>$post]);
    }
    public function update_post()
    {
        if(!Auth::auth_user()){
            $this->redirect('user.login');
        }
        if(empty($_GET['id'])){
            $this->redirect('index');
        }
        $post = Post::pk($_GET['id']);
        if($_POST && $post->id){
            $post->load($_POST);
            if($post->save()){
                $this->redirect('index');
            }

        }

        return $this->render('post/update_post', ['title'=>'Обновление поста', 'post'=>$post]);
    }
    public function delete_post()
    {
        if(!Auth::auth_user()){
            $this->redirect('user.login');
        }
        if(empty($_GET['id'])){
            $this->redirect('index');
        }

        $post = Post::pk($_GET['id']);

        if($post->id){

            $post->delete();
        }
        $this->redirect('index');
    }
    public function show_post()
    {
        if(empty($_GET['id'])){
            $this->redirect('index');
        }
        $post = Post::pk($_GET['id']);

        if($post->id){
            return $this->render('post/show_post', ['title'=>'Просмотр поста', 'post'=>$post]);
        }
        $this->redirect('index');
    }
}