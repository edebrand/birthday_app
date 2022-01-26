<?php
    try
    {
	    // On se connecte à MySQL
	    $db = new PDO('mysql:host=localhost;dbname=Birthday_project;charset=utf8', 'root', 'root');
    }
    catch(Exception $e)
    {
	    // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
    $sql = "DELETE FROM table_birthdays WHERE id =' " . $_GET['del_id'] . "'";
    $del= $db->prepare($sql);
    $exec = $del->execute();
    if ($exec = true) {
        header ('location: success_delete.php');
    }