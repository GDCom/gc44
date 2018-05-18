<?php
$id = $_GET['id'];
    
if ($id == 0) {
    $news = get_table($link, "SELECT * FROM `news` Order By date DESC");
}
else {
    $news = get_table($link, "SELECT * FROM `news` WHERE id=".$id);
}
?>

<div class="content">
<h1>Новости</h1> <!--Заголовок-->

<div class = "Text">
    <?php if (count($news) == 1) { //Если одна статья ?>
    <h3><?=$news[0]['title']?></h3>
    <div class="date_publ">Опубликовано: <?=$news[0]['date']?> (Мск)</div>
    <table>
        <tbody>
            <tr>
                <?php if ($news[0]['img1'] != NULL) { // Если есть первое изображение ?>
                <td class="enum">
                    <a rel="group" href="img/<?=$news[0]['img1']?>" class="prevew"><img class="first" src="img/m/smal_<?=$news[0]['img1']?>"></a>
                </td>
                <?php }?>
                <td class="enum" colspan="2" width="100%">
                    <p><?=$news[0]['content']?></p>
                </td>
            </tr>
            <?php if($news[0]['imgs'] != NULL) { ?>
            <?php
                $s = explode(";", $news[0]['imgs']); //Разбиваем список изображений в массив
                $i = count($s); //Количество изображений
            ?>
            <tr>
                <td height=5px></td>
            </tr>
            <?php for ($t = 0; $t < $i; $t = $t + 3) { //Для всех изображений с шагом 3 ?>
            <tr>
                <td class="enum">
                    <a rel="group" href="img/<?=$s[$t]?>" class="prevew">
                        <div class="rect1">
                            <div class="rect2">
                                <img src="img/m/smal_<?=$s[$t]?>">
                            </div>
                        </div>
                    </a>
                </td>
                <td class="enum">
                    <?php if($t + 1 < $i) {?>
                    <a rel="group" href="img/<?=$s[$t+1]?>" class="prevew">
                        <div class="rect1">
                            <div class="rect2">
                                <img src="img/m/smal_<?=$s[$t+1]?>">
                            </div>
                        </div>
                    </a>
                    <?php }?>
                </td>
                <td class="enum">
                    <?php if($t + 2 < $i) {?>
                    <a rel="group" href="img/<?=$s[$t+2]?>" class="prevew">
                        <div class="rect1">
                            <div class="rect2">
                                <img src="img/m/smal_<?=$s[$t+2]?>">
                            </div>
                        </div>
                    </a>
                    <?php }?>
                </td>
            </tr>
            <?php }?>
            <?php }?>
            <?php if($id != 0) {?>
            <tr>
                <td>
                    <a href="index.php?page=news&id=0"><img src="i/back.ico" width="40px" title="Вернуться к списку новостей"></a><br><br>
                </td>
                <td class="enum"></td>
                <td class="enum"></td>
            </tr>
            <?php }?>
        </tbody>
    </Table>

<?php } else { //Иначе, если список статей ?>
    <table>
        <tbody>
            <?php for($t = 0; $t < count($news); $t += 3) { //Для каждого элемента списка новостей с шагом три ?>
            <tr>
                <td class="enum"> <!--Первый столбец-->
                    <div class="top">
                        <a href="index.php?page=news&id=<?=$news[$t]['id']?>">
                            <h3><?=$news[$t]['title']?></h3> <!--Заголовок-->
                            <div class="date_publ">Опубликовано: <?=$news[$t]['date']?> (Мск)</div><br> <!--Дата публикации-->
                            <div class="rect1">
                                <div class="rect2">
                                    <?php if ($news[$t]['img1'] != NULL) { //Если первое изображение есть ?>
                                    <img src="img/m/smal_<?=$news[$t]['img1']?>"> <!--Изображение со ссылкой на новость-->
                                    <?php } else { //Иначе ?>
                                    <?=$news[$t]['content']?> <!--Текст новости-->
                                    <?php }?>
                                </div>
                            </div>
                        </a>
                    </div>
                </td>
                <td class="enum"> <!--Второй столбец-->
                    <?php if ($t+1 < count($news)) { //Если номер строки меньше количества всех строк ?>
                    <div class="top">
                        <a href="index.php?page=news&id=<?=$news[$t+1]['id']?>">
                            <h3><?=$news[$t+1]['title']?></h3> <!--Заголовок-->
                            <div class="date_publ">Опубликовано: <?=$news[$t+1]['date']?> (Мск)</div><br> <!--Дата публикации-->
                            <div class="rect1">
                                <div class="rect2">
                                    <?php if ($news[$t+1]['img1'] != NULL) { //Если первое изображение есть ?>
                                    <img src="img/m/smal_<?=$news[$t+1]['img1']?>"> <!--Изображение со ссылкой на новость-->
                                    <?php } else { //Иначе ?>
                                    <?=$news[$t+1]['content']?> <!--Текст новости-->
                                    <?php }?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php }?>
                </td>
                <td class="enum"> <!--Третий столбец-->
                    <?php if ($t+2 < count($news)) { //Если номер строки меньше количества всех строк ?>
                    <div class="top">
                        <a href="index.php?page=news&id=<?=$news[$t+2]['id']?>">
                            <h3><?=$news[$t+2]['title']?></h3> <!--Заголовок-->
                            <div class="date_publ">Опубликовано: <?=$news[$t+2]['date']?> (Мск)</div><br> <!--Дата публикации-->
                            <div class="rect1">
                                <div class="rect2">
                                    <?php if ($news[$t+2]['img1'] != NULL) { //Если первое изображение есть ?>
                                    <img src="img/m/smal_<?=$news[$t+2]['img1']?>"> <!--Изображение со ссылкой на новость-->
                                    <?php } else { //Иначе ?>
                                    <?=$news[$t+2]['content']?> <!--Текст новости-->
                                    <?php }?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php }?>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
<?php }?>
</div>
</div>