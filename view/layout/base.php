<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?=$this->asset('css/bootstrap.css')?>">
    <link rel="stylesheet" href="<?=$this->asset('css/app.bundle.css')?>">
    <link rel="stylesheet" href="<?=$this->asset('css/style.css')?>">
    <title><?=$this->title?></title>
</head>
<body>
<div class="bg-primary p-1 header">
    <div class="logo">
        <a href="<?=$this->route('index')?>">
            Posts
        </a>
    </div>
    <div class="link-header">
        <a href="<?=$this->route('user.login')?>">
            Войти
        </a>
        <a href="<?=$this->route('user.register')?>">
            Регистрация
        </a>
    </div>
</div>
<div>
    <?php $this->content()?>
</div>

</body>
</html>