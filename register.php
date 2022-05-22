<?php
require_once "config.php";

$username = $password =$confirm_password ="";
$usrname_err=$password_err = $confirm_password_err= "";

if($_SERVER['REQUEST_METHOD']=="POST"){

// CHEAK IF USERNAME EMPTY
if(empty(trim($_POST["username"]))){

$username_err ="Username canot be blank";
}else{
$sql = "SELECT id FROM users WHERE username =?";
$stmt = mysqli_prepare($conn,$sql);
   if($stmt)
   {
       mysqli_stmt_bind_param($stmt,"s",$prams_username);
   
//   set the value of param username
$prams_username = trim($_POST['username']);

// Try to execute this statement

if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_store_result($stmt);
       if(mysqli_stmt_num_rows($stmt)==1)
       {
           $username_err ="This username is already taken";
       }
       else{
           $username=trim($_POST['username']);
       }
    
}
else {
    echo "Somthings went wrongs";
}
   }
}

mysqli_stmt_close($stmt);
// cheack for password

if(empty(trim($_POST['password']))){

$password_err ="Password cannot be blank";

}
elseif(strlen(trim($_POST['password']))<5){
    $password_err="Password canot be less than 5 characters" ;
}
    else{
        $password =trim($_POST['password']);
        }

// cheack for confirm password feild

if(trim($_POST['password']) != trim($_POST['confirm_password'])){
    $password_err = "Password should match";
}

// if there were are no errors, go ahed and insert into the Database

if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

    $sql = "INSERT INTO users (username,password) VALUES (?,?)";
    $stmt= mysqli_prepare($conn,$sql);
    if($stmt)
    {   
        mysqli_stmt_bind_param($stmt,"ss",$param_username,
        $param_password);
// set these parameters
        $param_username=$username;
        $param_password = password_hash($password,PASSWORD_DEFAULT);

// TRY to execute the query
       if(mysqli_stmt_execute($stmt)){
           header("location: login.php");
       }else{
           echo "Somthings went wrong...cannot redirect!";
       }
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}
?>
<!-- HTML START FROM HERE  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn-php</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Learn-php</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Login</a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link disabled" href="register.php">Register</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
 <!-- registeration from -->

<div class="container mt-4">
<h2>Please Register Here</h2>
<hr>
<form action='' method='post'>
  <div class="form-row mb-3">
    <div class="form-group col-md-6 mb-3">
      <label for="inputEmail4">Username</label>
      <input type="text" class="form-control" id="inputEmail4" name="username" placeholder="username">
    </div>
    <div class="form-group col-md-6 mb-3">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4" name="password" placeholder="Password">
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6 mb-3">
      <label for="inputPassword4">Confirm Password</label>
      <input type="password" class="form-control" id="inputPassword5" name="confirm_password" placeholder="Confirm Password">
    </div>   
  <div class="form-group mb-3">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Agree terms & Condition
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
</div>
</body>
</html>