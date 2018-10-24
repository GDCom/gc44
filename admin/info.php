<?php
if (isset($_GET['type']) && isset($_POST['article'])) { //Если переменная типа блока и передаваемая информация по блоку доступны
    $type = $_GET['type'];
    
    run_command($link, "UPDATE info SET ".$type."='".apost($_POST['article'])."'"); //Обновляем данные в базе
    
    header('Location: index.php?page=info'); //Очищаем строку адреса от лишнего
}


?>


<h2>Редактирование основных блоков информации на сайте</h2>

<div class="space"></div>

<div class="tbl_back">
    <div class="tbl_title">
        Блок
    </div>
    <div class="tbl-2">
        <div class="col-1">
            Социальная концепция
        </div>
        <div class="col-last">
            <a href="index.php?page=edit_info&type=concept"><img src="../i/edit.ico" title="Редактировать"></a>
        </div>
        <div class="col-1">
            Богослужения
        </div>
        <div class="col-last">
            <a href="index.php?page=edit_info&type=service"><img src="../i/edit.ico" title="Редактировать"></a>
        </div>
        <div class="col-1">
            Контактные данные
        </div>
        <div class="col-last">
            <a href="index.php?page=edit_info&type=contacts"><img src="../i/edit.ico" title="Редактировать"></a>
        </div>
        <div class="col-1">
            Карта
        </div>
        <div class="col-last">
            <a href="index.php?page=edit_info&type=map"><img src="../i/edit.ico" title="Редактировать"></a>
        </div>
        <div class="col-1">
            Напишите нам
        </div>
        <div class="col-last">
            <a href="index.php?page=edit_info&type=mailus"><img src="../i/edit.ico" title="Редактировать"></a>
        </div>
    </div>
</div>