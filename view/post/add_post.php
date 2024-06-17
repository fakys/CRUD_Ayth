
<div class="container pt-5">
    <h1><?=$this->title?></h1>
    <form method="post" action="<?=$this->route('add_post')?>">
        <div class="form-group">
            <label for="exampleFormControlInput1">Название</label>
            <input name="title" type="text" class="form-control" placeholder="Введите название">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Содержание поста</label>
            <textarea name="content" class="form-control" placeholder="Содержание поста"></textarea>
        </div>
        <input type="submit" class="btn btn-primary" value="Создать">
    </form>
</div>