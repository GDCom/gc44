<?php

$mode = $_GET['mode']; //Узнаем режим (редактирования или создание)

    
if ($mode == 'edit') { //Если режим редактирования
    $id = $_GET['id']; //узнаем id
    
    $ministry = get_table($link, "SELECT * FROM ministry WHERE id=".$id);
    
    $t = "edit&id=".$ministry[0]['id'];
    $podp = "Редактирование записи";
}
else {
    $t = "add";
    $podp = "Новая запись";
}
?>

<div>
    <h2><?=$podp?></h2>
    
    <div class="space"></div>
    
    <form method="post" action="index.php?page=ministry&action=<?=$t?>" enctype="multipart/form-data">
        <label>
            Название:
            <input type="text" name="title" value="<?php if($mode == 'edit') {?><?=$ministry[0]['title']?><?php }?>" class="form-item" autofocus required>
        </label>
        
        <div class="space"></div>
        
        <label>
            Содержание:
            <textarea name="content" class="form-item-ta" required><?php if($mode == 'edit') {?><?=$ministry[0]['content']?><?php }?></textarea>
        </label>
        <label>
            <div class="flex"><input type="checkbox" name="img_check" value="YES" include> Изображение:</div>
            <input type="file" name="img" accept="image/gif, image/jpeg, image/png, image/jpg" class="form-item-file" include>
        </label>
        <label>
            Подпись:
            <textarea name="alt" class="form-item-ta" required><?php if($mode == 'edit') {?><?=$ministry[0]['alt']?><?php }?></textarea>
        </label>

        <input type="submit" value="Сохранить" class="btn">
    </form>
</div>