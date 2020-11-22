<?php
    // reserve for more features
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- styles and scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/faf20bb39b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/loader.css">
    <title>Login</title>
</head>

<body>
    <div class="loader_bg">
        <div class="loader"></div>
    </div>
    <div class="container">
        <form action="services/login.php" method="POST">
            <img src="images/wmsu.png" alt="wmsu logo">
            <div class="input-group mb-5">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" name="username" placeholder="username">
            </div>
            <div class="input-group mb-5">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                </div>
                <input type="password" class="form-control" name="password" placeholder="password" >
            </div>
            <div class="input-group mb-5">
                <select class="custom-select" id="inputGroupSelect02" name="user-type">
                    <option selected value="Student">Student...</option>
                    <option value="Admin">Admin</option>
                </select>
                <div class="input-group-append">
                    <label class="input-group-text text" for="inputGroupSelect02">User type</label>
                </div>
            </div>
           <button type="submit" class="btn btn-lg btn-primary" name="submit">Login</button>
        </form>
        <div class="title">
            <h1>WMSU</h1>
            <h3>Faculty Evaluation System</h3>
        </div>
    </div>

    <!-- importing libraries/frameworks -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
</body>
</html>