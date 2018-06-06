<?php
if (isset($_GET['type']) && isset($_POST['article'])) { //Если переменная типа блока и передаваемая информация по блоку доступны
    $type = $_GET['type'];
    
    run_command($link, "UPDATE info SET ".$type."='".apost($_POST['article'])."'"); //Обновляем данные в базе
    
    header('Location: index.php?page=info'); //Очищаем строку адреса от лишнего
}


?>


<h2>Редактирование основных блоков информации на сайте</h2>

<table class="list_back_admin">
    <tbody>
        <tr class="listHead">
            <td><b>Блок</b></td>
        </tr>
        <tr>
            <td class="list_text_one">
                Социальная концепция
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_info&type=concept"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
        <tr>
            <td class="list_text_one">
                Богослужения
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_info&type=service"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
        <tr>
            <td class="list_text_one">
                Контактные данные
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_info&type=contacts"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
        <tr>
            <td class="list_text_one">
                Карта
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_info&type=map"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
        <tr>
            <td class="list_text_one">
                Напишите нам
            </td>
            <td class="list_but">
                <a href="index.php?page=edit_info&type=mailus"><img src="../i/edit.ico" title="Редактировать"></a>
            </td>
        </tr>
    </tbody>
</table>