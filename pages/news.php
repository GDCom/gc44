<?php
$page = $_GET['page']; //Записываем страницу в переменную

$tbl_pp = get_table($link, "SELECT main_news FROM settings"); //Берем из базы кол-во элементов на страницу

if ($tbl_pp != NULL > 0 && $tbl_pp[0]['main_news'] != NULL) $pp = $tbl_pp[0]['main_news']; //Если значение не пустое, записываем в переменную
else $pp = 15; //Иначе присваиваем значение 15

if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

$id = $_GET['id'];
    
if ($id == 0) { //Если список новостей
    $tbl_count = get_table($link, "SELECT FLOOR((COUNT(*)+".($pp-1).")/".$pp.") AS count FROM news"); //Кол-во страниц новостей
    $pc = $tbl_count[0]['count']; //Записываем в переменную
    
    $news = get_table($link, "SELECT * FROM `news` Order By date DESC LIMIT ".($pn-1)*$pp.", ".$pp); //Считываем таблицу новостей согласно выбранной странице
}
else { //Иначе
    $news = get_table($link, "SELECT * FROM `news` WHERE id=".$id); //Считываем из базы конкретную новость
}
?>

<div class="cent">
    <div class="content">
        
        <?php if ($id != 0) { //Если одна статья ?>
        <h1><?=$news[0]['title']?></h1>
        <div class="space"></div>

        <p class="date_publ">Опубликовано: <?=$news[0]['date']?></p>
            
        <div class="Text">
            <div class="articl_img">
                <?php if ($news[0]['img1'] != NULL) { // Если есть первое изображение ?>
                <a rel="group" href="img/<?=$news[0]['img1']?>" class="prevew">
                    <div class="rect1_32">
                        <div class="rect2_32">
                            <img src="img/m/smal_<?=$news[0]['img1']?>">
                        </div>
                    </div>
                </a>
                <?php }?>
            </div>
            <div class="articl_text">
                <?=dapost($news[0]['content'])?>
            </div>
        </div>
            
        <?php if($news[0]['imgs'] != NULL) { //Если есть дополнительные изображения ?>
        <?php
            $s = explode(";", $news[0]['imgs']); //Разбиваем список изображений в массив
            $i = count($s); //Количество изображений
        ?>
        <div class="grid-3">
            <?php for ($t = 0; $t < $i; $t++) { //Для всех изображений с шагом 3 ?>
            <a rel="group" href="img/<?=$s[$t]?>" class="prevew">
                <div class="grid_cell">
                    <div class="rect1_32">
                        <div class="rect2_32">
                            <img src="img/m/smal_<?=$s[$t]?>">
                        </div>
                    </div>
                </div>
            </a>
            <?php }?>
        </div>
        <?php }?>
            
        <a href="index.php?page=<?=$page?>&id=0&p=<?=$pn?>" class="arrow"><img src="i/back.ico" width="40px" title="Вернуться к списку новостей"></a><br><br>
            
        <?php } else { //Иначе, если список статей ?>
        <h1>Новости</h1>
            
        <div class="grid-3">
            <?php for($t = 0; $t < count($news); $t++): //Для каждого элемента списка новостей с шагом три ?>
            <div class="grid_cell">
                <p class="date_publ">Опубликовано: <?=$news[$t]['date']?></p>
                <a href="index.php?page=<?=$page?>&id=<?=$news[$t]['id']?>&p=<?=$pn?>">
                    <div class="rect1_32">
                        <div class="rect2_32">
                            <?php if ($news[$t]['img1'] != NULL) { //Если первое изображение есть ?>
                            <img src="img/m/smal_<?=$news[$t]['img1']?>">
                            <?php } else { //Иначе ?>
                            <div class="Text"><?=dapost($news[$t]['content'])?></div>
                            <?php }?>
                        </div>
                    </div>
                </a>
                <h3><?=$news[$t]['title']?></h3>
            </div>
            <?php endfor ?>
        </div>
            
        
        <!--Навигация по страницам-->
        <?php if ($pc > 1) { //Если страниц больше одной ?>
        <?php
        if ($pc >= 7) { //Если количество страниц больше либо равно 7
            //Высчитываем первую ссылку
            if ($pn <= 4) $first = 1;
            elseif ($pn > 4 && ($pc - 4) >= $pn) $first = $pn - 3;
            else $first = $pc - 6;

            //Высчитываем последнюю ссылку
            if (($first + 6) <= $pc) $last = $first + 6;
            else $last = $pc;
        }
        else {
            $first = 1;
            $last = $pc;
        }
        ?>

        <ul class="page_num">
            <?php if ($first > 1) { //Если первая ссылка больше первой страницы, создаем ссылку на первую страницу ?>
            <li class="page_list"><a href="index.php?page=<?=$page?>&p=1">&lt;&lt;</a></li> &hellip;
            <?php }?>

            <?php for ($c = $first; $c <= $last; $c++) { //выводим ссылки 7 страниц ?>

            <?php if ($c == $pn) { ?>
            <li class="page_main"><?=$c?></li>
            <?php } else { ?>
            <li class="page_list"><a href="index.php?page=<?=$page?>&p=<?=$c?>"><?=$c?></a></li>
            <?php }?>

            <?php }?>

            <?php if ($last < $pc) { //Если последняя страница больше последней ссылки, создаем ссылку на последнюю страницу ?>
            &hellip; <li class="page_list"><a href="index.php?page=<?=$page?>&p=<?=$pc?>">&gt;&gt;</a></li>
            <?php }?>
        </ul>

        <div class="space"></div>
        <?php }?>
        <!--Конец навигации по страницам-->

        <?php }?>
    </div>
</div>