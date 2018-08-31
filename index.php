<?php
require_once("base/dbconnect.php");
require_once('base/database.php');

date_default_timezone_set("Europe/Moscow");

$link = db_connect();

$tbl_style = get_table($link, "SELECT style FROM settings"); //Берем информацию о стиле сайта
$style = $tbl_style[0]['style'];

switch ($style) { //Выбираем файл стилей в зависимости от настроек
    case gray:
        $style_file = 'styles_gray.css';
        break;
    case background:
        $style_file = 'styles.css';
        break;
    case blue:
        $style_file = 'styles_blue.css';
        break;
    default:
        $style_file = 'styles.css';
        break;
}
?>

<!DOCTYPE html>
<html lang="ru">
<html>
	<head>
        <meta charset="utf-8">
        <meta name="yandex-verification" content="61a6d318bbae3657" />
		<title>"Церковь Божья" Кострома</title>
        <link rel="stylesheet" href="<?=$style_file?>">
        <link rel="shortcut icon" href="i/gc.png">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        
        <link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        
        <script src="/js/scripts.js"></script>
        <script src="/js/script_fancy.js"></script>
        <script>$(function(){$('h3').hyphenate();})</script>
        
        
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter49157065 = new Ya.Metrika2({
                            id:49157065,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/tag.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks2");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/49157065" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
	</head>
	<body>
        <header>
            <?php if($style == 'background') { ?>
            <div class="background"><img src="i/header.png"></div>
            <?php } ?>
            <div class="head_main">
                <div class="button">
                    <a href="index.php?page=contacts" title="Контакты">
                        <div class="top_menu">
                            <div class="top_menu1">
                                <img src="i/contacts.png">
                            </div>
                            <div class="top_menu2">
                                Контакты
                            </div>
                        </div>
                    </a>
                    <!--<a href="index.php?page=prayerwall">Молитва</a>-->
                    <a href="index.php?page=media&type=foto" title="Медиаматериалы">
                        <div class="top_menu">
                            <div class="top_menu1">
                                <img src="i/media.png">
                            </div>
                            <div class="top_menu2">
                                Медиа
                            </div>
                        </div>
                    </a>
                    <a href="index.php?page=ministry&id=0" title="Служения">
                        <div class="top_menu">
                            <div class="top_menu1">
                                <img src="i/ministry.png">
                            </div>
                            <div class="top_menu2">
                                Служения
                            </div>
                        </div>
                    </a>
                    <a href="index.php?page=news&id=0" title="Новости">
                        <div class="top_menu">
                            <div class="top_menu1">
                                <img src="i/news.png">
                            </div>
                            <div class="top_menu2">
                                Новости
                            </div>
                        </div>
                    </a>
                    <a href="index.php?page=church&id=0" title="Церковь">
                        <div class="top_menu">
                            <div class="top_menu1">
                                <img src="i/church.png">
                            </div>
                            <div class="top_menu2">
                                Церковь
                            </div>
                        </div>
                    </a>
                    <a href="index.php" title="Главная">
                        <div class="top_menu">
                            <div class="top_menu1">
                                <img src="i/home.png">
                            </div>
                            <div class="top_menu2">
                                Главная
                            </div>
                        </div>
                    </a>
                </div>

                <a href="index.php" class="main_img"><img src="i/admin-ajax-e.png"></a>
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
                    <td>
                        <!-- Yandex.Metrika informer -->
                        <a href="https://metrika.yandex.ru/stat/?id=49157065&amp;from=informer"
                        target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/49157065/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                        style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="49157065" data-lang="ru" /></a>
                        <!-- /Yandex.Metrika informer -->
                    </td>
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