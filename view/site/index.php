<main id="js-page-content" role="main" class="page-content">
    <div class="col-md-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Список статей
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="fs-lg fw-300 p-5 bg-white border-faded rounded mb-g">
                        <?php foreach ($this->posts as $value):?>
                        <div>
                            <div><?=$value->title?></div>
                            <div><?=$value->content?></div>
                            <div class="d-flex gap-10">
                                <a href="<?=$this->route('show_post', ['id'=>$value->id])?>" class="btn btn-info ml-auto">Просмотр</a>
                                <a href="<?=$this->route('update_post', ['id'=>$value->id])?>" class="btn btn-warning">Редактирование</a>
                                <a href="<?=$this->route('delete_post', ['id'=>$value->id])?>" class="btn btn-danger">Удаление</a>
                            </div>
                            <hr>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <a href="<?=$this->route('add_post')?>" class="btn btn-success">Добавить статью</a>
                </div>
            </div>
        </div>
    </div>
</main>