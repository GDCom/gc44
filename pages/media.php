<?php
$page = $_GET['page']; //Записываем страницу в переменную
$array = NULL;

$tbl_p = get_table($link, "SELECT main_alb, main_foto, main_video, main_audio FROM settings"); //Берем из базы кол-во элементов на страницу по всем медиа

if ($tbl_p == NULL) { //Если таблица пустая, заполняем значениями по умолчанию
    $tbl_p[0]['main_alb'] = 30;
    $tbl_p[0]['main_foto'] = 30;
    $tbl_p[0]['main_video'] = 15;
    $tbl_p[0]['main_audio'] = 30;
}

$ppa = $tbl_p[0]['main_alb']; //Записываем в переменную кол-во альбомов на странице

if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

if (isset($_GET['pa'])) $pna = $_GET['pa']; //Если доступен параметр номера страницы альбома, записываем в переменную
else $pna = 1; //Иначе первая страница

$type = $_GET['type'];
if ($type == '') $type = 'foto';

if (isset($_GET['album'])) { //Если доступен параметр альбом
    $album = apost($_GET['album']);
    
    $tbl_par = get_table($link, "SELECT id, parentId FROM albums WHERE name='".$album."'"); //Получаем id и parentId альбома
    $parent = $tbl_par[0]['parentId'];
        
    $tbl_parent_alb = get_table($link, "SELECT name FROM albums WHERE id='".$parent."'"); //Название родительского альбома
    $par_alb = $tbl_parent_alb[0]['name']; //Записываем в переменную
        
    $dot_alb = get_table($link, "SELECT * FROM albums WHERE type='".$type."' AND parentId=".$tbl_par[0]['id']." ORDER BY date DESC"); //Список дочерних альбомов
    $parent_alb = get_table($link, "SELECT * FROM albums WHERE type='".$type."' AND parentId=".$tbl_par[0]['parentId']." ORDER BY date DESC"); //Список дочерних альбомов
}
else {
    $album = ''; //иначе переменная пустая
    $parent = 0; //Переменная родительского альбома равна нулю
}
    
if ($album == '') $dot_alb = get_table($link, "SELECT * FROM albums WHERE type='".$type."' AND parentId=0 ORDER BY date DESC"); //Список корневых альбомов

if (isset($_GET['par'])) $parent = $_GET['par']; //Если доступен параметр родительского альбома, записываем в переменную
else $parent = 0; //Иначе корень альбомов

switch ($type) { //В зависимости от типа медиа
    case 'foto':
        $podp = "Фотографии";
        $pp = $tbl_p[0]['main_foto'];
        break;
    case 'video':
        $podp = "Видеофайлы";
        $pp = $tbl_p[0]['main_video'];
        break;
    case 'audio':
        $podp = "Аудиофайлы";
        $pp = $tbl_p[0]['main_audio'];
        break;
}
    
$array = albums($link, $type, $pp, $pn, $ppa, $pna); //Выборка альбомов согласно страниц
$pca = $array['al_count']; //Кол-во страниц альбомов

?>

<div class="Menu">
    <div>
        <a href="index.php?page=<?=$page?>&type=foto">Фотографии</a><br>
        <a href="index.php?page=<?=$page?>&type=video">Видеофайлы</a><br>
        <a href="index.php?page=<?=$page?>&type=audio" class="space">Аудиофайлы</a><br>

        <?php if (count($parent_alb) > 0) { ?>
        <?php foreach($parent_alb as $a): ?>
        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$a['name']?>&pa=<?=$pna?>" class="second"><?=$a['name']?></a><br>
        <?php endforeach ?>
        <?php }?>
    </div>
