<?php session_start(); 
include("functions.php");
include("db_conn.php");

$user_data = check_login($conn);

if(isset($_POST["submit"])){
	
	mysqli_query($conn, $query);
}
?>
<html>
<head>
<title>
Image Upload PHP
</title>
<link href="./upload.css" rel="stylesheet" type="text/css"/>
</head>
   <body>
   <div class="form-box">
<br>
<form action="index.php" method="post" enctype="multipart/form-data">
    <h1>higherBooru</h1>
<input class="input-field" type="text" name="title" placeholder="Title" required></input>
      <br>
      <div class = "error-message">
      <?php if (isset($_GET['error'])): ?>
		<p><?php echo $_GET['error']; ?></p>
<?php endif ?>
      </div>
   <label class="custom-file-upload">
   <input type="file" name = "my_image" onchange="loadFile(event)">
<img id="output"/>
<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>
<br>
Upload Image
</label>
<br>
<form action="includes/index.php" method ="POST">
<label for="">Tags: </label>
<input type="checkbox" name="tags[]" value="Girl">#Girl</input>
<input type="checkbox" name="tags[]" value="Kawaii">#Kawaii</input>
<input type="checkbox" name="tags[]" value="cute">#Cute</input>
<input type="checkbox" name="tags[]" value="blackmen">#Boy</input>
<input type="checkbox" name="tags[]" value="blackmen">#Colorful</input>
<input type="checkbox" name="tags[]" value="blackmen">#BnW</input>
<input type="checkbox" name="tags[]" value="sexymen">#Anime</input> <br>
<input type="submit" class="upload-btn" name="submit" value ="Upload">
<button class = "back-btn" onclick="history.back()">Back</button>
   </form>
</form>
</div>
</body>
</html>
