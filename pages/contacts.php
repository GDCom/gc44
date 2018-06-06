<?php
check_base($link, 'info'); //Проверяем, пустая ли база и добавляем строку, если да

$array = get_table($link, "SELECT map, contacts FROM info"); //Загружаем данные из базы

if (isset($_GET['alert'])) {
    
    switch ($_GET['alert']) {
        case '0':
            $mes = 'Письмо успешно отправлено.';
            break;
        case '1':
            $mes = 'Введен некоректный e-mail.';
            break;
        case '3':
            $mes = 'При отправке произошла ошибка. Письмо не отправлено.';
            break;
    }
    
    echo "<script>alert('".$mes."');</script>";
}

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
                        <h2>Контактные данные:</h2>
                        <?=dapost($array[0]['contacts'])?>
                     </div>
                </td>
                <td></td>
                <td class="contacts">
                    <h2>Напишите нам:</h2>
                    <form action="pages/send_mail.php" method="post">
                        <label>
                            Ваше имя:<br>
                            <input type="text" name="name" class="form-item" required>
                        </label>
                        <label>
                            Ваш e-mail:<br>
                            <input type="email" name="email" class="form-item" required>
                        </label>
                        <label>
                            Сообщение:<br>
                            <textarea name="message" class="form-item-mail" required></textarea>
                        </label>
                        <input type="submit" name="submit" value="Отправить" class="btn">
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>