</div>
<div class="cent">
    <div class="content">
        <h1><?=$podp?></h1>
        <div class="space"></div>
        <?php if ($album != '' && $par_alb != '') { //Если выбран какой-то альбом ?>
            <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$par_alb?>&pa=<?=$pna?>" class="arrow"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
            <?php }
        elseif ($album != '' && $par_alb == '') { ?>
            <a href="index.php?page=<?=$page?>&type=<?=$type?>&pa=<?=$pna?>" class="arrow"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
        <?php }?>
        
        <?php if (count($array['album']) > 0) { //Если массив не пустой ?>
            <?php if (count($dot_alb) > 0) { //Если список дочерних альбомов не пуст ?>
                <div class="btn_look">
                    <b>Альбомы</b>
                </div>


                <?php if ($type == 'foto') { //Если тип данных фото ?>
                    <div class="grid-5">
                        <?php for($i = 0; $i < count(dapost($array['album'])); $i++) { //Для каждого альбома ?>
                        <div class="grid_cell">
                            <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i]?>&pa=<?=$pna?>">
                                <div class="alb_main">
                                    <div class="sq1">
                                        <div class="sq2">
                                            <img src="media/<?=$type?>/m/smal_<?=dapost($array['main'][$i])?>">
                                        </div>
                                    </div>
                                    <div class="alb_title"><?=$array['album'][$i]?></div>
                                </div>
                            </a>
                        </div>
                        <?php }?>
                    </div>
                <?php }
                else { //Иначе ?>
                    <div class="grid-3">
                        <?php for($i = 0; $i < count($dot_alb); $i++) { //Для каждого альбома ?>
                        <div class="grid_cell">
                            <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$dot_alb[$i]['name']?>&pa=<?=$pna?>">
                            <div class="rect1">
                                <div class="rect2">
                                    <?php $tbl = get_table($link, "SELECT * FROM ".$type." WHERE album='".$dot_alb[$i]['name']."' ORDER BY date DESC") //Берем обложки видео выбранного альбома ?>

                                    <div class="folder_cover">
                                        <?php if($tbl[0]['cover'] != '') { //Если есть обложка на последнее видео  ?>
                                        <img src="media/video/m/smal_<?=$tbl[0]['cover']?>">
                                        <?php }
                                        elseif ($type == 'video') { //иначе, если тип видео ?>
                                        <img src="i/video.jpg">
                                        <?php }
                                        elseif ($type == 'audio') { //Иначе, если тип аудио ?>
                                        <img src="i/audio_s.png">
                                        <?php } ?>
                                    </div>

                                    <div class="folder_front">
                                        <div class="Text"><?=$dot_alb[$i]['name']?></div> <!--(<?=count($tbl)?>)-->
                                    </div>

                                </div>
                            </div>

                            </a>
                        </div>
                        <?php }?>
                    </div>

                <?php }?>

                <!--Навигация по страницам-->
                <?php if ($pca > 1) { //Если страниц больше одной ?>
                <?php
                if ($pca >= 7) { //Если количество страниц больше либо равно 7
                    //Высчитываем первую ссылку
                    if ($pna <= 4) $first = 1;
                    elseif ($pna > 4 && ($pca - 4) >= $pna) $first = $pna - 3;
                    else $first = $pca - 6;

                    //Высчитываем последнюю ссылку
                    if (($first + 6) <= $pca) $last = $first + 6;
                    else $last = $pca;
                }
                else { //Иначе
                    $first = 1;
                    $last = $pca;
                }
                ?>

                <ul class="page_num">
                    <?php if ($first > 1) { //Если первая ссылка больше первой страницы, создаем ссылку на первую страницу ?>
                    <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$t]?>&pa=1">&lt;&lt;</a></li> &hellip;
                    <?php }?>

                    <?php for ($c = $first; $c <= $last; $c++) { //выводим ссылки 7 страниц ?>

                    <?php if ($c == $pna) { ?>
                    <li class="page_main"><?=$c?></li>
                    <?php } else { ?>
                    <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$t]?>&pa=<?=$c?>"><?=$c?></a></li>
                    <?php }?>

                    <?php }?>

                    <?php if ($last < $pca) { //Если последняя страница больше последней ссылки, создаем ссылку на последнюю страницу ?>
                    &hellip; <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$t]?>&pa=<?=$pca?>">&gt;&gt;</a></li>
                    <?php }?>
                </ul>
                <?php }?>
                <!--Конец навигации по страницам-->
            <?php } ?>
        
            <div class="space"></div>
                

                <?php for($t = 0; $t < count($array['album']); $t++) { //Для каждого альбома ?>
                <?php if ($array['album'][$t] == $album) { //Если выбранный альбом равняется текущему ?>
        
                <?php $pc = $array['count'][$t]; //Кол-во страниц ?>

                <div class="btn_look">
                    <b><?=$array['album'][$t]?></b>
                </div>

                <?php $tbl = $array['table'][$t]; ?>
                <?php switch ($type) {
                    case 'foto': //Показ фоток ?>
                        <div class="grid-5">
                            <?php for ($i = 0; $i < count($tbl); $i++) { //Для каждого элемента в альбоме ?>
                            <div class="grid_cell">
                                <a rel="group" href="media/<?=$type?>/<?=dapost($tbl[$i]['file'])?>" class="prevew">
                                    <div class="blink_rect"></div>
                                    <div class="sq1">
                                        <div class="sq2">
                                            <img src="media/<?=$type?>/m/smal_<?=dapost($tbl[$i]['file'])?>">
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php }?>
                        </div>
                        <?php break;
                    case 'video': //Показ видео ?>
                        <div class="grid-3">
                            <?php for ($i = 0; $i < count($tbl); $i++) { //Для каждого элемента в альбоме ?>
                            <?php $file = dapost(get_youtube($tbl[$i]['file'])); //Получаем ссылку для фрейма ?>
                            <div class="grid_cell">
                                <input class="video_frame" id="v<?=$i?>" type="checkbox">
                                <label class="video_label" for="v<?=$i?>">
                                    <div class="rect1">
                                        <div class="rect2">
                                            <?php if ($tbl[$i]['cover'] == '') { //Если есть обложка на видео ?>
                                            <img src="i/video.jpg">
                                            <?php }
                                            else { //Иначе ?>
                                            <img src="media/video/m/smal_<?=$tbl[$i]['cover']?>">
                                            <?php }?>
                                        </div>
                                    </div>
                                </label>
                                <div class="video_window">
                                    <div id="close_vid<?=$i?>"><a href="">
                                        <label class="video_label-2" for="v<?=$i?>"></label>
                                        <div class="vid_close"></div>
                                    </a></div>
                                    <iframe class="video" src="https://www.youtube.com/embed/<?=$file?>?enablejsapi=1" frameborder="0" allowfullscreen></iframe>
                                </div>
                                <div class="Text"><?=dapost($tbl[$i]['name'])?></div>
                            </div>
                            <?php }?>
                        </div>
                        <?php break;
                    case 'audio': //Показ аудио ?>
                        <div class="grid-1">
                            <?php foreach($tbl as $a): ?>
                            <div class="grid-2_40-60">
                                <div>
                                    <audio controls class="audio">
                                        <source src="media/audio/<?=dapost($a['file'])?>">
                                        <p>Ваш браузер не поддерживает аудио</p>
                                    </audio>
                                </div>
                                <div><?=dapost($a['name'])?></div>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <?php break;
                }?>


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
                    <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$t]?>&p=1&pa=<?=$pna?>">&lt;&lt;</a></li> &hellip;
                    <?php }?>

                    <?php for ($c = $first; $c <= $last; $c++) { //выводим ссылки 7 страниц ?>

                    <?php if ($c == $pn) { ?>
                    <li class="page_main"><?=$c?></li>
                    <?php } else { ?>
                    <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$t]?>&p=<?=$c?>&pa=<?=$pna?>"><?=$c?></a></li>
                    <?php }?>

                    <?php }?>

                    <?php if ($last < $pc) { //Если последняя страница больше последней ссылки, создаем ссылку на последнюю страницу ?>
                    &hellip; <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$t]?>&p=<?=$pc?>&pa=<?=$pna?>">&gt;&gt;</a></li>
                    <?php }?>
                </ul>
                <?php }?>
                <!--Конец навигации по страницам-->

                <?php }?>
                <?php }?>

        <?php }?>
        <?php if ($album != '' && $par_alb != '') { //Если выбран какой-то альбом ?>
            <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$par_alb?>&pa=<?=$pna?>" class="arrow"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
        <?php }
        elseif ($album != '' && $par_alb == '') { ?>
            <a href="index.php?page=<?=$page?>&type=<?=$type?>&pa=<?=$pna?>" class="arrow"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
        <?php }?>
    </div>
</div>