<?php
$type = $_GET['type'];

$albums = get_table($link, "SELECT name FROM albums WHERE type='".$type."'"); //Выбираем название альбомов для определенного типа
    
switch ($type) { //В зависимости от типа материалов
    case 'foto': //Фото
        $podp = "Загрузка новых фотографий";
        break;
    case 'video': //Видео
        $podp = "Загрузка новых видео";
        break;
    case 'audio'://Аудио
        $podp = "Загрузка новых аудиозаписей";
        break;
}

?>


<h2><?=$podp?></h2>
<form method="post" action="index.php?page=media&action=add&type=<?=$type?>" enctype="multipart/form-data">
    <?php switch ($type) { //Для каждого типа
        case 'foto': //Фото ?>
            <label>
                Выберите один или несколько файлов (не больше 20):
                <input type="file" name="files[]" class="form-item-file" multiple include>
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
            <label>
                Ссылка на видео:
                <input type="text" name="file" class="form-item" required>
            </label>
            <label>
                Название видео:
                <input type="text" name="name" class="form-item" required>
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
        case 'audio': //Аудио ?>
            <label>
                Выберите файл:
                <input type="file" name="files" class="form-item-file" required>
            </label>
            <label>
                Название файла:
                <input type="text" name="name" class="form-item" required>
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
    <input type="submit" value="Загрузить" class="btn">
</form>