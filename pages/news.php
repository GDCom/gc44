<?php
$pp = 15; //Новостей на страницу

if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

$id = $_GET['id'];
    
if ($id == 0) { //Если список новостей
    $tbl_count = get_table($link, "SELECT FLOOR((COUNT(*)+".($pp-1).")/".$pp.") AS count FROM `news` Order By id DESC"); //Кол-во страниц новостей
    $pc = $tbl_count[0]['count']; //Записываем в переменную
    
    $news = get_table($link, "SELECT * FROM `news` Order By date DESC LIMIT ".($pn-1)*$pp.", ".$pp); //Считываем таблицу новостей согласно выбранной странице
}
else { //Иначе
    $news = get_table($link, "SELECT * FROM `news` WHERE id=".$id); //Считываем из базы конкретную новость
}
?>

<div class="content">
<h1>Новости</h1> <!--Заголовок-->

<div class = "Text">
    <?php if (count($news) == 1) { //Если одна статья ?>
    <h3><?=$news[0]['title']?></h3>
    <div class="date_publ">Опубликовано: <?=$news[0]['date']?> (Мск)</div>
    <table>
        <tbody>
            <tr>
                <?php if ($news[0]['img1'] != NULL) { // Если есть первое изображение ?>
                <td class="enum">
                    <a rel="group" href="img/<?=$news[0]['img1']?>" class="prevew"><img class="first" src="img/m/smal_<?=$news[0]['img1']?>"></a>
                </td>
                <?php }?>
                <td class="enum" colspan="2" width="100%">
                    <p><?=$news[0]['content']?></p>
                </td>
            </tr>
            <?php if($news[0]['imgs'] != NULL) { ?>
            <?php
                $s = explode(";", $news[0]['imgs']); //Разбиваем список изображений в массив
                $i = count($s); //Количество изображений
            ?>
            <tr>
                <td height=5px></td>
            </tr>
            <?php for ($t = 0; $t < $i; $t = $t + 3) { //Для всех изображений с шагом 3 ?>
            <tr>
                <td class="enum">
                    <a rel="group" href="img/<?=$s[$t]?>" class="prevew">
                        <div class="rect1">
                            <div class="rect2">
                                <img src="img/m/smal_<?=$s[$t]?>">
                            </div>
                        </div>
                    </a>
                </td>
                <td class="enum">
                    <?php if($t + 1 < $i) {?>
                    <a rel="group" href="img/<?=$s[$t+1]?>" class="prevew">
                        <div class="rect1">
                            <div class="rect2">
                                <img src="img/m/smal_<?=$s[$t+1]?>">
                            </div>
                        </div>
                    </a>
                    <?php }?>
                </td>
                <td class="enum">
                    <?php if($t + 2 < $i) {?>
                    <a rel="group" href="img/<?=$s[$t+2]?>" class="prevew">
                        <div class="rect1">
                            <div class="rect2">
                                <img src="img/m/smal_<?=$s[$t+2]?>">
                            </div>
                        </div>
                    </a>
                    <?php }?>
                </td>
            </tr>
            <?php }?>
            <?php }?>
            <?php if($id != 0) {?>
            <tr>
                <td>
                    <a href="index.php?page=news&id=0&p=<?=$pn?>"><img src="i/back.ico" width="40px" title="Вернуться к списку новостей"></a><br><br>
                </td>
                <td class="enum"></td>
                <td class="enum"></td>
            </tr>
            <?php }?>
        </tbody>
    </table>

<?php } else { //Иначе, если список статей ?>
    <table>
        <tbody>
            <?php for($t = 0; $t < count($news); $t += 3) { //Для каждого элемента списка новостей с шагом три ?>
            <tr>
                <td class="enum"> <!--Первый столбец-->
                    <div class="top">
                        <a href="index.php?page=news&id=<?=$news[$t]['id']?>&p=<?=$pn?>">
                            <h3><?=$news[$t]['title']?></h3> <!--Заголовок-->
                            <div class="date_publ">Опубликовано: <?=$news[$t]['date']?> (Мск)</div><br> <!--Дата публикации-->
                            <div class="rect1">
                                <div class="rect2">
                                    <?php if ($news[$t]['img1'] != NULL) { //Если первое изображение есть ?>
                                    <img src="img/m/smal_<?=$news[$t]['img1']?>"> <!--Изображение со ссылкой на новость-->
                                    <?php } else { //Иначе ?>
                                    <?=$news[$t]['content']?> <!--Текст новости-->
                                    <?php }?>
                                </div>
                            </div>
                        </a>
                    </div>
                </td>
                <td class="enum"> <!--Второй столбец-->
                    <?php if ($t+1 < count($news)) { //Если номер строки меньше количества всех строк ?>
                    <div class="top">
                        <a href="index.php?page=news&id=<?=$news[$t+1]['id']?>&p=<?=$pn?>">
                            <h3><?=$news[$t+1]['title']?></h3> <!--Заголовок-->
                            <div class="date_publ">Опубликовано: <?=$news[$t+1]['date']?> (Мск)</div><br> <!--Дата публикации-->
                            <div class="rect1">
                                <div class="rect2">
                                    <?php if ($news[$t+1]['img1'] != NULL) { //Если первое изображение есть ?>
                                    <img src="img/m/smal_<?=$news[$t+1]['img1']?>"> <!--Изображение со ссылкой на новость-->
                                    <?php } else { //Иначе ?>
                                    <?=$news[$t+1]['content']?> <!--Текст новости-->
                                    <?php }?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php }?>
                </td>
                <td class="enum"> <!--Третий столбец-->
                    <?php if ($t+2 < count($news)) { //Если номер строки меньше количества всех строк ?>
                    <div class="top">
                        <a href="index.php?page=news&id=<?=$news[$t+2]['id']?>&p=<?=$pn?>">
                            <h3><?=$news[$t+2]['title']?></h3> <!--Заголовок-->
                            <div class="date_publ">Опубликовано: <?=$news[$t+2]['date']?> (Мск)</div><br> <!--Дата публикации-->
                            <div class="rect1">
                                <div class="rect2">
                                    <?php if ($news[$t+2]['img1'] != NULL) { //Если первое изображение есть ?>
                                    <img src="img/m/smal_<?=$news[$t+2]['img1']?>"> <!--Изображение со ссылкой на новость-->
                                    <?php } else { //Иначе ?>
                                    <?=$news[$t+2]['content']?> <!--Текст новости-->
                                    <?php }?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php }?>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
    
    <!--Навигация по страницам-->
    <div class="space"></div>
    <?php if ($pc > 1) { //Если страниц больше одной ?>
    <?php
    //Высчитываем первую ссылку
    if ($pn <= 4) $first = 1;
    elseif ($pn > 4 && ($pc - 4) >= $pn) $first = $pn - 3;
    else $first = $pc - 6;

    //Высчитываем последнюю ссылку
    if (($first + 6) <= $pc) $last = $first + 6;
    else $last = $pc;
    ?>

    <ul class="page_num">
        <?php if ($first > 1) { //Если первая ссылка больше первой страницы, создаем ссылку на первую страницу ?>
        <li class="page_list"><a href="index.php?page=news&p=1">&lt;&lt;</a></li> &hellip;
        <?php }?>

        <?php for ($c = $first; $c <= $last; $c++) { //выводим ссылки 7 страниц ?>

        <?php if ($c == $pn) { ?>
        <li class="page_main"><?=$c?></li>
        <?php } else { ?>
        <li class="page_list"><a href="index.php?page=news&p=<?=$c?>"><?=$c?></a></li>
        <?php }?>

        <?php }?>

        <?php if ($last < $pc) { //Если последняя страница больше последней ссылки, создаем ссылку на последнюю страницу ?>
        &hellip; <li class="page_list"><a href="index.php?page=news&p=<?=$pc?>">&gt;&gt;</a></li>
        <?php }?>
    </ul>

    <div class="space"></div>
    <?php }?>
    <!--Конец навигации по страницам-->
    
<?php }?>
</div>
</div>