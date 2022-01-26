<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>cadeau supprimé</title>
    </head>
    <body>
    <?php
    $id = $_REQUEST['del_id'];
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
    $sql1 = "SELECT id_user FROM table_gifts WHERE id = '$id'";
    $user_id_fetch= $db->prepare($sql1);
    $user_id_fetch->execute();
    $id_user = $user_id_fetch->fetch();
    $sql2 = "DELETE FROM table_gifts WHERE id = '$id'";
    $del= $db->prepare($sql2);
    $exec = $del->execute();
    if ($exec = true) {?>
    <p>Le cadeau a bien été supprimé</p>
    <a href="gift_search.php?id=<?php echo $id_user['id_user'] ?>"><p>retour</p></a>
    <?php }?>
</body>
</html>