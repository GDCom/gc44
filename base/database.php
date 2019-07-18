<?php

//Взять информацию из базы
function get_table($link, $query) {
    //Запрос в базу
    
    if (!mysqli_query($link, $query)) return NULL;
    else $result = mysqli_query($link, $query);
    
    if(!$result) die(mysqli_error($link));
    
    //Извлечение из базы
    $n = mysqli_num_rows($result);
    $table = array();
    
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $table[] = $row;
    }
     return $table;
}

//выполнение команды в базе
function run_command($link, $query) {
    $result = mysqli_query($link, $query);
    
    if (!$result) die(mysqli_error($link));
    
    return true;
}

//Функция загрузки файла на сервер
function upload_file($file, $puth, $size=400, $link, $type) {
    
    $s = date("ymdHi"); //Записываем в переменную дату и время для префикса
    
    if ($file['name'] != '') { //Если имя файла не пустое

        $name = $s."_".strtolower(translit($file['name'])); //Получаем имя файла
        if (!move_uploaded_file($file['tmp_name'], '../'.$puth.$name)) echo "Ошибка загрузки файла"; //Копируем файл
        
        $width = 0; //Нулевое значение ширины для миниатюры
        $width_b = 0; //Нулевое значение ширины для большой картинки
        $height = 0; //Нулевое значение высоты для миниатюры
        $height_b = 0; //Нулевое значение высоты для большой картинки
        
        if ($type == 'foto') { //Если это изображение
            $s_im = getimagesize('../'.$puth.$name); //Размер изображения

            if ($s_im[0] > $s_im[1]) { //Если ширина больше уменьшаем по ширине
                $width = $size;
                $width_b = 1080;
            }
            else { //Иначе уменьшаем по высоте
                $height = $size;
                $height_b = 1080;
            }
            
            $f = img_resize('../'.$puth.$name, '../'.$puth.$name, $width_b, $height_b); //Меняем размер основного изображения
            $f = img_resize('../'.$puth.$name, '../'.$puth.'m/smal_'.$name, $width, $height); //делаем миниатюру файла
            if ($f == false) echo "Ошибка обрезания файла";
            
            make_watermark('../'.$puth.$name); //Ставим водяной знак на основное изображение
            make_watermark('../'.$puth.'m/smal_'.$name); //Ставим водяной знак на миниатюру
        }
        else { //Иначе
            if (!move_uploaded_file($file['tmp_name'], '../'.$puth.$name)) echo "Ошибка загрузки файла"; //Копируем файл    
        }
    }
    else $name = NULL; //Иначе имя равно NULL
    
    return $name; //Возвращаем имя файла
}

//Функция загрузки файлов на сервер
function upload_files($files, $puth, $size=400, $link, $type) {
    
    $s = date("ymdHi"); //Записываем в переменную дату и время для префикса
    
    $nm = array();
    
    if (count($files['name']) > 0) { //Если массив файлов не пустой
        //Для каждого файла
        foreach ($files['name'] as $i=>$name) {
            if (basename($files['name'][$i]) != '') { //Если имя файла не пустое
                $filename = $s."_".strtolower(translit(basename($files['name'][$i]))); //Имя файла
                if (!move_uploaded_file($files['tmp_name'][$i], '../'.$puth.$filename)) echo "Ошибка загрузки файла"; //Копируем файл
                
                $width = 0; //Нулевое значение ширины для миниатюры
                $width_b = 0; //Нулевое значение ширины для большой картинки
                $height = 0; //Нулевое значение высоты для миниатюры
                $height_b = 0; //Нулевое значение высоты для большой картинки
                
                if ($type == 'foto') { //Если это изображение
                    $s_im = getimagesize('../'.$puth.$filename); //Размер изображения

                    if ($s_im[0] > $s_im[1]) { //Если ширина больше уменьшаем по ширине
                        $width = $size;
                        $width_b = 1080;
                    }
                    else { //Иначе уменьшаем по высоте
                        $height = $size;
                        $height_b = 1080;
                    }
                    
                    if (!img_resize('../'.$puth.$filename, '../'.$puth.$filename, $width_b, $height_b)) echo "Ошибка обрезания файлов"; //Меняем размер основного изображения
                    if (!img_resize('../'.$puth.$filename, '../'.$puth.'m/smal_'.$filename, $width, $height)) echo "Ошибка обрезания файлов"; //делаем миниатюру файла
                    
                    make_watermark('../'.$puth.$filename); //Ставим водяной знак на основное изображение
                    make_watermark('../'.$puth.'m/smal_'.$filename); //Ставим водяной знак на миниатюру
                }
                else { //Иначе
                    if (!move_uploaded_file($files['tmp_name'][$i], '../'.$puth.$filename)) echo "Ошибка загрузки файла"; //Иначе просто копируем файл
                }
                
                $nm[] = $filename; //Добавляем в архив
            }
        } 
    }
    else $nm = NULL; //Иначе переменная равна нулю
    
    return $nm;
}

