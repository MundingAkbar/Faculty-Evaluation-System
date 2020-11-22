<?php
    session_start();

    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error);

    function getDateForDatabase($date){
        $timestamp = strtotime($date);
        $date_formated = date('Y-m-d', $timestamp);
        return $date_formated;
    }

if(isset($_POST['add'])){
    $question = $_POST['question'];
    $date_str = date('Y-m-d');
    $date = getDateForDatabase($date_str);

    $adminID = $_SESSION['admin'];

    $mysqli->query("INSERT INTO Questioner(Question,Date_Added,Admin_ID) VALUES('$question','$date',$adminID);") or die($mysqli->error);
    
    $_SESSION['message'] = 'Question Added Successfully.';
    $_SESSION['type'] = 'success';

    header("Location: ../view/questioner.php");
    }


    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $mysqli->query("DELETE FROM Questioner WHERE ID = '$id';") or die($mysqli->error);

        $_SESSION['message'] = 'Question Deleted.';
        $_SESSION['type'] = 'warning';

        header("Location: ../view/questioner.php");
    }

    if(isset($_POST['update'])){
        $subject_code_old = $_POST['subject_id'];
        $subject_code = $_POST['subject_code'];
        $subject_description = $_POST['subject_description'];

        $mysqli->query("UPDATE Subject SET Subject_Code='$subject_code', Subject_Description='$subject_description' WHERE Subject_Code='$subject_code_old';") or die($mysqli->error);
        
        $_SESSION['message'] = 'Question Updated Successfully.';
        $_SESSION['type'] = 'success';
        header("Location: ../view/subject.php");
    }

        //function for clearing the textfield
        if(isset($_POST['clear'])){
            $question = '';
            $date_added = '';
            $id = '';
    
            header("Location: ../view/questioner.php");
        }
    

?>