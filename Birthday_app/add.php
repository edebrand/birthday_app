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
          header("location: success.php");
        }
    ?>