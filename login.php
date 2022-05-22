<?php

// This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username'])){

    header("location:welcome.php");
    exit;
}
require_once "config.php";

$username=$password ="";
$err ="";

// if request method is post 

if($_SERVER['REQUEST_METHOD']=="POST"){
if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
{
    $err="please enter username + password";
}
else{
    $username =trim($_POST['username']);
    $password =trim($_POST['password']);

}
if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"s", $param_username);
    $param_username=$username;
    // Try to execute this statement

if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt)==1)
    {
       mysqli_stmt_bind_result($stmt,$id,$username,$hashed_password);
       if(mysqli_stmt_fetch($stmt))
       {
        if(password_verify($password,$hashed_password))
        {
 
 // this means user input correct password . Allow user to login 
              session_start();
              $_SESSION['username']=$username;
              $_SESSION['id']=$id;
              $_SESSION['loggedin']=true;
 
  
             //  Redirecdt user to the welcome page.
             header("location:welcome.php");
        }  
       }
  
    }
}
}

}

?>






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
          <a class="nav-link" href="www.google.com">Tool</a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link " href="register.php">Register</a>
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
<h2>Please Login Here</h2>
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
  <div class="form-group mb-3">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Agree terms & Condition
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Log in</button>
</form>
</div>
</body>
</html>