<?php
namespace models;

use vendor\database\model\Model;

class Post extends Model
{
    protected static $table_name = 'posts';
    public function rules()
    {
        return [
            'title'=>['required'],
            'content'=>['required']
        ];
    }
    public function labels()
    {
        return [
            'title'=>'Название',
            'content'=>'Содержимое'
        ];
    }
}