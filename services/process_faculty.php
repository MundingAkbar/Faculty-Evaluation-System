<?php

    session_start();

    // connecting to the database
    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error());
    echo "connected";


    // function for adding students
    if(isset($_POST["add"])){
        $id = $_POST["faculty_id"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $present_address = $_POST["present_address"];
        $contact_number = $_POST["contact_number"];
        $department = $_POST['department'];
        $gender = $_POST['gender'];

        $adminID = $_SESSION['admin'];

          //validate contact number
          if(!ctype_digit($contact_number) || strlen($contact_number) != 11){
            $_SESSION['message'] = 'Please use number and 11 digit in contact number fields!';
            $_SESSION['type'] = 'warning';
            
            header("Location: ../view/faculty.php");
        }else{

        $mysqli->query("INSERT INTO Faculty VALUES('$id','$first_name','$middle_name','$last_name','$department','$gender','$present_address','$contact_number','$adminID');") or die($mysqli->error);
        
         // setting session
         $_SESSION['message'] = 'Record Successfully Added';
         $_SESSION['type'] = 'success';

        header("Location: ../view/faculty.php");
    }
}

    // function for record's deletion
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $mysqli->query("DELETE FROM Faculty WHERE ID = '$id'; ") or die($mysqli->error());

         // setting session
         $_SESSION['message'] = 'Record Successfully Deleted';
         $_SESSION['type'] = 'warning';

        header("Location: ../view/faculty.php");
    }

    //function for clearing the textfield
    if(isset($_POST['clear'])){
        $id = '';
        $first_name = '';
        $middle_name = '';
        $last_name = '';
        $present_address = '';
        $contact_number = '';

        header("Location: ../view/Faculty.php");
    }

    //function for updating the record
    if(isset($_POST['update'])){
        $id = $_POST['faculty_id'];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $present_address = $_POST["present_address"];
        $contact_number = $_POST["contact_number"];
        $department = $_POST['department'];
        $gender = $_POST['gender'];

       

        $mysqli->query("UPDATE Faculty SET ID='$id', First_name ='$first_name', Middle_name = '$middle_name', Last_name = '$last_name', Department = '$department', Gender = '$gender' , Present_Address = '$present_address', Contact_Number = '$contact_number' WHERE ID='$id';") or die($mysqli->error);
        
         // setting session
         $_SESSION['message'] = 'Record Successfully Updated';
         $_SESSION['type'] = 'success';

        header("Location: ../view/faculty.php");
    }

?>