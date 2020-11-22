<?php
    //starting and setting sessions
    session_start();

    // check if admin session is set if not go to login page
    if(!isset($_SESSION['admin'])){
        header("Location: ../index.php");
    }
    
    $_SESSION['page'] = "home";


    //database connection
    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error);

    //global variables with default values
    $student_count = 0;
    $faculty_count = 0;
    $course_count = 0;
    $subject_count = 0;
    $schedule_count = 0;
    $question_count = 0;
    $evaluation_count = 0;

    //fetching or querying all necessary data
    $result = $mysqli->query("SELECT * FROM Student;") or die($mysqli->error());
    $student_count = mysqli_num_rows($result);

    $result = $mysqli->query("SELECT * FROM Faculty;") or die($mysqli->error());
    $faculty_count = mysqli_num_rows($result);

    $result = $mysqli->query("SELECT * FROM Course;") or die($mysqli->error());
    $course_count = mysqli_num_rows($result);

    $result = $mysqli->query("SELECT * FROM Schedule;") or die($mysqli->error());
    $schedule_count = mysqli_num_rows($result);

    $result = $mysqli->query("SELECT * FROM Subject;") or die($mysqli->error());
    $subject_count = mysqli_num_rows($result);

    $results = $mysqli->query("SELECT * FROM Questioner;") or die($mysqli->error());
    $question_count = mysqli_num_rows($results);

    $results = $mysqli->query("SELECT * FROM Evaluate;") or die($mysqli->error);
    $evaluation_count = mysqli_num_rows($results);
?>

<!DOCTYPE html>
<html lang="en">

    <!-- importing templates header and navbar -->
    <?php require_once('../templates/header.php'); ?>
    <?php require_once('../templates/navbar.php'); ?>
    
    <div class="container mt-5">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                    <h4>Record Overview</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-3 mb-1">
                        <div class="card bg-secondary text-light">
                            <div class="card-body">
                                <h2><span><i class="fas fa-user"></i></span> <?php echo $student_count; ?></h2>
                                <h4>Student</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="card bg-danger text-light">
                            <div class="card-body">
                                <h2><span><i class="fas fa-user"></i></span>  <?php echo $faculty_count; ?></h2>
                                <h4>Faculty</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="card bg-secondary text-light">
                            <div class="card-body">
                                <h2><span><i class="fas fa-university"></i></span> <?php echo $course_count; ?></h2>
                                <h4>Course</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="card bg-danger text-light">
                            <div class="card-body">
                                <h2><span><i class="fas fa-university"></i></span> <?php echo $subject_count; ?></h2>
                                <h4>Subjects</h4>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-3 mb-1">
                        <div class="card bg-secondary text-light">
                            <div class="card-body">
                                <h2><span><i class="fas fa-clipboard-list"></i></span>  <?php echo $question_count; ?></h2>
                                <h4>Questions</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="card bg-danger text-light">
                            <div class="card-body">
                                <h2><span><i class="fas fa-clipboard-list"></i></span>  <?php echo $evaluation_count; ?></h2>
                                <h4>Evaluated</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="card bg-secondary text-light">
                            <div class="card-body">
                                <h2><span<i class="fas fa-calendar-alt"></i></span> <?php echo $schedule_count; ?></h2>
                                <h4>Schedule</h4>
                            </div>
                        </div>
                    </div>
                    </div>
                   
                    
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
            <h5 class="card-title text-center">Latest Evaluation</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr class="bg-dark text-light">
                        <th>No.</th>
                        <th>Faculty ID</th>
                        <th>Student ID</th>
                        <th>Subject Code</th>
                        <th>Course Code</th>
                        <th>Date Evaluated</th>
                        <th>Score</th>
                    </tr>
                    <?php
                            $result = $mysqli->query("SELECT * FROM Evaluate LIMIT 5;");
                            $i = 0;
                            while($row = $result->fetch_assoc()){
                                $i++;
                        ?>
                        <tr <?php if($row['Status'] == 'uncheck'){ ?>class="bg-secondary text-light"<?php } ?>>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['Faculty_ID']; ?></td>
                            <td><?php echo $row['Student_ID'];?></td>
                            <td><?php echo $row['Subject_Code'];?></td>
                            <td><?php echo $row['Course_Code']; ?></td>
                            <td><?php echo $row['Date_Evaluated'] ?></td>
                            <td><?php echo $row['Score']; ?></td>
                        </tr>       
                            <?php } ?>
                    
                </table>
            </div>
        </div>
    </div>
    
    <!-- importing libraries and frameworks -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- footer template -->
    <?php require_once('../templates/footer.php'); ?>
</html>