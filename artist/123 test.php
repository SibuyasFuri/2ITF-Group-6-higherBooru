<?php
session_start();
include("../db_conn.php");
include("../functions.php");

// Get the search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Add the sorting condition to the SQL query
$query = "SELECT images.name, images.image_url, users.user_name, users.user_id, images.dateUploaded FROM images JOIN users ON images.user_id = users.user_id WHERE users.user_name LIKE '%$searchQuery%' OR images.name LIKE '%$searchQuery%' OR images.tags LIKE '%$searchQuery%'";

// Get the sorting parameter from the query string
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';

// Modify the SQL query based on the sorting parameter
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
$result = mysqli_query($conn, $query);

$userDisplay = "";
$userID = "";
$userDate = "";

// Fetch user information
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $userDisplay = $row['user_name']; 
  $userID = $row['user_id'];
  $userDate = $row['dateUploaded'];
}

$query = "SELECT images.name, images.image_url, users.user_name, users.user_id, images.dateUploaded FROM images JOIN users ON images.user_id = users.user_id WHERE (users.user_name LIKE '%$searchQuery%' OR images.name LIKE '%$searchQuery%' OR images.tags LIKE '%$searchQuery%') AND users.user_name = '$userDisplay'";

$perPage = 20;

// Get the current page from the query string
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the database results
$offset = ($page - 1) * $perPage;

// Modify the SQL query to include the pagination limit
$query .= " LIMIT $offset, $perPage";

// Execute the modified query
$result = mysqli_query($conn, $query);

// Get the total number of search results from the database
$numResults = mysqli_num_rows($result);

// Calculate the total number of pages for the search results
$totalPages = ceil($numResults / $perPage);
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

    .topnav {
        overflow: hidden;
        background-color: rgba(49, 49, 56, 0.5);
        backdrop-filter: blur(3px);
        position: sticky;
        top: 0px;
        z-index: 100;
        border-bottom: 1px solid rgba(255,255,255,0.5);
    }
    .topnav-right {
        float: right;
        margin-right: 10px;
        margin-top: 10px;
    }
    .topnav-left {
        font-family: "Quicksand", sans-serif;
        font-size: 30px;
    }
    .topnav a {
        float: left;
        margin-left: 5px;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        transition-duration: 0.3s;
    }
      
    .topnav a:hover {
        text-shadow: 0px 0px 5px white;
        transition-timing-function: ease-in-out;
    }
    
    /* Style the pagination numbers */
.page-navigation {
    display: flex;
    justify-content: center;
    padding-top: 4rem;
    padding-bottom: 8rem;
    color: white;
    text-decoration: none;
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
    align-items: center;
    color: white;
}
/* Style the pagination buttons (everything else) */
.page-navigation a {
    display: flex;
    justify-content: center;
    font-size: 20px;
    padding-top: 5;
    margin: 0 5px;
    border: none;
    width: 40px;
    height: 40px;
    cursor: pointer;
    text-decoration: none;
    color: white;
    align-items: center;
    transition-duration: 0.3s;
}
/* pagination button everything else */
.page-navigation a:hover {
    color: #A7A7AA;
    border-radius: 5px;
    align-items: center;
    transition-timing-function: ease-in-out;
}
/* pagination button everything else */
.page-navigation a.active {
    background-color: #ddd;
    align-items: center;
}
/* current page style */
.page-navigation .current-page {
    background-color: #4F4F54;
    border-radius: 5px;
    align-items: center;
}

.button-sort {
    padding-left: 16rem;
    padding-bottom: 1rem;
}

/* Style the sorting buttons */
.button-sort button {
    display: inline-block;
    padding: 5px 10px;
    margin: 0 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    color: white;
    background-color: transparent;
    outline: none;
    transition-duration: .3s;
}

  /* Style the active sorting button */
.button-sort button.active {
    background-color: #4F4F54;
    color: white;
    transition-duration: .3s;
}

  /* Style the sorting buttons on hover */
.button-sort button:hover {
    color: #A7A7AA;
    transition-timing-function: ease-in-out;
}

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
  <main class="main-container">
  <header class="topnav">
        <div class="topnav-left">
        <a href="Main.php">higherBooru</a>
        </div>

        <div class="topnav-right">
        <?php
        if(isset($_SESSION['user_id'])){
        
          echo '<a href="../logout.php?/">Logout</a>';
          echo '<a href="../upload.php/" value="upload_button">Upload</a>';
        }
        elseif(empty($_SESSION['user_id'])) {
          echo '<a href="../login.php?/">Login/Register</a>';
        }
        ?>
        </div>
  </header>
    
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
          <h4 id='description'>
          User Description
        </h4>
        <button id="changeDesc">Edit</button>
        
          
        <script>
  window.addEventListener("DOMContentLoaded", () => {
    var labelElement = document.getElementById('description');
    var storedDescription = localStorage.getItem('userDescription');

    if (storedDescription) {
      labelElement.textContent = storedDescription;
    }

    document.getElementById('changeDesc').addEventListener('click', function() {
      var newText = prompt('Enter the new text for the label:', storedDescription || '');

      if (newText !== null && newText !== '') {
        labelElement.textContent = newText;
        localStorage.setItem('userDescription', newText);
      }
    });
  });
</script>

        

          </center><br><br><br><br><br><br>

        <section class="gallery">
          <h2 class="header-1">Artworks</h2>
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
        </section>
      </main>
    </div>
    
    <div class="gallery">
  <?php
  // Get Images in Gallery Folder
  $dir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR;
  $images = glob("$dir*.{jpg,jpeg,gif,png,bmp,webp}", GLOB_BRACE);

  
  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      // Process each row
      $userDisplay = $row['user_name']; 
      $userID = $row['user_id'];
      $userDate = $row['dateUploaded'];
  
      // Output the image gallery using the values from $row
      echo "<figure>";
      echo "<img src='../images/" . rawurlencode($row['image_url']) . "'>";
      echo "<figcaption class='caption-non-full'>" . $row['name'] . "</figcaption>";
      echo "<figcaption class='caption-full'>" . $row['name'] . "<br>Artist: " . $row['user_name'] . "<br>Date Uploaded: " . $row['dateUploaded'] . "</figcaption>";
      echo "</figure>";
    }
  }
  // Calculate the range of visible pages
$visibleRange = 5;

// Calculate the starting and ending page numbers for the visible range
$startPage = max(1, $page - $visibleRange);
$endPage = min($totalPages, $page + $visibleRange);

// Display the page navigation links
echo '<div class="page-navigation">';

// Link to first page
if ($page > 1) {
  echo '<a href="?page=1">First</a>';
} else {
  echo '<span class="disabled">First</span>';
}

// Link to previous page
if ($page > 1) {
  echo '<a href="?page=' . ($page - 1) . '">&lt;</a>';
} else {
  echo '<span class="disabled">&lt;</span>';
}

// Output links to individual pages
for ($p = $startPage; $p <= $endPage; $p++) {
  if ($p == $page) {
    echo '<span class="current-page">' . $page . '</span>';
  } else {
    echo '<a href="?page=' . $p . '">' . $p . '</a>';
  }
}

// Link to next page
if ($page < $totalPages) {
  echo '<a href="?page=' . ($page + 1) . '">&gt;</a>';
} else {
  echo '<span class="disabled">&gt;</span>';
}

// Link to last page
if ($page < $totalPages) {
  echo '<a href="?page=' . $totalPages . '">Last</a>';
} else {
  echo '<span class="disabled">Last</span>';
}

echo '</div>';
  ?>
</div>
  </main>
  </body>
</html>