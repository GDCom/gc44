<?php
$page = $_GET['page']; //Записываем страницу в переменную

$tbl_pp = get_table($link, "SELECT adm_ministry FROM settings"); //Берем из базы кол-во элементов на страницу

if ($tbl_pp != NULL > 0 && $tbl_pp[0]['adm_ministry'] != NULL) $pp = $tbl_pp[0]['adm_ministry']; //Если значение не пустое, записываем в переменную
else $pp = 30; //Иначе присваиваем значение 30

if (isset($_GET['p'])) $pn = $_GET['p']; //Если доступен параметр номера страницы, записываем в переменную
else $pn = 1; //Иначе первая страница

if (isset($_GET['action'])) {
    
    //Если доступен первый файл
    if (isset($_POST['img_check']) && $_POST['img_check'] == 'YES' && isset($_FILES['img']))
    {
         $img = upload_file($_FILES['img'], 'img/', 500, $link, 'foto');
    }
    
    $action = $_GET['action'];
    
    switch ($action) {  //В зависимости от режима
        case "add":     //Новая статья
            $t = "INSERT INTO ministry (title, content, img, alt) VALUES ('".$_POST['title']."', '".$_POST['content']."', '".$img."', '".$_POST['alt']."')"; //Команда на добавление новой записи
            
            break;
        case "edit": //Редактирование записи
            $id = $_GET['id'];
            
            if (isset($_POST['img_check']) && $_POST['img_check'] == 'YES') { //Если чекбокс отмечен
                del_img($link, 'ministry', 'img', $id, '../img/', '../img/m/smal_'); //Удаляем изображение с миниатюрой
                
                $img_t = ", img='".$img."'"; //строка для команды изменения
            }
            else $img_t = '';
            
            $t = "UPDATE ministry SET title='".$_POST['title']."', content='".$_POST['content']."'".$img_t.", alt='".$_POST['alt']."' WHERE id='".$id."'"; //Команда редактирования записи
            
            break;
        case "del": //Удаление записи
            $id = $_GET['id'];
            
            del_img($link, 'ministry', 'img', $id, '../img/', '../img/m/smal_'); //Удаляем изображение с миниатюрой
            
            $t = "DELETE FROM ministry WHERE id=".$id; //Команда удаления новости
            
            break;
    }
    run_command($link, $t); //Посылаем команду в базу
    
    header('Location: index.php?page=ministry');
}

$tbl_count = get_table($link, "SELECT FLOOR((COUNT(*)+".($pp-1).")/".$pp.") AS count FROM ministry"); //Кол-во страниц новостей
$pc = $tbl_count[0]['count']; //Записываем в переменную


$ministry = get_table($link, "SELECT * FROM ministry ORDER BY title LIMIT ".($pn-1)*$pp.", ".$pp); //Считываем таблицу служений из базы согласно выбранной странице
?>

<h2>Создание и редактирование раздела "Служения"</h2>

<div class="space"></div>

<a href="index.php?page=edit_ministry&mode=new" class="arrow"><img src="../i/add.ico" height="40px" title="Создать"></a>

<div class="tbl_back">
    <div class="tbl_title">
        Название служения
    </div>
    
    <div class="tbl-3">
        <?php foreach($ministry as $a): ?>
        <div class="col-1">
                <?=$a['title']?>
        </div>
        <div class="col-midle">
                <a href="index.php?page=edit_ministry&mode=edit&id=<?=$a['id']?>"><img src="../i/edit.ico" title="Редактировать"></a>
        </div>
        <div class="col-last">
                <a href="index.php?page=<?=$page?>&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
        </div>
        <?php endforeach ?>
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