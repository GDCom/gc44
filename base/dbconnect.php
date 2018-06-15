<?php
    define('MYSQL_SERVER', '127.0.0.1');
    define('MYSQL_USER', 'admin');
    define('MYSQL_PASSWORD', 'Adm44');
    define('MYSQL_DB', 'gchnru_gc44');
    
//Соединение с базой
function db_connect() {
    
    $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or die("Ошибка подключения: ".mysqli_error($link));
    
    if(!mysqli_set_charset($link, "utf8")){
        print("Error: ".mysqli_error($link));
    }
    
    return $link;
}

?>