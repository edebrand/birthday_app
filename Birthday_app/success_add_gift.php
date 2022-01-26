<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadeau ajouté</title>
</head>
<?php $id = $_REQUEST['id']?>
<body>
    <p>Le cadeau a bien été ajoutée</p>
    <a href="gift_search.php?id=<?php echo $id?>"><p>retour</p></a>
</body>
</html>