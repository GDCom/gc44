<?php
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
else $type = '';

check_base($link, 'church'); //Проверяем, пустая ли база и добавляем строку, если да

switch ($type) { //Для каждого типа статьи
    case 'episcop': //Епископ
        $array = get_table($link, "SELECT foto_ep AS foto, art_ep AS article FROM church");
        $podp = "Начальствующий епископ";
        break;
    case 'pastor': //Пастор
        $array = get_table($link, "SELECT foto_past AS foto, art_past AS article FROM church");
        $podp = "Старший пастор";
        break;
    case 'faith': //вероучение
        $array = get_table($link, "SELECT faith AS article FROM church");
        $podp = "Основы вероучения";
        break;
    case 'teach': //Обучение
        $array = get_table($link, "SELECT teach AS article FROM church");
        $podp = "Процесс обучения";
        break;
    case 'pray': //молитва
        $array = get_table($link, "SELECT pray AS article FROM church");
        $podp = "Самая важная молитва";
        break;
}

?>

<h2>Редактирование статьи "<?=$podp?>"</h2>

<form method="post" action="index.php?page=church&type=<?=$type?>" enctype="multipart/form-data">
    <?php if ($type == 'episcop' || $type == 'pastor') { //Если редактирование епископ или пастор ?>
    <label>
        <div class="flex"><input type="checkbox" name="img_check" value="YES" include> Выберите файл изображения:</div>
        <input type="file" name="foto" accept="image/gif, image/jpeg, image/png, image/jpg" class="form-item-file" include>
    </label>
    <?php }?>
    <label>
        Содержание статьи:
        <textarea name="article" class="form-item-ta" required><?=$array[0]['article']?></textarea>
    </label>
    <input type="submit" value="Сохранить" class="btn">
</form>