<?php

session_start();
include("db_conn.php");
include("functions.php");

// Get the search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Modify the SQL query to include the search condition
if (!empty($searchQuery)) {
  $query = "SELECT images.name, images.image_url, users.user_name FROM images JOIN users ON images.user_id = users.user_id WHERE users.user_name LIKE '%$searchQuery%' OR images.name LIKE '%$searchQuery%' OR images.tags LIKE '%$searchQuery%'";
} else {
  $query = "SELECT images.name, images.image_url, users.user_name FROM images JOIN users ON images.user_id = users.user_id";
}

// Execute the query
$result = mysqli_query($conn, $query);

// Get the number of search results
$numResults = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html>
  <head>
    <title>higherBooru</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="./Main.css" rel="stylesheet" type="text/css"/>

</head>
  <body>
  <main class="main-container">
  <header class="topnav">
        <div class="topnav-left">
        <a href="Main.php">higherBooru</a>
</div>

        <div class="topnav-right">
        <?php
        if(isset($_SESSION['user_id'])){

          echo '<a href="logout.php?">Logout</a>';
          echo '<a href="upload.php" value="upload_button">Upload</a>';
        }
          elseif(empty($_SESSION['user_id'])) {
            echo '<a href="login.php?">Login</a>';
          }
?>
        </div>
</header>

    <div class="main" id="page-content">
      <main class="main-1">
        <section class="gallery">
          <h2 class="header-1">Artworks</h2>
        </section>
      </main>
    </div>

    <!-- Search bar -->
    <div class="search-bar">
      <form method="get">
        <input type="text" name="search" placeholder="Search" value="<?php echo $searchQuery; ?>">
        <button type="submit">Search</button>
      </form>
      <?php
      if (!empty($searchQuery)) {
        echo '<p>Showing ' . $numResults . ' results for "' . $searchQuery . '"</p>';
      }
      ?>
    </div>
    
    <!-- Sorting buttons -->
    <div class="button-sort" id="image-sort">
    <form method="get">
    <?php $selectedSort = isset($_GET['sort']) ? $_GET['sort'] : 'latest'; ?>     <!-- Checks for which sorting method is selected -->
    <label>Sort by:</label>
    <button type="submit" name="sort" value="latest"<?php if ($selectedSort === 'latest') echo ' class="active"'; ?>>Latest</button>
    <button type="submit" name="sort" value="oldest"<?php if ($selectedSort === 'oldest') echo ' class="active"'; ?>>Oldest</button>
    <button type="submit" name="sort" value="az"<?php if ($selectedSort === 'az') echo ' class="active"'; ?>>A-Z</button>
    <button type="submit" name="sort" value="za"<?php if ($selectedSort === 'za') echo ' class="active"'; ?>>Z-A</button>
    </form>
    </div>

    <div class="grid" id="image-grid">
      
    <?php
    // Fetch the search results
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $artistName = $row['user_name'];
          $imageName = $row['image_url'];

          echo '<div class="image-container">';
          echo '<div class="artist-name-container">';
          echo '<a href="artist/' . $artistName . '.php">' . $artistName . '</a>';
          echo '</div>';
          echo '<img src="images/' . $imageName . '">';
          echo '</div>';
        }
      } else {
        echo '<p>No results found.</p>';
      }
    
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
        // Get the image filename
        $filename = $images[$i];
        
        // Skip images that are not within the current page or do not match the search query (if provided)
        if ($i < $offset || $i >= $offset + $limit || (!empty($searchQuery) && !strstr($filename, $searchQuery))) {
          continue;
        }

        // Get the image filename
        $filename = $images[$i];

        // Get the artist's username based on the image's URL
        $query = "SELECT users.user_name FROM images JOIN users ON images.user_id = users.user_id WHERE images.image_url = '" . basename($filename) . "'";
        $result = mysqli_query($conn, $query);
        $artistName = '';
        if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $artistName = $row['user_name'];
        }

        // Image container
        echo '<div class="image-container" style="grid-column: ' . ($column_index + 1) . ';">';
        echo '<div class="artist-name-container">';
        if (!empty($artistName)) {
          echo '<a href="artist/' . $artistName . '.php">' . $artistName . '</a>';
        } else {
          echo $artistName; // Display the artist's name without a link
        }
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
        echo '<a href="?page=1">&laquo;</a>';
      } else {
        echo '<span class="disabled">&laquo;</span>';
      }
            
      // Link to previous page
      if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '">&#8249;</a>';
      } else {
        echo '<span class="disabled">&#8249;</span>';
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
        echo '<a href="?page=' . ($page + 1) . '">&#8250;</a>';
      } else {
        echo '<span class="disabled">&#8250;</span>';
      }

      // Link to last page
      if ($page < $total_pages) {
        echo '<a href="?page=' . $total_pages . '">&raquo;</a>';
      } else {
        echo '<span class="disabled">&raquo;</span>';
      }

      echo '</div>';

      ?>
  </main>

  </body>
</html>

