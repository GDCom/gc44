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
    case blue:
        $style_file = 'styles_blue.css';
        break;
    case background:
        $style_file = 'styles_fon.css';
        break;
    default:
        $style_file = 'styles_fon.css';
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
        <link rel="stylesheet" href="styles.css">
        
        <link rel="shortcut icon" href="i/gc.png">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        
        <link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        
        <script src="/js/scripts.js"></script>
        <script src="/js/script_fancy.js"></script>
        <script>$(function(){$('.Text').hyphenate();})</script>
        
        
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
        <!-- Yandex.Metrika counter -->
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
                            <div class="top_menu2">
                                Контакты
                            </div>
                            <div class="top_menu1">
                                <img src="i/contacts.png">
                            </div>
                        </div>
                    </a>
                    <!--<a href="index.php?page=prayerwall">Молитва</a>-->
                    <a href="index.php?page=media&type=foto" title="Медиаматериалы">
                        <div class="top_menu">
                            <div class="top_menu2">
                                Медиа
                            </div>
                            <div class="top_menu1">
                                <img src="i/media.png">
                            </div>
                        </div>
                    </a>
                    <a href="index.php?page=ministry&id=0" title="Служения">
                        <div class="top_menu">
                            <div class="top_menu2">
                                Служения
                            </div>
                            <div class="top_menu1">
                                <img src="i/ministry.png">
                            </div>
                        </div>
                    </a>
                    <a href="index.php?page=news&id=0" title="Новости">
                        <div class="top_menu">
                            <div class="top_menu2">
                                Новости
                            </div>
                            <div class="top_menu1">
                                <img src="i/news.png">
                            </div>
                        </div>
                    </a>
                    <a href="index.php?page=church&id=0" title="Церковь">
                        <div class="top_menu">
                            <div class="top_menu2">
                                Церковь
                            </div>
                            <div class="top_menu1">
                                <img src="i/church.png">
                            </div>
                        </div>
                    </a>
                    <a href="index.php" title="Главная">
                        <div class="top_menu">
                            <div class="top_menu2">
                                Главная
                            </div>
                            <div class="top_menu1">
                                <img src="i/home.png">
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="Head_img">
                    <div class="Head_img2">
                        <a href="index.php" class="main_img"><img src="i/admin-ajax-e.png"></a>
                    </div>
                </div>
                
                <div class="search">
                    <div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'http://gc44.ru/index.php?page=result','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по сайту gc44','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2329906,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'поиск','input_placeholderColor':'#818181','input_borderColor':'#7f9db9'}"><form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8"><input type="hidden" name="searchid" value="2329906"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="search" name="text" value=""/><input type="submit" value="Найти"/></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
                </div>
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
                        case 'pers_dat':
                            include("pages/pers_dat.php");
                            break;
                        case 'result':
                            include("pages/result.php");
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
                <a href="index.php?page=pers_dat" >Политика в отношении обработки персональных данных</a>
            </div>
            <div>
                © 2010 - <?=date("Y")?> г. Местная религиозная организация христиан веры евангельской (пятидесятников) "Церковь Божья" г. Костромы, Костромской области. ИНН 4401115856 ОГРН 1134400000525
            </div>
         </footer>
	</body>
</html>