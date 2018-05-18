<?php
$id = $_GET['id'];
    
$menu = get_table($link, "SELECT id, title FROM ministry ORDER BY title");

if ($id == 0) {
    $ministry = get_table($link, "SELECT * FROM ministry ORDER BY title");
}
else {
    $ministry = get_table($link, "SELECT * FROM ministry WHERE id=".$id);
}
?>

<?php if(count($menu) > 0) {?>

    <div class="Menu">
        <div>
            <?php foreach($menu as $a): ?>
            <a href="index.php?page=ministry&id=<?=$a['id']?>"><?=$a['title']?></a><br>
            <?php endforeach?>
        </div>
    </div>

    <div class = "content">
    <h1>Служения</h1>
        <table class="enum_tbl">
            <tbody>
                <?php if(count($ministry) > 1) { //Если массив больше одной строки (весь список служений) ?>
                <?php for($i = 0; $i < count($ministry); $i += 3) {?>
                <tr>
                    <td class="enum">
                        <a href="index.php?page=ministry&id=<?=$ministry[$i]['id']?>">
                            <h3><?=$ministry[$i]['title']?></h3>
                            <img src="img/m/smal_<?=$ministry[$i]['img']?>">
                        </a>
                    </td>
                    <td class="enum">
                        <?php if($i + 1 < count($ministry)) {?>
                        <a href="index.php?page=ministry&id=<?=$ministry[$i + 1]['id']?>">
                            <h3><?=$ministry[$i + 1]['title']?></h3>
                            <img src="img/m/smal_<?=$ministry[$i + 1]['img']?>">
                        </a>
                        <?php }?>
                    </td>
                    <td class="enum">
                        <?php if($i + 2 < count($ministry)) {?>
                        <a href="index.php?page=ministry&id=<?=$ministry[$i + 2]['id']?>">
                            <h3><?=$ministry[$i + 2]['title']?></h3>
                            <img src="img/m/smal_<?=$ministry[$i + 2]['img']?>">
                        </a>
                        <?php }?>
                    </td>
                </tr>
                <?php }?>
                <?php } else { //Иначе, если выбрано одно служение ?>
                <h3><?=$ministry[0]['title']?></h3> <!--Заголовок-->
                <tr>
                    <td class="foto1">
                        <a href="img/<?=$ministry[0]['img']?>" target="_blank" class="prevew">
                            <img src="img/m/smal_<?=$ministry[0]['img']?>">
                        </a> <!--Фотка-->
                        <div class="date_publ"><?=$ministry[0]['alt']?></div> <!--Подпись к фото-->
                    </td>
                    <td class="enum_min">
                        <?=$ministry[0]['content']?> <!--Описание-->
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
<?php }?>