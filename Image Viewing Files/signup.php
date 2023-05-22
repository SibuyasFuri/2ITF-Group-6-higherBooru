<?php
session_start();
include("db_conn.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
	
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password)) {

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Save the hashed password to the database
        $user_id = rand(0, 999);
        $query = "INSERT INTO users (user_id, user_name, password) VALUES ('$user_id', '$user_name', '$hashed_password')";
        mysqli_query($conn, $query);

        header("Location: login.php");
        die;
    } else {
        echo "Please input valid data";
    }
}


?>

<html>
    <head>
        <title>Signup</title>
    </head>
    <style type="text/css">
	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}

	#button{

		padding: 10px;
		width: 100px;
		color: white;
		background-color: lightblue;
		border: none;
	}

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	</style>
<body>
    <div id="box">
        <form method="post">
            <div style="font-size: 20px;margin: 10px;color: white;">Signup</div>

            <input id="text" type="text" name="user_name"><br><br>
            <input id="text" type="password" name="password"><br><br>

            <input id="button" type="submit" value="Signup"><br><br>

            <a href="login.php">Click to Login</a><br><br>
        </form>
    </div>
    
</body>
</html>