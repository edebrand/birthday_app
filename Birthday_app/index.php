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
        <div class="container">
            <header>
                <h1 class="title">Anniversaires</h1>
                <img class="gifts_img" src="img/gifts.png"/>
            </header>
            <!-- SEARCH FORM -->
            <form class="search_bar" action="index.php" method="post">
            <input class="bar" name="search" type="search" required/>
            </form>
            <div id="list" class="list">
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

                if (!isset($_POST["search"]) || $_POST["search"] == "") {
                    $sqlQuery = "SELECT surname, first_name, dob,img,id, DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age, (365.25 - (TIMESTAMPDIFF(day, dob, CURDATE()) mod 365.25)) AS days from table_birthdays order by surname ASC";
                    $user = $db->prepare($sqlQuery);
                }
                    else {
                        $sqlQuery = "SELECT surname, first_name, dob,img,id, DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age, (365.25 - (TIMESTAMPDIFF(day, dob, CURDATE()) mod 365.25)) AS days from table_birthdays WHERE surname LIKE :ls OR first_name LIKE :fs order by surname ASC";
                        $user = $db->prepare($sqlQuery);
                        $q = "%" . $_POST["search"] . "%";
                        $user->bindParam(':ls', $q);
                        $user->bindParam(':fs', $q, PDO::PARAM_STR);?>
                        <a class="return_home" href="index.php">retour à la liste<a>
                    <?php }
                $user->execute();
                $lists = $user->fetchAll();
                // On affiche chaque nom un à un
                foreach ($lists as $list) {
                    $url = 'uploads/'. $list['img'];?>
                    <div class=individual_card>
                        <a class="inside_card" href="personal_file.php?id=<?php echo $list['id']?>">
                            <?php echo '<img class="img_id" src="' . $url .'">';?>
                            <div class="right_text">
                                <h2><?php echo $list['surname'] . " " . $list['first_name'];?></h2>
                                <p class="age"><?php echo $list['Age'] . " ans";?></p>
                                <?php
                                    if ($list['days'] > 364) {
                                        echo "<p class='display_days'> Anniversaire <strong>aujourd'hui</strong></p>";
                                    }
                                    else {
                                    echo "<p class='display_days'>Anniversaire dans <strong>" . round($list['days']) . "</strong> jours</p>";
                                }?>
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