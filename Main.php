<?php
session_start();
include("db_conn.php");
include("functions.php");

// Get the search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Get the sorting parameter from the query string
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';

// Modify the SQL query to include the necessary columns
if (!empty($searchQuery)) {
  $query = "SELECT images.name, images.image_url, users.user_name FROM images JOIN users ON images.user_id = users.user_id WHERE users.user_name LIKE '%$searchQuery%' OR images.name LIKE '%$searchQuery%' OR images.tags LIKE '%$searchQuery%'";
} else {
  $query = "SELECT images.name, images.image_url, users.user_name FROM images JOIN users ON images.user_id = users.user_id";
}

// Add the sorting condition to the SQL query
switch ($sort) {
  case 'oldest':
    // Sort by file's last modified timestamp in ascending order
    $query .= " ORDER BY images.image_url ASC";
    break;
  case 'az':
    $query .= " ORDER BY images.name ASC";
    break;
  case 'za':
    $query .= " ORDER BY images.name DESC";
    break;
  default:
    // Sort by file's last modified timestamp in descending order (default: latest)
    $query .= " ORDER BY images.image_url DESC";
    break;
}

// Execute the query
$result = mysqli_query($conn, $query);

// Get the number of search results from the database
$numResults = mysqli_num_rows($result);

// Calculate the total number of pages for the database results
$totalDatabasePages = ceil($numResults / 20);

// Get the current page from the query string
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the database results
$offset = ($page - 1) * 20;

// Modify the SQL query to include the pagination limit
$query .= " LIMIT $offset, 20";
$result = mysqli_query($conn, $query);

// Specify the image directory
$imageDirectory = "images/";

// Get the directory images
$directoryImages = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE) ?: [];
$numDirectoryImages = count($directoryImages);

// Calculate the total number of pages for the combined results
$totalCombinedPages = ceil(($numResults + $numDirectoryImages) / 20);

// Calculate the offset for the combined results
$combinedOffset = ($page - 1) * 20;

// Combine the database results and directory images
$combinedResults = array_merge(mysqli_fetch_all($result, MYSQLI_ASSOC), $directoryImages);

$currentPageResults = array_slice($combinedResults, $combinedOffset, 20);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>higherBooru</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="./Main.css" rel="stylesheet" type="text/css"/>

    <style>
        .image-container figure {
          margin: 0;
          background: transparent;
        }

        .image-container figcaption {
          font-size: 1.0em;
          text-align: center;
          color: #fff;
          padding: 5px 10px;
        }

        /* Fullscreen Image */
        .image-container .full {
          position: fixed;
          top: 0; left: 0; z-index: 999;
          width: 100%; height: 100%;
          object-fit: contain;
          background-color: rgba(16, 16, 22, 0.6);
          cursor: pointer;
          padding-top: 2rem;
          padding-bottom: 12rem;
        }
        .image-container .caption-full {
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
        .image-container img.full + .caption-full {
          display: block;
        }

        /* Animation */
        .image-container { overflow-x: hidden; }
        .image-container img { transition: all 0.3s; }
    </style>


    <script>
      window.addEventListener("DOMContentLoaded", () => {
        // Get All Images
        var all = document.querySelectorAll(".image-container img");

        // Click on Image to Toggle Fullscreen
        if (all.length > 0) {
          for (let img of all) {
            img.onclick = () => {
              // Toggle Full-Screen Class
              img.classList.toggle("full");

              // Get the Corresponding Caption Elements
              var captionFull = img.nextElementSibling;

              if (img.classList.contains("full")) {
                // Image is in Full-Screen Mode
                captionFull.style.display = "block";
                
                // Disable Scrolling
                document.body.style.overflow = "hidden";
                
              } else {
                // Image is Not in Full-Screen Mode
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
          echo '<a href="login.php?">Login/Register</a>';
        }
        ?>
        </div>
  </header>

    <div class="main" id="page-content">
      <main class="main-1">
        <section class="gallery">
          <h2 class="header-1">Artworks</h2>
        </section>
        <!-- Search bar -->
        <div class="search-bar">
      <form method="get">
      <button class="search-btn" type="submit">Search</button>
        <input type="text" class="search-input" name="search" value="<?php echo $searchQuery; ?>">
      </form>
      <?php
      if (!empty($searchQuery)) {
        echo '<br><p>Showing ' . $numResults . ' results for "' . $searchQuery . '"</p>';
      }
      ?>
    </div>
      </main>
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
    // Fetch the search results from the combined results
    if (!empty($currentPageResults)) {
      foreach ($currentPageResults as $result) {
        if (is_array($result)) {
          $artistName = $result['user_name'];
          $imageName = $result['image_url'];

          echo '<div class="image-container">';
          echo '<div class="artist-name-container">';
          echo '<a href="artist/' . $artistName . '.php">' . $artistName . '</a>';
          echo '</div>';
          echo '<img src="images/' . $imageName . '">';
          echo '</div>';
        } else {
          // Assuming $result is the file path of a directory image
          echo '<div class="image-container">';
          echo '<img src="' . $result . '">';
          echo '</div>';
        }
      }
    }

        // Display a message if no results found
        if (empty($currentPageResults)) {
          echo '<p>No results found.</p>';
        }
        ?>
      </div>

      <?php

      // Calculate the range of visible pages
      $visibleRange = 5;

      // Calculate the starting and ending page numbers for the visible range
      $startPage = max(1, $page - $visibleRange);
      $endPage = min($totalCombinedPages, $page + $visibleRange);

      // Display the page navigation links
      echo '<div class="page-navigation">';

      // Link to first page with sorting parameter
      if ($page > 1) {
        echo '<a href="?page=1&sort=' . $sort . '">&laquo;</a>';
      } else {
        echo '<span class="disabled">&laquo;</span>';
      }

      // Link to previous page with sorting parameter
      if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '&sort=' . $sort . '">&#8249;</a>';
      } else {
        echo '<span class="disabled">&#8249;</span>';
      }

      // Output links to individual pages with sorting parameter
      for ($p = $startPage; $p <= $endPage; $p++) {
        if ($p == $page) {
          echo '<span class="current-page">' . $page . '</span>';
        } else {
          echo '<a href="?page=' . $p . '&sort=' . $sort . '">' . $p . '</a>';
        }
      }

      // Link to next page with sorting parameter
      if ($page < $totalCombinedPages) {
        echo '<a href="?page=' . ($page + 1) . '&sort=' . $sort . '">&#8250;</a>';
      } else {
        echo '<span class="disabled">&#8250;</span>';
      }

      // Link to last page with sorting parameter
      if ($page < $totalCombinedPages) {
        echo '<a href="?page=' . $totalCombinedPages . '&sort=' . $sort . '">&raquo;</a>';
      } else {
        echo '<span class="disabled">&raquo;</span>';
      }

      echo '</div>';
?>
  </main>

  </body>
</html>