<?php 
    // starting sessions
    session_start();
    //database connection
    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error());

    //submit data
    if(isset($_POST['submit'])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $userType = $_POST["user-type"];
        // if user is Admin
        if($userType == "Admin"){
            $result = $mysqli->query("SELECT * FROM $userType WHERE Username='$username' AND Password='$password';") or die($mysqli->error);

            $admin = $result->fetch_assoc();
            
            $_SESSION['admin'] = $admin['ID'];

            if(!empty($_POST["username"]) && !empty($_POST["password"])){
                
                if(mysqli_num_rows($result) == 1){
                    header("Location: ../view/home.php");
                }else{
                    header("Location: ../index.php");
                }
            }else{
                header("Location: ../index.php");
            }
        }else if($userType == "Student"){
            $result = $mysqli->query("SELECT * FROM $userType WHERE Username='$username' AND Password='$password';") or die($mysqli->error);

            $student = $result->fetch_assoc();

            
            $_SESSION['student'] = $student['ID'];
            $_SESSION['student_name'] = $student['First_name'];
            echo  $_SESSION['student'];

            if(!empty($_POST["username"]) && !empty($_POST["password"])){
                
                if(mysqli_num_rows($result) == 1){
                    header("Location: ../view/student_view.php");
                }else{
                    header("Location: ../index.php");
                }
            }else{
                header("Location: ../index.php");
            }
        }
    }
?>