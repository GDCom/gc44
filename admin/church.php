<?php
if (isset($_GET['type'])) { //Если передаваемая переменная type доступна
    $type = $_GET['type']; //Тип статьи
    
    switch ($type) { //Для типов статей
        case 'episcop': //Епископ
            $f = "foto_ep"; //Колонка фотки
                
            $type = 'art_ep'; //колонка статьи
            break;
        case 'pastor': //Пастор
            $f = "foto_past"; //Колонка фотки
            
            $type = 'art_past'; //колонка статьи
            break;
    }
    
    //Если доступен файл
    if (isset($_POST['img_check']) && $_POST['img_check'] == 'YES') //если чекбокс отмечен
    {
        del_img($link, 'church', $f, 1, '../img/', '../img/m/smal_'); //Удаляем изображение с миниатюрой
        
        if (isset($_FILES['foto'])) { //Если файл доступен
            $img = upload_file($_FILES['foto'], 'img/', 500, $link, "img"); //Загружаем фотку
        }
        else $img = ''; //Иначе фото пустое
        
        $t = "UPDATE church SET ".$f."='".$img."'"; //Команда замены изображения
        
        run_command ($link, $t); //Посылаем команду в базу
    }
    
    
    $set = $type."='".$_POST['article']."'"; //строка изменяемых данных для команды обновления статьи
      
    $t = "UPDATE church SET ".$set; //Команда редактирования записи
    
    run_command($link, $t); //Посылаем команду в базу

    header('Location: index.php?page=church');
}

?>


<h2>Редактирование статей в разделе "Церковь"</h2>

<table class="list_back_admin">
    <tbody>
        <tr class="listHead">
            <td><b>Статья</b></td>
        </tr>        
        <tr>
            <td class="list_text_one">
                Начальствующий епископ
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_church&type=episcop"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
        <tr>
            <td class="list_text_one">
                Старший пастор
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_church&type=pastor"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
        <tr>
            <td class="list_text_one">
                Основы вероучения
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_church&type=faith"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
        <tr>
            <td class="list_text_one">
                Процесс обучения
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_church&type=teach"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
        <tr>
            <td class="list_text_one">
                Самая важная молитва
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_church&type=pray"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
    </tbody>
</table>