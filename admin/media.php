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

$podp = '';
$array = NULL;
$f = false;

if (isset($_GET['type'])) $type = $_GET['type']; //Тип медиа;
else $type = '';

if (isset($_GET['action'])) { //Если доступна переменная action
    
    switch ($_GET['action']) { //Выбор режима
        case 'add': //Добавить
             if (isset($_POST['type'])) { //Если доступна переменная type
                 $type_al = $_POST['type'];
                 $name = $_POST['name'];
                 
                 $str = "INSERT INTO albums (name, type, date) VALUES ('".$name."', '".$type_al."', '".date("Y-m-d")."')"; //Команда добавления
                 
                 run_command($link, $str); //Добавляем альбом в базу
            }
            else { //Иначе
                $album = $_POST['album']; //Название альбома
                
                run_command($link, "UPDATE albums SET date='".date("Y-m-d")."' WHERE name='".$album."'"); //Обновляем дату альбома в базе альбомов
                
                //Если доступны файлы
                if (isset($_FILES['files']))
                {
                    if ($type == 'foto') { //Если это фотки
                        $files = upload_files($_FILES['files'], 'media/'.$type.'/', 300, $link, "img"); //Копируем файлы и получаем строку для базы

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
                    else { //Иначе только один файл
                        $f = apost(upload_file($_FILES['files'], 'media/'.$type.'/', 0, $link, "")); //Копируем файлы и получаем строку для базы

                        $s = apost($_POST['name']); //Название записи

                        $str = "INSERT INTO ".$type." (file, name, album, date) VALUES ('".$f."', '".$s."','".$album."', '".date("Y-m-d")."')"; //Создаем команду

                        run_command($link, $str); //Посылаем команду в базу
                    }
                }
                else { //Иначе
                    $f = apost($_POST['file']); //Меняем апострофы на его код

                    $s = apost($_POST['name']); //Меняем апострофы на его код

                    $str = "INSERT INTO ".$type." (file, name, album, date) VALUES ('".$f."', '".$s."', '".$album."', '".date("Y-m-d")."')"; //Создаем команду

                    run_command($link, $str); //Посылаем команду в базу
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
                $id = $_GET['id'];
                $album = $_GET['album'];

                del_img($link, $type, 'file', $id, '../media/'.$type.'/', '../media/'.$type.'/m/smal_');

                $t = "DELETE FROM ".$type." WHERE id=".$id; //Команда удаления новости

                run_command($link, $t); //Посылаем команду в базу
            }
            break;
        case 'main': //Сделать обложкой альбома
            $album = $_GET['album'];
            $type = $_GET['type'];
            $id = $_GET['id'];
            
            run_command($link, "UPDATE ".$type." SET main=0 WHERE album='".$album."'"); //Очищаем предыдущую обложку
            
            run_command($link, "UPDATE ".$type." SET main=1 WHERE id=".$id); //Устанавливаем новую обложку
            break;
        case 'edit': //Редактирование записи
            $id = $_GET['id']; //id записи
            $type = $_GET['type']; //Тип медиа
            $name = $_POST['name']; //Подпись записи
            $album = $_POST['album']; //Альбом
            
            run_command($link, "UPDATE ".$type." SET name='".$name."', album='".$album."' WHERE id=".$id); //Обновляем запись в базе
            break;
    }
    
    /*if ($type == 'foto') header('Location: index.php?page=media&type='.$type.'&album='.$album); //Если фотки, то очистка строки адреса с названием альбома*/
    if ($type == 'albums' && $f == true) header('Location: index.php?page=media&type='.$type.'&allert'); //иначе, если тип альбомы и предупреждение
    else header('Location: index.php?page=media&type='.$type.'&album='.$album); //Иначе без альбома
}
else {
    if (isset($_GET['allert'])) { //Если доступно предупреждение
        echo "<script>alert('Альбом содержит материалы и не может быть удален.');</script>"; //Выводим предупреждение
    }
        
    if (isset($_GET['album'])) $album = $_GET['album']; //Если переменная альбома доступна, переносим в переменую
    else $album = ''; //иначе переменная пустая
    
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

<h3><?=$podp?></h3>
<?php if ($podp = 'Фотографии' && $album != '') { ?>
<a href="index.php?page=<?=$page?>&type=<?=$type?>&pa=<?=$pna?>"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a><br><br>
<?php }?>
<?php if ($type != '' && $album == '') {?>
<a href="index.php?page=edit_media&type=<?=$type?>&action=add"><img src="../i/add.ico" height="40px" title="Создать"></a><br><br>
<?php }?>
<?php switch ($type) { //Для каждого типа
    case 'foto': //Фотографии ?>
        <?php if (count($array['album']) > 0) { //Если массив не пустой ?>
        <?php if ($album != '') { //Если переменная альбома не пустая ?>
        <?php for($r = 0; $r < count($array['album']); $r++) { //Для каждого альбома ?>
        <?php $pc = $array['count'][$r]; //Кол-во станиц для альбома ?>
        <?php if ($array['album'][$r] == $album) { //Если название альбома совпадает с переменной ?>
        <table class="listBack">
            <tbody>
                <!--Шапка таблицы-->
                <tr class="listHead">
                    <td colspan="100%">
                        <div class="btn_look">
                            <b><?=$array['album'][$r]?></b>
                        </div>
                    </td>
                </tr>
                <?php $tbl = $array['table'][$r]; //все элементы из текущего альбома в массив ?>
                <?php for ($i = 0; $i < count($tbl); $i += 5) { //Для каждого пятого элемента (таблица в пять колонок) ?>
                <tr>
                    <td class="enum5">
                        <div class="sq1">
                            <div class="sq2">
                                <a href="index.php?page=<?=$page?>&action=del&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i]['id']?>&type=<?=$type?>"><img src="../i/delete.ico" title="Удалить" class="fix"></a>
                                <?php if ($tbl[$i]['file'] != $array['main'][$r]) { //Если фотка не является обложкой ?>
                                <a href="index.php?page=<?=$page?>&action=main&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i]['id']?>&type=<?=$type?>"><img src="../i/check.ico" title="Сделать обложкой" class="fix2"></a>
                                <?php }?>
                                <a href="../media/foto/<?=$tbl[$i]['file']?>"  target="_blank" class="prevew"><img src="../media/foto/m/smal_<?=$tbl[$i]['file']?>"></a>
                            </div>
                        </div>
                    </td>
                    <td class="enum5">
                        <div class="sq1">
                            <div class="sq2">
                                <?php if ($i + 1 < count($tbl)) {?>
                                <a href="index.php?page=<?=$page?>&action=del&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i+1]['id']?>&type=<?=$type?>"><img src="../i/delete.ico" title="Удалить" class="fix"></a>
                                <?php if ($tbl[$i+1]['file'] != $array['main'][$r]) { //Если фотка не является обложкой ?>
                                <a href="index.php?page=<?=$page?>&action=main&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i+1]['id']?>&type=<?=$type?>"><img src="../i/check.ico" title="Сделать обложкой" class="fix2"></a>
                                <?php }?>
                                <a href="../media/foto/<?=$tbl[$i+1]['file']?>"  target="_blank" class="prevew"><img src="../media/foto/m/smal_<?=$tbl[$i+1]['file']?>"></a>
                                <?php }?>
                            </div>
                        </div>
                    </td>
                    <td class="enum5">
                        <div class="sq1">
                            <div class="sq2">
                                <?php if ($i + 2 < count($tbl)) {?>
                                <a href="index.php?page=<?=$page?>&action=del&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i+2]['id']?>&type=<?=$type?>"><img src="../i/delete.ico" title="Удалить" class="fix"></a>
                                <?php if ($tbl[$i+2]['file'] != $array['main'][$r]) { //Если фотка не является обложкой ?>
                                <a href="index.php?page=<?=$page?>&action=main&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i+2]['id']?>&type=<?=$type?>"><img src="../i/check.ico" title="Сделать обложкой" class="fix2"></a>
                                <?php }?>
                                <a href="../media/foto/<?=$tbl[$i+2]['file']?>"  target="_blank" class="prevew"><img src="../media/foto/m/smal_<?=$tbl[$i+2]['file']?>"></a>
                                <?php }?>
                            </div>
                        </div>
                    </td>
                    <td class="enum5">
                        <div class="sq1">
                            <div class="sq2">
                                <?php if ($i + 3 < count($tbl)) {?>
                                <a href="index.php?page=<?=$page?>&action=del&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i+3]['id']?>&type=<?=$type?>"><img src="../i/delete.ico" title="Удалить" class="fix"></a>
                                <?php if ($tbl[$i+3]['file'] != $array['main'][$r]) { //Если фотка не является обложкой ?>
                                <a href="index.php?page=<?=$page?>&action=main&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i+3]['id']?>&type=<?=$type?>"><img src="../i/check.ico" title="Сделать обложкой" class="fix2"></a>
                                <?php }?>
                                <a href="../media/foto/<?=$tbl[$i+3]['file']?>"  target="_blank" class="prevew"><img src="../media/foto/m/smal_<?=$tbl[$i+3]['file']?>"></a>
                                <?php }?>
                            </div>
                        </div>
                    </td>
                    <td class="enum5">
                        <div class="sq1">
                            <div class="sq2">
                                <?php if ($i + 4 < count($tbl)) {?>
                                <a href="index.php?page=<?=$page?>&action=del&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i+4]['id']?>&type=<?=$type?>"><img src="../i/delete.ico" title="Удалить" class="fix"></a>
                                <?php if ($tbl[$i+4]['file'] != $array['main'][$r]) { //Если фотка не является обложкой ?>
                                <a href="index.php?page=<?=$page?>&action=main&album=<?=$array['album'][$r]?>&id=<?=$tbl[$i+4]['id']?>&type=<?=$type?>"><img src="../i/check.ico" title="Сделать обложкой" class="fix2"></a>
                                <?php }?>
                                <a href="../media/foto/<?=$tbl[$i+4]['file']?>"  target="_blank" class="prevew"><img src="../media/foto/m/smal_<?=$tbl[$i+4]['file']?>"></a>
                                <?php }?>
                            </div>
                        </div>
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
        <table class="listBack">
            <tbody>
               <tr class="listHead">
                    <td colspan="100%">
                        <div class="btn_look">
                            <b>Альбомы</b>
                        </div>
                    </td>
                </tr>
                <?php for($i = 0; $i < count($array['album']); $i +=5) { //Для каждого альбома ?>
                <tr class="listHead">
                    <?php $tbl=$array['table'][$i]; ?>
                    <td class="enum5">
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i]?>&pa=<?=$pna?>">
                            <?php if ($type == 'foto') { //Если тип фото ?>
                            <div class="sq1">
                                <div class="sq2">
                                    <img src="../media/<?=$type?>/m/smal_<?=dapost($array['main'][$i])?>">
                                </div>
                            </div>
                            <?php }?>
                            <?=$array['album'][$i]?>
                        </a>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 1 < count($array['album'])) {?>
                        <?php $tbl=$array['table'][$i+1]; ?>
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i+1]?>&pa=<?=$pna?>">
                            <?php if ($type == 'foto') { //Если тип фото ?>
                            <div class="sq1">
                                <div class="sq2">
                                    <img src="../media/<?=$type?>/m/smal_<?=dapost($array['main'][$i+1])?>">
                                </div>
                            </div>
                            <?php }?>
                            <?=$array['album'][$i+1]?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 2 < count($array['album'])) {?>
                        <?php $tbl=$array['table'][$i+2]; ?>
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i+2]?>&pa=<?=$pna?>">
                            <?php if ($type == 'foto') { //Если тип фото ?>
                            <div class="sq1">
                                <div class="sq2">
                                    <img src="../media/<?=$type?>/m/smal_<?=dapost($array['main'][$i+2])?>">
                                </div>
                            </div>
                            <?php }?>
                            <?=$array['album'][$i+2]?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 3 < count($array['album'])) {?>
                        <?php $tbl=$array['table'][$i+3]; ?>
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i+3]?>&pa=<?=$pna?>">
                            <?php if ($type == 'foto') { //Если тип фото ?>
                            <div class="sq1">
                                <div class="sq2">
                                    <img src="../media/<?=$type?>/m/smal_<?=dapost($array['main'][$i+3])?>">
                                </div>
                            </div>
                            <?php }?>
                            <?=$array['album'][$i+3]?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 4 < count($array['album'])) {?>
                        <?php $tbl=$array['table'][$i+4]; ?>
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i+4]?>&pa=<?=$pna?>">
                            <?php if ($type == 'foto') { //Если тип фото ?>
                            <div class="sq1">
                                <div class="sq2">
                                    <img src="../media/<?=$type?>/m/smal_<?=dapost($array['main'][$i+4])?>">
                                </div>
                            </div>
                            <?php }?>
                            <?=$array['album'][$i+4]?>
                        </a>
                        <?php }?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>

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
        <?php }?>
    <?php break;
    case 'video':
    case 'audio': //Видео и аудио ?>
        <?php if (count($array['album']) > 0) { //Если кол-во альбомов больше нуля ?>
        <?php if ($album != '') { //Если переменная альбома не пустая ?>
        <?php for($r = 0; $r < count($array['album']); $r++) { //Для каждого альбома ?>
        <?php $pc = $array['count'][$r]; //Кол-во станиц для альбома ?>
        <?php if ($array['album'][$r] == $album) { //Если название альбома совпадает с переменной (выбранный альбом)?>
        <table class="list_back_admin">
            <tbody>
                <!--Шапка таблицы-->
                <tr class="listHead">
                    <td colspan="100%"><b><?=$array['album'][$r]?></b></td>
                </tr>
                <tr class="listHead">
                    <td>
                        Название
                    </td>
                    <td>
                        <?php if ($type == 'audio') { ?>Имя файла<?php }
                        else {?>Ссылка на видео<?php }?>
                    </td>
                </tr>
                <?php $tbl = $array['table'][$r]; ?>
                <?php for ($i = 0; $i < count($tbl); $i++) {?>
                <tr>
                    <td class="list_text">
                        <?=$tbl[$i]['name']?>
                    </td>
                    <td class="list_text">
                        <?=$tbl[$i]['file']?>
                    </td>
                    <td class="list_but">
                        <a href="index.php?page=edit_media&action=edit&id=<?=$tbl[$i]['id']?>&type=<?=$type?>"><img src="../i/edit.ico" title="Редактировать"></a>
                    </td>
                    <td class="list_but">
                        <a href="index.php?page=<?=$page?>&action=del&id=<?=$tbl[$i]['id']?>&type=<?=$type?>"><img src="../i/trash.ico" title="Удалить"></a>
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
        <table class="list_back_admin">
            <tbody>
                <!--Шапка таблицы-->
                <tr class="listHead">
                    <td colspan="100%"><b>Список альбомов</b></td>
                </tr>
                <?php for($i = 0; $i < count($array['album']); $i += 5) { //Для всех альбомов с шагом 5 ?>
                <tr class="listHead">
                    <td class="enum5">
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i]?>&pa=<?=$pna?>">
                            <?=$array['album'][$i]?>
                        </a>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 1 < count($array['album'])) { //Если в массиве еще есть записи ?>
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i+1]?>&pa=<?=$pna?>">
                            <?=$array['album'][$i+1]?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 2 < count($array['album'])) { //Если в массиве еще есть записи ?>
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i+2]?>&pa=<?=$pna?>">
                            <?=$array['album'][$i+2]?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 3 < count($array['album'])) { //Если в массиве еще есть записи ?>
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i+3]?>&pa=<?=$pna?>">
                            <?=$array['album'][$i+3]?>
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum5">
                        <?php if ($i + 4 < count($array['album'])) { //Если в массиве еще есть записи ?>
                        <a href="index.php?page=<?=$page?>&type=<?=$type?>&album=<?=$array['album'][$i+4]?>&pa=<?=$pna?>">
                            <?=$array['album'][$i+4]?>
                        </a>
                        <?php }?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>

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
        <?php }?>
        <?php break;
    case 'albums': //Редактор альбомов ?>
        <table class="list_back_admin">
            <tbody class="labels">
                <tr class="listHead">
                    <td class="Str">
                        <b>Фотографии</b>
                    </td>
                    <td>
                        <label for="Foto" class="hide_table">
                            <img src="../i/toggle.png">
                        </label>
                        <input type="checkbox" name="Foto" id="Foto" data-toggle="toggle">
                    </td>
                </tr>
            </tbody>
            <tbody class="hide">
                <?php foreach ($array as $a): //Для каждой строки списка альбомов?>
                <?php if($a['type'] == 'foto') { //Если фото ?>
                <tr>
                    <td class="list_text_one">
                        <?=$a['name']?>
                    </td>
                    <td class="list_but">
                        <a href="index.php?page=<?=$page?>&type=albums&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
                    </td>
                </tr>
                <?php }?>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="space"></div>
        <table class="list_back_admin">
            <tbody class="labels">
                <tr class="listHead">
                    <td class="Str">
                        <b>Видео</b>
                    </td>
                    <td>
                        <label for="Video" class="hide_table">
                            <img src="../i/toggle.png">
                        </label>
                        <input type="checkbox" name="Video" id="Video" data-toggle="toggle">
                    </td>
                </tr>
            </tbody>
            <tbody class="hide">
                <?php foreach ($array as $a): //Для каждой строки списка альбомов?>
                <?php if($a['type'] == 'video') { //Если фото ?>
                <tr>
                    <td class="list_text_one">
                        <?=$a['name']?>
                    </td>
                    <td class="list_but">
                        <a href="index.php?page=<?=$page?>&type=albums&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
                    </td>
                </tr>
                <?php }?>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="space"></div>
        <table class="list_back_admin">
            <tbody class="labels">
                <tr class="listHead">
                    <td class="Str">
                        <b>Аудио</b>
                    </td>
                    <td>
                        <label for="Audio" class="hide_table">
                            <img src="../i/toggle.png">
                        </label>
                        <input type="checkbox" name="Audio" id="Audio" data-toggle="toggle">
                    </td>
                </tr>
            </tbody>
            <tbody class="hide">
                <?php foreach ($array as $a): //Для каждой строки списка альбомов?>
                <?php if($a['type'] == 'audio') { //Если фото ?>
                <tr>
                    <td class="list_text_one">
                        <?=$a['name']?>
                    </td>
                    <td class="list_but">
                        <a href="index.php?page=<?=$page?>&type=albums&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
                    </td>
                </tr>
                <?php }?>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php break;
} ?>
<?php if ($podp = 'Фотографии' && $album != '') { ?>
<br><a href="index.php?page=<?=$page?>&type=<?=$type?>&pa=<?=$pna?>"><img src="../i/back.ico" width="40px" title="Вернуться к списку альбомов"></a>
<?php }?>