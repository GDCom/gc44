<?php
$array = NULL;

if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

if (isset($_GET['album'])) {
    $album = $_GET['album'];
}
else $album = '';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    
    switch ($type) {
        case 'foto':
            $podp = "Фотографии";
            $pp = 30;
            break;
        case 'video':
            $podp = "Видеофайлы";
            $pp = 15;
            break;
        case 'audio':
            $podp = "Аудиофайлы";
            $pp = 30;
            break;
    }
    
    if ($type != '') $array = albums($link, $type, $pp, $pn);
}

?>

    <div class="Menu">
        <div>
            <a href="index.php?page=media&type=foto">Фотографии</a><br>
            <a href="index.php?page=media&type=video">Видеофайлы</a><br>
            <a href="index.php?page=media&type=audio" class="space">Аудиофайлы</a><br>

            <?php if (count($array['album']) > 0) { ?>
            <?php foreach($array['album'] as $a): ?>
            <a href="index.php?page=media&type=<?=$type?>&album=<?=$a?>" class="second"><?=$a?></a><br>
            <?php endforeach ?>
            <?php }?>
        </div>
    </div>
    <div class="content">
        <h1>Медиа материалы</h1>
        <h3><?=$podp?></h3>
        <?php if ($album != '') { //Если выбран альбом, показываем кнопку к списку альбомов ?>
        <a href="index.php?page=media&type=<?=$type?>"><img src="i/back.ico" width="40px" title="Вернуться к списку альбомов"></a><br><br>
        <?php }?>
        <?php if (count($array['album']) > 0) { //Если массив не пустой ?>
        <?php if ($album == '') { //Если альбом не выбран ?>
        <table class="listBack">
            <tbody>
               <tr class="listHead">
                    <td colspan="100%"><b>Альбомы</b></td>
                </tr>
                <?php for($i = 0; $i < count($array['album']); $i +=5) { //Для каждого альбома ?>
                <tr class="listHead">
                    <td class="enum5">
                        <a href="index.php?page=media&type=<?=$type?>&album=<?=$array['album'][$i]?>">
                            <?php if ($type == 'foto') { //Если тип данных фото ?>
                            <div class="alb_main">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/<?=$type?>/m/smal_<?=dapost($array['main'][$i])?>">
                                    </div>
                                </div>
                                <div class="alb_title"><?=$array['album'][$i]?></div>
                            </div>
                            <?php }
                            else { //Иначе ?>
                            <?=$array['album'][$i]?>
                            <?php }?>                            
                        </a>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 1 < count($array['album'])) { //Если в массиве еще есть записи ?>
                        <a href="index.php?page=media&type=<?=$type?>&album=<?=$array['album'][$i+1]?>">
                            <?php if ($type == 'foto') { //Если тип данных фото ?>
                            <div class="alb_main">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/<?=$type?>/m/smal_<?=dapost($array['main'][$i+1])?>">
                                    </div>
                                </div>
                                <div class="alb_title"><?=$array['album'][$i+1]?></div>
                            </div>
                            <?php }
                            else { //Иначе ?>
                            <?=$array['album'][$i+1]?>
                            <?php }?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 2 < count($array['album'])) { //Если в массиве еще есть записи ?>
                        <a href="index.php?page=media&type=<?=$type?>&album=<?=$array['album'][$i+2]?>">
                            <?php if ($type == 'foto') { //Если тип данных фото ?>
                            <div class="alb_main">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/<?=$type?>/m/smal_<?=dapost($array['main'][$i+2])?>">
                                    </div>
                                </div>
                                <div class="alb_title"><?=$array['album'][$i+2]?></div>
                            </div>
                            <?php }
                            else { //Иначе ?>
                            <?=$array['album'][$i+2]?>
                            <?php }?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 3 < count($array['album'])) { //Если в массиве еще есть записи ?>
                        <a href="index.php?page=media&type=<?=$type?>&album=<?=$array['album'][$i+3]?>">
                            <?php if ($type == 'foto') { //Если тип данных фото ?>
                            <div class="alb_main">
                                <div class="sq1">
                                    <div class="sq2">    
                                        <img src="media/<?=$type?>/m/smal_<?=dapost($array['main'][$i+3])?>">
                                    </div>
                                </div>
                                <div class="alb_title"><?=$array['album'][$i+3]?></div>
                            </div>
                            <?php }
                            else { //Иначе ?>
                            <?=$array['album'][$i+3]?>
                            <?php }?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 4 < count($array['album'])) { //Если в массиве еще есть записи ?>
                        <a href="index.php?page=media&type=<?=$type?>&album=<?=$array['album'][$i+4]?>">
                            <?php if ($type == 'foto') { //Если тип данных фото ?>
                            <div class="alb_main">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/<?=$type?>/m/smal_<?=dapost($array['main'][$i+4])?>">
                                    </div>
                                </div>
                                <div class="alb_title"><?=$array['album'][$i+4]?></div>
                            </div>
                            <?php }
                            else { //Иначе ?>
                            <?=$array['album'][$i+4]?>
                            <?php }?>
                        </a>
                        <?php }?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        
        <?php } else { //Иначе показываем элементы альбома ?>
        <?php for($t = 0; $t < count($array['album']); $t++) { //Для каждого альбома ?>
        <?php if ($array['album'][$t] == $album) { //Если выбранный альбом равняется текущему ?>
        <?php $pc = $array['count'][$t]; //Кол-во страниц ?>
        <table class="listBack">
            <tbody>
                <tr class="listHead">
                    <td colspan="100%"><b><?=$array['album'][$t]?></b></td>
                </tr>
                <?php $tbl = $array['table'][$t]; ?>
                <?php switch ($type) {
                    case 'foto': //Показ фоток ?>
                    <?php for ($i = 0; $i < count($tbl); $i += 5) { //Для каждого элемента в альбоме ?>
                        <tr class="listHead">
                            <td class="enum5">
                                <a rel="group" href="media/<?=$type?>/<?=dapost($tbl[$i]['file'])?>" class="prevew">
                                    <div class="sq1">
                                        <div class="sq2">
                                            <img src="media/<?=$type?>/m/smal_<?=dapost($tbl[$i]['file'])?>">
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td class="enum5">
                                <?php if ($i + 1 < count($tbl)) { //Если не конец массива ?>
                                <a rel="group" href="media/<?=$type?>/<?=dapost($tbl[$i+1]['file'])?>" class="prevew">
                                    <div class="sq1">
                                        <div class="sq2">
                                            <img src="media/<?=$type?>/m/smal_<?=dapost($tbl[$i+1]['file'])?>">
                                        </div>
                                    </div>
                                </a>
                                <?php }?>
                            </td>
                            <td class="enum5">
                                <?php if ($i + 2 < count($tbl)) { //Если не конец массива ?>
                                <a rel="group" href="media/<?=$type?>/<?=dapost($tbl[$i+2]['file'])?>" class="prevew">
                                    <div class="sq1">
                                        <div class="sq2">
                                            <img src="media/<?=$type?>/m/smal_<?=dapost($tbl[$i+2]['file'])?>">
                                        </div>
                                    </div>
                                </a>
                                <?php }?>
                            </td>
                            <td class="enum5">
                                <?php if ($i + 3 < count($tbl)) { //Если не конец массива ?>
                                <a rel="group" href="media/<?=$type?>/<?=dapost($tbl[$i+3]['file'])?>" class="prevew">
                                    <div class="sq1">
                                        <div class="sq2">
                                            <img src="media/<?=$type?>/m/smal_<?=dapost($tbl[$i+3]['file'])?>">
                                        </div>
                                    </div>
                                </a>
                                <?php }?>
                            </td>
                            <td class="enum5">
                                <?php if ($i + 4 < count($tbl)) { //Если не конец массива ?>
                                <a rel="group" href="media/<?=$type?>/<?=dapost($tbl[$i+4]['file'])?>" class="prevew">
                                    <div class="sq1">
                                        <div class="sq2">
                                            <img src="media/<?=$type?>/m/smal_<?=dapost($tbl[$i+4]['file'])?>">
                                        </div>
                                    </div>
                                </a>
                                <?php }?>
                            </td>
                        </tr>
                    <?php }?>
                    <?php break;
                    case 'video': //Показ видео ?>
                    <?php for ($i = 0; $i < count($tbl); $i += 3) { //Для каждого элемента в альбоме ?>
                    <script src="http://vjs.zencdn.net/5.0/video.min.js"></script>
                        <tr class="listHead">
                            <td class="enum">
                                <div>
                                    <?php $file = dapost(get_youtube($tbl[$i]['file'])); ?>
                                    <iframe src="https://www.youtube.com/embed/<?=$file?>" frameborder="0" allowfullscreen width="100%"></iframe>
                                    <br><?=dapost($tbl[$i]['name'])?>
                                </div>
                            </td>
                            <td class="enum">
                                <?php if ($i + 1 < count($tbl)) {?>
                                <div>
                                    <?php $file = dapost(get_youtube($tbl[$i+1]['file'])); ?>
                                    <iframe src="https://www.youtube.com/embed/<?=$file?>" frameborder="0" allowfullscreen width="100%"></iframe>
                                    <br><?=dapost($tbl[$i+1]['name'])?>
                                </div>
                            <?php }?>
                            </td>
                            <td class="enum">
                                <?php if ($i + 2 < count($tbl)) {?>
                                <div>
                                    <?php $file = dapost(get_youtube($tbl[$i+2]['file'])); ?>
                                    <iframe src="https://www.youtube.com/embed/<?=$file?>" frameborder="0" allowfullscreen width="100%"></iframe>
                                    <br><?=dapost($tbl[$i+2]['name'])?>
                                </div>
                            <?php }?>
                            </td>
                        </tr>
                    <?php }?>
                    <?php break;
                    case 'audio': //Показ аудио ?>
                    <?php foreach($tbl as $a): ?>
                    <tr>
                        <td class="list_text">
                             <audio controls>
                                <source src="media/audio/<?=dapost($a['file'])?>">
                                <p>Ваш браузер не поддерживает аудио</p>
                             </audio>
                        </td>
                        <td class="list_text">
                            <?=dapost($a['name'])?><br>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php break;
                }?>
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
            <li class="page_list"><a href="index.php?page=media&type=<?=$type?>&album=<?=$array['album'][$t]?>&p=1">&lt;&lt;</a></li> &hellip;
            <?php }?>

            <?php for ($c = $first; $c <= $last; $c++) { //выводим ссылки 7 страниц ?>

            <?php if ($c == $pn) { ?>
            <li class="page_main"><?=$c?></li>
            <?php } else { ?>
            <li class="page_list"><a href="index.php?page=media&type=<?=$type?>&album=<?=$array['album'][$t]?>&p=<?=$c?>"><?=$c?></a></li>
            <?php }?>

            <?php }?>

            <?php if ($last < $pc) { //Если последняя страница больше последней ссылки, создаем ссылку на последнюю страницу ?>
            &hellip; <li class="page_list"><a href="index.php?page=media&type=<?=$type?>&album=<?=$array['album'][$t]?>&p=<?=$pc?>">&gt;&gt;</a></li>
            <?php }?>
        </ul>
        <div class="space"></div>
        <?php }?>
        <!--Конец навигации по страницам-->
        
        <?php }?>
        <?php }?>
        <?php }?>
        <?php }?>
        <?php if ($album != '') { //Если выбран альбом, показываем кнопку к списку альбомов ?>
        <a href="index.php?page=media&type=<?=$type?>"><img src="i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
        <?php }?>
    </div>