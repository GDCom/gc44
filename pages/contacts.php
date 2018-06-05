<?php
check_base($link, 'info'); //Проверяем, пустая ли база и добавляем строку, если да

$array = get_table($link, "SELECT map, contacts FROM info"); //Загружаем данные из базы

?>

<div class="cent">
    <div class="content">
        <h1>Контакты</h1>
        <!--Карта-->
        <?=dapost($array[0]['map'])?>
        <br><br>
        <table>
            <tr>
                <td class="contacts">
                    <div>
                        <?=dapost($array[0]['contacts'])?>
                     </div>
                </td>
                <td width="50%"></td>
            </tr>
        </table>
    </div>
</div>