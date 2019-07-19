<?php
$page = $_GET['page']; //Записываем страницу в переменную

$tbl_p = get_table($link, "SELECT adm_alb, adm_foto, adm_video, adm_audio FROM settings"); //Берем из базы кол-во элементов на страницу по всем медиа

if ($tbl_p == NULL) { //Если таблица пустая, заполняем значениями по умолчанию
    $tbl_p[0]['adm_alb'] = 30;
    $tbl_p[0]['adm_foto'] = 30;
    $tbl_p[0]['adm_video'] = 30;
    $tbl_p[0]['adm_audio'] = 30;
}

$ppa = $tbl_p[0]['adm_alb']; //Записываем в переменную кол-во альбомов на странице


if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

if (isset($_GET['pa'])) $pna = $_GET['pa']; //Если доступен параметр номера страницы альбома, записываем в переменную
else $pna = 1; //Иначе первая страница

//Начальные значения
$podp = '';
$array = NULL;
$f = false;

if (isset($_GET['type'])) $type = $_GET['type']; //Тип медиа
else $type = '';

if (isset($_GET['action'])) { //Если доступна переменная action
    
    switch ($_GET['action']) { //Выбор режима
        case 'add': //Добавить
            if (isset($_POST['type'])) { //Если доступна переменная type

                $type_al = $_POST['type'];
                $name = apost($_POST['name']);
                $parent_id = $_POST['parent_album'];
                
                $str = "INSERT INTO albums (name, type, date, parentId) VALUES ('".$name."', '".$type_al."', '".date("Y-m-d")."', '".$parent_id."')"; //Команда добавления
                 
                run_command($link, $str); //Добавляем альбом в базу
            }
            else { //Иначе
                echo('Get in');
                
                $album = apost($_POST['album']); //Название альбома
                
                run_command($link, "UPDATE albums SET date='".date("Y-m-d")."' WHERE name='".$album."'"); //Обновляем дату альбома в базе альбомов
                
                //Если доступны файлы
                if (isset($_FILES['files']) || isset($_FILES['cover'])) {
                    if ($type == 'foto') { //Если это фотки
                        $files = upload_files($_FILES['files'], 'media/'.$type.'/', 300, $link, $type); //Копируем файлы и получаем строку для базы

                        for ($i = 0; $i < count($files); $i++) { //Для каждого элемента массива с названиями файлов
                            $f = apost($files[$i]);

                            $str = "INSERT INTO ".$type." (file, album, date) VALUES ('".$f."', '".$album."', '".date("Y-m-d")."')"; //Создаем команду

                            run_command($link, $str); //Посылаем команду в базу
                        }

                        $tbl = get_table($link, "SELECT id FROM foto WHERE album='".$album."' AND main=1"); //Делаем выборку обложки по данному альбому

                        if (count($tbl) == 0) { //Если таковой нет
                            $tbl = get_table($link, "SELECT id FROM foto WHERE album='".$album."' LIMIT 1");

                            run_command($link, "UPDATE ".$type." SET main=1 WHERE id=".$tbl[0]['id']); //Устанавливаем новую обложку
                        }
                    }
                    else if ($type == 'video') { //Если видео
                        $cover = upload_file($_FILES['cover'], 'media/video/', 500, $link, 'foto'); //Копируем файл и получаем строку для базы
                        
                        $f = apost($_POST['file']); //Меняем апострофы на его код

                        $s = apost($_POST['name']); //Меняем апострофы на его код

                        $str = "INSERT INTO ".$type." (file, name, album, cover, date) VALUES ('".$f."', '".$s."', '".$album."', '".apost($cover)."', '".date("Y-m-d")."')"; //Создаем команду

                        run_command($link, $str); //Посылаем команду в базу
                    }
                    else { //Иначе только один файл аудио
                        
                        $f = apost(upload_file($_FILES['files'], 'media/'.$type.'/', 0, $link, $type)); //Копируем файлы и получаем строку для базы

                        $s = apost($_POST['name']); //Название записи

                        $str = "INSERT INTO ".$type." (file, name, album, date) VALUES ('".$f."', '".$s."','".$album."', '".date("Y-m-d")."')"; //Создаем команду

                        run_command($link, $str); //Посылаем команду в базу
                    }
                }
            }
            break;
        case 'del': //Удалить
            if ($_GET['type'] == 'albums') { //Если тип альбомы
                $id = $_GET['id']; //id записи
                
                $album = get_table($link, "SELECT * FROM albums WHERE id=".$id); //Берем информацию об альбоме
                
                $tbl = get_table($link, "SELECT * FROM ".$album[0]['type']." WHERE album='".$album[0]['name']."'"); //Делаем выборку материала по данному альбому
                
                if (count($tbl) == 0) run_command($link, "DELETE FROM albums WHERE id=".$id); //Если файлов в альбоме нет, удаляем альбом
                else $f = true;  //Иначе создаем перременную на ошибку
            }
            else {
                $id = $_GET['id']; //id Записи
                $album = $_GET['album']; //Название альбома
                
                if ($type == 'video') { //Если удаление видео
                    del_img($link, $type, 'cover', $id, '../media/video/', '../media/video/m/smal_'); //Удаление обложки для видео
                }
                else {
                    del_img($link, $type, 'file', $id, '../media/'.$type.'/', '../media/'.$type.'/m/smal_'); //Удаление изображения или аудио
                }
                
                $t = "DELETE FROM ".$type." WHERE id=".$id; //Команда удаления новости

                run_command($link, $t); //Посылаем команду в базу
            }
            break;
        case 'main': //Сделать обложкой альбома
            $album = apost($_GET['album']);
            $type = $_GET['type'];
            $id = $_GET['id'];
            
            run_command($link, "UPDATE ".$type." SET main=0 WHERE album='".$album."'"); //Очищаем предыдущую обложку
            
            run_command($link, "UPDATE ".$type." SET main=1 WHERE id=".$id); //Устанавливаем новую обложку
            break;
        case 'edit': //Редактирование записи
            $id = $_GET['id']; //id записи
            $type = $_GET['type']; //Тип медиа
            $name = apost($_POST['name']); //Подпись записи
            $album = $_POST['album']; //Альбом
            
            run_command($link, "UPDATE ".$type." SET name='".$name."', album='".$album."' WHERE id=".$id); //Обновляем запись в базе
            break;
    }
    
    if ($type == 'albums' && $f == true) header('Location: index.php?page=media&type='.$type.'&allert'); //иначе, если тип альбомы и предупреждение
    else header('Location: index.php?page=media&type='.$type.'&album='.dapost($album)); //Иначе без альбома
}
else {
    if (isset($_GET['allert'])) { //Если доступно предупреждение
        echo "<script>alert('Альбом содержит материалы и не может быть удален.');</script>"; //Выводим предупреждение
    }
    
    
    if (isset($_GET['album'])) {
        $album = apost($_GET['album']); //Если переменная альбома доступна, переносим в переменую
        
        $tbl_par = get_table($link, "SELECT id, parentId FROM albums WHERE name='".$album."'"); //Получаем id альбома
        $parent = $tbl_par[0]['parentId'];
        
        $tbl_parent_alb = get_table($link, "SELECT name FROM albums WHERE id='".$parent."'"); //Название родительского альбома
        $par_alb = $tbl_parent_alb[0]['name']; //Записываем в переменную
        
        $dot_alb = get_table($link, "SELECT * FROM albums WHERE type='".$type."' AND parentId=".$tbl_par[0]['id']." ORDER BY date DESC"); //Список дочерних альбомов
    }
    else {
        $album = ''; //иначе переменная пустая
        $parent = 0; //Переменная родительского альбома равна нулю
    }
    
    if ($album == '') $dot_alb = get_table($link, "SELECT * FROM albums WHERE type='".$type."' AND parentId=0 ORDER BY date DESC"); //Список корневых альбомов
    
    if ($type != '') { //Если тип не пустой
        
        switch ($type) { //В зависимости от типа медиа
            case 'foto': //Фото
                $podp = "Фотографии";
                $pp = $tbl_p[0]['adm_foto']; //Кол-во элементов на странице
                break;
            case 'video': //Видео
                $podp = "Видеофайлы";
                $pp = $tbl_p[0]['adm_video']; //Кол-во элементов на странице
                break;
            case 'audio': //Аудио
                $podp = "Аудиофайлы";
                $pp = $tbl_p[0]['adm_audio']; //Кол-во элементов на странице
                break;
            case 'albums': //Редактор альбомов
                $podp = "Редактирование альбомов";
                break;
        }
        
        if ($type != 'albums') { //Если не альбомы
            $array = albums($link, $type, $pp, $pn, $ppa, $pna); //Делаем выборку медмиаматериалов из базы
            $pca = $array['al_count']; //Кол-во страниц альбомов
        }
        else $array = get_table($link, "SELECT * FROM albums ORDER BY date DESC"); //Иначе делаем выборку альбомов

    }
    else {
        $podp = '';
        $array = NULL;
    }
}
?>

