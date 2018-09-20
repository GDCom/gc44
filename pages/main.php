<?php
$news = get_table($link, "SELECT * FROM `news` Order By id DESC LIMIT 0, 3"); //Берем три последние новости

$video_pr = get_table($link, "SELECT * FROM video WHERE album='Проповеди' ORDER BY date DESC LIMIT 0, 1"); //Берем последнее видео проповеди

$video_other = get_table($link, "SELECT * FROM video WHERE album<>'Проповеди' ORDER BY date DESC LIMIT 0, 1"); //Берем последнее видео не проповеди

$foto = get_table($link, "SELECT * FROM foto ORDER BY date DESC LIMIT 0, 15"); //Берем последние 20 фоток

check_base($link, 'info'); //Проверяем, пустая ли база и добавляем строку, если да

$array = get_table($link, "SELECT concept, service FROM info"); //Получаем информацию из базы
?>

<div class="cent">
    <div class="content">
        <h2>Последние новости:</h2> <!--Заголовок-->
        <!--Выводим таблицу из трех последних новостей-->        
        <table>
            <tbody>
                <tr>
                    <?php foreach($news as $a): ?> <!--Для каждой новости-->
                        <td class="enum"> <!--Новая колонка-->
                            <a href="index.php?page=news&id=<?=$a['id']?>">
                                <p class="date_publ">Опубликовано: <?=$a['date']?></p> <!--Дата публикации-->
                                <div class="top_news1">
                                    <div class="top_news2">
                                        <?php if ($a['img1'] != NULL) { ?> 
                                        <div><img src="img/m/smal_<?=$a['img1']?>"></div>
                                        <div class="tn_2">
                                            <div class="tn_21">
                                                <?=dapost($a['content'])?>
                                            </div>
                                            <div class="tn_22">
                                                Читать далее...
                                            </div>
                                        </div>
                                        <?php } else {?>
                                        <div class="tn_2">
                                            <div class="tn_21">
                                                <?=dapost($a['content'])?>
                                            </div>
                                            <div class="tn_22">
                                                Читать далее...
                                            </div>
                                        </div>
                                        <div class="tn_2">
                                            <div class="tn_21">
                                                <?=dapost($a['content'])?>
                                            </div>
                                            <div class="tn_22">
                                                Читать далее...
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </a>
                        </td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <?php foreach($news as $a): ?> <!--Для каждой новости-->
                        <td class="enum"> <!--Новая колонка-->
                            <h3><?=$a['title']?></h3> <!--Заголовок новости-->
                        </td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
        <?php if(count($video_pr) != 0) { //Если видео проповеди есть ?>
        <!--<hr />-->
        <div class="color_space"></div>
        <table>
            <tbody>
                <tr>
                    <td>
                        <h2>Проповедь:</h2>
                    </td>
                </tr>
                <tr class="listHead">
                    <td>
                        <?php $fileV = dapost(get_youtube($video_pr[0]['file'])); ?>
                        <iframe class="video_main" src="https://www.youtube.com/embed/<?=$fileV?>" frameborder="0" allowfullscreen></iframe>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="tn_22"><a href="index.php?page=media&type=video&album=Проповеди">Другие проповеди...</a></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php } ?>
        <?php if(count($foto) != 0) { //Если фотки есть ?>
        <!--<hr />-->
        <div class="color_space"></div>
        <table>
            <tbody>
                <tr>
                    <td colspan="100%">
                        <h2>Фотографии:</h2>
                    </td>
                </tr>
                <?php for ($i = 0; $i < count($foto); $i += 5) { //Для каждого элемента в выборке ?>
                    <tr class="listHead">
                        <td class="enum5">
                            <a rel="group" href="media/foto/<?=dapost($foto[$i]['file'])?>" class="prevew">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/foto/m/smal_<?=dapost($foto[$i]['file'])?>">
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td class="enum5">
                            <?php if ($i + 1 < count($foto)) { //Если не конец массива ?>
                            <a rel="group" href="media/foto/<?=dapost($foto[$i+1]['file'])?>" class="prevew">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/foto/m/smal_<?=dapost($foto[$i+1]['file'])?>">
                                    </div>
                                </div>
                            </a>
                            <?php }?>
                        </td>
                        <td class="enum5">
                            <?php if ($i + 2 < count($foto)) { //Если не конец массива ?>
                            <a rel="group" href="media/foto/<?=dapost($foto[$i+2]['file'])?>" class="prevew">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/foto/m/smal_<?=dapost($foto[$i+2]['file'])?>">
                                    </div>
                                </div>
                            </a>
                            <?php }?>
                        </td>
                        <td class="enum5">
                            <?php if ($i + 3 < count($foto)) { //Если не конец массива ?>
                            <a rel="group" href="media/foto/<?=dapost($foto[$i+3]['file'])?>" class="prevew">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/foto/m/smal_<?=dapost($foto[$i+3]['file'])?>">
                                    </div>
                                </div>
                            </a>
                            <?php }?>
                        </td>
                        <td class="enum5">
                            <?php if ($i + 4 < count($foto)) { //Если не конец массива ?>
                            <a rel="group" href="media/foto/<?=dapost($foto[$i+4]['file'])?>" class="prevew">
                                <div class="sq1">
                                    <div class="sq2">
                                        <img src="media/foto/m/smal_<?=dapost($foto[$i+4]['file'])?>">
                                    </div>
                                </div>
                            </a>
                            <?php }?>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="100%">
                        <div class="tn_22"><a href="index.php?page=media&type=foto">Другие фото...</a></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php } ?>
        <?php if(count($video_other) != 0) { //Если видео есть ?>
        <!--<hr />-->
        <div class="color_space"></div>
        <table>
            <tbody>
                <tr>
                    <td>
                        <h2>Видео:</h2>
                    </td>
                </tr>
                <tr class="listHead">
                    <td>
                        <?php $fileV = dapost(get_youtube($video_other[0]['file'])); ?>
                        <iframe class="video_main" src="https://www.youtube.com/embed/<?=$fileV?>" frameborder="0" allowfullscreen></iframe>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="tn_22"><a href="index.php?page=media&type=video">Другие видео...</a></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php } ?>
        <!--<hr />-->
        <div class="color_space"></div>
        <table>
            <tbody>
                <tr>
                    <td width = 59% class = "Text">
                        <h2>Социальная концепция:</h2>
                        <?=dapost($array[0]['concept'])?>
                    </td>
                    <td></td>
                    <td width= 40% class = "Text">
                        <h2>Богослужения:</h2>
                        <?=dapost($array[0]['service'])?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>