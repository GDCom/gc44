<?php
require_once("base/dbconnect.php");
require_once('base/database.php');

date_default_timezone_set("Europe/Moscow");

$link = db_connect();

$tbl_style = get_table($link, "SELECT style FROM settings"); //Берем информацию о стиле сайта
$style = $tbl_style[0]['style'];

$style_file = 'styles_'.$style.'.css'; //Выбираем файл стилей в зависимости от настроек

if (isset($_GET['page'])) { //Если доступен параметр page
    $page = $_GET['page'];
    $page_name = 'Главная';
}
else { //Иначе
    $page = '';
    $page_name = '';
}

$tbl_ministry = get_table($link, "SELECT title, id FROM ministry"); //Делаем выборку названий служений

switch ($page) {
    case 'church':
        $name1 = '\Церковь'; //Название ссылки
        $link_name = 'article'; //имя ссылки
        
        if (isset($_GET['article'])) { //Если доступен параметр статья
            $link2 = $_GET['article']; //Ссылка второго уровня на статью
            switch ($link2) {
                case 'episcop':
                    $name2 = "\Начальствующий епископ";
                    break;
                case 'pastor':
                    $name2 = "\Старший пастор";
                    break;
                case 'faith':
                    $name2 = "\Основы вероучения";
                    break;
                case 'teaching':
                    $name2 = "\Процесс обучения";
                    break;
                case 'prayer':
                    $name2 = "\Самая важная молитва";
                    break;
                case 'bible':
                    $name2 = "\Библия";
                    break;
            }
        }
        else { //Иначе ссылка второго уровня на первую статью о епископе
            $link2 = "episcop";
            $name2 = "\Начальствующий епископ";
        }
        
        break;
    case 'news':
    case 'ministry':
        if ($page == 'news') $name1 = '\Новости'; //Для новостей
        else $name1 = '\Служения'; //Для служения
        
        $link_name = 'id';
        
        $id = $_GET['id'];
        if ($id != 0) { //Если id не равен нулю
            $tbl = get_table($link, "SELECT title FROM ".$page." WHERE id='".$id."'");
            $name2 = '&#092;'.$tbl[0]['title'];
        }
        
        break;
    case 'media':
        $name1 = '\Медиаматериалы';
        $link_name = 'type';
        $link_name2 = 'album';
        
        $link2 = $_GET['type'];
        switch ($link2) {
            case 'foto':
            default:
                $name2 = '\Фотографии';
                break;
            case 'video':
                $name2 = '\Видеозаписи';
                break;
            case 'audio':
                $name2 = '\Аудиозаписи';
                break;
        }
        
        if (isset($_GET['album'])) {
            $name3 = '&#092;'.$_GET['album'];
            $pa_link = $_GET['pa'];
            $link3 = apost($_GET['album']).'&pa='.$pa_link;
        }
        
        break;
    case 'contacts':
        $name1 = '\Контакты';
        $link_name = 'contacts';
        break;
    default:
        $page = '';
        $page_name = '';
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
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="<?=$style_file?>">
        
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
            <div class="head_main">
                <div class="Head_img">
                    <a href="index.php" class="main_img">
                        <svg class="logo_svg" id="logo_svg" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 595.3 595.3" xml:space="preserve">
                            <path xmlns="http://www.w3.org/2000/svg" id="logo" class="st0" d="M521.5,457c-31.3-1.5-58.6,0.4-83.9,5.1c-47.2,8.9-89.9,33.7-116.9,49.6      c-21.2-18.3-37.3-27.6-72.4-39.8c-51.3-17.8-102.9-19.6-171.4-10.3v0c50.1,67.4,130.3,111,220.8,110.9      C390,572.6,471.7,526.9,521.5,457z M502.1,188.6c4.8-3.2,9.9-6.4,15.2-9.7c0.2-0.1,0.4-0.3,0.6-0.4c-7.6-14-16.6-27.4-27.1-40.1      c-88-106.8-246-122-352.8-34C39.7,185.5,19,325.8,85,430.9c7.9,0,15.6,0.1,23.2,0.4C38.6,333.1,55.7,196.4,150,118.7      c98.8-81.4,244.9-67.4,326.3,31.4C486.4,162.3,495,175.2,502.1,188.6z M164.3,244.8c6.4,1.9,16.2,3.3,26.6,13.3      c13.7,13.2,16.7,29.5,15.1,47.1c-2,21.6-7.2,63.4,5.5,90.8c23.1,49.8,77.1,51.8,111.7,104.7c1.4-44,8.4-93.1,38.4-153.7      c6.6-13.3,15.6-27.3,24.7-41.8c0,0-24.8-1.5-53.8-23.9c-31.3-24.2-40.2-43.6-77-84.9c-10.1-11.4-27.1-25.5-52.8-18.3      c-14.9,4.2-25.2,18.1-27.3,39.3C173.8,233.3,168.5,241.1,164.3,244.8z M78.2,431c-65.4-107.3-43.7-249.1,56-331.3      c109.3-90.1,271-74.6,361.2,34.8c10.7,13,19.9,26.7,27.7,41c5-3,10.2-6.1,15.7-9.2c-8.2-15-18-29.5-29.3-43.2      C413,6,239.8-10.7,122.7,85.8C18.6,171.6-6.1,317.9,57.4,431.6h0C64.4,431.3,71.3,431.1,78.2,431z M156.7,246.7      c3.8-3.1,12.2-10.8,11.9-32c-0.4-25.7,6.5-47.5,32.2-56.3c18.9-6.5,40.1-2.7,56.9,10.8c27.8,22.3,49.1,65.4,71.8,88.5      c34.7,35.4,61.1,41.2,61.1,41.2c9.3-13.1,20-26.9,30.6-39.3c18.7-22,40.2-43.4,76-67.7c-7-13.2-15.4-25.9-25.3-37.8      c-79.4-96.3-221.8-110-318.2-30.7c-93.1,76.7-109,212.3-38.4,308.3c22.7,1.1,43.8,3.6,62.8,7.2c60.8,11.6,109.1,35.2,136.2,59.8      c-4.8-5.7-9.5-11.3-21.2-19.2c-27.8-19-57.4-30.1-80.2-53.5c-26.6-27.3-32.1-59.4-26.8-94c4-26.1,7.9-44.2,3.2-59.4      C184,255.2,162.4,249,156.7,246.7z M297.6,3.3c162.9,0,295,132.1,295,295c0,162.9-132.1,295-295,295c-162.9,0-295-132.1-295-295      C2.7,135.4,134.7,3.3,297.6,3.3z M563.2,368.1c4.9-18.4,7.8-37.5,8.8-57.3c-111.7,38.3-181.1,73.5-237.1,178.8      C374.4,450.3,422.2,396.7,563.2,368.1z M571.1,272.3c-2.2-24.1-7.7-48.1-16.3-71.2c-33.5,20.8-66.5,44.1-98.7,73.7      c-58.9,54.4-118.8,135.6-126.6,212.7c17.9-40.6,42-74.7,63.1-98C441.1,335.9,494,302.8,571.1,272.3z M552.3,400.8L552.3,400.8      c-111.3,14.1-165.9,47.2-212.8,92.6c54.4-35.9,122.8-57.8,198.2-62l0-0.2C543.3,421.4,548,411.5,552.3,400.8z"/>
                        </svg>
                    </a>
                </div>
                
                <div class="head_block">
                    <div class="button">
                        <div class="button_link">
                            <div class="top_menu">
                                <a href="index.php?page=contacts" title="Контакты">
                                    <div class="top_menu2">
                                        Контакты
                                    </div>
                                    <div class="top_menu1">
                                        <img src="i/contacts.png" class="btn_img">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="button_link">
                            <div class="top_menu">
                                <a href="index.php?page=media&type=foto" title="Медиаматериалы">
                                    <div class="top_menu2">
                                        Медиа
                                    </div>
                                    <div class="top_menu1">
                                        <img src="i/media.png" class="btn_img">
                                    </div>
                                </a>
                            </div>
                            <div class="top_menu3">
                                <div><a href="index.php?page=media&type=foto">Фотоматериалы</a></div>
                                <div><a href="index.php?page=media&type=video">Видеоматериалы</a></div>
                                <div><a href="index.php?page=media&type=audio">Аудиоматериалы</a></div>
                            </div>
                        </div>
                        <div class="button_link">
                            <div class="top_menu">
                                <a href="index.php?page=ministry&id=0" title="Служения">
                                    <div class="top_menu2">
                                        Служения
                                    </div>
                                    <div class="top_menu1">
                                        <img src="i/ministry.png" class="btn_img">
                                    </div>
                                </a>
                            </div>
                            <div class="top_menu3">
                                <?php foreach($tbl_ministry as $a): //Для каждого наименования служения ?>
                                <div>
                                    <a href="index.php?page=ministry&id=<?=$a["id"]?>"><?=$a['title']?></a>
                                </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="button_link">
                            <div class="top_menu">
                                <a href="index.php?page=news&id=0" title="Новости">
                                    <div class="top_menu2">
                                        Новости
                                    </div>
                                    <div class="top_menu1">
                                        <img src="i/news.png" class="btn_img">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="button_link">
                            <div class="top_menu">
                                <a href="index.php?page=church&id=0" title="Церковь">
                                    <div class="top_menu2">
                                        Церковь
                                    </div>
                                    <div class="top_menu1">
                                        <img src="i/church.png" class="btn_img">
                                    </div>
                                </a>
                            </div>
                            <div class="top_menu3">
                                <div><a href="index.php?page=church&article=episcop">Начальствующий епископ</a></div>
                                <div><a href="index.php?page=church&article=pastor">Старший пастор</a></div>
                                <div><a href="index.php?page=church&article=faith">Основы вероучения</a></div>
                                <div><a href="index.php?page=church&article=teaching">Процесс обучения</a></div>
                                <div><a href="index.php?page=church&article=prayer">Самая важная молитва</a></div>
                                <div><a href="index.php?page=church&article=bible">Библия</a></div>
                            </div>
                        </div>
                        <div class="button_link">
                            <div class="top_menu">
                                <a href="index.php" title="Главная">
                                    <div class="top_menu2">
                                        Главная
                                    </div>
                                    <div class="top_menu1">
                                        <img src="i/home.png" class="btn_img">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mine_name">
                        <svg class="name_svg" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="470px" height="336px" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                         viewBox="0 0 841.9 595.3" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path id="XMLID_113_" class="st0" d="M200.4,244.8l-24.9,0.1c0-1.7,0-6,0-8.1l-3.2-7.4H86.2V121.9c0-1.1-0.1-2.4-0.2-3.9h25.7
                            c-0.1,1.4-0.2,2.7-0.2,3.9v85.2H165v-85.4c0-1-0.1-2.3-0.3-3.7h25.9c-0.1,1.3-0.2,2.6-0.2,3.7v85.4l0,0l10,22.3
                            C200.4,234,200.4,242.6,200.4,244.8z M293.6,229.4h-82.1c-1.9-3.8-4.3-8.9-5.7-11.9v-95.8c0-0.9-0.2-2.2-0.5-3.7h85.4v23.7
                            c-1.5-0.2-3.2-0.3-4.9-0.3h-54.4v17.4h45.5v23.7h-45.5v23.3h57c1.1,0,3-0.1,5.2-0.3V229.4z M391.3,151.9c0,9.9-3.9,18.1-11.6,24.8
                            c-7.3,6.2-16,9.2-26.2,9.2h-23v39.9c0,1.1,0.1,2.3,0.2,3.5h-26c0.1-1.3,0.2-2.6,0.2-3.7v-104c0-1-0.1-2.3-0.2-3.7h49.2
                            c10.2,0,18.8,3.1,26,9.2C387.5,133.9,391.3,142.1,391.3,151.9z M363.5,151.5c0-3.7-1.2-6.7-3.7-8.9c-2.7-2.2-5.9-3.2-9.6-3.2
                            h-19.6v24.2h19.6c3.7,0,6.9-1.1,9.6-3.4C362.2,157.9,363.5,155,363.5,151.5z M399.7,249.4V121.7c0-1-0.1-2.3-0.2-3.7h27.3
                            c0,1.4,0,2.7,0,3.9v36.4c11.4-1.3,20.3-6.6,26.7-15.7c4.4-6.5,6.6-13.3,6.6-20.3c0-1.1-0.1-2.5-0.2-4.2h28.5
                            c-0.7,8.1-2.6,16-5.5,23.7c-4.8,12.6-11.9,22.6-21.1,29.9c0,0,30.2,24.4,30.1,73.2 M591.6,173.7c0,18-4.3,32.2-12.8,42.5
                            c-9.1,10.8-22,16.2-38.7,16.2c-16.7,0-29.5-5.4-38.5-16.2c-8.5-10.4-12.8-24.5-12.8-42.5c0-18,4.3-32.1,12.8-42.4
                            c9-10.8,21.8-16.2,38.5-16.2c16.7,0,29.6,5.4,38.7,16.2C587.4,141.6,591.6,155.7,591.6,173.7z M565.9,173.4c0-9.4-2-17.8-6.1-25
                            c-4.7-8.7-11.3-13.1-19.6-13.1c-8.2,0-14.7,4.4-19.3,13.1c-4.1,7.2-6.1,15.5-6.1,25c0,9.3,2,17.7,6.1,25.1
                            c4.7,8.8,11.1,13.3,19.3,13.3c8.3,0,14.9-4.4,19.6-13.3C563.9,191.1,565.9,182.7,565.9,173.4z M681.2,200.2c0,9-2.8,16.1-8.5,21.3
                            c-5.8,5.3-13.2,8-22.2,8h-48.8c0.1-1.3,0.2-2.6,0.2-3.7v-104c0-0.9-0.1-2.2-0.2-3.7h38.3c10.3,0,18.8,2,25.7,5.9
                            c8.4,4.8,12.6,12,12.6,21.4c0,6.3-1.5,11.4-4.6,15.4c-2.8,3.6-7,7.1-12.8,10.5C674.5,178.1,681.2,187.7,681.2,200.2z M651.2,150.1
                            c0-3.4-1.6-6.2-4.8-8.3c-2.7-1.8-5.8-2.8-9.2-2.8h-10.3v22.2h9.8c3.8,0,7-0.9,9.7-2.8C649.6,156.3,651.2,153.5,651.2,150.1z
                             M655.6,195.1c0-3.7-1.5-6.8-4.5-9.2c-3.2-2.6-6.7-3.9-10.6-3.9l-13.7-0.2v26.5h13.7c3.9,0,7.4-1.1,10.6-3.4
                            C654.1,202.5,655.6,199.2,655.6,195.1z M772,192c0,12.5-3.7,22-11.1,28.4c-6.8,6.1-16.4,9.1-28.8,9.1h-43.5
                            c0.1-1.2,0.2-2.5,0.2-3.7v-104c0-1.1-0.1-2.4-0.2-3.7h26.8c-0.2,1.4-0.3,2.7-0.3,3.7v36.5h12.4c12.1,0,22.2,2.5,30.2,7.5
                            C767.2,171.9,772,180.6,772,192z M746.9,192.9c0-4.7-2.5-8.2-7.5-10.3c-3.4-1.7-7.9-2.6-13.4-2.6h-10.8v27.3h13.3
                            C740.7,207.3,746.9,202.5,746.9,192.9z M197.6,335.6c0,15.3-4.4,26.9-13.2,34.8c-8.7,7.4-20.6,11.2-35.8,11.2H86
                            c0.1-1.4,0.2-2.9,0.2-4.5V249.4c0-1.4-0.1-2.9-0.2-4.5h114.4V270c-2,0-6.7,0-8.4,0h-73.7v24.2h24.3c14.9,0,27.3,3,37.3,9.1
                            C191.6,310.7,197.4,321.5,197.6,335.6z M166.7,336.8c0-5.8-3.3-10-9.8-12.7c-4.5-2.1-10.2-3.2-16.8-3.2h-21.7v33.5H144
                            C159.1,354.4,166.7,348.5,166.7,336.8z M335.4,313.1c0,22.1-5.4,39.5-16.1,52.2c-11.5,13.2-27.7,19.9-48.7,19.9
                            c-21,0-37.1-6.6-48.5-19.9c-10.7-12.7-16.1-30.1-16.1-52.2c0-22.1,5.4-39.4,16.1-52c11.3-13.2,27.5-19.9,48.5-19.9
                            c21,0,37.2,6.6,48.7,19.9C330,273.7,335.4,291.1,335.4,313.1z M303,312.8c0-11.6-2.6-21.8-7.7-30.7c-6-10.7-14.2-16.1-24.7-16.1
                            c-10.4,0-18.5,5.4-24.3,16.1c-5.1,8.8-7.7,19.1-7.7,30.7c0,11.5,2.6,21.8,7.7,30.8c5.9,10.9,14,16.3,24.3,16.3
                            c10.5,0,18.7-5.4,24.7-16.3C300.4,334.5,303,324.2,303,312.8z M491.9,244.8c-0.4,10.3-2.1,20.1-5.1,29.1
                            c-5,15.3-13.2,27.5-24.6,36.7l38,71h-35.8c-0.5-2.4-1.1-4.4-1.9-6.1l-25-53.6c-3.3,0.9-6.9,1.7-10.8,2.5v52.6
                            c0,1.4,0.1,2.9,0.2,4.5h-27.5c0.1-1.5,0.2-3,0.2-4.5v-52.8c-4.3-0.9-7.9-1.6-11-2.3L364.1,376c-1,1.9-1.6,3.8-1.9,5.7h-36l38-71
                            c-11-9-19.1-21.2-24.4-36.7c-3.2-9.5-4.9-19.2-5.3-29.1h34.6c-0.1,1.1-0.1,2.5,0,4.2c2,25.9,12.2,40.9,30.5,45.2v-44.8
                             M627.1,335.6c0,15.4-4.5,27-13.6,34.8c-8.3,7.4-20.1,11.2-35.4,11.2H513c0.1-1.5,0.2-3,0.2-4.5V249.4c0-1.4-0.1-2.9-0.2-4.5H546
                            c-0.3,1.8-0.4,3.3-0.4,4.5v44.8h26.9c14.9,0,27.2,3.1,37.1,9.3C621.3,310.9,627.1,321.6,627.1,335.6z M596.3,336.8
                            c0-5.8-3.1-10-9.3-12.7c-4.2-2.1-9.7-3.2-16.5-3.2h-25v33.5h28C588.7,354.4,596.3,348.5,596.3,336.8z M743.4,381.8h-32.2
                            c0.1-1.6,0.2-3.2,0.2-4.7v-48.8h-20.1l-25,47.7c-1,1.8-1.8,3.7-2.3,5.9h-38.4l33.7-56.4c-8.7-3.5-15.7-8.5-21-14.9
                            c-5.8-7.1-8.7-15.1-8.7-24c0-12,4.7-22,14-30.1c9-7.7,19.5-11.5,31.6-11.5h68.1c-0.1,1.6-0.2,3.2-0.2,4.7v127.5
                            C743.2,378.6,743.2,380.2,743.4,381.8z M711.6,300.6v-29.5h-29.3c-4.5,0-8.4,1.3-11.5,4c-3.2,2.8-4.7,6.4-4.7,10.8
                            c0,4.2,1.6,7.7,4.7,10.6c3.3,2.8,7.1,4.2,11.5,4.2H711.6z M156.5,481.6h-24.1c-0.2-1.3-0.6-2.5-1.2-3.7l-15.5-33.7l-10.4,1.5v33
                            c0,0.9,0,1.8,0,2.9H86c0.1-1,0.1-2,0.1-2.9v-80.5c0-0.8,0-1.7-0.1-2.9h19.3c0,1.1,0,2.1,0,3v28.1c8.8-1,15.7-5.1,20.6-12.2
                            c3.4-5,5.1-10.3,5.1-15.7c0-0.9,0-1.9-0.1-3.2H153c-0.6,6.3-2,12.4-4.3,18.4c-3.7,9.8-9.2,17.5-16.3,23.1L156.5,481.6z
                             M236.5,438.5c0,13.9-3.5,24.9-10.5,32.9c-7.5,8.3-18,12.5-31.7,12.5c-13.7,0-24.2-4.2-31.6-12.5c-7-8-10.5-19-10.5-32.9
                            c0-13.9,3.5-24.8,10.5-32.8c7.4-8.3,17.9-12.5,31.6-12.5c13.7,0,24.2,4.2,31.7,12.5C233,413.7,236.5,424.6,236.5,438.5z
                             M215.4,438.3c0-7.3-1.7-13.7-5-19.3c-3.9-6.8-9.3-10.1-16.1-10.1c-6.8,0-12,3.4-15.9,10.1c-3.3,5.6-5,12-5,19.3
                            c0,7.2,1.7,13.7,5,19.4c3.8,6.8,9.1,10.3,15.9,10.3c6.8,0,12.2-3.4,16.1-10.3C213.8,452,215.4,445.5,215.4,438.3z M323.3,454.6
                            c-5.2,19.6-18,29.4-38.6,29.4c-12.9,0-23-4.4-30.5-13.1c-6.9-8.3-10.4-19.2-10.4-32.4c0-13.1,3.5-23.8,10.4-32.2
                            c7.5-8.7,17.6-13.1,30.5-13.1c18.1,0,30.7,8.7,37.8,26.1h-25c-1.8-5.8-6.1-8.7-12.8-8.7c-6.7,0-11.8,3.2-15.3,9.5
                            c-2.8,5.1-4.2,11.2-4.2,18.4c0,7.3,1.4,13.5,4.2,18.7c3.5,6.2,8.6,9.3,15.3,9.3c8.3,0,13.4-4,15.3-11.9H323.3z M396.8,414.9
                            c-1.4-0.4-2.9-0.6-4.8-0.6h-20.5v64.5c0,0.9,0.1,1.8,0.4,2.9h-21.3c0.1-1,0.1-1.9,0.1-2.7v-64.6H330c-2.4-5.2-4.6-9.9-4.6-9.9
                            v-8.9h71.3V414.9z M474.7,421.7c0,7.6-3,14-8.9,19.2c-5.6,4.8-12.4,7.2-20.3,7.2h-17.8v30.9c0,0.9,0,1.8,0.1,2.7h-20.1
                            c0.1-1,0.1-2,0.1-2.9v-80.5c0-0.8,0-1.7-0.1-2.9h38c7.9,0,14.6,2.4,20.1,7.2C471.8,407.7,474.7,414.1,474.7,421.7z M453.1,421.3
                            c0-2.9-1-5.2-2.9-6.9c-2.1-1.7-4.5-2.5-7.4-2.5h-15.1v18.7h15.1c2.9,0,5.3-0.9,7.4-2.6C452.2,426.3,453.1,424,453.1,421.3z
                             M565.7,438.5c0,13.9-3.5,24.9-10.5,32.9c-7.5,8.3-18,12.5-31.7,12.5c-13.7,0-24.2-4.2-31.6-12.5c-7-8-10.5-19-10.5-32.9
                            c0-13.9,3.5-24.8,10.5-32.8c7.4-8.3,17.9-12.5,31.6-12.5c13.7,0,24.2,4.2,31.7,12.5C562.2,413.7,565.7,424.6,565.7,438.5z
                             M544.6,438.3c0-7.3-1.7-13.7-5-19.3c-3.9-6.8-9.3-10.1-16.1-10.1c-6.8,0-12,3.4-15.9,10.1c-3.3,5.6-5,12-5,19.3
                            c0,7.2,1.7,13.7,5,19.4c3.8,6.8,9.1,10.3,15.9,10.3c6.8,0,12.2-3.4,16.1-10.3C542.9,452,544.6,445.5,544.6,438.3z M677.3,481.6
                            h-21.3c0-1-0.1-2-0.4-3.2l-8.5-41.6L634,481.6h-21.2l-13.4-45.9l-8.5,42.7c-0.2,0.8-0.2,1.9-0.2,3.2h-21.5l18.1-85.8h20.1
                            l15.7,51.5l15.7-51.5h19.9L677.3,481.6z M764.3,481.6H742c-0.2-1-0.4-2.2-0.7-3.5l-4.4-11.9h-32.4l-4.5,11.8
                            c-0.4,1.4-0.6,2.5-0.7,3.6h-12.3l-3.7-15.8l27.7-70.3h19.5L764.3,481.6z M730.1,447.7l-9.3-24.9l-9.5,24.9H730.1z M423.3,214.9
                            c-0.2,1.3-0.2,2.6-0.3,3.6c0,0.2,0,1.3,0.1,2.7c0.1,1.8,0.2,2.1,0.2,3.8c0,1,0,1.7,0,2.5c-0.1,1.5-0.1,1.3-0.3,3.6
                            c-0.1,1.1-0.1,1.5-0.3,2.1c-0.2,0.5-0.5,1.2-1.2,1.7c-0.6,0.4-1.2,0.5-2.1,0.7c-0.8,0.2-0.8,0.1-1.8,0.3c-1.1,0.2-1.8,0.3-2.4,0.7
                            c-0.6,0.4-0.9,0.8-1,0.9c-0.3,0.4-0.4,0.7-0.5,1.2c-0.2,0.6-0.2,1-0.2,1.5c-0.1,0.7-0.1,1,0,1.3c0.2,0.6,0.8,0.9,1.1,1.2
                            c0.6,0.4,1.2,0.5,1.8,0.7c0.3,0.1,0.3,0.1,1.7,0.3c1.2,0.2,1.4,0.2,1.6,0.3c0.8,0.2,1.2,0.3,1.6,0.5c0.6,0.4,0.9,0.8,1,1.1
                            c0.1,0.2,0.3,0.5,0.5,1.4c0.2,0.7,0.2,1.1,0.3,1.8c0.1,1.5,0,3-0.1,4.8c-0.1,2.2-0.1,2-0.2,4.4c-0.1,1-0.1,1.7-0.1,2.8
                            c0,1.6,0,2.4,0,2.8c0.1,0.9,0.2,1.6,0.3,2.2c0.3,1.7,0.7,3,1.1,4.4c0.5,1.7,0.6,1.7,0.9,2.8c0.4,1.4,0.5,2.6,0.6,3.1
                            c0.1,1.3,0.1,2.3,0.1,3.6c0,0.9,0,1.9-0.2,3.2c-0.2,1.5-0.4,2.7-0.5,3.2c-0.2,0.9-0.4,1.5-0.6,2.1c-0.2,0.5-0.4,1.5-0.9,2.6
                            c-0.2,0.6-0.7,1.6-1.5,3.5c-0.4,0.9-0.5,1.1-0.7,1.5c-0.3,0.6-0.5,0.8-0.8,1.4c-0.1,0.3-0.2,0.6-0.4,1.1c-0.2,0.5-0.3,0.8-0.2,1
                            c0,0.2,0.1,0.4,0.3,0.7c0.1,0.1,0.3,0.2,0.6,0.3c0.4,0.1,0.6,0,0.9-0.1c0.2-0.1,0.5-0.2,0.9-0.6c0.5-0.4,0.7-0.9,0.8-1
                            c0.5-0.8,0.7-1.4,1-2.2c0.5-1.3,0.8-2.1,1-2.5c0.8-1.9,0.6-1,0.8-1.7c0-0.1,0.2-0.6,0.7-1.1c0.4-0.4,0.5-0.4,0.6-0.4
                            c0.2,0,0.3,0.2,0.3,0.3c0.2,0.3,0.1,0.7,0.1,0.8c-0.2,0.8-0.6,1.6-0.8,1.9c-0.2,0.4-0.4,0.9-0.8,1.9c-0.2,0.6-0.2,0.5-0.6,1.6
                            c-0.3,0.8-0.6,1.7-1,2.5c0,0-0.3,0.8-0.4,1.7c0,0.3,0,0.6,0.2,0.9c0.2,0.2,0.5,0.3,0.7,0.3c0.2,0,0.7,0.2,1.3,0
                            c0.7-0.2,1-0.8,1.2-1.3c0.4-0.8,0.1-1,0.6-2c0,0,0,0,0.6-1.1c0.1,0.2,0.1,0.5,0.2,0.9c0,0.8-0.2,1.6-0.2,1.8
                            c-0.1,0.5-0.2,0.7-0.1,1.1c0,0.1,0.1,0.4,0.4,0.5c0.4,0.2,0.9,0,1-0.1c0.5-0.2,0.7-0.6,0.9-1.2c0.2-0.4,0.3-0.7,0.4-1.3
                            c0.2-0.7,0.3-1,0.3-1.5c0.1-0.5,0.1-1,0.1-1.3c0-0.3,0-0.6,0-1.1c0-0.2,0-0.3,0-0.4c0.1,0.1,0.3,0.2,0.5,0.5
                            c0.1,0.1,0.3,0.5,0.4,1.3c0.1,0.9-0.2,1.2,0.1,1.6c0.1,0.1,0.3,0.4,0.6,0.5c0.3,0.1,0.6-0.1,0.8-0.2c0.1-0.1,0.4-0.2,0.7-0.6
                            c0.2-0.3,0.2-0.5,0.4-1.4c0.2-1.2,0.2-1.1,0.3-1.4c0-0.3,0-0.8,0.1-1.4c0.1-0.5,0.1-0.7,0.2-0.7c0.2,0,0.4,0.4,0.5,0.5
                            c0.1,0.3,0.1,0.4,0.2,0.8c0.1,0.5,0.2,0.8,0.4,0.8c0.2,0.1,0.4-0.1,0.6-0.2c0.2-0.2,0.4-0.4,0.5-0.7c0.2-0.4,0.2-0.6,0.3-1
                            c0.2-0.9,0.3-0.7,0.4-1.2c0.1-0.6,0.1-1.1,0.1-1.5c0-0.8,0-1.1,0-1.1c0-0.1,0-0.4,0.1-0.9c0.1-0.2,0.1-0.3,0.2-0.4
                            c0.1,0,0.2,0.1,0.6,0.7c0.4,0.7,0.4,0.7,0.6,0.9c0.1,0.1,0.6,0.5,1.1,0.4c0.4-0.1,0.6-0.6,0.7-0.9c0.2-0.5,0-1-0.1-1.4
                            c-0.2-0.5-0.2-0.4-0.5-1.2c0,0-0.1-0.2-0.3-1.1c0-0.1,0.1-0.3,0.1-0.4c0.3,0.2,0.6,0.4,0.8,0.5c0.4,0.3,0.4,0.3,0.6,0.4
                            c0.3,0.1,0.6,0,0.9-0.2c0.3-0.2,0.3-0.4,0.4-0.7c0.1-0.4,0-0.8,0-1c-0.2-1,0-0.9-0.1-1.9c-0.1-0.7-0.3-1-0.2-1.5
                            c0-0.1,0.1-0.7,0.1-0.7c0.2,0,0.5,0,0.6,0c0.8,0,0.9,0,1-0.1c0.4-0.1,0.6-0.5,0.8-0.8c0.3-0.6,0.3-1.3,0.3-1.8c0-0.4,0-0.7,0-1.1
                            c0-0.3,0-0.6,0.1-0.7c0.1-0.1,0.3,0.1,0.5,0.1c0.4,0,0.7-0.2,0.8-0.2c0.5-0.3,0.6-0.9,0.6-1.4c0.1-0.5,0-0.9-0.1-1.4
                            c-0.1-0.6-0.2-0.9-0.3-1.2c-0.1-0.3-0.3-0.5-0.2-0.6c0.1-0.1,0.4,0.2,0.8,0.2c0.3-0.1,0.5-0.3,0.6-0.6c0.2-0.3,0.2-0.6,0.3-1.2
                            c0-0.4,0.1-0.6,0-0.8c-0.1-0.4-0.3-0.6-0.4-0.8c-0.4-0.5-0.8-0.7-0.7-0.9c0.1-0.1,0.4,0,0.8-0.1c0.4-0.1,0.7-0.4,0.8-0.5
                            c0.5-0.5,0.7-1.4,0.5-2c-0.2-0.7-0.7-1-0.5-1.4c0.1-0.2,0.3-0.2,0.6-0.4c0.4-0.4,0.6-0.8,0.6-1c0.2-0.6,0-1.1-0.1-1.3
                            c-0.3-0.7-0.8-0.9-1.5-2c-0.1-0.2-0.3-0.5-0.2-0.8c0-0.2,0.1-0.3,0.3-0.7c0.3-0.5,0.4-0.8,0.4-1c0.1-0.6-0.4-1.1-0.4-1.2
                            c-0.4-0.4-0.9-0.2-1.1-0.6c-0.1-0.1,0-0.1-0.1-0.7c0-0.4-0.1-0.7-0.2-0.9c-0.1-0.4-0.4-0.6-0.7-1c-0.3-0.4-0.5-0.8-0.9-1.7
                            c-0.5-1.1-0.4-1.1-0.7-1.7c-0.4-0.7-0.9-1.2-1-1.3c-0.3-0.3-0.5-0.5-1.2-1.1c-0.1-0.1-0.4-0.4-0.6-0.9c-0.2-0.4-0.2-0.5-0.1-0.6
                            c0.1-0.2,0.3-0.2,0.5-0.3c0.2-0.1,0.4-0.1,0.9-0.1c0.4,0,0.8,0,1.1,0.1c0.3,0,0.9,0.2,1.5,0.4c0.9,0.4,1.4,1,1.8,1.4
                            c1.7,2.1,2.6,3.3,2.6,3.3c1.5,2.1,2.2,3.2,2.6,3.8c1.3,2,2,3,2.1,3.3c0.4,0.8,0.7,1.5,1.5,2.3c0.3,0.3,0.8,0.7,1.7,1
                            c0.4,0.1,0.9,0.3,1.6,0.2c0.2,0,0.6-0.1,0.9-0.4c0.1-0.1,0.5-0.4,0.6-1c0-0.4-0.2-0.6,0-0.8c0.2-0.2,0.5-0.2,0.5-0.2
                            c0.3,0,0.5,0.2,0.8,0.3c0.4,0.2,1,0.1,1.4-0.1c0.7-0.4,0.6-1.5,0.6-1.7c0-0.2,0-0.4,0-0.7c0-0.2,0-0.3,0.1-0.4
                            c0.1-0.1,0.3-0.1,0.6,0c0.6,0,0.9,0.1,1,0c0.3-0.1,0.4-0.6,0.5-0.9c0-0.3,0.1-0.5,0-0.7c-0.1-0.2-0.2-0.3-0.2-0.5
                            c-0.1-0.2-0.1-0.3,0-0.4c0,0,0.1-0.1,0.6,0c0.5,0,0.5,0.1,0.7,0.1c0.5-0.1,0.7-0.5,0.8-0.6c0.1-0.2,0.1-0.4,0.2-0.7
                            c0-0.5,0.1-0.7,0-0.9c-0.1-0.3-0.4-0.4-0.3-0.6c0-0.1,0.2-0.2,0.4-0.3c0.3-0.1,0.5,0.1,0.8,0.1c0.4,0,0.6-0.2,0.8-0.3
                            c0.3-0.2,0.4-0.5,0.5-0.9c0.1-0.2,0.2-0.6,0.2-1.2c0-0.3,0-0.5-0.2-0.8c-0.1-0.3-0.3-0.4-0.3-0.6c0-0.1,0-0.3,0.2-0.5
                            c0.2-0.1,0.3-0.1,0.7-0.1c0.4,0,0.7-0.1,0.9-0.2c0.5-0.3,0.6-0.9,0.6-1c0-0.3-0.1-0.6-0.2-0.8c-0.1-0.2-0.2-0.3-0.4-0.7
                            c-0.2-0.4-0.2-0.5-0.1-0.5c0.1-0.2,0.4-0.1,0.9-0.3c0.2-0.1,0.6-0.2,0.8-0.5c0.4-0.4,0.2-1,0.2-1.2c0-0.2-0.1-0.3-0.2-0.7
                            c0-0.3-0.1-0.4-0.1-0.6c0-0.1,0-0.3,0.3-0.8c0.3-0.5,0.3-0.5,0.5-0.8c0.1-0.3,0.3-0.5,0.3-0.9c0-0.1,0-0.5-0.2-0.8
                            c-0.1-0.1-0.3-0.4-0.6-0.5c-0.4-0.2-0.8,0-0.9-0.1c-0.1-0.1,0.1-0.4,0.2-0.5c0.2-0.3,0.4-0.3,0.5-0.5c0.2-0.2,0.2-0.5,0.1-0.9
                            c0-0.4-0.1-0.7-0.3-0.9c-0.1-0.1-0.3-0.2-0.7-0.3c-0.6-0.2-1.1-0.3-1.1-0.3c-0.4-0.1-0.5-0.1-0.6-0.2c-0.1-0.2,0.3-0.4,0.6-1
                            c0.2-0.4,0.2-0.7,0.3-0.8c0-0.3,0.1-0.6-0.1-0.9c-0.1-0.1-0.2-0.4-0.5-0.6c-0.2-0.1-0.5-0.2-0.8-0.2c0,0-0.1,0-0.8-0.1
                            c-0.1-0.2-0.3-0.5-0.2-0.7c0.1-0.3,0.3-0.3,0.5-0.8c0.1-0.2,0.3-0.5,0.3-0.8c0-0.2,0-0.6-0.3-0.9c-0.3-0.3-0.7-0.4-1.2-0.4
                            c-0.5-0.1-1.1,0-1.2,0.1c0,0,0,0,0,0c-0.1,0,0.1-0.4,0.3-0.7c0.2-0.5,0.3-0.5,0.4-0.8c0.1-0.2,0.2-0.5,0-0.7
                            c-0.1-0.2-0.3-0.3-0.7-0.4c-0.5-0.2-0.9-0.2-1.2-0.2c-0.6,0-0.9,0.1-0.9,0c-0.1-0.1,0.5-0.3,0.7-0.8c0.1-0.3,0.1-0.7,0-0.9
                            c-0.1-0.3-0.1-0.5-0.3-0.7c-0.2-0.2-0.6-0.2-0.9-0.3c-0.5,0-0.6,0.1-0.7,0c-0.3-0.1-0.1-0.4-0.4-0.9c0-0.1-0.2-0.4-0.6-0.8
                            c-0.4-0.3-0.8-0.5-1.1-0.6c-0.1,0-0.5-0.2-1.1-0.2c-0.2,0-0.7,0-1.3,0.1c0,0-0.5,0.1-1,0.4c-2.4,1.4-3,3.3-5,6.5
                            c-0.8,1.3-1.3,1.9-2.2,3.1c-0.3,0.4-1.1,1.4-2.2,2.5c-0.7,0.6-1.1,0.9-1.7,1.2c-0.3,0.2-0.8,0.3-1.6,0.6c-1.1,0.4-1.3,0.4-1.5,0.4
                            c0,0-0.1,0-1.1,0c0-0.2-0.1-0.5,0.1-0.9c0.1-0.1,0.2-0.5,0.6-0.8c0.5-0.4,0.8-0.3,1-0.6c0.1-0.2,0.1-0.4,0.1-0.6
                            c0-0.3-0.2-0.4-0.1-0.6c0-0.1,0.1-0.2,0.5-0.4c0.7-0.3,0.7-0.3,1-0.5c0.4-0.3,0.5-0.6,0.6-0.8c0.2-0.5,0.1-0.9,0.1-1
                            c-0.1-0.3-0.2-0.5-0.3-0.7c-0.3-0.4-0.4-0.4-0.4-0.6c0-0.3,0.6-0.3,1.3-0.8c0.4-0.3,0.6-0.7,0.8-1.1c0.2-0.5,0.3-0.9,0.3-0.9
                            c0.1-0.4,0-0.7-0.1-0.8c-0.1-0.2-0.1-0.3-0.3-0.5c-0.2-0.2-0.5-0.1-0.6-0.2c-0.1-0.2,0.4-0.4,0.7-1c0.2-0.3,0.2-0.6,0.2-1
                            c0-0.6-0.1-1-0.2-1.5c-0.2-0.6-0.2-0.9-0.5-1.1c0,0-0.1-0.1-0.8-0.5c-0.1-0.3,0-0.6,0-0.7c0.1-0.4,0.3-0.6,0.3-1
                            c0-0.2,0.1-0.5-0.1-0.7c-0.2-0.3-0.6-0.4-0.7-0.4c-0.4-0.1-0.6,0-0.7-0.1c-0.1-0.2,0.2-0.5,0.9-1.5c0.4-0.6,0.5-0.8,0.6-1
                            c0.1-0.2,0.2-0.5,0.1-0.9c-0.1-0.3-0.1-0.3-0.2-0.6c-0.1-0.5,0.1-0.6,0-0.9c-0.1-0.4-0.5-0.7-0.6-0.7c-0.5-0.3-0.8-0.2-1-0.5
                            c-0.1-0.2-0.1-0.3,0-0.6c0.1-0.5,0.3-0.7,0.4-1c0.3-0.8-0.2-1.6-0.3-1.8c-0.1-0.2-0.3-0.5-0.8-0.7c0,0-0.2-0.1-1.1-0.4
                            c0.1-0.3,0.3-0.8,0.3-1.4c0-0.6-0.2-1.1-0.3-1.4c-0.1-0.4-0.2-0.7-0.5-1c-0.3-0.4-0.7-0.6-0.9-0.7c-0.2-0.1-0.5-0.2-0.9-0.3
                            c-0.4-0.1-0.5,0-0.6-0.1c-0.1-0.2,0.2-0.4,0.5-0.9c0.1-0.2,0.3-0.6,0.2-1c0-0.5-0.3-0.9-0.4-1c-0.1-0.2-0.5-0.6-1.1-0.8
                            c-0.2-0.1-0.4-0.1-0.5-0.2c-0.2-0.2,0.1-0.5,0.3-0.9c0.1-0.3,0.1-0.6,0-1.3c0-0.5-0.1-0.9-0.3-1.6c-0.2-0.8-0.4-1.2-0.5-1.4
                            c-0.3-0.6-0.6-0.8-0.8-0.9c-0.1,0-0.4-0.1-0.7,0c-0.3,0.1-0.4,0.4-0.5,0.6c-0.1,0.3-0.1,0.5-0.2,0.9c0,0.5,0,0.6-0.1,0.7
                            c-0.2,0.2-0.5,0.2-0.7,0.1c-0.1,0-0.3-0.2-0.4-0.8c-0.1-0.9,0.3-1.1,0.3-2.1c0-0.6-0.2-1.2-0.3-1.6c-0.1-0.3-0.3-0.8-0.7-1.3
                            c-0.4-0.5-0.8-0.7-1-0.8c-0.5-0.2-0.8-0.2-0.8-0.2c-0.3,0.1-0.5,0.3-0.5,0.4c-0.1,0.2-0.1,0.3,0,0.9c0,0.2,0,0.4,0,0.4
                            c0,0.3,0.1,0.4,0.1,0.4c-0.1,0-0.4-0.7-0.7-1.5c-0.1-0.2,0-0.1-0.3-1.5c-0.1-0.6-0.2-0.9-0.4-1.2c-0.2-0.2-0.4-0.5-0.8-0.7
                            c-0.1,0-0.7-0.3-1.1,0c-0.4,0.2-0.4,0.7-0.4,0.9c0,0.3,0,0.4,0.4,1.6c0.2,0.7,0.3,1,0.3,1.4c0,0.1,0.1,0.4,0,0.7
                            c-0.1,0.1-0.2,0.3-0.4,0.3c-0.2,0-0.3-0.3-0.4-0.5c-0.3-0.8-0.5-1.6-0.5-1.7c-0.2-0.9-0.3-0.7-0.6-1.8c0-0.1-0.1-0.6-0.5-1.1
                            c-0.1-0.2-0.3-0.3-0.4-0.5c-0.1-0.1-0.5-0.3-0.9-0.3c-0.3,0-0.4,0.2-0.5,0.3c-0.4,0.4-0.4,0.8-0.5,1.2c-0.1,0.5,0,0.8,0,1.1
                            c0,0.3,0.1,0.5,0.2,1c0.1,0.3,0.2,0.5,0.4,1.2c0.2,0.7,0.4,1,0.4,1.1c0.1,0.5,0.1,0.9,0.1,1.4c0,0.2-0.1,1.2-0.2,1.3
                            c-0.1,0-0.1-0.3-0.4-1.1c-0.2-0.5-0.3-0.8-0.4-1.2c-0.3-0.9-0.5-1.3-0.6-1.4c-0.3-0.7-0.5-0.9-0.6-1c-0.1-0.1-0.4-0.4-0.9-0.7
                            c-0.4-0.2-0.7-0.4-1.1-0.3c-0.2,0.1-0.3,0.3-0.4,0.5c-0.3,0.5-0.2,0.9-0.2,1c0.1,1.1,0.9,2.5,1.4,3.8c0.2,0.4,0.3,1,0.5,2.1
                            c0.3,1.6,0.4,2.8,0.5,3.6c0.1,1.4,0.1,2.5,0.1,3.5c0,0.7,0,1.4,0,2.8c0,2-0.1,3-0.1,3.6c-0.1,2-0.4,3.4-0.5,3.9
                            c-0.1,0.4-0.3,1.4-0.6,2.8c-0.5,1.7-0.6,1.7-0.9,2.8C423.7,212.3,423.6,212.8,423.3,214.9z"/>
                        </svg>

                    </div>
                    
                    <div class="white-line"></div>
                    
                    <div class="opacity-line">
                        <div class="link_page">
                            <a href="index.php"><?=$page_name?></a><a href="index.php?page=<?=$page?>"><?=$name1?></a><a href="index.php?page=<?=$page?>&<?=$link_name?>=<?=$link2?>"><?=$name2?></a><a href="index.php?page=<?=$page?>&<?=$link_name?>=<?=$link2?>&<?=$link_name2?>=<?=$link3?>"><?=$name3?></a>
                        </div>
                    </div>
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
            
            <div class="share">
                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                <script src="//yastatic.net/share2/share.js"></script>
                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,twitter,lj,viber,whatsapp" data-direction="vertical"></div>
            </div>
            
            <a href="#" id="toTop"><img src="../i/up.ico"></a>
        </div>
        <footer>
            <div class="flex">
                <div>
                    <!-- Yandex.Metrika informer -->
                    <a href="https://metrika.yandex.ru/stat/?id=49157065&amp;from=informer"
                    target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/49157065/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                    style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="49157065" data-lang="ru" /></a>
                    <!-- /Yandex.Metrika informer -->
                </div>

                <div class="search">
                    <div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'http://gc44.ru/index.php?page=result','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по сайту gc44','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2329906,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'поиск','input_placeholderColor':'#818181','input_borderColor':'#7f9db9'}">
                        <form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8">
                            <input type="hidden" name="searchid" value="2329906"/>
                            <input type="hidden" name="l10n" value="ru"/>
                            <input type="hidden" name="reqenc" value=""/>
                            <input type="search" name="text" value=""/>
                            <input type="submit" value="Найти"/>
                        </form>
                    </div>
                    <style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style>
                    <script type="text/javascript">
                        (function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');
                    </script>
                </div>
            </div>
            <div>
                <a href="index.php?page=pers_dat" >Политика в отношении обработки персональных данных</a>
            </div>
            <div>
                © 2010 - <?=date("Y")?> г. Местная религиозная организация христиан веры евангельской (пятидесятников) "Церковь Божья" г. Костромы, Костромской области. ИНН 4401115856 ОГРН 1134400000525
            </div>
         </footer>
	</body>
</html>