//Наложение водяного знака на изображение
function make_watermark($file){
    // получаем полезные данные о картинке
    $image_info = getimagesize($file);
    
    //Создаем водяной знак с шириной изображения
    img_resize('../i/watermark.png', '../i/wtrmrk_newsize.png', $image_info[0], 0);
    
    // получаем полезные данные о водяном знаке
    $watermark_info = getimagesize('../i/wtrmrk_newsize.png');

    // определяем MIME-тип изображения, для выбора соответствующей функции
    $format = strtolower(substr($image_info['mime'], strpos($image_info['mime'], '/') + 1));

    // определяем названия функция для создания и сохранения картинки
    $im_cr_func = "imagecreatefrom" . $format;
    $im_save_func = "image" . $format;

    // загружаем изображение в php
    $img = $im_cr_func($file);

    // загружаем в php наш водяной знак
    $watermark = imagecreatefrompng('../i/wtrmrk_newsize.png');

    // определяем координаты левого верхнего угла водяного знака
    $pos_x = 0; //($image_info[0] - $watermark_info[0]) / 2; 
    $pos_y = ($image_info[1] - $watermark_info[1]); 

    // помещаем водяной знак на изображение
    imagecopy($img, $watermark, $pos_x, $pos_y, 0, 0, $watermark_info[0], $watermark_info[1]);

    // сохраняем изображение с уникальным именем
    $im_save_func($img, $file);
    
    //Удаляем временный водяной знак
    unlink('../i/wtrmrk_newsize.png');
}

//Функция для создания массива альбомов аудио, видео, фото
function albums ($link, $base_table, $pp, $pn, $ppa, $pna) {
    $name_album = get_table($link, "SELECT name FROM albums WHERE type='".$base_table."'"); //Названия всех альбомов

    if (count($name_album) > 0) { //Если база не пустая
        
        $alb_count = get_table($link, "SELECT FLOOR((COUNT(*)+".($ppa-1).")/".$ppa.") AS count FROM albums WHERE type='".$base_table."'"); //Кол-во страниц альбомов
        
        $array['al_count'] = $alb_count[0]['count']; //Записываем в массив количество страниц альбомов
        
        $name_album = get_table($link, "SELECT name FROM albums WHERE type='".$base_table."' ORDER BY date DESC LIMIT ".($pna-1)*$ppa.", ".$ppa); //Названия всех альбомов согласно выбранной странице с сортировкой по дате от новых к старым
        
        $t = 0; //Переменная для массива альбомов
        
        for ($i = 0; $i < count($name_album); $i++) { //Для каждого альбома
            
            $tbl_tmp = get_table($link, "SELECT * FROM ".$base_table." WHERE album='".$name_album[$i]['name']."' ORDER BY date DESC");
            
            if (count($tbl_tmp) > 0) { //Если медиа есть в альбоме    
                $tbl_count = get_table($link, "SELECT FLOOR((COUNT(*)+".($pp-1).")/".$pp.") AS count FROM ".$base_table." WHERE album='".$name_album[$i]['name']."' ORDER BY date DESC"); //Кол-во страниц для альбома согласно ограничению кол-ва эл-ов на страницу
            
                $array['count'][$t] = $tbl_count[0]['count']; //Записываем в массив
            
                $tbl_tmp = get_table($link, "SELECT * FROM ".$base_table." WHERE album='".$name_album[$i]['name']."' ORDER BY date DESC LIMIT ".($pn-1)*$pp.", ".$pp); //Все фотки из этого альбома во временный массив согласно выбранной страницы и кол-ва записей
            
                $array['album'][$t] = $name_album[$i]['name']; //Имя альбома

                $array['table'][$t] = $tbl_tmp; //Все фотки из этого альбома в массив table

                if ($base_table == 'foto') { //Если база фоток
                    $tbl_main = get_table($link, "SELECT file FROM foto WHERE album='".$name_album[$i]['name']."' AND main=1"); //Делаем выборку обложки данного альбома
                    if (count($tbl_main) > 0) $array['main'][$t] = $tbl_main[0]['file']; //Записываем имя файла обложки в массив обложек, если есть
                    else $array['main'][$t] = ''; //Иначе значение пустое
                }
                
                $t += 1; //Увеличиваем переменную на 1
            }
        }
    }
    else $array = NULL;

    return $array;
}

