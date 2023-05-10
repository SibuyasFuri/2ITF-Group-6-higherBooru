<?php session_start(); 
include("functions.php");
include("db_conn.php");
$user_data = check_login($conn);
echo '<script>alert("You need to login in order to post any images")</script>';
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
   <form action="upload.php" method="post" enctype="multipart/form-data">
<input type = "file"
name = "my_image">
<input type="submit" name="submit" value = "Upload">

   </form> 
</body>
</html>