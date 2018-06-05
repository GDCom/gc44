<?php
$news = get_table($link, "SELECT * FROM `news` Order By id DESC LIMIT 0, 3"); //Берем три последние новости

check_base($link, 'info'); //Проверяем, пустая ли база и добавляем строку, если да

$array = get_table($link, "SELECT concept, service FROM info"); //Получаем информацию из базы
?>

<div class="cent">
    <div class="content">
        <h2>Последние новости:</h2> <!--Заголовок-->
        <!--Выводим таблицу из трех последних новостей-->        
        <table>
            <tbody>
                <tr>
                    <?php foreach($news as $a): ?> <!--Для каждой новости-->
                        <td class="enum"> <!--Новая колонка-->
                            <h3><?=$a['title']?></h3> <!--Заголовок новости-->
                        </td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <?php foreach($news as $a): ?> <!--Для каждой новости-->
                        <td class="enum"> <!--Новая колонка-->
                            <a href="index.php?page=news&id=<?=$a['id']?>">
                                <p class="date_publ">Опубликовано: <?=$a['date']?></p> <!--Дата публикации-->
                                <div class="top_news1">
                                    <div class="top_news2">
                                        <?php if ($a['img1'] != NULL) { ?> 
                                        <div><img src="img/m/smal_<?=$a['img1']?>"></div>
                                        <div class="tn_2">
                                            <div class="tn_21">
                                                <?=$a['content']?>
                                            </div>
                                            <div class="tn_22">
                                                Читать далее...
                                            </div>
                                        </div>
                                        <?php } else {?>
                                        <div class="tn_2">
                                            <div class="tn_21">
                                                <?=$a['content']?>
                                            </div>
                                            <div class="tn_22">
                                                Читать далее...
                                            </div>
                                        </div>
                                        <div class="tn_2">
                                            <div class="tn_21">
                                                <?=$a['content']?>
                                            </div>
                                            <div class="tn_22">
                                                Читать далее...
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </a>
                        </td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
        <hr />
        <table>
            <tbody>
                <tr>
                    <td width = 59% class = "Text">
                        <h2>Социальная концепция:</h2>
                        <?=dapost($array[0]['concept'])?>
                    </td>
                    <td></td>
                    <td width= 40% class = "Text">
                        <h2>Богослужения:</h2>
                        <?=dapost($array[0]['service'])?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>