//Изменение размера файла
function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 100) {  
    if (!file_exists($src))
        return false;
 
    $size = getimagesize($src);
      
    if ($size === false)
        return false;
 
    $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
    $icfunc = 'imagecreatefrom'.$format;
     
    if (!function_exists($icfunc))
        return false;
 
    $x_ratio = $width  / $size[0];
    $y_ratio = $height / $size[1];
     
    if ($height == 0)
    { 
        $y_ratio = $x_ratio;
        $height  = $y_ratio * $size[1];
    }
    elseif ($width == 0)
    { 
        $x_ratio = $y_ratio;
        $width   = $x_ratio * $size[0];
    }
     
    $ratio       = min($x_ratio, $y_ratio);
    $use_x_ratio = ($x_ratio == $ratio);
     
    $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
    $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
    $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width)   / 2);
    $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
      
    // если не нужно увеличивать маленькую картинку до указанного размера
    if ($size[0]<$new_width && $size[1]<$new_height)
    {
        $width = $new_width = $size[0];
        $height = $new_height = $size[1];
    }
 
    $isrc  = $icfunc($src);
    $idest = imagecreatetruecolor($width, $height);
      
    imagefill($idest, 0, 0, $rgb);
    imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);
 
    $i = strrpos($dest,'.');
    if (!$i) return '';
    $l = strlen($dest) - $i;
    $ext = substr($dest,$i+1,$l);
     
    switch ($ext)
    {
        case 'jpeg':
        case 'jpg':
        imagejpeg($idest,$dest,$quality);
        break;
        case 'gif':
        imagegif($idest,$dest);
        break;
        case 'png':
        imagepng($idest,$dest);
        break;
    }
 
    imagedestroy($isrc);
    imagedestroy($idest);
 
    return true;  
}

//Функция удаления первого файла
function del_img($link, $base, $col, $id, $puth, $puth_m) {
    $img_d = get_table($link, "SELECT ".$col." FROM ".$base." WHERE id=".$id); //Выбираем названия первого файла из базы для удаления
    
    $file_name = dapost($puth.$img_d[0][$col]);
    $file_name_m = dapost($puth_m.$img_d[0][$col]);
        
    if ($img_d[0][$col] != '') { //Если поле не пустое
        if (!unlink($file_name)) echo 'Ошибка удаления первого файла'; //Удаляем первый файл
        if (!unlink($file_name_m)) echo 'Ошибка удаления миниатюры первого файла'; //Удаляем миниатюру первого файла
    }
}
    
//Функция удаления остальных файлов
function del_imgs($link, $base, $col, $id, $puth, $puth_m) {
    $img_d = get_table($link, "SELECT ".$col." FROM ".$base." WHERE id=".$id); //Выбираем названия файлов из удаляемой новости
            
    $s = explode(";", dapost($img_d[0][$col])); //Разбиваем спсок изображений в массив
            
    for ($i = 0; $i < count($s); $i++) { //Для каждого файла в массиве
        if (!unlink($puth.$s[$i])) echo 'Ошибка удаления '.$s[$i].' файла'; //Удаляем остальные файлы
        if (!unlink($puth_m.$s[$i])) echo 'Ошибка удаления миниатюры '.$s[$i].' файла'; //Удаляем миниатюры остальных файлов
    }
}

//Создаем правильную ссылку на видео в Youtube
function get_youtube($file) {
    $i = strrpos($file, '/'); //Определяем индекс последнего слеша
    
    $file = substr($file, $i+1); //Обрезаем все лишнее
    
    return $file; //Возвращаем измененную строку
}

