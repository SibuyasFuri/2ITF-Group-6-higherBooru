<!DOCTYPE html>
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
    // Get Images in Gallery Folder
    $dir = __DIR__ . DIRECTORY_SEPARATOR . "gallery" . DIRECTORY_SEPARATOR;
    $images = glob("$dir*.{jpg,jpeg,gif,png,bmp,webp}", GLOB_BRACE);

    // Output Images
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