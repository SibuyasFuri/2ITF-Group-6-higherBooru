<html lang="en">
<head>
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
        <button type= "submit" class = "submit-btn" name= "submit_login">Log In</button>
    </form>
    <form id = "register" class = "input-group" method = "post">
        <input type = "text" class = "input-field" placeholder="User ID" name = "user_name" required>
        <input type = "password" class = "input-field" placeholder="Enter Password" name = "password" required>
        <button type= "submit" class = "submit-btn" name ="submit_registration">Register</button>
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