<?php
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
else $type = '';

check_base($link, 'info'); //Проверяем, пустая ли база и добавляем строку, если да

$array = get_table($link, "SELECT ".$type." AS article FROM info"); //Получаем запись из базы

switch ($type) { //В зависимости от блока
    case 'concept': //Социальная концепция
        $podp = "Социальная концепция";
        break;
    case 'service': //Богослужения
        $podp = "Богослужения";
        break;
    case 'contacts': //Контакты
        $podp = "Контактные данные";
        break;
    case 'mailus': //Написать
        $podp = "Напишите нам";
        break;
    case 'map': //Карта
        $podp = "Карта";
        break;
}

?>



<h2>Редактирование блока "<?=$podp?>"</h2>

<form method="post" action="index.php?page=info&type=<?=$type?>" enctype="multipart/form-data">
    <?php if ($type == 'mailus') { //Если редактирование "Напишите нам" ?>
    <label>
        Укажите e-mail для доставки сообщений:
        <input type="email" name="article" class="form-item" value="<?=dapost($array[0]['article'])?>" required>
    </label>
    <?php } else { //Иначе ?>
    <label>
        Содержание блока:
        <textarea name="article" class="form-item-ta" required><?=dapost($array[0]['article'])?></textarea>
    </label>
    <?php } ?>
    <input type="submit" value="Сохранить" class="btn">
</form>