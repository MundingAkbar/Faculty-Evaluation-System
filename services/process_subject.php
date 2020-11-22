<?php

    session_start();

    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error);

    function getDateForDatabase($date){
        $timestamp = strtotime($date);
        $date_formated = date('Y-m-d', $timestamp);
        return $date_formated;
    }

if(isset($_POST['add'])){
    $subject_code = $_POST['subject_code'];
    $subject_description = $_POST['subject_description'];
    $date_str = date('Y-m-d');
    $date = getDateForDatabase($date_str);

    $adminID = $_SESSION['admin'];

    $mysqli->query("INSERT INTO Subject(Subject_Code,Subject_Description,Date_Added,Admin_ID) VALUES('$subject_code','$subject_description','$date',$adminID);") or die($mysqli->error);
     // setting session
     $_SESSION['message'] = 'Record Successfully Added';
     $_SESSION['type'] = 'success';

    header("Location: ../view/subject.php");
    }


    if(isset($_GET['delete'])){
        $subject_code = $_GET['delete'];

        $mysqli->query("DELETE FROM Subject WHERE Subject_Code = '$subject_code';") or die($mysqli->error);

         // setting session
         $_SESSION['message'] = 'Record Successfully Deleted';
         $_SESSION['type'] = 'warning';

        header("Location: ../view/subject.php");
    }

    if(isset($_POST['update'])){
        $subject_code_old = $_POST['subject_id'];
        $subject_code = $_POST['subject_code'];
        $subject_description = $_POST['subject_description'];

        $mysqli->query("UPDATE Subject SET Subject_Code='$subject_code', Subject_Description='$subject_description' WHERE Subject_Code='$subject_code_old';") or die($mysqli->error);
        
         // setting session
         $_SESSION['message'] = 'Record Successfully Updated';
         $_SESSION['type'] = 'success';

        header("Location: ../view/subject.php");
    }

        //function for clearing the textfield
        if(isset($_POST['clear'])){
            $subject_code = '';
            $subject_description = '';
            $date_added = '';
    
            header("Location: ../view/subject.php");
        }
    

?>