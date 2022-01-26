<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadeau supprimé</title>
</head>
<?php $id = $_REQUEST['id']?>
<body>
    <p>Le cadeau a bien été supprimé</p>
    <a href="gift_search.php?=<?php echo $id ?>"><p>retour</p></a>
    <?php var_dump($id)?>
</body>
</html>