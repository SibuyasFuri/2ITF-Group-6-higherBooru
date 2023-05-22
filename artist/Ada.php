<?php
session_start();
include("../db_conn.php");
include("../functions.php");

$image_name = '';
$image_url = '';
$image_upload = '';
$user_name = '';
$user_id = '';
$user_date = '';

// Get the search query
$searchQuery = basename($_SERVER['PHP_SELF'], '.php');

// Check if $searchQuery matches users.user_name
$query = "SELECT users.user_id 
          FROM users 
          WHERE users.user_name = '$searchQuery'";
          
// Execute the query to retrieve the user_id
$result = mysqli_query($conn, $query);

// Check if the query returned any results
if (mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
  $user_id = $user['user_id'];

  // Retrieve the remaining needed info using the obtained user_id
  $query = "SELECT images.name, images.image_url, users.user_name, users.user_id, images.dateUploaded, users.date
            FROM images 
            JOIN users ON images.user_id = users.user_id 
            WHERE (users.user_id = '$user_id' OR images.name LIKE '%$searchQuery%' OR images.tags LIKE '%$searchQuery%' OR images.name = '$searchQuery')";

  // Execute the final query
  $result = mysqli_query($conn, $query);

  // Process the results as needed
  $images = []; // Array to store the images
  while ($row = mysqli_fetch_assoc($result)) {
    // Access the retrieved data
    $image_name = $row['name'];
    $image_url = $row['image_url'];
    $image_upload = $row['dateUploaded'];
    $user_name = $row['user_name'];
    $user_id = $row['user_id'];
    $user_date = $row['date'];

    // Replace the title in the image name
    $image_name = str_replace('$row[\'name\']', $row['name'], $image_name);

    // Add the image details to the array
    $images[] = [
      'name' => $image_name,
      'url' => $image_url,
      'dateUploaded' => $image_upload,
      'user_name' => $user_name,
      'user_id' => $user_id,
      'user_date' => $user_date
    ];
  }
} else {
  // Handle the case when no user is found with the given search query
  echo "No user found.";
}

// Get the sorting parameter from the query string
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';

// Modify the SQL query based on the sorting parameter
switch ($sort) {
  case 'latest':
    // Sort by file's last modified timestamp in descending order
    $query .= " ORDER BY images.dateUploaded DESC";
    break;
  case 'oldest':
    // Sort by file's last modified timestamp in ascending order
    $query .= " ORDER BY images.dateUploaded ASC";
    break;
  case 'az':
    $query .= " ORDER BY images.name ASC";
    break;
  case 'za':
    $query .= " ORDER BY images.name DESC";
    break;
  default:
    // Sort by file's last modified timestamp in descending order (default: latest)
    $query .= " ORDER BY images.dateUploaded DESC";
    break;
}

$perPage = 20;

// Get the current page from the query string
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the database results
$offset = ($page - 1) * $perPage;

// Modify the SQL query to include the pagination limit
$query .= " LIMIT $offset, $perPage";

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
    <link href="./Artist.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/6d9cfe3d07.js" crossorigin="anonymous"></script>

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
      <a href="../Main.php">higherBooru</a>
    </div>

    <div class="topnav-right">
      <?php
      if(isset($_SESSION['user_id'])){

        echo '<a href="../logout.php">Logout</a>';
        echo '<a href="../upload.php" value="upload_button">Upload</a>';
      }
      elseif(empty($_SESSION['user_id'])) {
        echo '<a href="../login.php">Login/Register</a>';
      }
      ?>
    </div>
  </header>

  <div class="main" id="page-content">
    <main class="main-1">
      <div class = "user-icon">
      <i class="fa-solid fa-user" style="font-size:300px;color: #f2f2f2"></i>
      </div>
      <h1><?php echo $user_name; ?></h1>
      <br>

      <h5 style="color:gray;">
      UID: <?php echo $user_id ?><br> Account Created: <?php echo $user_date ?>
      </h5><br><br>
      <h4 id='description'>
      User Description
      </h4>
      <button class="edit-btn" id="changeDesc">Edit</button>

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
      </main>

      <div class = "heading">
        Artworks
      </div>
      </section>
    </main>
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
  </div>

<?php
if (count($images) > 0) {
  echo '<div class="gallery">';
  foreach ($images as $image) {

    // Output the image gallery using the values from $row
    echo "<figure>";
    echo "<img src='../images/" . $image['url'] . "'>";
    echo "<figcaption class='caption-non-full'>" . $image['name'] . "</figcaption>";
    echo "<figcaption class='caption-full'>" . $image['name'] . "<br>Artist: " . $image['user_name'] . "<br>Date Uploaded: " . $image['dateUploaded'] . "</figcaption>";
    echo "</figure>";
  }
  echo '</div>';
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
for ($p = $startPage; $p <= $endPage; $p++) {
  if ($p == $page) {
    echo '<span class="current-page">' . $page . '</span>';
  } else {
    echo '<a href="?page=' . $p . '">' . $p . '</a>';
  }
}

// Link to next page
if ($page < $totalPages) {
  echo '<a href="?page=' . ($page + 1) . '">&#8250;</a>';
} else {
  echo '<span class="disabled">&#8250;</span>';
}

// Link to last page
if ($page < $totalPages) {
  echo '<a href="?page=' . $totalPages . '">&raquo;</a>';
} else {
  echo '<span class="disabled">&raquo;</span>';
}

echo '</div>';
?>
</div>
</main>
</body>
</html>