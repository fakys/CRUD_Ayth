<?php
namespace controllers\post;

use vendor\controller\Controller;

class PostController extends Controller
{
    protected $layout = 'layout/base';

    public function add_post()
    {
        return $this->render('post/add_post');
    }
}