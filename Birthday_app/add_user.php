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
         <h1 class="title2">Ajouter une personne</h1>
        <img class="gifts_img" src="img/gifts.png"/>
      </header>
      <form class="form_individual" action="add_user.php" method="post" enctype="multipart/form-data">
        <div class="name_row">
          <div class="surname">
            <label for="surname">NOM*</label>
            <input type="text" name="surname" required="required" id="surname">
          </div>
          <div class="first_name">
            <label for="first_name">Prénom*</label>
            <input type="text" name="first_name" required="required" id="first_name">
          </div>
        </div>
        <div class="dob">
          <label for="dob">Date de naissance*</label>
          <input type="date" name="dob" required="required" id="dob">
          <p>* Champs obligatoires</p>
        </div>
        <div class="tel">
          <label for="tel">Numéro de téléphone</label>
          <input type="tel" name="phone" pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}" id="tel">
        </div>
        <input type="file" name="fileToUpload" id="file">
        <label for="file" class="btn_load_img">Ajouter une photo</label>
        <input type="submit" name="submit" value="AJOUTER">
      </form>

      <?php
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
          try {
            $db = new PDO('mysql:host=localhost;dbname=Birthday_project;charset=utf8', 'root', 'root');
            $sqlQuery = "INSERT INTO table_birthdays (surname, first_name, dob, phone, img) VALUES (:surname, :first_name, :dob, :phone, :img)";
            $req = $db -> prepare($sqlQuery);
            $req -> bindParam(':surname', $_POST["surname"]);
            $req -> bindParam(':first_name', $_POST["first_name"]);
            $req -> bindParam(':dob', $_POST["dob"]);
            $req -> bindParam(':phone', $_POST["phone"]);
            $req -> bindParam(':img', $_FILES["fileToUpload"]["name"]);
            $exec = $req->execute();
            if ($exec === true) {
              header("location: success.php");
            }
          }
          catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
        }
      ?>
    </div>
    <footer class="footer_add_individual">
                <a href="index.php">
                    <div class="close_file">FERMER</div>
                </a>
            </footer>
   </body>
</html>