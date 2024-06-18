
<div class="container pt-5">
    <h1><?=$this->title?></h1>
    <form method="post" action="<?=$this->route('update_post', ['id'=>$this->post->id])?>">
        <div class="form-group">
            <label for="exampleFormControlInput1">Название</label>
            <input name="title" value="<?=$this->post->title?>" type="text" class="form-control" placeholder="Введите название">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Содержание поста</label>
            <textarea name="content"  class="form-control" placeholder="Содержание поста"><?=$this->post->content?></textarea>
        </div>
        <input type="submit" class="btn btn-primary" value="Обновить">
    </form>
</div>