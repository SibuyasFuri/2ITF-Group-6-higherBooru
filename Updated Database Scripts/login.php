<?php
session_start();
include("db_conn.php");
include("functions.php");

///if(isset($_SESSION['user_id']))
//{
	//header("Location:Main.php?success=1'");
//} else {
if($_SERVER['REQUEST_METHOD'] == "POST"){
    //something was posted

   $user_name = $_POST['user_name'];
    $password =$_POST['password'];

    if(!empty($user_name) && !empty($password)){

//reading to database


$query = "select * from users where user_name = '$user_name' limit 1";
$result = mysqli_query($conn, $query);

if($result){
    if($result && mysqli_num_rows($result) > 0){

        $user_data = mysqli_fetch_assoc($result);
        if($user_data['password']=== $password){
            $_SESSION['user_id'] = $user_data['user_id'];
            header("Location: Main.php");
            die;
        }

    }
}

echo "Wrong Username or Password";
    }
    else {
        echo "Please Input Valid Data";
    }
}
//
?>

<?php
//signup area


if($_SERVER['REQUEST_METHOD'] == "POST"){
    //something was posted

   $user_name = $_POST['user_name'];
    $password =$_POST['password'];

    if(!empty($user_name) && !empty($password)){

//saving to database

$user_id = rand(0,999);

$query = "insert into users (user_id,user_name,password) values ('$user_id','$user_name','$password')";
mysqli_query($conn,$query);
header("Location: login.php");
die;
    }
	else {
        echo "Please Input Valid Data";
    }
}
?>

<html lang="en">
<head>
	<h4> <br><br><a href = "Main.php">Go Back to Home</a></h4>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="./login.css" rel="stylesheet" type="text/css"/>
</head>
<body>
      <div class="form-box">
        <div class ="button-box">
            <div id = "btn"> </div>
            <button type = "button" class = "toggle-btn" onclick = "login()">Log In</button>
            <button type = "button" class = "toggle-btn" onclick = "register()">Register</button>
        </div>

    <h1>higherBooru</h1>
    <form id = "login" class = "input-group" method ="post">
        <input type = "text" class = "input-field" placeholder="User ID" name ="user_name" required>
        <input type = "password" class = "input-field" placeholder="Enter Password" name ="password" required>
        <button type= "submit" class = "submit-btn" name= "submit_login" value = "Login">Log In</button>
    </form>
    <form id = "register" class = "input-group" method = "post">
        <input type = "text" class = "input-field" placeholder="User ID" name = "user_name" required>
        <input type = "password" class = "input-field" placeholder="Enter Password" name = "password" required>
        <button type= "submit" class = "submit-btn" name ="submit_registration" value ="Signup">Register</button>
    </form>
      </div>

        <script>
        var x = document.getElementById('login');
        var y = document.getElementById('register');
        var z = document.getElementById('btn');

        function register(){
          x.style.left = "-400px";
          y.style.left = "50px";
          z.style.left = "110px";
        }
        function login(){
          x.style.left = "50px";
          y.style.left = "450px";
          z.style.left = "0";
        }
        
        </script>
	</body>
</html>