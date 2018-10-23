<?php
$page = $_GET['page']; //Записываем страницу в переменную

$tbl_pp = get_table($link, "SELECT main_ministry FROM settings"); //Берем из базы кол-во элементов на страницу

if ($tbl_pp != NULL > 0 && $tbl_pp[0]['main_ministry'] != NULL) $pp = $tbl_pp[0]['main_ministry']; //Если значение не пустое, записываем в переменную
else $pp = 15; //Иначе присваиваем значение 15

if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

$id = $_GET['id'];
    
$menu = get_table($link, "SELECT id, title FROM ministry ORDER BY title LIMIT ".($pn-1)*$pp.", ".$pp); //Список названий служений согласно выбраной странице

if ($id == 0) { //Если список служений
    $tbl_count = get_table($link, "SELECT FLOOR((COUNT(*)+".($pp-1).")/".$pp.") AS count FROM ministry"); //Кол-во страниц
    $pc = $tbl_count[0]['count']; //Записываем в переменную
    
    $ministry = get_table($link, "SELECT * FROM ministry ORDER BY title LIMIT ".($pn-1)*$pp.", ".$pp); //Считываем таблицу служений согласно выбранной странице
}
else { //Иначе статья про конкретное служение
    $ministry = get_table($link, "SELECT * FROM ministry WHERE id=".$id);
}
?>

<?php if(count($menu) > 0) { //Если есть служения в базе ?>
    <script>$(function(){$('h3').hyphenate();})</script>
    <div class="Menu">
        <div>
            <?php foreach($menu as $a): //Для каждого элемента всписке служений ?>
            <a href="index.php?page=<?=$page?>&id=<?=$a['id']?>"><?=$a['title']?></a><br>
            <?php endforeach?>
        </div>
    </div>
    <div class="cent">
        <div class = "content">
            <?php if($id == 0) { //Если массив больше одной строки (весь список служений) ?>
            <h1>Служения</h1>
                        
            <div class="grid-3">
                <?php for($i = 0; $i < count($ministry); $i++) { //Для каждого элемена массива с шагом три ?>
                <div class="grid_cell">
                    <a href="index.php?page=<?=$page?>&id=<?=$ministry[$i]['id']?>&p=<?=$pn?>">
                        <div class="rect1_32">
                            <div class="rect2_32">
                                <img src="img/m/smal_<?=$ministry[$i]['img']?>">
                            </div>
                        </div>
                    </a>
                    <h3><?=$ministry[$i]['title']?></h3>
                </div>
                <?php }?>
            </div>
            
            <?php } else { //Иначе, если выбрано одно служение ?>
            
            <h1><?=$ministry[0]['title']?></h1>
            
            <div class="Text">
                <div class="articl_img">
                    <a rel="group" href="img/<?=$ministry[0]['img']?>" class="prevew">
                        <img src="img/m/smal_<?=$ministry[0]['img']?>">
                    </a>
                    <div class="sign"><?=$ministry[0]['alt']?></div>
                </div>
                <div class="articl_text">
                    <?=$ministry[0]['content']?>
                </div>
            </div>
            <?php }?>
            
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
            
            <?php if ($id != 0) { //Если есть выбранное служение ?>
            <div class="space"></div>
            <a href="index.php?page=<?=$page?>&p=<?=$pn?>" class="arrow"><img src="i/back.ico" width="40px" title="Вернуться к списку служений"></a><br><br>
            <?php }?>
        </div>
    </div>
<?php }?>