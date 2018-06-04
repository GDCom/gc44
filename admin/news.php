<?php
$page = $_GET['page']; //Записываем страницу в переменную

$tbl_pp = get_table($link, "SELECT adm_news FROM settings"); //Берем из базы кол-во элементов на страницу

if ($tbl_pp != NULL > 0 && $tbl_pp[0]['adm_news'] != NULL) $pp = $tbl_pp[0]['adm_news']; //Если значение не пустое, записываем в переменную
else $pp = 30; //Иначе присваиваем значение 30

if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

if (isset($_GET['action'])) {
    //Если доступен первый файл
    if (isset($_POST['img1_check']) && $_POST['img1_check'] == 'YES' && isset($_FILES['img1'])) //Если чекбокс отмечен и файл передан
    {
         $img1 = upload_file($_FILES['img1'], 'img/', 500, $link, "img"); //Копируем файл и получаем строку для базы
    }
    
    //Если доступны остальные файлы
    if (isset($_POST['imgs_check']) && $_POST['imgs_check'] == 'YES' && isset($_FILES['imgs'])) //Если чекбокс отмечен и файлы переданы
    {
        $imgs = upload_files($_FILES['imgs'], 'img/', 500, $link, "img"); //Копируем файлы и получаем массив для базы
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
            
            $t = "INSERT INTO news (title, date, content, img1, imgs) VALUES ('".$_POST['title']."', '".date("Y-m-d")."', '".$_POST['content']."', '".$img1_t."', '".$imgs_t."')"; //Команда на добавление новой записи
            
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

$tbl_count = get_table($link, "SELECT FLOOR((COUNT(*)+".($pp-1).")/".$pp.") AS count FROM `news` Order By id DESC"); //Кол-во страниц новостей
$pc = $tbl_count[0]['count']; //Записываем в переменную

$news = get_table($link, "SELECT * FROM `news` Order By id DESC LIMIT ".($pn-1)*$pp.", ".$pp); //Считываем таблицу новостей согласно выбранной странице
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
                <a href="index.php?page=<?=$page?>&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
            </td>
        </tr>
        <?php endforeach ?>
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