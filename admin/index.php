<?php
require_once("../base/dbconnect.php");
require_once("../base/database.php");

date_default_timezone_set("Europe/Moscow");

$link = db_connect();

$tbl_style = get_table($link, "SELECT style FROM settings"); //Берем информацию о стиле сайта
$style = $tbl_style[0]['style'];

$style_file = 'styles_'.$style.'.css'; //Выбираем файл стилей в зависимости от настроек
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>"Церковь Божья" Кострома</title>
        <link rel="stylesheet" href="../styles.css">
        <link rel="stylesheet" href="../<?=$style_file?>">
        <link rel="shortcut icon" href="../i/gc.png">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="../js/scripts.js"></script>
    </head>
    <body>
        <header>
            <div class="admHead">
                <h4>Административная панель</h4>
            </div>
        </header>
        <div class="WithMenu">
            <div class="Menu">
                <div>
                    <a href="../index.php" class="space">Вернуться на сайт</a>
                    <a href="index.php?page=info">Инфоблоки</a>
                    <a href="index.php?page=church">Церковь</a>
                    <a href="index.php?page=news">Новости</a>
                    <a href="index.php?page=ministry">Служения</a>
                    <a href="index.php?page=media&type=foto">Медиа материалы</a>
                    <!--<a href="index.php?page=prayer">Молитвенная стена</a>-->
                    <a href="index.php?page=settings">Настройки</a>
                    <a href="index.php?page=instructions" class="space">Инструкции</a>
                                        
                    <?php if (isset($_GET['page']) && ($_GET['page'] == 'media' || $_GET['page'] == 'edit_media')) {?>
                    <a href="index.php?page=media&type=foto" class="second">Фото</a>
                    <a href="index.php?page=media&type=video" class="second">Видео</a>
                    <a href="index.php?page=media&type=audio" class="second">Аудио</a>
                    <a href="index.php?page=media&type=albums" class="second"><b>Редактор альбомов</b></a>
                    <?php }?>
                </div>
            </div>
            <div class="cent">
                <div class="content">
                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        switch ($page) {
                            case 'ministry':
                                include("ministry.php");
                                break;
                            case 'news':
                                include("news.php");
                                break;
                            case 'media':
                                include("media.php");
                                break;
                            case 'edit_news':
                                include("edit_news.php");
                                break;
                            case 'edit_ministry':
                                include("edit_ministry.php");
                                break;
                            case 'edit_media':
                                include("edit_media.php");
                                break;
                            case 'church':
                                include("church.php");
                                break;
                            case 'edit_church':
                                include("edit_church.php");
                                break;
                            case 'info':
                                include("info.php");
                                break;
                            case 'edit_info':
                                include("edit_info.php");
                                break;
                            case 'prayer':
                                include("prayer.php");
                                break;
                            case 'settings':
                                include("settings.php");
                                break;
                            case 'instructions':
                                include("instruct.php");
                                break;
                        }
                     }
                    else {
                        include("news.php");
                    } ?>
                    <a href="#" id="toTop"><img src="../i/up.ico"></a> <!--Кнопка вверх-->
                </div>
            </div>
        </div>
        <footer>
            <div class="space"></div>
            <div>
                © 2010 - <?=date("Y")?> г. Местная религиозная организация христиан веры евангельской (пятидесятников) "Церковь Божья" г. Костромы, Костромской области. ИНН 4401115856 ОГРН 1134400000525
             </div>
        </footer>
    </body>
</html>