<?php
$type = $_GET['type'];
$action = $_GET['action'];

if ($action == 'edit') { //Если редактирование
    $id = $_GET['id']; //Получаем id записи
    
    $tbl = get_table($link, "SELECT * FROM ".$type." WHERE id=".$id); //Получаем запись из базы
    
    $name = $tbl[0]['name']; //Название записи
    $album = $tbl[0]['album']; //Название альбома
    
    switch ($type) { //В зависимости от типа материалов
        case 'video': //Видео
            $podp = "Редактирование записи видео";
            break;
        case 'audio'://Аудио
            $podp = "Редактирование аудиозаписи";
            break;
    }
    
    $btn = 'Сохранить'; //Подпись кнопки подтверждения
}
else {
    $file = ""; //Ссылка на файл пустая
    $name = ""; //Название записи пустое
    $album = "Выберите альбом"; //Название альбома пустое
    $id = 0; //Нулевой id для новой записи
    
    switch ($type) { //В зависимости от типа материалов
        case 'foto': //Фото
            $podp = "Загрузка новых фотографий";
            break;
        case 'video': //Видео
            $podp = "Загрузка нового видео";
            break;
        case 'audio'://Аудио
            $podp = "Загрузка новой аудиозаписи";
            break;
    }
    
    $btn = 'Загрузить'; //Подпись кнопки подтверждения
}

$albums = get_table($link, "SELECT name FROM albums WHERE type='".$type."' ORDER BY date DESC"); //Выбираем название альбомов для определенного типа

?>


<h2><?=$podp?></h2>
<form method="post" action="index.php?page=media&action=<?=$action?>&type=<?=$type?>&id=<?=$id?>" enctype="multipart/form-data">
    <?php switch ($type) { //Для каждого типа
        case 'foto': //Фото ?>
            <label>
                Выберите один или несколько файлов (не больше 20):
                <input type="file" name="files[]" accept="image/gif, image/jpeg, image/png, image/jpg" class="form-item-file" multiple include>
            </label>
            <label>
                Название альбома:
                <select type="input" name='album' class="form-item" required>
                    <option value="">Выберите альбом</option>
                    <?php foreach($albums as $a): ?>
                    <option value="<?=$a['name']?>"><?=$a['name']?></option>
                    <?php endforeach ?>
                </select>
            </label>
        <?php break;
        case 'video': //Видео ?>
            <?php if ($action == "add"): //Если добавление новой записи ?>
            <label>
                Ссылка на видео:
                <input type="text" name="file" class="form-item" value="" required>
            </label>
            <?php endif ?>
            <label>
                Название видео:
                <input type="text" name="name" class="form-item" value="<?=$name?>" required>
            </label>
            <label>
                Название альбома:
                <select type="input" name='album' class="form-item" required>
                    <option value="<?=$album?>"><?=$album?></option>
                    <?php foreach($albums as $a): ?>
                    <option value="<?=$a['name']?>"><?=$a['name']?></option>
                    <?php endforeach ?>
                </select>
            </label>
        <?php break;
        case 'audio': //Аудио ?>
            <?php if ($action == "add"): //Если добавление новой записи ?>
            <label>
                Выберите файл:
                <input type="file" name="files" accept="audio/mp3, audio/wav" class="form-item-file" required>
            </label>
            <?php endif ?>
            <label>
                Название файла:
                <input type="text" name="name" class="form-item" value="<?=$name?>" required>
            </label>
            <label>
                Название альбома:
                <select type="input" name='album' class="form-item" required>
                    <option value="<?=$album?>"><?=$album?></option>
                    <?php foreach($albums as $a): ?>
                    <option value="<?=$a['name']?>"><?=$a['name']?></option>
                    <?php endforeach ?>
                </select>
            </label>
        <?php break;
        case 'albums': //Альбомы ?>
           <label>
                Название альбома:
                <input type="text" name="name" class="form-item" required>
            </label>
            <label>
                Тип медиа:
                <select type="input" name='type' class="form-item" required>
                    <option value="">Выберите тип медиа</option>
                    <option value="foto">Фотографии</option>
                    <option value="video">Видеофайлы</option>
                    <option value="audio">Аудиофайлы</option>
                </select>
            </label> 
        <?php break;
    }?>
    <input type="submit" value="<?=$btn?>" class="btn">
</form>