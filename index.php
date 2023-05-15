<!DOCTYPE html>
<html>
  <head>
    <title>higherBooru</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="./index.css" rel="stylesheet" type="text/css"/>
</head>
  <body>
  <main class="main-container">
  <header class="topnav topnav-left">
        <a class="active" href="#dashboard">Dashboard</a>

        <div class="topnav-right">
          <a href="#login/register">Login/Register</a>
          <a href="#upload">Upload</a>
        </div>
</header>
    
    <header class="banner">
      <div class="header">
        <h1 class="Title">higherBooru</h1>
    </header>

    <div class="main" id="page-content">
      <main class="main-1">
        <section class="gallery">
          <h2 class="header-1">Artworks</h2>
        </section>
      </main>
    </div>
    
    <!-- Sorting buttons -->
    <div class="button-sort" id="image-sort">
    <form method="get">
    <label>Sort by:</label>
    <button type="submit" name="sort" value="latest">Latest</button>
    <button type="submit" name="sort" value="oldest">Oldest</button>
    <button type="submit" name="sort" value="az">A-Z</button>
    <button type="submit" name="sort" value="za">Z-A</button>
    </form>
    </div>

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
  </main>

  </body>
</html>