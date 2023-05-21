<?php
session_start();
include("db_conn.php");
include("functions.php");

if (isset($_POST['submit']) && isset($_FILES['my_image'])) {
  include "db_conn.php";

  $img_name = $_FILES['my_image']['name'];
  $img_size = $_FILES['my_image']['size'];
  $tmp_name = $_FILES['my_image']['tmp_name'];
  $error = $_FILES['my_image']['error'];

  if ($error === 0) {
    if ($img_size > 12500000) {
      $em = "File is too large.";
      header("Location: upload.php?error=$em");
    } else {
      $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_ex_lc = strtolower($img_ex);

      $allowed_exs = array("jpg", "jpeg", "png", "PNG", "gif");
      if (in_array($img_ex_lc, $allowed_exs)) {
        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
        $img_upload_path = 'images/' . $new_img_name;

        move_uploaded_file($tmp_name, $img_upload_path);

        $title = $_POST["title"];
        $tags = $_POST['tags'];
        $tag = "";
        foreach ($tags as $row) {
          $tag .= $row . ",";
        }

        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO images (user_id, name, image_url, tags) VALUES ('$user_id', '$title', '$new_img_name', '$tag')";
        mysqli_query($conn, $sql);
        
        header("Location: Main.php");
      } else {
        $em = "You can't upload files of this type";
        header("Location: upload.php?error=$em");
      }
    }
  } else {
    $em = "An unknown error occurred!";
    header("Location: upload.php?error=$em");
  }
} else {
  header("Location: upload.php");
}
?>