<div class="container">
    <h1><?=$this->title?></h1>
    <form class="pt-5" method="post" enctype="multipart/form-data" action="<?=$this->route('user.login')?>">
        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control <?php if($this->user->has_message('email')) echo 'is-invalid'?>" placeholder="email">
            <?php if($this->user->has_message('email')):?>
                <div class="error"><?=$this->user->get_message('email')?></div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Пароль</label>
            <input name="password" type="password" class="form-control" placeholder="Пароль">
        </div>
        <button type="submit" class="btn btn-primary">Вход</button>
    </form>
</div>