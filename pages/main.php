<?php
$news = get_table($link, "SELECT * FROM `news` Order By id DESC LIMIT 0, 3"); //Берем три последние новости

$audio_pr = get_table($link, "SELECT * FROM audio WHERE album='Проповеди' ORDER BY date DESC LIMIT 0,1"); //Берем последнее аудио проповеди

$video_pr = get_table($link, "SELECT * FROM video WHERE album='Проповеди' ORDER BY date DESC LIMIT 0, 1"); //Берем последнее видео проповеди

$video_other = get_table($link, "SELECT * FROM video WHERE album<>'Проповеди' ORDER BY date DESC LIMIT 0, 1"); //Берем последнее видео не проповеди

$foto = get_table($link, "SELECT * FROM foto ORDER BY date DESC LIMIT 0, 20"); //Берем последние 20 фоток

check_base($link, 'info'); //Проверяем, пустая ли база и добавляем строку, если да

$array = get_table($link, "SELECT concept, service FROM info"); //Получаем информацию из базы
?>

<link rel="canonical" href="http://www.gc44.ru/index.php?page=main">

<div class="cent">
    <div class="content">
        <div class="block_2">
            <h2>Последние новости:</h2>
            <div class="flex_news-3">
                <?php foreach($news as $a): //Для каждой новости ?>
                    <div class="grid_cell_shadow">
                        <p class="date_publ">Опубликовано: <?=$a['date']?></p>
                        <a href="index.php?page=news&id=<?=$a['id']?>">
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
                        <h3><?=$a['title']?></h3>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="tn_22"><a href="index.php?page=news" class="butn">Все новости...</a></div>
        </div>
        
        
        
        <?php if ($style != 'flat') { //Если не плоская тема ?>
        <div class="color_space"></div>
        <?php }?>
        
        
        <?php if(count($audio_pr) != 0) { //Если есть аудио проповеди ?>
        <div class="block_2">
            <h2>Аудио- проповедь:</h2>
            <div class="grid-1">
                <img class="audio_preach" src="../i/audio.png">
                <div class="audio_frame">
                    <audio controls class="audio">
                        <source src="media/audio/<?=dapost($audio_pr[0]['file'])?>">
                        <p>Ваш браузер не поддерживает аудио</p>
                    </audio>
                </div>
                <div class="audio_name">
                    <div class="Text">
                        <?=dapost($audio_pr[0]['name'])?>
                    </div>
                </div>
            </div>
            <div class="tn_22"><a href="index.php?page=media&type=audio&album=Проповеди" class="butn">Другие аудио- проповеди...</a></div>
        </div>
        <?php }?>
        

        <?php if ($style != 'flat') { //Если не плоская тема ?>
        <div class="color_space"></div>
        <?php }?>

        <?php if(count($video_pr) != 0) { //Если видео проповеди есть ?>
        <div class="block_2">
            <h2>Проповедь:</h2>
            <div class="grid-1">
                <?php $fileV = dapost(get_youtube($video_pr[0]['file'])); ?>
                <iframe class="video_main" src="https://www.youtube.com/embed/<?=$fileV?>" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="tn_22"><a href="index.php?page=media&type=video&album=Проповеди" class="butn">Другие проповеди...</a></div>
        </div>
        <?php } ?>
        
        
                
        <?php if ($style != 'flat') { //Если не плоская тема ?>
        <div class="color_space"></div>
        <?php }?>
        
        <?php if(count($foto) != 0) { //Если фотки есть ?>    
        <div class="block_1">
            <h2>Фотографии:</h2>

            <div class="grid-5">
                <?php for ($i = 0; $i < count($foto); $i++) { //Для каждого элемента в выборке ?>
                <div class="grid_cell">
                    <a rel="group" href="media/foto/<?=dapost($foto[$i]['file'])?>" class="prevew">
                        <div class="blink_rect"></div>
                        <div class="sq1">
                            <div class="sq2">
                                <img src="media/foto/m/smal_<?=dapost($foto[$i]['file'])?>">
                            </div>
                        </div>
                    </a>
                </div>
                <?php }?>
            </div>

            <div class="tn_22"><a href="index.php?page=media&type=foto" class="butn">Другие фото...</a></div>

            <?php } ?>
            <?php if(count($video_other) != 0) { //Если видео есть ?>
        </div>
        
        <?php if ($style != 'flat') { //Если не плоская тема ?>
        <div class="color_space"></div>
        <?php }?>
        
        <div class="block_2">
            <h2>Видео:</h2>

            <div class="grid-1">
                <?php $fileV = dapost(get_youtube($video_other[0]['file'])); ?>
                <iframe class="video_main" src="https://www.youtube.com/embed/<?=$fileV?>" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="tn_22"><a href="index.php?page=media&type=video" class="butn">Другие видео...</a></div>

            <?php } ?>
        </div>
        
        <?php if ($style != 'flat') { //Если не плоская тема ?>
        <div class="color_space"></div>
        <?php }?>
        
        <div class="block_1">
            <div class="grid-2_60-40">
                <div class="grid_cell">
                    <h2>Социальная концепция:</h2>
                    <div class="Text">
                        <?=dapost($array[0]['concept'])?>
                    </div>
                </div>
                <div></div>
                <div class="grid_cell">
                    <h2>Богослужения:</h2>
                    <div class="Text">
                        <?=dapost($array[0]['service'])?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>