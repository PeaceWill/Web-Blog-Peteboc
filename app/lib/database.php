
<?php
    $host = DB_SERVER;
    $user = DB_USER;
    $password = DB_PASSWORD;
    $database = DB_DATABASE;
    
    $dns = "mysql:host=$host;dbname=$database";
    $opt = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new \PDO($dns, $user, $password, $opt); 
?>
