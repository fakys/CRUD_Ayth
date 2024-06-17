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
            return $this->redirect('index');
        }
        return $this->render('post/add_post', ['title'=>'Создание поста']);
    }
}