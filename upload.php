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
	<?php if (isset($_GET['error'])): ?>
		<p><?php echo $_GET['error']; ?></p>
<?php endif ?>
   <form action="index.php" method="post" enctype="multipart/form-data">
<input type = "file" name = "my_image">
	</form>
 
   <style>
    label{
        display: block;
    }
   </style>
   <body>
    <form action="includes/index.php" method ="POST"><label for="">Title</label>
<input type="text" name="title" required></input>
<label for="">#Tags</label>
<input type="checkbox" name="tags[]" value="Girl">#Girl
<input type="checkbox" name="tags[]" value="Kawaii">#Kawaii
<input type="checkbox" name="tags[]" value="cute">#cute
<input type="checkbox" name="tags[]" value="blackmen">#blackmen
<input type="checkbox" name="tags[]" value="sexymen">#sexymen <br>
<input type="submit" name="submit" value = "Upload">
   </form> 
</div>
</body>
</html>
