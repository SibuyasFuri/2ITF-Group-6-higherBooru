<!DOCTYPE html>
<html>
  <head>
    <title>HigherBooru</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

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
        background-color: #f9f9f9;
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

            /* Set up the grid layout */
        .grid {
        display: grid;
        grid-template-columns: repeat(4, 5fr);
        grid-gap: 10px;
        padding-left: 16rem;
        padding-right: 16rem;
      }
      
      /* Set up the image containers */
      .image-container {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 133.33%; /* 3:4 aspect ratio */
        overflow: hidden;
      }
      
      /* Style the images */
      .image-container img {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .image-info {
        padding-bottom: 2rem;
      }
      
      /* Hide all pages except the first one */
      .page {
        display: none;
      }
      .page:first-of-type {
        display: grid;
      }
      
      /* Style the pagination buttons */
      .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
      }
      .pagination button {
        margin: 0 5px;
        padding: 5px 10px;
        border: none;
        background-color: #eee;
        cursor: pointer;
      }
      .pagination button:hover {
        background-color: #ccc;
      }
      .pagination button.active {
        background-color: #ddd;
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
        <section class="gallery">
          <h2 class="header-1">Artworks</h2>
        </section>
      </main>
    </div>
    <div class="grid" id="image-grid">
    <?php

$limit = 20;
$num_columns = 4;
$images = glob("images/*.{jpg,jpeg,png,gif}", GLOB_BRACE);

// Calculate the total number of pages
$total_pages = ceil(count($images) / $limit);

// Get the current page from the query string
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the images
$offset = ($page - 1) * $limit;

// Initialize the column index
$column_index = 0;

// Loop through the images and display them in the grid
for ($i = 0; $i < count($images); $i++) {
  // Skip images that are not within the current page
  if ($i < $offset || $i >= $offset + $limit) {
    continue;
  }

  // Get the image filename
  $filename = $images[$i];
  
  // Image container
  echo '<div class="image-container" style=grid-column: ' . ($column_index + 1) . ';">';
  echo '<img src="' . $filename . '">';
  echo '</div>';

  // Increment the column index and reset it if necessary
  $column_index++;
  if ($column_index >= $num_columns) {
    $column_index = 0;
  }
}

// Output links to navigate between pages
if ($page > 1) {
  echo '<a href="?page=' . ($page - 1) . '">Previous page</a>';
}

for ($p = 1; $p <= $total_pages; $p++) {
  if ($p == $page) {
    echo '<span class="current-page">' . $page . '</span>';
  } else {
    echo '<a href="?page=' . $p . '">' . $p . '</a>';
  }
}

if ($page < $total_pages) {
  echo '<a href="?page=' . ($page + 1) . '">Next page</a>';
}

?>

  <!-- Navigation buttons for switching between pages -->
   <div class="navigation">
     <?php
      //  // Output a button for each page
      //  for ($page = 1; $page <= $total_pages; $page++) {
      //    echo '<button class="page-button" data-page="' . $page . '">' . $page  . '</button>';
      //  }
     ?>
   </div>

  <script>

    
    // Select all navigation buttons
    const pageButtons = document.querySelectorAll('.page-button');
    
    // Add a click event listener to each button
    pageButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Get the page number from the data-page attribute
        const pageNumber = button.dataset.page;
        
        // Hide all pages except the one with the selected page number
        const pages = document.querySelectorAll('.page');
        pages.forEach(page => {
          if (page.id === 'page-' + pageNumber) {
            page.style.display = 'grid';
          } else {
            page.style.display = 'none';
          }
        });
      });
    });
      


    </script> 
  </body>
</html>
