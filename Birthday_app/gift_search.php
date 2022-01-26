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
            $sqlQuery1 = "SELECT * FROM table_gifts WHERE id_user ='$id' order by date_gift DESC";
            $gifts = $db->prepare($sqlQuery1);
            $gifts->execute();
            $list_gifts = $gifts->fetchAll();
            $sqlQuery2 = "SELECT first_name from table_birthdays WHERE id='$id'";
            $user = $db->prepare($sqlQuery2);
            $user->execute();
            $name = $user->fetch();
        ?>
        <div class="container_gift">
            <header>
                <h1 class="title_gifts">Cadeaux <?php echo ' ' . $name['first_name'];?></h1>
                <img class="gifts_img" src="img/gifts.png"/>
            </header>
            <form class="search_bar" action="gift_search.php" method="post">
            <input class="bar" name="search" type="search" required/>
            </form>
            <div class="list_gifts">
                <?php
                foreach ($list_gifts as $list_gift) {
                    $url = 'uploads/'. $list_gift['img'];
                    $gift_id = $list_gift['id'];?>
                    <div class=gift_card>
                        <div class="inside_card">
                            <?php echo '<img class="img_id" src="' . $url .'">';?>
                            <div class="gift_text">
                                <h2><?php echo $list_gift['gift_name'];?></h2>
                                <p class="gift_year"><?php echo $list_gift['date_gift'];?></p>
                            </div>
                                <a value="<?php echo htmlentities($_REQUEST['id']);?>" onclick="deleteme(<?php echo $gift_id;?>)" name="delete"><img src="img/bin.png"/></a>
                            <script>
                                function deleteme(delid) {
                                    window.location.href='delete_gift.php?del_id=' +delid+'';
                                    return true;
                                }
                            </script>
                        </div>
                    </div>
                <?php }?>
            </div>
            <footer class="footer_gifts">
                <a class="add_file" href="add_gift.php?id=<?php echo $id?>">
                    AJOUTER
                </a>
                <a href="personal_file.php?id=<?php echo $id?>"><div class="return_home">RETOUR</div></a>
            </footer>
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