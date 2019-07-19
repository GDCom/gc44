<?php
$type = $_GET['type'];
$action = $_GET['action'];

if (isset($_GET['album'])) $album = $_GET['album']; //Если доступен параметр альбома, то прописываем в переменную
else $album = "Выберите альбом"; //Иначе название альбома пустое

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
else { //иначе
    $file = ""; //Ссылка на файл пустая
    $name = ""; //Название записи пустое
    
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
        case 'fotoAlbums': //Фотоальбом
            $type = 'albums';
            $type_album = 'foto';
            $podp = "Создание нового фотоальбома";
            break;
        case 'videoAlbums': //Фотоальбом
            $type = 'albums';
            $type_album = 'video';
            $podp = "Создание нового видеоальбома";
            break;
        case 'audioAlbums': //Фотоальбом
            $type = 'albums';
            $type_album = 'audio';
            $podp = "Создание нового аудиоальбома";
            break;
    }
    
    $btn = 'Загрузить'; //Подпись кнопки подтверждения
}

switch ($type) { //В зависимости от типа
    case 'albums': //Добавление альбома
        $albums = get_table($link, "SELECT name, id FROM albums WHERE type='".$type_album."' AND parentId=0 ORDER BY date DESC"); //Выбираем названия корневых альбомов для определенного типа
        break;
    default: //Для остальных случаев
        $albums = get_table($link, "SELECT name FROM albums WHERE type='".$type."' ORDER BY date DESC"); //Выбираем название альбомов для определенного типа
        break;
}

?>


<h2><?=$podp?></h2>
<form method="post" action="index.php?page=media&action=<?=$action?>&type=<?=$type?>&id=<?=$id?>" enctype="multipart/form-data">
    <br>
    <?php switch ($type) { //Для каждого типа
        case 'foto': //Фото ?>
            <label>
                Выберите один или несколько файлов (не больше 20):
                <input type="file" name="files[]" accept="image/gif, image/jpeg, image/png, image/jpg" class="form-item-file" multiple include>
            </label>
            <label>
                Название альбома:
                <select type="input" name='album' class="form-item" required>
                    <option value="<?=apost($album)?>"><?=$album?></option>
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
    
            <div class="space"></div>        
            <label>
                Обложка:
                <input type="file" name="cover" accept="image/gif, image/jpeg, image/png, image/jpg" class="form-item-file" include>
            </label>
            <?php endif ?>
    
            <label>
                Название видео:
                <input type="text" name="name" class="form-item" value="<?=$name?>" required>
            </label>
            
            <div class="space"></div>
            
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
    
            <div class="space"></div>
    
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
            <label style="visibility: hidden"> <?php //Скрываем, чтобы не смущало ?>
                Тип медиа:
                <input type="text" name="type" class="form-item" value="<?=$type_album?>" required readonly>
            </label>
            <label>
                Название альбома:
                <input type="text" name="name" class="form-item" required>
            </label>
            <?php if ($type_album != 'foto') { //Если тип альбома не фото ?>
            <label>
                Выбор родительского альбома:
                <select type="input" name='parent_album' class="form-item" required>
                    <option value="0">Корневой альбом</option>
                    <?php foreach($albums as $a): ?>
                    <option value="<?=$a['id']?>"><?=$a['name']?></option>
                    <?php endforeach ?>
                </select>
            </label>
            <?php }?>
        <?php break;
    }?>
    
    <div class="space"></div>
    
    <input type="submit" value="<?=$btn?>" class="btn">
</form>