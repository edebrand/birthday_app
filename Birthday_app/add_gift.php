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
    ?>
    <div class="container_gift_add">
      <header>
         <h1 class="title_gift_add">Nouveau cadeau</h1>
        <img class="gifts_img" src="img/gifts.png"/>
      </header>
      <form class="form_gift" action="add_gift.php" method="post" enctype="multipart/form-data">
          <div class="gift_name">
            <label for="gift_name">Type de cadeau*</label>
            <input type="text" name="gift_name" required="required" id="gift_name">
          </div>
          <div class="gift_year">
            <label for="gift_year">Année*</label>
            <input type="number" min="1900" max="2099" step="1" name="gift_year" required="required" id="gift_year">
          </div>
          <p>* Champs obligatoires</p>
        <input type="file" name="fileToUpload" id="file">
        <label for="file" class="btn_load_img_gift">Ajouter une photo</label>
        <input type="submit" name="submit" value="AJOUTER">
        <input type="hidden" name="id" value="<?php echo htmlentities($_REQUEST['id']);?>">
      </form>
      <?php
    try
    {
      $db = new PDO('mysql:host=localhost;dbname=Birthday_project;charset=utf8', 'root', 'root');
          
    }
    catch(PDOException $e)
    {
      echo "Error: " . $e->getMessage();
    }
    $uploadOk = NULL;
        if ($_POST) {
          $target_dir = "uploads/";
          $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          // Check if file already exists
          if (file_exists($target_file)) {
            echo "Cette image existe déjà.";
            $uploadOk = 0;
          }
          else {
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
              && $imageFileType != "gif") {
              echo "Seuls les images JPG, JPEG, PNG & GIF sont autorisées.";
              $uploadOk = 0;
            }
          }
          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk == 0) {
            echo "L'image n'a pas été téléchargée.";
            // if everything is ok, try to upload file
          } 
          else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            }
            else {
              echo "Une erreur s'est produite.";
            }
          }
        }
        $sqlQuery = "INSERT INTO table_gifts (gift_name, date_gift, img, id_user) VALUES (:gift_name, :date_gift, :img, :id_user)";
        $req = $db -> prepare($sqlQuery);
        $req -> bindParam(':gift_name', $_POST["gift_name"]);
        $req -> bindParam(':date_gift', $_POST["gift_year"]);
        $req -> bindParam(':img', $_FILES["fileToUpload"]["name"]);
        $req -> bindParam(':id_user', $id);
        $exec = $req->execute();
        if ($exec === true) {
          header("location: success_add_gift.php?id=$id");
        }
    ?>
      
    </div>
    <footer class="footer_add_individual">
                <a href="gift_search.php?id=<?php $id?>">
                    <div class="close_file">FERMER</div>
                </a>
    </footer>
  </body>
</html>