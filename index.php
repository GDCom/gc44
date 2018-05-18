<?php
require_once('base/database.php');

$link = db_connect();
?>

<!DOCTYPE html>
<html lang="ru">
<html>
	<head>
        <meta charset="utf-8">
		<title>"Церковь Божья" Кострома</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="shortcut icon" href="i/ajax-e.png">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        
        <link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        
        <script src="/js/scripts.js"></script>
        <script src="/js/script_fancy.js"></script>
	</head>
	<body>
        <header>
            <div class="background"><img src="i/header.png"></div>
            <div class="head_main">
                <div class="button">
                    <a href="index.php?page=contacts">Контакты</a>
                    <!--<a href="index.php?page=prayerwall">Молитва</a>-->
                    <a href="index.php?page=media&type=foto">Медиа</a>
                    <a href="index.php?page=ministry&id=0">Служения</a>
                    <a href="index.php?page=news&id=0">Новости</a>
                    <a href="index.php?page=church&id=0">Церковь</a>
                    <a href="index.php">Главная</a>
                </div>

                <a href="index.php"><img src="i/admin-ajax-e.png"></a>
            </div>
        </header>
        <div class="WithMenu">
            <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    
                    switch ($page) {
                        case 'ministry':
                            include("pages/ministry.php");
                            break;
                        case 'news':
                            include("pages/news.php");
                            break;
                        case 'media':
                            include("pages/media.php");
                            break;
                        case 'prayerwall':
                            include("pages/prayerwall.php");
                            break;
                        case 'contacts':
                            include("pages/contacts.php");
                            break;
                        case 'church':
                            include("pages/church.php");
                            break;
                        default:
                            include("pages/main.php");
                            break;
                    }
                }
                else include("pages/main.php");
            ?>
            <a href="#" id="toTop"><img src="../i/up.ico"></a> <!--Кнопка вверх-->
        </div>
        <footer>
            <!--Кнопки поделиться-->
            <table width="100%">
                <tr>
                    <td></td>
                    <td class="share">
                        <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                        <script src="//yastatic.net/share2/share.js"></script>
                        <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,twitter,lj,viber,whatsapp"></div>
                    </td>
                </tr>
            </table>
            
            <div>
                © 2010 - <?=date("Y")?> г. Местная религиозная организация христиан веры евангельской (пятидесятников) "Церковь Божья" г. Костромы, Костромской области. ИНН 4401115856 ОГРН 1134400000525
             </div>
         </footer>
	</body>
</html>