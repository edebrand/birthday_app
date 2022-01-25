<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Birthdays</title>
        <link rel="stylesheet" href="SCSS/birthday.css">
    </head>
    <body>
    <?php 
            $id = $_GET['id'];
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

            // Si tout va bien, on peut continuer
            $sqlQuery = "SELECT * from table_gifts WHERE id_user='$id' order by date DESC";
            $gifts = $db->prepare($sqlQuery);
            $gifts->execute();
            $lists = $gifts->fetchAll();
        ?>
        <div class="container">
            <header>
                <h1 class="title">Cadeaux</h1>
                <img class="gifts_img" src="img/gifts.png"/>
            </header>
            <div class="search_bar">
                <input class="bar" name="search" type="text">
            </div>
            <div class="list">
                <?php
                foreach ($lists as $list) {
                    $url = 'uploads/'. $list['img'];?>
                    <div class=gift_card>
                        <a class="inside_card">
                            <?php echo '<img class="img_id" src="' . $url .'">';?>
                            <div class="gift_text">
                                <h2><?php echo $list['gift_name'];?></h2>
                                <p class="gift_year"><?php echo $list['date'];?></p>
                            </div>
                        </a>
                    </div>
                <?php }?>
            </div>
            <footer class="footer_main">
                <a href="add_user.php">
                    <div class="add_file">AJOUTER</div>
                </a>
            </footer>
        </div>
    </body>
</html>