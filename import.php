<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=stockify', 'root', '');
$sql = file_get_contents('stockify.sql');
$pdo->exec($sql);
echo "BERHASIL IMPORT DATA!";