<?php

use controllers\user\UserController;
use controllers\post\PostController;
use vendor\router\Router;

Router::index([\controllers\site\SiteController::class, 'index'], 'index');
Router::get('/add_post', [PostController::class, 'add_post'], 'add_post');
Router::get('/update_post', [PostController::class, 'update_post'], 'update_post');
Router::get('/delete_post', [PostController::class, 'delete_post'], 'delete_post');
Router::get('/show_post', [PostController::class, 'show_post'], 'show_post');
Router::get('/user/register', [UserController::class, 'register'], 'user.register');
Router::get('/user/login', [UserController::class, 'login'], 'user.login');
Router::get('/user/profile', [UserController::class, 'profile'], 'user.profile');
Router::get('/user/logout', [UserController::class, 'logout'], 'user.logout');