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
        margin-top: 2rem; /* adjust this to add more space for the artist name */
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      /* Style the artist names */
      .image-container .artist-name-container {
        padding-left: 5px;
        cursor: pointer;
      }

      /* NOT USED
      .image-info {
        padding-bottom: 2rem;
      } */
      
      /* Hide all pages except the first one */
      .page {
        display: none;
      }
      .page:first-of-type {
        display: grid;
      }
      
      /* Style the pagination numbers */
      .page-navigation {
        display: flex;
        justify-content: center;
        padding-top: 4rem;
        padding-bottom: 8rem;
        color: black;
      }

      /* Style the pagination buttons (ellipses only) */
      .page-navigation span {
        display: flex;
        justify-content: center;
        padding-left: 5px;
        padding-right: 5px;
        font-size: 20px;
        margin: 0 5px;
        border: none;
        width: 40px;
        height: 40px;
        background-color: #eee;
      }

      /* Style the pagination buttons (everything else) */
      .page-navigation a {
        display: flex;
        justify-content: center;
        padding-left: 5px;
        padding-right: 5px;
        font-size: 20px;
        margin: 0 5px;
        border: none;
        width: 40px;
        height: 40px;
        background-color: #eee;
        cursor: pointer;
      }
      
      /* pagination button ellipses only. NOT CSS NEEDED, THIS IS ALWAYS TO BE INACTIVE */
      /* .page-navigation span:hover {
        background-color: #ccc;
      } */

      /* pagination button ellipses only. NOT CSS NEEDED, THIS IS ALWAYS TO BE INACTIVE */
      /* .page-navigation span.active {
        background-color: #ddd;
      } */

      /* pagination button everything else */
      .page-navigation a:hover {
        background-color: #ccc;
      }

      /* pagination button everything else */
      .page-navigation a.active {
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
    
    <!-- Sorting buttons -->
    <form method="get">
    <label>Sort by:</label>
    <button type="submit" name="sort" value="latest">Latest</button>
    <button type="submit" name="sort" value="oldest">Oldest</button>
    <button type="submit" name="sort" value="az">A-Z</button>
    <button type="submit" name="sort" value="za">Z-A</button>
    </form>

    <div class="grid" id="image-grid">
    <?php

      $limit = 20;
      $num_columns = 4;
      $images = glob("images/*.{jpg,jpeg,png,gif}", GLOB_BRACE);

// Sort by latest
function sortLatest($a, $b) {
  return filemtime($b) - filemtime($a);
}

// Sort by oldest
function sortOldest($a, $b) {
  return filemtime($a) - filemtime($b);
}

// Sort by A-Z
function sortAZ($a, $b) {
  return strcmp($a, $b);
}

// Sort by Z-A
function sortZA($a, $b) {
  return strcmp($b, $a);
}

// Default sort is by latest modification time
usort($images, 'sortLatest');

// Check if the user has selected a different sort order
if (isset($_GET['sort'])) {
  $sort = $_GET['sort'];
  switch ($sort) {
      case 'latest':
          usort($images, 'sortLatest');
          break;
      case 'oldest':
          usort($images, 'sortOldest');
          break;
      case 'az':
          usort($images, 'sortAZ');
          break;
      case 'za':
          usort($images, 'sortZA');
          break;
      default:
          // Invalid sort option, fall back to default sort
          usort($images, 'sortLatest');
          break;
  }
}

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
        echo '<div class="artist-name-container">';
        echo 'add artist page link here'; // !!! important !!! //
        echo '</div>';
        echo '<img src="' . $filename . '">';
        echo '</div>';

        // Increment the column index and reset it if necessary
        $column_index++;
        if ($column_index >= $num_columns) {
          $column_index = 0;
        }
      }

      // Output the closing tag for the grid container div
      echo '</div>';

      // Add a new div for the page navigation links
      echo '<div class="page-navigation">';
      
      // Link to first page
      if ($page > 1) {
        echo '<a href="?page=1">First</a>';
      } else {
        echo '<span class="disabled">First</span>';
      }
            
      // Link to previous page
      if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '">Prev</a>';
      } else {
        echo '<span class="disabled">Prev</span>';
      }

      // Output links to individual pages
      $start = 1;
      $end = $total_pages;

      if ($total_pages > 11) {
        if ($page <= 5) {
          $end = 11;
        } elseif ($total_pages - $page <= 5) {
          $start = $total_pages - 10;
        } else {
          $start = $page - 5;
          $end = $page + 5;
        }
      }

      if ($start > 1) {
        echo '<span class="ellipsis">&hellip;</span>';
      }

      for ($p = $start; $p <= $end; $p++) {
        if ($p == $page) {
          echo '<span class="current-page">' . $page . '</span>';
        } else {
          echo '<a href="?page=' . $p . '">' . $p . '</a>';
        }
      }

      if ($end < $total_pages) {
        echo '<span class="ellipsis">&hellip;</span>';
      }

      // Link to next page
      if ($page < $total_pages) {
        echo '<a href="?page=' . ($page + 1) . '">Next</a>';
      } else {
        echo '<span class="disabled">Next</span>';
      }

      // Link to last page
      if ($page < $total_pages) {
        echo '<a href="?page=' . $total_pages . '">Last</a>';
      } else {
        echo '<span class="disabled">Last</span>';
      }

      echo '</div>';

      ?>
      

  </body>
</html>
