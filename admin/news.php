<?php

if (isset($_GET['action'])) {
    //Если доступен первый файл
    if (isset($_POST['img1_check']) && $_POST['img1_check'] == 'YES' && isset($_FILES['img1'])) //Если чекбокс отмечен и файл передан
    {
         $img1 = upload_file($_FILES['img1'], 'img/', 400, $link, "img"); //Копируем файл и получаем строку для базы
    }
    
    //Если доступны остальные файлы
    if (isset($_POST['imgs_check']) && $_POST['imgs_check'] == 'YES' && isset($_FILES['imgs'])) //Если чекбокс отмечен и файлы переданы
    {
        $imgs = upload_files($_FILES['imgs'], 'img/', 400, $link, "img"); //Копируем файлы и получаем массив для базы
    }
    
    $action = $_GET['action'];
    switch ($action) {  //В зависимости от режима
        case "add":     //Новая статья
            if (isset($_POST['img1_check']) && $_POST['img1_check'] == 'YES') $img1_t = $img1; //Если чекбокс отмечен, меняем изображение в базе
            else $img1_t = ''; //Иначе пропускаем
            
            if (isset($_POST['imgs_check']) && $_POST['imgs_check'] == 'YES') { //Если чекбокс отмечен
                for ($i = 0; $i < count($imgs); $i++) { //для каждого элемента массива названий файлов
                    if ($i == 0) $imgs_t = $imgs[$i]; //Если первый элемент
                    else $imgs_t = $imgs_t.";".$imgs[$i]; //Последующие элементы
                }
                $imgs_t = $imgs_t; //Добавляем строки для внесения в команду
            }
            else $imgs_t = ''; //Иначе пропускаем
            
            $t = "INSERT INTO news (title, date, content, img1, imgs) VALUES ('".$_POST['title']."', '".date("Y-m-d H:i:s")."', '".$_POST['content']."', '".$img1_t."', '".$imgs_t."')"; //Команда на добавление новой записи
            
            break;
        case "edit": //Редактирование записи
            $id = $_GET['id'];
            
            //Первый файл
            if (isset($_POST['img1_check']) && $_POST['img1_check'] == 'YES') { //Если чекбокс отмечен
                del_img($link, 'news', 'img1', $id, '../img/', '../img/m/smal_'); //Удаляем первый файл
                               
                $img1_t = ", img1='".$img1."'"; //меняем изображение в базе
            }
            else $img1_t = ''; //Иначе пропускаем
            
            //Остальные файлы
            if (isset($_POST['imgs_check']) && $_POST['imgs_check'] == 'YES') { //Если чекбокс отмечен
                del_imgs($link, 'news', 'imgs', $id, '../img/', '../img/m/smal_'); //Удаляем остальные файлы
                
                for ($i = 0; $i < count($imgs); $i++) { //для каждого элемента массива названий файлов
                    if ($i == 0) $imgs_t = $imgs[$i]; //Если первый элемент
                    else $imgs_t = $imgs_t.";".$imgs[$i]; //Последующие элементы
                }
                $imgs_t = ", imgs='".$imgs_t."'"; //Добавляем строки для внесения в команду
            }
            elseif (isset($_POST['imgs_check']) && $_POST['imgs_check'] == 'YES' && $imgs == NULL) { //Если чекбокс отмечен, но файлы не выбраны
                del_imgs($link, 'news', 'imgs', $id, '../img/', '../img/m/smal_'); //Удаляем остальные файлы
                $imgs_t = ''; //Пустая строка для базы
            }
            else $imgs_t = ''; //Иначе пропускаем
            
            $t = "UPDATE news SET title='".$_POST['title']."', date='".$_POST['date']."', content='".$_POST['content']."'".$img1_t.$imgs_t." WHERE id='".$id."'"; //Команда редактирования записи
            break;
        case "del": //Удаление записи
            $id = $_GET['id'];
            
            del_img($link, 'news', 'img1', $id, '../img/', '../img/m/smal_'); //Удаляем первый файл
            
            del_imgs($link, 'news', 'imgs', $id, '../img/', '../img/m/smal_'); //Удаляем остальные файлы
            
            $t = "DELETE FROM news WHERE id=".$id; //Команда удаления новости
            break;
    }
    run_command($link, $t); //Посылаем команду в базу
    
    header('Location: index.php?page=news');
}

$news = get_table($link, "SELECT * FROM `news` Order By id DESC"); //Считываем таблицу новостей
?>

<h2>Создание и редактирование раздела "Новости"</h2>

<a href="index.php?page=edit_news&mode=new"><img src="../i/add.ico" height="40px" title="Создать новую запись"></a><br><br>

<table class="list_back_admin">
    <tbody>
        <!--Шапка таблицы-->
        <tr class="listHead">
            <td>
                <b>Заголовок</b>
            </td>
            <td>
                <b>Дата публикации</b>
            </td>
        </tr>
        <!--Данные-->
        <?php foreach($news as $a): ?>
        <tr>
            <td class="list_text">
                <?=$a['title']?>
            </td>
            <td class="list_text">
                <?=$a['date']?>
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_news&mode=edit&id=<?=$a['id']?>"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
            <td class="list_but">
                <a href="index.php?page=news&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>