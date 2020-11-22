<?php

    session_start();

    // connecting to the database
    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error());

    // function for adding students
    if(isset($_POST["add"])){
        $semester = $_POST['semester'];
        $section = $_POST['section'];
        $year_level = $_POST['year_level'];
        $faculty_id = $_POST['faculty_id'];
        $subject_code = $_POST['subject_code'];
        $course_code = $_POST['course_code'];

        $adminID = $_SESSION['admin'];

        $mysqli->query("INSERT INTO Schedule(Semester,Section,Year_Level,Faculty_ID,Subject_Code,Course_Code,Admin_ID) VALUES('$semester','$section','$year_level','$faculty_id','$subject_code','$course_code',$adminID);") or die($mysqli->error);
        
         // setting session
         $_SESSION['message'] = 'Record Successfully Added';
         $_SESSION['type'] = 'success';

        header("Location: ../view/schedule.php");
    }

    // function for record's deletion
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $mysqli->query("DELETE FROM Schedule WHERE ID = $id; ") or die($mysqli->error());
        
         // setting session
         $_SESSION['message'] = 'Record Successfully Deleted';
         $_SESSION['type'] = 'warning';

        header("Location: ../view/schedule.php");
    }

    //function for clearing the textfield
    if(isset($_POST['clear'])){
        $semester = '';
        $section = '';
        $year_level = '';
        $faculty_id = '';
        $subject_code = '';
        $course_code = '';

        header("Location: ../view/schedule.php");
    }

    //function for updating the record
    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $semester = $_POST['semester'];
        $section = $_POST['section'];
        $year_level = $_POST['year_level'];
        $faculty_id = $_POST['faculty_id'];
        $subject_code = $_POST['subject_code'];
        $course_code = $_POST['course_code'];

        $mysqli->query("UPDATE Schedule SET Semester='$semester', Section ='$section', Year_Level = '$year_level', Faculty_ID = '$faculty_id', Subject_Code = '$subject_code', Course_Code = '$course_code' WHERE ID=$id;") or die($mysqli->error);
        
         // setting session
         $_SESSION['message'] = 'Record Successfully Updated';
         $_SESSION['type'] = 'success';

        header("Location: ../view/schedule.php");
    }

?>