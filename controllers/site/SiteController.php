<?php
namespace controllers\site;

use vendor\controller\Controller;

class SiteController extends Controller
{
    protected $layout = 'layout/base';
    public function index()
    {
        return $this->render('site/index');
    }
}