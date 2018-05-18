<?php
if (isset($_GET['action'])) {
    
    //Если доступен первый файл
    if (isset($_POST['img_check']) && $_POST['img_check'] == 'YES' && isset($_FILES['img']))
    {
         $img = upload_file($_FILES['img'], 'img/', 400, $link, "img");
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

$ministry = get_table($link, "SELECT * FROM ministry ORDER BY title");
?>

<h2>Создание и редактирование раздела "Служения"</h2>

<a href="index.php?page=edit_ministry&mode=new"><img src="../i/add.ico" height="40px" title="Создать"></a><br><br>

<!--Показ всего списка новостей-->
<table class="list_back_admin">
    <tbody>
        <!--Шапка таблицы-->
        <tr class="listHead">
            <td>
                <b>Заголовок</b>
            </td>
        </tr>
        <!--Данные-->
        <?php foreach($ministry as $a): ?>
        <tr>
            <td class="list_text_one">
                <?=$a['title']?>
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_ministry&mode=edit&id=<?=$a['id']?>"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
            <td class="list_but">
                <a href="index.php?page=ministry&action=del&id=<?=$a['id']?>"><img src="../i/trash.ico" title="Удалить"></a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>