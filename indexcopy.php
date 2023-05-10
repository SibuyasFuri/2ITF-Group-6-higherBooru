<?php include "db_conn.php"; ?>
<html>
 <head>
    <title>View</title>
    <style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			flex-wrap: wrap;
			min-height: 100vh;
		}
        .alb {
            width: 200px;
            height: 200px;
            padding: 5px;
        }
        .alb img {
            width: 100%;
            height: 100%;
        }
        a {
            text-decoration: none;
            color: black;
        }
        .button{
            
            height: 500px;
            display: flex;
            align-items: center;

        }
</style>
</head>
<body>
    
    <div class ="button">
<?php if (isset($_GET['error'])): ?>
		<p><?php echo $_GET['error']; ?></p>
<?php endif ?>
   <form action="upload.php" method="post" enctype="multipart/form-data">
<input type = "file"
name = "my_image">
<input type="submit" name="submit" value = "Upload">

   </form> 
   <br>
   </div>
    <?php
    $sql = "SELECT * FROM images ORDER BY id DESC";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0){
        while ($images = mysqli_fetch_assoc($res)){  ?>
<div class ="alb"> <img src="images/<?=$images['image_url']?>"></div>
      <?php  } }?>
</body>
</html>