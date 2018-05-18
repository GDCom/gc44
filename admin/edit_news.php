<?php


$mode = $_GET['mode']; //Узнаем режим (редактирования или создание)

    
if ($mode == 'edit') { //Если режим редактирования
    $id = $_GET['id']; //узнаем id
    
    $new = get_table($link, "SELECT * FROM `news` WHERE id=".$id);

    $podp = "Редактирование записи";
    $t="edit&id=".$new[0]['id'];
}
else {
    $t = "add";
    $podp = "Новая запись";
}
?>


<div>
    <h2><?=$podp?></h2>
    <form method="post" action="index.php?page=news&action=<?=$t?>" enctype="multipart/form-data">
        <label>
            Название:
            <input type="text" name="title" value="<?php if($mode == 'edit') {?><?=$new[0]['title']?><?php }?>" class="form-item" autofocus required>
        </label>
        <?php if($mode == 'edit') {?>
        <label>
            Дата:
            <input type="datetime" name="date" value="<?=$new[0]['date']?>" class="form-item" required>
        </label>
        <?php } ?>
        <label>
            Содержание новости:
            <textarea name="content" class="form-item-ta" required><?php if($mode == 'edit') {?><?=$new[0]['content']?><?php }?></textarea>
        </label>
        <label>
            <div class="flex"><input type="checkbox" name="img1_check" value="YES" include> Первое изображение:</div>
            <input type="file" name="img1" class="form-item-file" include>
        </label>
        <label>
            <div class="flex"><input type="checkbox" name="imgs_check" value="YES" include> Остальные изображения:</div>
            <input type="file" name="imgs[]" class="form-item-file" multiple include>
        </label>
        <input type="submit" value="Сохранить" class="btn">
    </form>
</div>