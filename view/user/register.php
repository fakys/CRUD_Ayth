<div class="container">
    <h1><?=$this->title?></h1>
    <form class="pt-5" method="post" enctype="multipart/form-data" action="<?=$this->route('user.register')?>">
        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control <?php if($this->user->has_message('email')) echo 'is-invalid'?>" placeholder="email">
            <?php if($this->user->has_message('email')):?>
                <div class="error"><?=$this->user->get_message('email')?></div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label>Логин</label>
            <input name="name" type="text" class="form-control <?php if($this->user->has_message('name')) echo 'is-invalid'?>" placeholder="Логин">
            <?php if($this->user->has_message('name')):?>
                <div class="error"><?=$this->user->get_message('name')?></div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label>ФИО</label>
            <input name="fio" type="text" class="form-control <?php if($this->user->has_message('fio')) echo 'is-invalid'?>" placeholder="ФИО">
            <?php if($this->user->has_message('fio')):?>
                <div class="error"><?=$this->user->get_message('fio')?></div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label>Аватар</label>
            <input name="avatar" type="file" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Пароль</label>
            <input name="password" type="password" class="form-control <?php if($this->user->has_message('password')) echo 'is-invalid'?>" placeholder="Пароль">
            <?php if($this->user->has_message('password')):?>
                <div class="error"><?=$this->user->get_message('password')?></div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Повторите пароль</label>
            <input name="password_confirm" type="password" class="form-control" placeholder="Повторите пароль">
        </div>
        <button type="submit" class="btn btn-primary">Регистрация</button>
    </form>
</div>