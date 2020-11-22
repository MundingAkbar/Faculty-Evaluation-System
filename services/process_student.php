<?php

    session_start();

    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error());
    echo "connected";


    // function for adding students
    if(isset($_POST["add"])){
        $id = $_POST["student_id"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $present_address = $_POST["present_address"];
        $contact_number = $_POST["contact_number"];
        $guardian_name = $_POST["guardian_name"];
        $guardian_contact_number = $_POST["guardian_contact_number"];
        $major = $_POST['majors'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];

        $adminID = $_SESSION['admin'];
         //validate contact number
         if(!ctype_digit($contact_number) || strlen($contact_number) != 11 || !ctype_digit($guardian_contact_number) || strlen($guardian_contact_number) != 11 ){
            $_SESSION['message'] = 'Please use number and 11 digit in contact number fields!';
            $_SESSION['type'] = 'warning';
            
            header("Location: ../view/student.php");
        }else{
        $mysqli->query("INSERT INTO Student VALUES('$id','$first_name','$middle_name','$last_name','$major','$gender','$present_address','$contact_number','$guardian_name','$guardian_contact_number','$id','$password','$adminID');") or die($mysqli->error);
        
        // setting session
        $_SESSION['message'] = 'Record Successfully Added';
        $_SESSION['type'] = 'success';

        header("Location: ../view/student.php");
        }
    }

    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $mysqli->query("DELETE FROM Student WHERE ID = '$id'; ") or die($mysqli->error());

         // setting session
         $_SESSION['message'] = 'Record Deleted';
         $_SESSION['type'] = 'warning';

        header("Location: ../view/student.php");
    }

    if(isset($_POST['clear'])){
        $id = '';
        $first_name = '';
        $middle_name = '';
        $last_name = '';
        $present_address = '';
        $contact_number = '';
        $guardian_name = '';
        $guardian_contact_number = '';
        $password = '';

        header("Location: ../view/student.php");
    }

    if(isset($_POST['update'])){
        $id = $_POST['student_id'];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $present_address = $_POST["present_address"];
        $contact_number = $_POST["contact_number"];
        $guardian_name = $_POST["guardian_name"];
        $major = $_POST['majors'];
        $guardian_contact_number = $_POST["guardian_contact_number"];
        $password = $_POST['password'];
        $gender = $_POST['gender'];

        $mysqli->query("UPDATE Student SET ID='$id', First_name ='$first_name', Middle_name = '$middle_name', Last_name = '$last_name', Major = '$major', Gender = '$gender' , Present_Address = '$present_address', Contact_Number = '$contact_number', Guardian = '$guardian_name', Guardian_Contact_Number = '$guardian_contact_number', Username = '$id', Password = '$password' WHERE ID='$id';") or die($mysqli->error);
        
         // setting session
         $_SESSION['message'] = 'Record Successfully Updated';
         $_SESSION['type'] = 'success';

        header("Location: ../view/student.php");
    }

?>