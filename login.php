<?php
session_start();
include("db_conn.php");
include("functions.php");

///if(isset($_SESSION['user_id']))
//{
	//header("Location:Main.php?success=1'");
//} else {
if($_SERVER['REQUEST_METHOD'] == "POST"){
    //something was posted

   $user_name = $_POST['user_name'];
    $password =$_POST['password'];

    if(!empty($user_name) && !empty($password)){

//reading to database


$query = "select * from users where user_name = '$user_name' limit 1";
$result = mysqli_query($conn, $query);

if($result){
    if($result && mysqli_num_rows($result) > 0){

        $user_data = mysqli_fetch_assoc($result);
        if($user_data['password']=== $password){
            $_SESSION['user_id'] = $user_data['user_id'];
            header("Location: Main.php");
            die;
        }

    }
}

echo "Wrong Username or Password";
    }
    else {
        echo "Please Input Valid Data";
    }
}
//
?>

<?php
//signup area


if($_SERVER['REQUEST_METHOD'] == "POST"){
    //something was posted

   $user_name = $_POST['user_name'];
    $password =$_POST['password'];

    if(!empty($user_name) && !empty($password)){

//saving to database

// saving to database
$user_id = rand(0, 999);
$query = "INSERT INTO users (user_id, user_name, password) VALUES ('$user_id', '$user_name', '$password')";
mysqli_query($conn, $query);

// Create the HTML page for the user
$html = '<!DOCTYPE html>
<html>
  <head>
    
    <title>HigherBooru</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="Artist Page.css" rel="stylesheet">
    <script src="Artist Page.js"></script>

</head>
  <body>
    <div class="navbar">
      <div class="dropdown">
        <button class="dropbtn">Menu &#9660;</button>
        <div class="dropdown-content">
          <a href="Main.php">Home</a>
          <a href="Works.php">Works</a>
          <a href="About.php">About</a>
        </div>
      </div> 
    </div>
    
    <header class="banner">
      <div class="header">
        <h1 class="Title">HigherBooru</h1>
      </div>
    </header>

    <div class="main" id="page-content">
      <main class="main-1">
          <br><br><br><br><center>

          <img src="Default_pfp.png" width="420" height="420"/><br><br><br>

          <h1>$user_name</h1>
          <br>

          <h5 style="color:gray;">
          UID: 75425647 <br> Account Created: DD/MM/YYYY
          </h5><br><br>

          <h4>
          The quick brown fox jumps over the lazy dog.<br> 
          The quick brown fox jumps over the lazy dog.<br>
          The quick brown fox jumps over the lazy dog.
          </h4>

          </center><br><br><br><br><br><br>

        <section class="gallery">
          <h2 class="header-1">Artworks</h2>
        </section>
      </main>
    </div>
    
    <div class="gallery">
    <?php
    // Get Images in Gallery Folder
    $dir = __DIR__ . DIRECTORY_SEPARATOR . "gallery" . DIRECTORY_SEPARATOR;
    $images = glob("$dir*.{jpg,jpeg,gif,png,bmp,webp}", GLOB_BRACE);

    // Output Images
    foreach ($images as $i) {
      $img = basename($i);
      $caption = substr($img, 0, strrpos($img, "."));
      printf("<figure>
                <img src=\'gallery/%s\'>
                <figcaption class=\'caption-non-full\'>
                  <center>%s</center>
                </figcaption>
                <figcaption class=\'caption-full\'>
                  <center>%s<br>Artist: Artist Name<br>Date Uploaded: DD/MM/YYYY</center>
                </figcaption>
              </figure>",
        rawurlencode($img), $caption, $caption
      );
    }
    ?>
    </div>

  </body>
</html>';

//Defines the directory path for the created page
$pageDirectory = 'artist/';

// Save the HTML page with the user's username as the filename
$filename = $pageDirectory . $user_name . ".php";
file_put_contents($filename, $html);

// Redirection
header("Location: login.php");
die;
    }
	else {
        echo "Please Input Valid Data";
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="./login.css" rel="stylesheet" type="text/css"/>
</head>
<body>
      <div class="form-box">
        <div class ="button-box">
            <div id = "btn"> </div>
            <button type = "button" class = "toggle-btn" onclick = "login()">Log In</button>
            <button type = "button" class = "toggle-btn" onclick = "register()">Register</button>
        </div>

    <h1>higherBooru</h1>
    <form id = "login" class = "input-group" method ="post">
        <input type = "text" class = "input-field" placeholder="User ID" name ="user_name" required>
        <input type = "password" class = "input-field" placeholder="Enter Password" name ="password" required>
        <button type= "submit" class = "submit-btn" name= "submit_login" value = "Login">Log In</button>
        <button class = "back-btn" onclick="history.back()">Back</button>
    </form>
    <form id = "register" class = "input-group" method = "post">
        <input type = "text" class = "input-field" placeholder="User ID" name = "user_name" required>
        <input type = "password" class = "input-field" placeholder="Enter Password" name = "password" required>
        <button type= "submit" class = "submit-btn" name ="submit_registration" value ="Signup">Register</button>
        <button class = "back-btn" onclick="history.back()">Back</button>
    </form>
      </div>

        <script>
        var x = document.getElementById('login');
        var y = document.getElementById('register');
        var z = document.getElementById('btn');

        function register(){
          x.style.left = "-400px";
          y.style.left = "50px";
          z.style.left = "110px";
        }
        function login(){
          x.style.left = "50px";
          y.style.left = "450px";
          z.style.left = "0";
        }
        
        </script>
	</body>
</html>
