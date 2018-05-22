<?php
$pp = 15; //Элементов на страницу

if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

$id = $_GET['id'];
    
$menu = get_table($link, "SELECT id, title FROM ministry ORDER BY title");

if ($id == 0) { //Если список служений
    $tbl_count = get_table($link, "SELECT FLOOR((COUNT(*)+".($pp-1).")/".$pp.") AS count FROM ministry"); //Кол-во страниц
    $pc = $tbl_count[0]['count']; //Записываем в переменную
    
    $ministry = get_table($link, "SELECT * FROM ministry ORDER BY title LIMIT ".($pn-1)*$pp.", ".$pp); //Считываем таблицу служений согласно выбранной странице
}
else { //Иначе статья про конкретное служение
    $ministry = get_table($link, "SELECT * FROM ministry WHERE id=".$id);
}
?>

<?php if(count($menu) > 0) {?>

    <div class="Menu">
        <div>
            <?php foreach($menu as $a): ?>
            <a href="index.php?page=ministry&id=<?=$a['id']?>"><?=$a['title']?></a><br>
            <?php endforeach?>
        </div>
    </div>

    <div class = "content">
    <h1>Служения</h1>
        <table class="enum_tbl">
            <tbody>
                <?php if($id == 0) { //Если массив больше одной строки (весь список служений) ?>
                <?php for($i = 0; $i < count($ministry); $i += 3) {?>
                <tr>
                    <td class="enum">
                        <a href="index.php?page=ministry&id=<?=$ministry[$i]['id']?>&p=<?=$pn?>">
                            <h3><?=$ministry[$i]['title']?></h3>
                            <div class="rect1">
                                <div class="rect2">
                                    <img src="img/m/smal_<?=$ministry[$i]['img']?>">
                                </div>
                            </div>
                        </a>
                    </td>
                    <td class="enum">
                        <?php if($i + 1 < count($ministry)) {?>
                        <a href="index.php?page=ministry&id=<?=$ministry[$i + 1]['id']?>&p=<?=$pn?>">
                            <h3><?=$ministry[$i + 1]['title']?></h3>
                            <div class="rect1">
                                <div class="rect2">
                                    <img src="img/m/smal_<?=$ministry[$i + 1]['img']?>">
                                </div>
                            </div>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum">
                        <?php if($i + 2 < count($ministry)) {?>
                        <a href="index.php?page=ministry&id=<?=$ministry[$i + 2]['id']?>&p=<?=$pn?>">
                            <h3><?=$ministry[$i + 2]['title']?></h3>
                            <div class="rect1">
                                <div class="rect2">
                                    <img src="img/m/smal_<?=$ministry[$i + 2]['img']?>">
                                </div>
                            </div>
                        </a>
                        <?php }?>
                    </td>
                </tr>
                <?php }?>
                <?php } else { //Иначе, если выбрано одно служение ?>
                
                <h3><?=$ministry[0]['title']?></h3> <!--Заголовок-->
                <tr>
                    <td class="foto1">
                        
                        <a rel="group" href="img/<?=$ministry[0]['img']?>" class="prevew">
                            <img src="img/m/smal_<?=$ministry[0]['img']?>">
                        </a> <!--Фотка-->
                        <div class="date_publ"><?=$ministry[0]['alt']?></div> <!--Подпись к фото-->
                    </td>
                    <td class="enum_min">
                        <?=$ministry[0]['content']?> <!--Описание-->
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
            <li class="page_list"><a href="index.php?page=ministry&p=1">&lt;&lt;</a></li> &hellip;
            <?php }?>

            <?php for ($c = $first; $c <= $last; $c++) { //выводим ссылки 7 страниц ?>

            <?php if ($c == $pn) { ?>
            <li class="page_main"><?=$c?></li>
            <?php } else { ?>
            <li class="page_list"><a href="index.php?page=ministry&p=<?=$c?>"><?=$c?></a></li>
            <?php }?>

            <?php }?>

            <?php if ($last < $pc) { //Если последняя страница больше последней ссылки, создаем ссылку на последнюю страницу ?>
            &hellip; <li class="page_list"><a href="index.php?page=ministry&p=<?=$pc?>">&gt;&gt;</a></li>
            <?php }?>
        </ul>

        <div class="space"></div>
        <?php }?>
        <!--Конец навигации по страницам-->
        <a href="index.php?page=ministry&p=<?=$pn?>"><img src="i/back.ico" width="40px" title="Вернуться к списку служений"></a><br><br>
    </div>
<?php }?>