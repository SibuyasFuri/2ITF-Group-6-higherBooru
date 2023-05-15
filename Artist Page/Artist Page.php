<!DOCTYPE html>
<html>
  <head>
    <title>HigherBooru</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <script src="gallery.js"></script>
    <!-- <script src="gallery (2).js"></script> -->


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


      /* GALLERY CONTAINER */
      .gallery {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 8px;
        max-width: 1200px;
        margin: 0 auto;
      }

      /* THUMBNAILS & CAPTION */
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
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1.0em;
        text-align: center;
        color: #fff;
        padding: 5px 10px;
      }

      /* FULLSCREEN IMAGE */
      .gallery img.full {
        position: fixed;
        top: 0; left: 0; z-index: 999;
        width: 100%; height: 100%;
        object-fit: contain;
        background-color: rgba(16, 16, 22, 0.6);
        cursor: pointer;
        padding-left: 16rem;
        padding-right: 16rem;
      }
      .gallery .caption-non-full {
        display: block;
      }
      .gallery .caption-full {
        display: none;
        position: fixed;
        top: 20px;
        left: 10%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 10px;
        font-size: 16px;
        z-index: 9999;
      }
      .gallery img.full + .caption-full {
        display: block;
      }

      /* ANIMATION */
      .gallery { overflow-x: hidden; }
      .gallery img { transition: all 0.3s; }


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

          <h1>Artist Name</h1>
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
    // GET IMAGES IN GALLERY FOLDER
    $dir = __DIR__ . DIRECTORY_SEPARATOR . "gallery" . DIRECTORY_SEPARATOR;
    $images = glob("$dir*.{jpg,jpeg,gif,png,bmp,webp}", GLOB_BRACE);

    // OUTPUT IMAGES
    foreach ($images as $i) {
      $img = basename($i);
      $caption = substr($img, 0, strrpos($img, "."));
      printf("<figure>
                <img src='gallery/%s'>
                <figcaption class='caption-non-full'>
                  <center>%s</center>
                </figcaption>
                <figcaption class='caption-full'>
                  <center>%s<br>Artist: Artist Name<br>Date Uploaded: DD/MM/YYYY</center>
                </figcaption>
              </figure>",
        rawurlencode($img), $caption, $caption
      );
    }
  ?>
</div>

  </body>
</html>