//Меняем апостроф, чтобы не было ошибок базы
function apost($s) {
    $s = str_replace("'", "&#39;", $s);
    $s = str_replace('"', "&#34;", $s);
    return $s;
}

//Возвращаем апостроф назад
function dapost($s) {
    $s = str_replace("&#39;", "'", $s);
    $s = str_replace("&#34;", '"', $s);
    return $s;
}

//Функция по определению пустой таблицы и добавления пустой строки
function check_base($link, $base) {
    $array = get_table($link, "SELECT COUNT(*) AS count FROM ".$base); //Определяем кол-во строк

    if ($array[0]['count'] == 0) { //Если ноль записей
        run_command($link, "INSERT INTO ".$base." () VALUE ()"); //Создаем новую запись
    }
    
    //return true;
}

//Функция транслитерации кирилицы в латиницу
function translit($text) {
    
    //Меняем буквы по отдельности
    $text = str_replace("а", "a", $text);
    $text = str_replace("б", "b", $text);
    $text = str_replace("в", "v", $text);
    $text = str_replace("г", "g", $text);
    $text = str_replace("д", "d", $text);
    $text = str_replace("е", "e", $text);
    $text = str_replace("ё", "yo", $text);
    $text = str_replace("ж", "gh", $text);
    $text = str_replace("з", "z", $text);
    $text = str_replace("и", "i", $text);
    $text = str_replace("й", "y", $text);
    $text = str_replace("к", "k", $text);
    $text = str_replace("л", "l", $text);
    $text = str_replace("м", "m", $text);
    $text = str_replace("н", "n", $text);
    $text = str_replace("о", "o", $text);
    $text = str_replace("п", "p", $text);
    $text = str_replace("р", "r", $text);
    $text = str_replace("с", "s", $text);
    $text = str_replace("т", "t", $text);
    $text = str_replace("у", "u", $text);
    $text = str_replace("ф", "f", $text);
    $text = str_replace("х", "h", $text);
    $text = str_replace("ц", "c", $text);
    $text = str_replace("ч", "ch", $text);
    $text = str_replace("ш", "sh", $text);
    $text = str_replace("щ", "sch", $text);
    $text = str_replace("ъ", "'", $text);
    $text = str_replace("ы", "yi", $text);
    $text = str_replace("ь", "'", $text);
    $text = str_replace("э", "e", $text);
    $text = str_replace("ю", "yu", $text);
    $text = str_replace("я", "ya", $text);
    
    $text = str_replace("А", "a", $text);
    $text = str_replace("Б", "b", $text);
    $text = str_replace("В", "v", $text);
    $text = str_replace("Г", "g", $text);
    $text = str_replace("Д", "d", $text);
    $text = str_replace("Е", "e", $text);
    $text = str_replace("Ё", "yo", $text);
    $text = str_replace("Ж", "gh", $text);
    $text = str_replace("З", "z", $text);
    $text = str_replace("И", "i", $text);
    $text = str_replace("Й", "y", $text);
    $text = str_replace("К", "k", $text);
    $text = str_replace("Л", "l", $text);
    $text = str_replace("М", "m", $text);
    $text = str_replace("Н", "n", $text);
    $text = str_replace("О", "o", $text);
    $text = str_replace("П", "p", $text);
    $text = str_replace("Р", "r", $text);
    $text = str_replace("С", "s", $text);
    $text = str_replace("Т", "t", $text);
    $text = str_replace("У", "u", $text);
    $text = str_replace("Ф", "f", $text);
    $text = str_replace("Х", "h", $text);
    $text = str_replace("Ц", "c", $text);
    $text = str_replace("Ч", "ch", $text);
    $text = str_replace("Ш", "sh", $text);
    $text = str_replace("Щ", "sch", $text);
    $text = str_replace("Ъ", "'", $text);
    $text = str_replace("Ы", "yi", $text);
    $text = str_replace("Ь", "'", $text);
    $text = str_replace("Э", "e", $text);
    $text = str_replace("Ю", "yu", $text);
    $text = str_replace("Я", "ya", $text);
    
    return $text; //Возвращаем строку
}
?>