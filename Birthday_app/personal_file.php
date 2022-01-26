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
            $id = $_REQUEST['id'];
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
            $sqlQuery = "SELECT surname, first_name, dob,img, phone, DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age, 365.25 - (TIMESTAMPDIFF(day, dob, CURDATE()) mod 365.25) as days from table_birthdays WHERE id='$id' order by surname ASC";
            $user = $db->prepare($sqlQuery);
            $user->execute();
            $lists = $user->fetchAll();
        ?>
             
        <?php
        foreach ($lists as $list) {?>
            <header>
                <?php echo '<h1 class="title_indiv">' . $list['first_name'] . ' ' . $list['surname']?> </h1>
                <img class="gifts_img" src="img/gifts.png"/>
            </header>
            <div class="container_indiv">
                <?php $url = 'uploads/'. $list['img'];?>
                    <div class="individual_profile">
                        <?php echo '<img class="img_id_indiv" src="' . $url .'">';
                            if ($list['days'] > 364) {
                                echo "<img src='img/birthday_cake.png'/>";
                                echo '<p class="display_days_today">' . $list['Age'] . ' ans <strong>AUJOURD' . '&#039' . 'HUI' .'</strong></p>';?>
                                <div class="more_buttons">
                                    <div class="call_buttons">
                                    <a class="call_user" href="tel:<?php echo $list['phone']?>">
                                        <div class="call_txt">Appeler <?php echo $list['first_name']?></div>
                                    </a>
                                    <a class="send_msg" href="sms:<?php echo $list['phone']?>">
                                        <div class="msg_txt">Envoyer un SMS à <?php echo $list['first_name'] ?></div>
                                    </a>
                                </div>
                                <a class="gift_search" href="gift_search.php?id=<?php echo $id?>">
                                        <div class="gift_txt">Rechercher un cadeau</div>
                                    </a>
                                </div>
                            <?php }
                            else {
                                echo "<p class='display_days_not_today'>" . $list['Age'] . " ans dans <strong>" . round($list['days']) . "</strong> jours</p>";
                            }
                            ?>
                    </div>
        <?php }?>
                
                <footer class="footer_file">
                    <a href="#myModal" id="myBtn"><div class="delete_file">SUPPRIMER</div></a>
                    <a href="index.php"><div class="return_home">RETOUR</div></a>
                </footer>
        </div>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <p>Voulez-vous vraiment supprimer cette fiche ?</p>
                <a class="close">Non</a>
                <div class="delete"><input type="button" onclick="deleteme(<?php echo $id;?>)" name="delete" value="Oui"></div>
                <script>
                    function deleteme(delid) {
                        window.location.href='delete.php?del_id=' +delid+'';
                        return true;
                    }
                </script>

            </div>
        </div>
        <script type="text/javascript">
            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal
            btn.onclick = function() {
            modal.style.display = "block";}

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
            modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            
        </script>
    </body>
</html>