<div class="container">
    <div class="d-flex align-items-center justify-content-center pt-5">
        <div class="image-container">
            <img src="<?=$this->asset("image/users_ava/{$this->user['avatar']}")?>" width="150">
        </div>
        <div class="pl-3">
          <div class="d-flex flex-column justify-content-around">
              <p>Email: <?=$this->user['email']?></p>
              <p>Логин: <?=$this->user['name']?></p>
              <p>ФИО: <?=$this->user['fio']?></p>
          </div>
            <a href="<?=$this->route('user.logout')?>" class="btn btn-danger">Выйти</a>
        </div>
    </div>
</div>