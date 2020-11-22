<?php
    // starting session and setting session
    session_start();
    
    // check if admin session is set if not go to login page
    if(!isset($_SESSION['student'])){
        header("Location: ../index.php");
    }
    $_SESSION['page'] = "student";

    //convertion of data strings to timestamp for database insertion
    function getDateForDatabase($date){
        $timestamp = strtotime($date);
        $date_formated = date('Y-m-d', $timestamp);
        return $date_formated;
    }

    // connecting to database
    $mysqli = new mysqli('localhost','root','','faculty_evaluation') or die($mysqli->error());

    // all default messages or varibales
    $default_message = "Search to display data here";
    $search_success = false;
    $evaluated = false;
    // global variables
    // faculty default variables
    $first_name = 'None';
    $middle_name = 'None';
    $last_name = 'None';
    $department = 'None';
    $gender = 'None';
    $contact_number = 'None';
    // subject defualt variables
    $subject_code = 'None';
    $subject_description = 'None';
    // course default varibales
    $course_code = 'None';
    $course_description = 'None';
    // schedule default variables
    $section = 'None';
    $year_level = "None";
    $semester = "None";
    $feedback = '';
    
    //searching data
    if(isset($_POST['search'])){
        $first_name = $_POST['faculty_first_name'];
        $last_name = $_POST['faculty_last_name'];
        $subject_code = $_POST['subject_code'];
        $course_code = $_POST['course_code'];
        $semester = $_POST['semester'];
        $section = $_POST['section'];


        $faculty_result = $mysqli->query("SELECT * FROM Faculty WHERE First_name ='$first_name' AND Last_name = '$last_name';");
        
        if(mysqli_num_rows($faculty_result) >= 1){
            $default_message = '';
            // fetching faculty data
            $faculty_data = $faculty_result->fetch_assoc();
            $faculty_id = $faculty_data['ID'];
            $first_name = $faculty_data['First_name'];
            $middle_name = $faculty_data['Middle_name'];
            $last_name = $faculty_data['Last_name'];
            $department = $faculty_data['Department'];
            $gender = $faculty_data['Gender'];
            $contact_number = $faculty_data['Contact_Number'];
            $student_id = $_SESSION['student'];

            $evaluate_result = $mysqli->query("SELECT * FROM Evaluate WHERE Student_ID ='$student_id' AND Faculty_ID = '$faculty_id';");
            
            if(mysqli_num_rows($evaluate_result) >= 1){
                $evaluated = true;
            }
            
            $schedule_result = $mysqli->query("SELECT * FROM Schedule WHERE Faculty_ID = '$faculty_id' AND Subject_Code = '$subject_code' AND Course_Code = '$course_code' AND Semester = '$semester' AND Section = '$section';") or die($mysqli->error);
            // echo mysqli_num_rows($schedule_result);
            // echo count($schedule_result);
            if(count($schedule_result) == 1){
                $schedule = $schedule_result->fetch_assoc();
                $search_success = true;
                
                $subject_code = $schedule['Subject_Code'];
                $course_code = $schedule['Course_Code'];
                $semester = $schedule['Semester'];
                $section = $schedule['Section'];
                $year_level = $schedule['Year_Level'];

                
                 $_SESSION['faculty_id'] = $faculty_id;
                 $_SESSION['subject_code'] = $subject_code;
                 $_SESSION['course_code'] = $course_code;

            }else{
                $default_message = "data doesn't exist in Schedules";
                
                    // faculty default variables
                    $first_name = 'None';
                    $middle_name = 'None';
                    $last_name = 'None';
                    $department = 'None';
                    $gender = 'None';
                    $contact_number = 'None';
                    // subject defualt variables
                    $subject_code = 'None';
                    // course default varibales
                    $course_code = 'None';
                    // schedule default variables
                    $section = 'None';
                    $year_level = "None";
                    $semester = "None";
            }
        }else{
        $default_message = "data doesn't exist in faculties";
        // faculty default variables
        $first_name = 'None';
        $middle_name = 'None';
        $last_name = 'None';
        $department = 'None';
        $gender = 'None';
        $contact_number = 'None';
        // subject defualt variables
        $subject_code = 'None';
        // course default varibales
        $course_code = 'None';
        // schedule default variables
        $section = 'None';
        $year_level = "None";
        $semester = "None";
        }
    }

    //function for clearing the textfield
    if(isset($_POST['clear'])){

        $default_message = "Search to display data here";

        $first_name = 'None';
        $last_name = 'None';
        $subject_code = 'None';
        $course_code = 'None';
        $section = 'None';
        $year_level = "None";
        $semester = "None";
        $search_success = false;

        header("Location: ../view/student_view.php");
    }
    //submit evalutation
    if(isset($_POST['submit_evaluation'])){
        $date_str = date('Y-m-d');
        $date = getDateForDatabase($date_str);
        $student_id = $_SESSION['student'];
        $faculty_id = $_SESSION['faculty_id'];
        $subject_code = $_SESSION['subject_code'];
        $course_code = $_SESSION['course_code'];
        $feedback = $_POST['feedback'];
        
        // calculating total score from evaluation
        $i = 0;
        $total = 0;
        $total_score = $_SESSION['question_length'] * 3;
        while($i < $_SESSION['question_length']){
            $i++;
            $total +=  $_POST['semester'.$i];
        }
      $percentage = ($total / $total_score) * 100;
        
        $mysqli->query("INSERT INTO Evaluate(Date_Evaluated,Status,Student_ID,Faculty_ID,Subject_Code,Course_Code,Feedback,Score) VALUES('$date','uncheck','$student_id','$faculty_id','$subject_code','$course_code','$feedback','$percentage');") or die($mysqli->error);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <!-- importing templates header and navbar -->
    <?php require_once('../templates/header.php'); ?>
    <?php require_once('../templates/student_header.php'); ?>

       <!-- alert prompt for operations -->
       <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-<?=$_SESSION['type'];?> alert-dismissible fade show" role="alert">
        <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    <?php endif; ?>
    <!-- end of alert -->
    
    <div class="container-fluid ">
        <h2 class="p-3">Welcome, <?php echo $_SESSION['student_name']."  "; ?><span><i class="far fa-smile-beam"></i></span></h2>
    </div>
    <!-- form for searching faculties -->
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-md-5 ">
                <form action="student_view.php" method="POST" class="form-custom p-2">
                        <img src="../images/reading.svg" alt="user logo" class="form-logo">
                        <div class="form-group pt-2">
                            <input required type="text" class="form-control" placeholder="Faculty First Name" name="faculty_first_name">
                        </div>
                        <div class="form-group pt-2">
                            <input required type="text" class="form-control" placeholder="Faculty Last Name" name="faculty_last_name">
                        </div>
                        <div class="input-group pb-3">
                            <select class="custom-select" id="inputGroupSelect02" name="semester">
                                <option value="1st" selected>1st</option>
                                <option value="2nd">2nd</option>
                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text text" for="inputGroupSelect02">Semester</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input required type="text" class="form-control" placeholder="Subject Code (Example: CS135)" name="subject_code">
                        </div>
                        <div class="form-group">
                            <input required type="text" class="form-control" placeholder="Course Code (Example: BSCS)" name="course_code">
                        </div>
                        <div class="form-group">
                            <input required type="text" class="form-control" placeholder="Section (Example: A)" name="section">
                        </div>
                        <button type="submit" class="btn btn-info" name="search">Search</button>
                        <button type="submit" class="btn btn-warning ml-2" name="clear">Clear</button>
                    </form>
            </div>
            <div class="col-md-7 mt-5">
                <div class="card text-center">
                    <h3 class="card-header bg-dark text-light"><?php echo $default_message;
                                if($default_message == ''){
                                    echo $first_name." ".$last_name; 
                                }
                    ?> </h3>
                    <div class="card-body">
                        <h5 class="card-title">Information</h5>
                        <p class="card-text">Subject Code: <?php echo $subject_code; ?></p>
                        <p class="card-text">Course Code: <?php echo $course_code; ?></p>
                        <p class="card-text">Semester: <?php echo $semester; ?></p>
                        <p class="card-text">Section: <?php echo $section; ?></p>
                        <p class="card-text">Year Level: <?php echo $year_level; ?></p>
                        <?php if($search_success == true){ ?>
                        <?php if($evaluated == false){ ?>
                        <a href="#info" class="btn btn-primary" data-toggle="modal" data-target="#evaluate" name="evaluate">Evaluate</a>
                        <?php }?>    
                        <a href="#info" class="btn btn-secondary" data-toggle="modal" data-target="#info">More info</a>
                        <?php }?>
                    </div>          
                </div>
            </div>
        </div>
    </div>
        <!-- Modal for evaluation -->
        <div class="modal fade" id="evaluate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header bg-info text-light">
                    <h5 class="modal-title" id="staticBackdropLabel"><span class="pr-2"><i class="far fa-edit"></i></span> General Performance Evaluation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center text-info">
                <p class="text-muted">Note! You can only evaluate one faculty according to schedules once.</p>
                <form action="student_view.php" method="POST">
                <?php
                            //showing evaluation form
                            $question_result = $mysqli->query("SELECT * FROM Questioner;") or die($mysqli->error);
                            $_SESSION['question_length'] = mysqli_num_rows($question_result);
                        if(mysqli_num_rows($question_result) >= 1):
                            $i = 0;
                            while($questions = $question_result->fetch_assoc()):
                                $i++;
                ?>

                    <input type="hidden" class="form-control" placeholder="Section" name="id" value="<?php echo $id; ?>">
                      <div class="input-group pb-3 pt-3">
                      <div class="input-group-prepend">
                            <label class="input-group-text text" for="inputGroupSelect02"><?php echo $questions['Question'] ?></label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect02" name="semester<?php echo $i; ?>">
                            <option value="1" selected>Needs improvement</option>
                            <option value="2">Adequate</option>
                            <option value="3">Satisfactory</option>
                        </select>
                        
                    </div>
                
                <?php
                                endwhile;
                            endif; 
                ?>
                <div class="input-group pt-3 pb-3">
                            <textarea class="form-control" aria-label="With textarea" rows="5" placeholder="What can you suggest to improve his/her performance?..." name="feedback" echo $question; ?></textarea>
                     </div>
                </div>

                <div class="modal-footer">
                   <button type="submit" class="btn btn-primary text-light" name="submit_evaluation">Submit Evaluation</button>
                </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>
            <!-- End of Modal -->

             <!-- Modal for more info -->
        <div class="modal fade"id="info" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            
            <?php
                if($search_success == true){
                    $course_result = $mysqli->query("SELECT * FROM Course WHERE Course_Code ='$course_code';");
                    $subject_result = $mysqli->query("SELECT * FROM Subject WHERE Subject_Code ='$subject_code';");

                    if(count($course_code) >= 1 && count($subject_code) >= 1){
                        $course_data = $course_result->fetch_assoc();
                        $subject_data = $subject_result->fetch_assoc();

                        // subject data
                        $subject_code =  $subject_data['Subject_Code'];
                        $subject_description = $subject_data['Subject_Description'];
                        
                        // course data
                        $course_code = $course_data['Course_Code'];
                        $course_description = $course_data['Course_Description'];
                    }
                }
            ?>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header bg-info text-light">
                    <h5 class="modal-title" id="staticBackdropLabel">Further Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center text-info">
                        <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                        <!-- card -->
                                        <div class="card">
                                            <div class="card-header bg-dark text-light">
                                                <h5><span class="pr-2"><i class="fas fa-user-alt"></i></span><?php echo $first_name." '".$middle_name."' ".$last_name ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <p>Department: <?php echo $department; ?></p>
                                                <p>Gender: <?php echo $gender; ?></p>
                                                <p>Contact Number: <?php echo $contact_number;?></p>
                                            </div>
                                        </div>
                                        <!-- end of card -->
                                </div> 
                                <div class="col-lg-6 col-md-6 col-sm--12">
                                        <!-- card -->
                                        <div class="card">
                                            <div class="card-header bg-dark text-light">
                                               <h5><span class="pr-2"><i class="fas fa-info-circle"></i></span> Schedule/Course/Subject</h5> 
                                            </div>
                                            <div class="card-body">
                                            <p>Subject Code: <?php echo $subject_code; ?></p>
                                            <p>Subject Description: <?php echo $subject_description; ?></p>
                                            <p>Course Code: <?php echo $course_code; ?></p>
                                            <p>Course Description: <?php echo $course_description; ?></p>
                                            <p>Semester: <?php echo $semester;?></p>
                                            <p>Section: <?php echo $section; ?></p>
                                            <p>Year_Level: <?php echo $year_level; ?></p>
                                            </div>
                                        </div>
                                        <!-- end of card -->
                                </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>
            <!-- End of Modal -->

    <!-- importing libares/frameworks/template footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <?php require_once('../templates/footer.php') ?>
</html>