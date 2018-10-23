<?php
if (isset($_GET['article'])) $article = $_GET['article']; //Получаем тип статьи
else $article = ''; //Иначе ноль

switch ($article) {
    case 'episcop':
    default:
        $podp = "Начальствующий епископ";
        if (!$array = get_table($link, "SELECT foto_ep AS foto, art_ep AS 'article' FROM church WHERE id=1")) $array = NULL; //Берем информацию из базы
        break;
    case 'pastor':
        $podp = "Старший пастор";
        $array = get_table($link, "SELECT foto_past AS foto, art_past AS 'article' FROM church WHERE id=1"); //Берем информацию из базы
        break;
    case 'faith':
        $podp = "Основы вероучения";
        $array = get_table($link, "SELECT faith AS 'article' FROM church WHERE id=1"); //Берем информацию из базы
        break;
    case 'teaching':
        $podp = "Процесс обучения";
        $array = get_table($link, "SELECT teach AS 'article' FROM church WHERE id=1"); //Берем информацию из базы
        break;
    case 'prayer':
        $podp = "Самая важная молитва";
        $array = get_table($link, "SELECT pray AS 'article' FROM church WHERE id=1"); //Берем информацию из базы
        break;
    case 'bible':
        $podp = "Библия";
        break;
}

?>

<div class="Menu">
    <div>
        <a href="index.php?page=church&article=episcop">Начальствующий епископ</a>
        <a href="index.php?page=church&article=pastor">Старший пастор</a>
        <a href="index.php?page=church&article=faith">Основы вероучения</a>
        <a href="index.php?page=church&article=teaching">Процесс обучения</a>
        <a href="index.php?page=church&article=prayer">Самая важная молитва</a>
        <a href="index.php?page=church&article=bible">Библия</a>
    </div>
</div>

<div class="cent">
    <div class="content">

        <h1><?=$podp?></h1>
        <div class="Text">
        <?php
        switch ($article) { //Для каждого пункта меню
            case  'episcop': //Начальствующий епископ
            case 'pastor': //Старший пастор
            default: //По умолчанию ?>
                <?php if ($array != NULL) { //Если массив не пустой ?>
                <div class="articl_img">
                    <a rel="group" href="img/<?=$array[0]['foto']?>" class="prevew"><img src="img/m/smal_<?=$array[0]['foto']?>"></a>
                </div>
                <div class="articl_text">
                    <?=$array[0]['article']?>
                </div>
                <?php }?>
                <?php break;
            case 'faith': //Основы вероучения
            case 'teaching': //Процесс обучения
            case 'prayer': //Самая важная молитва ?>
                <?php if ($array != NULL) { //Если массив не пустой ?>
                <?=$array[0]['article']?>
                <?php }?>
                <?php break;
            case 'bible': //Библия ?>
                <iframe class="bible" src="http://allbible.info/iframebible/" title="Подкрепись! Библия онлайн." frameborder="0" scrolling="no" data-proportion="0.9806629834254144"></iframe>
                <?php break; } ?>
        </div>
    </div>
</div>