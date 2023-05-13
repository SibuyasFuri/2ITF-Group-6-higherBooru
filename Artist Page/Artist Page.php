<!DOCTYPE html>
<html>
  <head>
    <title>HigherBooru</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="gallery.css" rel="stylesheet">
    <script src="gallery.js"></script>

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

      .banner .header {

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

      .main .main-1 {
      }

      .main .gallery {

      }

      .main .header-1 {

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

    </style>
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
    </header>

    <div class="main" id="page-content">
      <main class="main-1">
          <br><br><br><br><center>

          <img src="Default_pfp.png" width="420" height="420"/><br><br><br>

          <a href="https://www.google.com/">
          <!-- Google.com here is a placeholder -->
          <h1>Artist Name</h1>
          </a><br>

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
    
    <div class="gallery"><?php
      // GET IMAGES IN GALLERY FOLDER
      $dir = __DIR__ . DIRECTORY_SEPARATOR . "gallery" . DIRECTORY_SEPARATOR;
      $images = glob("$dir*.{jpg,jpeg,gif,png,bmp,webp}", GLOB_BRACE);

      // OUTPUT IMAGES
      foreach ($images as $i) {
        $img = basename($i);
        $caption = substr($img, 0, strrpos($img, "."));
        printf("<figure><img src='gallery/%s'><figcaption>
        <center>

        Artwork Title
        
        </center>
        </figcaption></figure>", 
          rawurlencode($img), $caption
        );
      }
    ?></div>

  </body>
</html>
