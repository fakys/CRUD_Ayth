<div class="container pt-5">
    <h1><?=$this->title?></h1>
    <form method="post" action="<?=$this->route('add_post')?>">
        <div class="form-group">
            <label for="exampleFormControlInput1">Название</label>
            <input value="<?=$this->post->title?>" name="title" type="text" class="form-control <?php if($this->post->has_message('title')) echo 'is-invalid'?>" placeholder="Введите название">
            <?php if($this->post->has_message('title')):?>
                <div class="error"><?=$this->post->get_message('title')?></div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Содержание поста</label>
            <textarea name="content" class="form-control <?php if($this->post->has_message('content')) echo 'is-invalid'?>" placeholder="Содержание поста"><?=$this->post->content?></textarea>
            <?php if($this->post->has_message('content')):?>
                <div class="error"><?=$this->post->get_message('content')?></div>
            <?php endif;?>
        </div>
        <input type="submit" class="btn btn-primary" value="Создать">
    </form>
</div>