<h2>Создание и редактирование в разделе "Медиа материалы"</h2>

<div class="space"></div>

<h3><?=$podp?></h3>

<div class="space"></div>

<div class="btn_space_2">
    <?php if ($album != '' && $par_alb != '') { //Если выбран какой-то альбом ?>
    <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$par_alb?>&pa=<?=$pna?>" class="arrow"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
    <?php }
    elseif ($album != '' && $par_alb == '') { ?>
        <a href="index.php?page=<?=$page?>&type=<?=$type?>&pa=<?=$pna?>" class="arrow"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
    <?php }?>
    
    <?php if ($type != '' & $type != 'albums') { //Если тип медиа не пустой ?>
    <a href="index.php?page=edit_media&type=<?=$type?>&album=<?=$album?>&action=add" class="arrow"><img src="../i/add.ico" height="40px" title="Создать"></a>
    <?php }?>
</div>

<?php switch ($type) { //Для каждого типа
    case 'foto': //Фотографии ?>
        <?php if (count($dot_alb) > 0) { //Если список альбомов не пустой ?>
            <div class="btn_look">
                <b>Альбомы</b>
            </div>

            <div class="grid-5">
                <?php for($i = 0; $i < count($array['album']); $i++) { //Для каждого альбома ?>
                <?php $tbl=$array['table'][$i]; ?>
                <div class="grid_cell">
                    <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i]?>&pa=<?=$pna?>">
                        <div class="sq1">
                            <div class="sq2">
                                <img src="../media/<?=$type?>/m/smal_<?=dapost($array['main'][$i])?>">
                            </div>
                        </div>
                        <?=dapost($array['album'][$i])?>
                    </a>
                </div>
                <?php }?>
            </div>

            <!--Навигация по страницам-->
            <div class="space"></div>
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
            <div class="space"></div>
            <?php }?>
            <!--Конец навигации по страницам-->
        <?php }?>

        <?php if (count($array['album']) > 0) { //Если массив не пустой ?>
            <?php if ($album != '') { //Если переменная альбома не пустая ?>
            <?php for($r = 0; $r < count($array['album']); $r++) { //Для каждого альбома ?>
            <?php $pc = $array['count'][$r]; //Кол-во станиц для альбома ?>
            <?php if ($array['album'][$r] == $album) { //Если название альбома совпадает с переменной ?>
            <div class="btn_look">
                <b><?=dapost($array['album'][$r])?></b>
            </div>

            <?php $tbl = $array['table'][$r]; //все элементы из текущего альбома в массив ?>
            <div class="grid-5">
                <?php for ($i = 0; $i < count($tbl); $i++) { //Для каждого элемента ?>
                <div class="grid_cell">
                    <div class="sq1">
                        <div class="sq2">
                            <a href="index.php?page=<?=$page?>&action=del&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i]['id']?>&type=<?=$type?>"><img src="../i/delete.ico" title="Удалить" class="fix"></a>
                            <?php if ($tbl[$i]['file'] != $array['main'][$r]) { //Если фотка не является обложкой ?>
                            <a href="index.php?page=<?=$page?>&action=main&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i]['id']?>&type=<?=$type?>"><img src="../i/check.ico" title="Сделать обложкой" class="fix2"></a>
                            <?php }?>
                            <a href="../media/foto/<?=$tbl[$i]['file']?>"  target="_blank" class="prevew"><img src="../media/foto/m/smal_<?=$tbl[$i]['file']?>"></a>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>

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
                <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$r]?>&p=1&pa=<?=$pna?>">&lt;&lt;</a></li> &hellip;
                <?php }?>

                <?php for ($c = $first; $c <= $last; $c++) { //выводим ссылки 7 страниц ?>

                <?php if ($c == $pn) { ?>
                <li class="page_main"><?=$c?></li>
                <?php } else { ?>
                <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$r]?>&p=<?=$c?>&pa=<?=$pna?>"><?=$c?></a></li>
                <?php }?>

                <?php }?>

                <?php if ($last < $pc) { //Если последняя страница больше последней ссылки, создаем ссылку на последнюю страницу ?>
                &hellip; <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$r]?>&p=<?=$pc?>&pa=<?=$pna?>">&gt;&gt;</a></li>
                <?php }?>
            </ul>

            <div class="space"></div>
            <?php }?>
            <!--Конец навигации по страницам-->

            <?php }?>
            <?php }?>
            <?php }
            else { //Иначе список альбомов ?>
                
            <?php }?>
        <?php }?>
    <?php break;
    case 'video': //Видео
    case 'audio': //Аудио ?>
        <?php if (count($dot_alb) > 0) { //Если список альбомов не пустой ?>
            <div class="btn_look">
                Список альбомов
            </div>

            <div class="grid-5">
                <?php for($i = 0; $i < count($dot_alb); $i++) { //Для всех альбомов ?>
                <div class="grid_cell">
                    <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=apost($dot_alb[$i]['name'])?>&pa=<?=$pna?>">
                        <div class="sq1">
                            <div class="sq2">
                                <img src="../i/folder.png">
                            </div>
                        </div>

                        <?=$dot_alb[$i]['name']?>
                    </a>
                </div>
                <?php }?>
            </div>

            <!--Навигация по страницам-->
            <div class="space"></div>
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
            <div class="space"></div>
            <?php }?>
            <!--Конец навигации по страницам-->
        <?php }?>

        <div class="space"></div>
        
        <?php if (count($array['album']) > 0) { //Если кол-во альбомов больше нуля ?>
            <?php if ($album != '') { //Если переменная альбома не пустая ?>
                <?php for($r = 0; $r < count($array['album']); $r++) { //Для каждого альбома ?>
                    <?php $pc = $array['count'][$r]; //Кол-во станиц для альбома ?>
                    <?php if ($array['album'][$r] == $album) { //Если название альбома совпадает с переменной (выбранный альбом)?>
                    <div class="tbl_back">
                        <div class="tbl_title">
                                <?=dapost($array['album'][$r])?>
                        </div>

                        <div class="tbl-4">
                            <div class="tbl_title">
                                    Название
                            </div>
                            <div class="tbl_title">
                                    <?php if ($type == 'audio') { ?>Имя файла<?php }
                                    else {?>Ссылка на видео<?php }?>
                            </div>
                            <div></div>
                            <div></div>


                            <?php $tbl = $array['table'][$r]; ?>
                            <?php for ($i = 0; $i < count($tbl); $i++) {?>
                            <div class="col-1">
                                    <?=$tbl[$i]['name']?>
                            </div>
                            <div class="col-midle">
                                <?=$tbl[$i]['file']?>
                            </div>
                            <div class="col-midle">
                                    <a href="index.php?page=edit_media&action=edit&id=<?=$tbl[$i]['id']?>&type=<?=$type?>"><img src="../i/edit.ico" title="Редактировать"></a>
                            </div>
                            <div class="col-last">
                                    <a href="index.php?page=<?=$page?>&action=del&id=<?=$tbl[$i]['id']?>&type=<?=$type?>"><img src="../i/trash.ico" title="Удалить"></a>
                            </div>
                            <?php }?>
                        </div>
                    </div>

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
                        <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$r]?>&p=1&pa=<?=$pna?>">&lt;&lt;</a></li> &hellip;
                        <?php }?>

                        <?php for ($c = $first; $c <= $last; $c++) { //выводим ссылки 7 страниц ?>

                        <?php if ($c == $pn) { ?>
                        <li class="page_main"><?=$c?></li>
                        <?php } else { ?>
                        <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$r]?>&p=<?=$c?>&pa=<?=$pna?>"><?=$c?></a></li>
                        <?php }?>

                        <?php }?>

                        <?php if ($last < $pc) { //Если последняя страница больше последней ссылки, создаем ссылку на последнюю страницу ?>
                        &hellip; <li class="page_list"><a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$r]?>&p=<?=$pc?>&pa=<?=$pna?>">&gt;&gt;</a></li>
                        <?php }?>
                    </ul>

                    <div class="space"></div>
                    <?php }?>
                    <!--Конец навигации по страницам-->

                    <?php }?>
                <?php }?>
            <?php }?>
        <?php }?>
        <?php break;
    case 'albums': //Редактор альбомов ?>
        <a href="index.php?page=edit_media&type=fotoAlbums&action=add" class="arrow"><img src="../i/add.ico" height="40px" title="Создать"></a>
        <div class="tbl_back">
            <div class="tbl_title">
                Фотографии
            </div>
            <input type="checkbox" class="hide" id="Hide_foto" data-toggle="toggle">
            <label for="Hide_foto" class="hide_table">
                <img src="../i/toggle.png">
            </label>
                
            <div class="tbl-2">    
                <?php foreach ($array as $a): //Для каждой строки списка альбомов ?>
                <?php if($a['type'] == 'foto') { //Если фото ?>
                <div class="col-1">
                    <?=dapost($a['name'])?>
                </div>
                <div class="col-last">
                        <a href="index.php?page=<?=$page?>&type=albums&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
                </div>
                <?php }?>
                <?php endforeach ?>
                    
            </div>
        </div>
        
        <div class="space"></div>

        <a href="index.php?page=edit_media&type=videoAlbums&action=add" class="arrow"><img src="../i/add.ico" height="40px" title="Создать"></a>
        <div class="tbl_back">
            <div class="tbl_title">
                Видео
            </div>
            <input type="checkbox" class="hide" id="Hide_video" data-toggle="toggle">
            <label for="Hide_video" class="hide_table">
                <img src="../i/toggle.png">
            </label>
                
            <div class="tbl-2">    
                <?php for ($i = 0; $i < count($array); $i++) { //Для каждой строки в списке альбомов ?>
                <?php if ($array[$i]['type'] == 'video' & $array[$i]['parentId'] == '0'): //Если тип видео и папка корневая ?>
                <div class="col-1">
                    <?=dapost($array[$i]['name']) //Имя альбома ?>
                </div>
                <div class="col-last">
                    <a href="index.php?page=<?=$page?>&type=albums&action=del&id=<?=$array[$i]['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
                </div>
                <?php for ($r = 0; $r < count($array); $r++) { //Для каждой строки в списке альбомов
                if ($array[$r]['parentId'] == $array[$i]['id']): //Если тип видео и дочерний выбранного корневого альбома ?>
                    <div class="col-1">
                        <p style="text-indent: 40px"><?=dapost($array[$r]['name'])?></p>
                    </div>
                    <div class="col-last">
                        <a href="index.php?page=<?=$page?>&type=albums&action=del&id=<?=$array[$r]['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
                    </div>
                <?php endif ?>
                <?php }?>
                <?php endif ?>
                <?php }?>
            </div>
        </div>

        <div class="space"></div>
        
        <a href="index.php?page=edit_media&type=audioAlbums&action=add" class="arrow"><img src="../i/add.ico" height="40px" title="Создать"></a>
        <div class="tbl_back">
            <div class="tbl_title">
                Аудио
            </div>
            <input type="checkbox" class="hide" id="Hide_audio" data-toggle="toggle">
            <label for="Hide_audio" class="hide_table">
                <img src="../i/toggle.png">
            </label>
                
            <div class="tbl-2">    
                <?php foreach ($array as $a): //Для каждой строки списка альбомов?>
                <?php if($a['type'] == 'audio') { //Если видео ?>
                <div class="col-1">
                    <?=dapost($a['name'])?>
                </div>
                <div class="col-last">
                        <a href="index.php?page=<?=$page?>&type=albums&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
                </div>
                <?php }?>
                <?php endforeach ?>
                    
            </div>
        </div>
        <?php break;
} ?>
<?php if ($album != '' && $par_alb != '') { //Если выбран какой-то альбом ?>
    <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$par_alb?>&pa=<?=$pna?>" class="arrow"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
<?php }
elseif ($album != '' && $par_alb == '') { ?>
    <a href="index.php?page=<?=$page?>&type=<?=$type?>&pa=<?=$pna?>" class="arrow"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
<?php }?>