<?php

    session_start();

    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error);

    function getDateForDatabase($date){
        $timestamp = strtotime($date);
        $date_formated = date('Y-m-d', $timestamp);
        return $date_formated;
    }

if(isset($_POST['add'])){
    $course_code = $_POST['course_code'];
    $course_description = $_POST['course_description'];
    $date_str = date('Y-m-d');
    $date = getDateForDatabase($date_str);

    $adminID = $_SESSION['admin'];

    $mysqli->query("INSERT INTO Course(Course_Code,Course_Description,Date_Added,Admin_ID) VALUES('$course_code','$course_description','$date',$adminID);") or die($mysqli->error);
    
     // setting session
     $_SESSION['message'] = 'Record Successfully Added';
     $_SESSION['type'] = 'success';

    header("Location: ../view/course.php");
    }


    if(isset($_GET['delete'])){
        $course_code = $_GET['delete'];

        $mysqli->query("DELETE FROM Course WHERE Course_Code = '$course_code';") or die($mysqli->error());

         // setting session
         $_SESSION['message'] = 'Record Successfully Deleted';
         $_SESSION['type'] = 'warning';

        header("Location: ../view/course.php");
    }

    if(isset($_POST['update'])){
        $course_code_old = $_POST['course_id'];
        $course_code = $_POST['course_code'];
        $course_description = $_POST['course_description'];

        $mysqli->query("UPDATE Course SET Course_Code='$course_code', Course_Description='$course_description' WHERE Course_Code='$course_code_old';") or die($mysqli->error);
        
         // setting session
         $_SESSION['message'] = 'Record Successfully Updated';
         $_SESSION['type'] = 'success';
         
        header("Location: ../view/course.php");
    }
    
      //function for clearing the textfield
      if(isset($_POST['clear'])){
        $course_code = '';
      $course_description = '';
      $date_added = '';

        header("Location: ../view/course.php");
    }

?>