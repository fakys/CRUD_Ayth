<?php
namespace controllers\site;

use models\Post;
use vendor\controller\Controller;

class SiteController extends Controller
{
    protected $layout = 'layout/base';
    public function index()
    {
        $posts =Post::all();
        return $this->render('site/index', ['posts'=>$posts]);
    }
}