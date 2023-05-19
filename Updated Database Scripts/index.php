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
<style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			min-height: 100vh;
		}
</style>

</head>
<body>
	
	<?php if (isset($_GET['error'])): ?>
		<p><?php echo $_GET['error']; ?></p>
<?php endif ?>
<a href = "Main.php">Go Back to Home</a>
   <form action="upload.php" method="post" enctype="multipart/form-data">
<input type = "file"
name = "my_image">
 
   <style>
    label{
        display: block;
    }
   </style>
   <body>
    <form action="includes/upload.php" method ="POST"><label for="">Title</label>
<input type="text" name="title" required></input>
<label for="">#Tags</label>
<input type="checkbox" name="tags[]" value="Girl">#Girl
<input type="checkbox" name="tags[]" value="Kawaii">#Kawaii
<input type="checkbox" name="tags[]" value="cute">#cute
<input type="checkbox" name="tags[]" value="blackmen">#blackmen
<input type="checkbox" name="tags[]" value="sexymen">#sexymen <br>
<input type="submit" name="submit" value = "Upload">


   </form> 
</body>
</html>
