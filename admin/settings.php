<?php

if (isset($_POST['adm_alb'])) { //Если есть данные для изменения
    $tbl = get_table($link, "SELECT * FROM settings"); //Берем информацию о настройках из базы
    
    if ($tbl != NULL) { //Если запись уже есть
        $cmd = "UPDATE settings SET adm_alb='".$_POST['adm_alb']."', adm_foto='".$_POST['adm_foto']."', adm_video='".$_POST['adm_video']."', adm_audio='".$_POST['adm_audio']."', adm_news='".$_POST['adm_news']."', adm_ministry='".$_POST['adm_ministry']."', main_alb='".$_POST['main_alb']."', main_foto='".$_POST['main_foto']."', main_video='".$_POST['main_video']."', main_audio='".$_POST['main_audio']."', main_news='".$_POST['main_news']."', main_ministry='".$_POST['main_ministry']."'";
        
        run_command($link, $cmd); //Обновляем
    }
    else { //если нет
        $cmd = "INSERT INTO settings (adm_alb, adm_foto, adm_video, adm_audio, adm_news, adm_ministry, main_alb, main_foto, main_video, main_audio, main_news, main_ministry) VALUES (".$_POST['adm_alb'].", ".$_POST['adm_foto'].", ".$_POST['adm_video'].", ".$_POST['adm_audio'].", ".$_POST['adm_news'].", ".$_POST['adm_ministry'].", ".$_POST['main_alb'].", ".$_POST['main_foto'].", ".$_POST['main_video'].", ".$_POST['main_audio'].", ".$_POST['main_news'].", ".$_POST['main_ministry'].")";
        
        run_command($link, $cmd); //Добавляем запись
    }
}

$tbl = get_table($link, "SELECT * FROM settings"); //Берем информацию о настройках из базы

if ($tbl != NULL) { //Если запись уже есть
    //Заносим данные в переменные
    $adm_alb = $tbl[0]['adm_alb'];
    $adm_foto = $tbl[0]['adm_foto'];
    $adm_video = $tbl[0]['adm_video'];
    $adm_audio = $tbl[0]['adm_audio'];
    $adm_news = $tbl[0]['adm_news'];
    $adm_ministry = $tbl[0]['adm_ministry'];
    
    $main_alb = $tbl[0]['main_alb'];
    $main_foto = $tbl[0]['main_foto'];
    $main_video = $tbl[0]['main_video'];
    $main_audio = $tbl[0]['main_audio'];
    $main_news = $tbl[0]['main_news'];
    $main_ministry = $tbl[0]['main_ministry'];
}
else { //Иначе Значения по умолчанию
    $adm_alb = 30;
    $adm_foto = 30;
    $adm_video = 30;
    $adm_audio = 30;
    $adm_news = 30;
    $adm_ministry = 30;
    
    $main_alb = 30;
    $main_foto = 30;
    $main_video = 15;
    $main_audio = 30;
    $main_news = 15;
    $main_ministry = 15;
}

?>

<h2>Настройки</h2>

<div>
    <form method="post" action="index.php?page=settings" enctype="multipart/form-data">
        <table class="list_back_admin">
            <tbody>
                <tr class="listHead">
                    <td>
                        <b>Настройки сайта</b>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество альбомов на странице в разделе "Медиа материалы"
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="main_alb" value="<?=$main_alb?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество фотографий на странице в альбоме медиа
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="main_foto" value="<?=$main_foto?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество видео на странице в альбоме медиа
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="main_video" value="<?=$main_video?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество аудиозаписей на странице в альбоме медиа
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="main_audio" value="<?=$main_audio?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество новостей на странице
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="main_news" value="<?=$main_news?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество служений на странице
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="main_ministry" value="<?=$main_ministry?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="space"></div>
        <table class="list_back_admin">
            <tbody>
                <tr class="listHead">
                    <td>
                        <b>Настройки административной панели</b>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество альбомов на странице в разделе "Медиа материалы"
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="adm_alb" value="<?=$adm_alb?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество фотографий на странице в альбоме медиа
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="adm_foto" value="<?=$adm_foto?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество видео на странице в альбоме медиа
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="adm_video" value="<?=$adm_video?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество аудиозаписей на странице в альбоме медиа
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="adm_audio" value="<?=$adm_audio?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество новостей на странице
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="adm_news" value="<?=$adm_news?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="list_text_one">
                        Количество служений на странице
                    </td>
                    <td class="list_but">
                        <label>
                            <input type="text" name="adm_ministry" value="<?=$adm_ministry?>" class="form-item" autofocus required>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="space"></div>
        <input type="submit" value="Сохранить" class="btn">
    </form>
</div>