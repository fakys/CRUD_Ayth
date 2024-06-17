<?php
use vendor\router\Router;

Router::index([\controllers\site\SiteController::class, 'index'], 'index');
Router::get('/add_post', [\controllers\post\PostController::class, 'add_post'], 'add_post');