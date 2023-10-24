<?php
  try {
  
    // Kapcsolódás
    $dbh = new PDO('mysql:host=localhost;dbname=web2', 'root', '',
                  array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
    $dbh->exec("insert into felhasznalok values (1, 'Rendszer', 'Admin', 'Admin','".
                password_hash("admin", PASSWORD_DEFAULT)."', '__1')");
    for($i=2; $i<=25; $i++)
    {
      $dbh->exec("insert into felhasznalok values (${i}, 'Családi${i}', 'Utónév${i}', 'Login${i}','".
                  password_hash("login".$i, PASSWORD_DEFAULT)."', '_1_')");
		
    }
    echo "Ok";
  }
  catch (PDOException $e) {
    echo "Hiba: ".$e->getMessage();
  }
?>

