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
$html = 
'
<?php
session_start();
include("../db_conn.php");
include("../functions.php");
$userDisplay = "";
$userID = "";
$userDate = "";


if (!empty($searchQuery)) {
  
  $query = "SELECT images.name, images.image_url, images.user_id, users.user_name, images.dateUploaded FROM images";
} else {
  $query = "SELECT images.name, images.image_url, images.user_id, users.user_name, images.dateUploaded FROM images JOIN users ON images.user_id = users.user_id";
}

$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // Process each row
    $userDisplay = $row[\'user_name\']; 
    $userID = $row[\'user_id\'];
    $userDate = $row[\'dateUploaded\'];
  }
}

?>

<!DOCTYPE html>


<html>
  <head>
    
    <title>HigherBooru</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
      /* Add styles for the navigation bar */
      .navbar {
        background-color: #333;
        overflow: hidden;
      }

      /* Style the links inside the navigation bar */
      .navbar a {
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
      }

      /* Style the dropdown menu */
      .dropdown {
        float: left;
        overflow: hidden;
      }

      /* Style the dropdown button */
      .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        margin: 0;
      }

      /* Style the dropdown content */
      .dropdown-content {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: #101016;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      }

      /* Style the links inside the dropdown */
      .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
      }

      /* Add a hover effect for links inside the dropdown */
      .dropdown-content a:hover {
        background-color: #ddd;
      }

      /* Show the dropdown menu when the user moves the mouse over the dropdown button */
      .dropdown:hover .dropdown-content {
        display: block;
      }

      body {
        background-color:  #101016;
        color: white;
      }

      .banner {
        padding-top: 12rem;
        padding-left: 16rem;
        padding-right: 16rem;;
      }

      h1.Title {
        padding-bottom: 10px;
      }

      h2.header-1 {
        padding-top: 10px;
      }

      .main {
        padding-left: 16rem;
        padding-right: 16rem;
        padding-bottom: 4rem;
        border-top: 1px solid rgba(255,255,255,0.5);
      }


      a:link {
      color: white;
      background-color: transparent;
      text-decoration: none;
      }

      a:visited {
        color: white;
        background-color: transparent;
        text-decoration: none;
      }

      a:hover {
      color: white;
      background-color: transparent;
      text-decoration: underline;
      }

      a:active {
        color: white;
        background-color: transparent;
        text-decoration: none;
      }


      /* Gallery Container */
      .gallery {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 8px;
        max-width: 1200px;
        margin: 0 auto;
      }

      /* Thumbanils & Caption */
      .gallery figure {
        margin: 0;
        background: transparent;
      }
      .gallery img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        cursor: pointer;
      }
      .gallery figcaption {
        font-size: 1.0em;
        text-align: center;
        color: #fff;
        padding: 5px 10px;
      }

      /* Fullscreen Image */
      .gallery img.full {
        position: fixed;
        top: 0; left: 0; z-index: 999;
        width: 100%; height: 100%;
        object-fit: contain;
        background-color: rgba(16, 16, 22, 0.6);
        cursor: pointer;
        padding-top: 2rem;
        padding-bottom: 12rem;
      }
      .gallery .caption-non-full {
        display: block;
        text-align: center;
      }
      .gallery .caption-full {
        display: none;
        position: fixed;
        top: 85%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.6);
        color: #fff;
        padding: 10px;
        font-size: 16px;
        z-index: 9999;
        text-align: center;
      }
      .gallery img.full + .caption-full {
        display: block;
      }

      /* Animation */
      .gallery { overflow-x: hidden; }
      .gallery img { transition: all 0.3s; }
    </style>


    <script>
      window.addEventListener("DOMContentLoaded", () => {
        // Get All Images
        var all = document.querySelectorAll(".gallery img");

        // Click on Image to Toggle Fullscreen
        if (all.length > 0) {
          for (let img of all) {
            img.onclick = () => {
              // Toggle Full-Screen Class
              img.classList.toggle("full");

              // Get the Corresponding Caption Elements
              var captionNonFull = img.nextElementSibling;
              var captionFull = img.nextElementSibling.nextElementSibling;

              if (img.classList.contains("full")) {
                // Image is in Full-Screen Mode
                captionNonFull.style.display = "none";
                captionFull.style.display = "block";
                
                // Disable Scrolling
                document.body.style.overflow = "hidden";
                
              } else {
                // Image is Not in Full-Screen Mode
                captionNonFull.style.display = "block";
                captionFull.style.display = "none";
                
                // Enable Scrolling
                document.body.style.overflow = "auto";
              }
            };
          }
        }
    });
    </script>

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

          <h1><?php echo $userDisplay; ?></h1>
          <br>

          <h5 style="color:gray;">
          UID: <?php echo $userID ?><br> Account Created: <?php echo $userDate ?>
          </h5><br><br>
          <h4 id=\'description\'>
          User Description
        </h4>
        <button id="changeDesc">Edit</button>
        
          
        <script>
  window.addEventListener("DOMContentLoaded", () => {
    var labelElement = document.getElementById(\'description\');
    var storedDescription = localStorage.getItem(\'userDescription\');

    if (storedDescription) {
      labelElement.textContent = storedDescription;
    }

    document.getElementById(\'changeDesc\').addEventListener(\'click\', function() {
      var newText = prompt(\'Enter the new text for the label:\', storedDescription || \'\');

      if (newText !== null && newText !== \'\') {
        labelElement.textContent = newText;
        localStorage.setItem(\'userDescription\', newText);
      }
    });
  });
</script>

        

          </center><br><br><br><br><br><br>

        <section class="gallery">
          <h2 class="header-1">Artworks</h2>
        </section>
      </main>
    </div>
    
    <div class="gallery">
    <?php
    // Get Images in Gallery Folder
    $dir = __DIR__ . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR;
    $images = glob("$dir*.{jpg,jpeg,gif,png,bmp,webp}", GLOB_BRACE);

    // Output Images
    foreach ($images as $i) {
      $img = basename($i);
      $caption = substr($img, 0, strrpos($img, "."));
      printf("<figure>

                <img src=\'images/%s\'>

                <figcaption class=\'caption-non-full\'>
                  %s
                </figcaption>

                <figcaption class=\'caption-full\'>
                  %s<br>Artist: Artist Name<br>Date Uploaded: DD/MM/YYYY
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
die();
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
