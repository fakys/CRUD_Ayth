<?php
namespace controllers\post;

use models\Post;
use vendor\controller\Controller;

class PostController extends Controller
{
    protected $layout = 'layout/base';

    public function add_post()
    {
        if ($_POST){
            $post  = new Post($_POST);
            $post->save();
            $this->redirect('index');
        }
        return $this->render('post/add_post', ['title'=>'Создание поста']);
    }
    public function update_post()
    {
        if(empty($_GET['id'])){
            $this->redirect('index');
        }
        $post = Post::pk($_GET['id']);
        if($_POST){
            $new_post = $post->load($_POST);
            $new_post->save();
            $this->redirect('index');
        }

        return $this->render('post/update_post', ['title'=>'Обновление поста', 'post'=>$post]);
    }
}