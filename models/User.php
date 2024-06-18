<?php
namespace models;

use vendor\database\model\Model;

class User extends Model
{
    protected static $table_name = 'users';

    public function rules()
    {
        return [
            'name'=>['required'],
            'email'=>['required', 'email', 'unique'],
            'fio'=>['required'],
            'password'=>['required', 'equal'=>'password_confirm']
        ];
    }
    public function labels()
    {
        return [
            'name'=>'Логин',
            'email'=>'Email',
            'fio'=>'ФИО',
            'password'=>'Пароль',
            'password_confirm'=> 'Повторите пароль'
        ];
    }
}