<?php
    // session
    session_start();
    
    // check if admin session is set if not go to login page
    if(!isset($_SESSION['admin'])){
        header("Location: ../index.php");
    }
    //session for active navigation
    $_SESSION['page'] = "evaluate";

    
    //database connection
    $mysqli = new mysqli('localhost','root','','faculty_evaluation') or die($mysqli->error());

    // global variables
    $searching = false;

    // checking if status is uncheck to set dynamic design
    if(isset($_GET['status'])){
        $id = $_GET['status'];

        $mysqli->query("UPDATE Evaluate SET Status='check' WHERE ID= $id;") or die($mysqli->error);
    }

    //accepting all pending evaluation
    if(isset($_POST['accept_all'])){
        $mysqli->query("UPDATE Evaluate SET Status='check';") or die($mysqli->error);
    }

    //searching data using faculty ID
    if(isset($_POST['search'])){
        $search_id = $_POST['search_id'];

        $faculty_result = $mysqli->query("SELECT * FROM Evaluate WHERE Faculty_ID = '$search_id';");

        if(mysqli_num_rows($faculty_result) >= 1){
            $searching = true;
        }
    }

    //show all button will show if search button triggered
    if(isset($_POST['show_all'])){
        $searching = false;
    }

    //delete evaluation data
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
         // setting session
         $_SESSION['message'] = 'Record Successfully Deleted';
         $_SESSION['type'] = 'warning';

        $mysqli->query("DELETE FROM Evaluate WHERE ID = $id") or die($mysqli->error);
    }

    //delete all  evaluation data
    if(isset($_POST['delete_all'])){

         // setting session
         $_SESSION['message'] = 'All Record Successfully Deleted';
         $_SESSION['type'] = 'danger';

        $mysqli->query("Delete * FROM Evaluate;");
    }

?>
<!DOCTYPE html>
<html lang="en">
    <!-- importing templates -->
    <?php require_once('../templates/header.php'); ?>
    <?php require_once('../templates/navbar.php'); ?>

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
    
    <div class="container mb-5">
        <div class="row mt-5 myContent">       
            <div class="col-lg-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h3>Evaluation record(s)</h3>
                            </div>
                            <div class="col-md-6 col-sm-12">
                            <form action="evaluate.php" method="POST" class="ml-auto">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                    <input type="text" class="form-control" placeholder="Search (faculty ID)" name="search_id">
                                    <button type="submit" class="btn btn-secondary" name="search">Search</button>
                                    <button type="submit" class="btn btn-secondary ml-1 bg-success" name="accept_all">Accept all</button>
                                    <div class="container pt-2 pb-1">
                                          <div class="row justify-content-end">
                                          <?php if($searching == true){ ?>
                                             <button type="submit" class="btn btn-secondary ml-1 bg-info" name="show_all">Show all</button>
                                          <?php } ?>
                                            <button type="submit" class="btn btn-secondary ml-1 bg-danger" name="delete_all">Delete all</button>
                                         </div>
                                    </div>
                                </div>
                       </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive myTable">
                        <table class="table">
                            <tr>
                                <th>No.</th>
                                <th>Faculty ID</th>
                                <th>Student ID</th>
                                <th>Subject Code</th>
                                <th>Course Code</th>
                                <th>Date Evaluated</th>
                                <th>Score</th>
                                <th>Result</th>
                                <th>Accept</th>
                                <th>Delete</th>
                            </tr>
                            <?php
                                if($searching == false){
                               $result = $mysqli->query("SELECT * FROM Evaluate;");
                               $i = 0;
                               while($row = $result->fetch_assoc()){
                                   $i++;
                            ?>
                            <tr <?php if($row['Status'] == 'uncheck'){ ?>class="bg-secondary text-light"<?php } ?>>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($row['Faculty_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Student_ID']);?></td>
                                <td><?php echo htmlspecialchars($row['Subject_Code']);?></td>
                                <td><?php echo htmlspecialchars($row['Course_Code']); ?></td>
                                <td><?php echo htmlspecialchars($row['Date_Evaluated']); ?></td>
                                <td><?php echo htmlspecialchars($row['Score']); ?></td>
                                <td>
                                      <a href="evaluate.php?info=<?php echo htmlspecialchars($row['ID']); ?>" class="btn btn-info"  data-toggle="modal" data-target="#info<?php echo $i; ?>"><i class="fas fa-chart-line"></i></a>
                                </td>
                                <td>
                                    <?php if($row['Status'] == 'uncheck'){ ?>
                                      <a href="evaluate.php?status=<?php echo htmlspecialchars($row['ID']);?>" class="btn btn-success"><i class="fas fa-check-square"></i></a>
                                    <?php } ?>
                                      </td>
                                  <td>
                                      <a href="evaluate.php?delete=<?php echo htmlspecialchars($row['ID']);?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                  </td>
                            </tr>               
                            <!-- Modal for more info -->
      <div class="modal fade"id="info<?php echo $i; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" >
                <div class="modal-content">
                <div class="modal-header bg-info text-light">
                    <h5 class="modal-title" id="staticBackdropLabel">Evaluation Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center text-dark">
                        <?php
                            $student_id = $row['Student_ID'];
                            $faculty_id = $row['Faculty_ID'];
                            $subject_code = $row['Subject_Code'];
                            $course_code = $row['Course_Code'];
                            $schedule_result =  $mysqli->query("SELECT * FROM Schedule WHERE Faculty_ID ='$faculty_id' AND Subject_Code = '$subject_code' AND Course_Code = '$course_code';") or die($mysqli->error);
                            $schedule = $schedule_result->fetch_assoc();
                            $student_result = $mysqli->query("SELECT * FROM Student WHERE ID ='$student_id';") or die($mysqli->error);
                            $student = $student_result->fetch_assoc();
                            $faculty_result = $mysqli->query("SELECT * FROM Faculty WHERE ID ='$faculty_id';") or die($mysqli->error);
                            $faculty = $faculty_result->fetch_assoc();
                            $subject_result = $mysqli->query("SELECT * FROM Subject  WHERE Subject_Code ='$subject_code';") or die($mysqli->error);
                            $subject = $subject_result->fetch_assoc();
                            $course_result = $mysqli->query("SELECT * FROM Course  WHERE Course_Code ='$course_code';") or die($mysqli->error);
                            $course = $course_result->fetch_assoc();
                            
                            // this query is to determined the total or overall score for faculty
                            $overall_score_result = $mysqli->query("SELECT AVG(Score) FROM Evaluate WHERE Faculty_ID = '$faculty_id' AND Status='check';");
                            $overall_score = $overall_score_result->fetch_assoc();
                            // $count = mysqli_num_rows($overall_score);
                            // $total = 0;
                            // while($counting = $overall_score->fetch_assoc()){
                            //     $total = 
                            // }
                        ?>

                        <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                        <!-- card -->
                                        <div class="card">
                                            <div class="card-header bg-dark text-light">
                                                <h5><span class="pr-2"><i class="fas fa-user-alt"></i></span>Student</h5>
                                            </div>
                                            <div class="card-body">
                                                <p>Name: <?php echo htmlspecialchars($student['First_name'])." '".htmlspecialchars($student['Middle_name'])."' ".htmlspecialchars($student['Last_name']); ?> </p>
                                                <p>Major:<?php echo htmlspecialchars($student['Major']); ?></p>
                                                <p>Gender: <?php echo htmlspecialchars($student['Gender']); ?></p>
                                                <p>Present Address: <?php echo htmlspecialchars($student['Present_Address']); ?></p>
                                                <p>Contact Number: <?php echo htmlspecialchars($student['Contact_Number']); ?></p>
                                                <p>Guardian: <?php echo htmlspecialchars($student['Guardian']); ?></p>
                                                <p>Guardian Contact Number: <?php echo htmlspecialchars($student['Guardian_Contact_Number']); ?></p>
                                            </div>
                                        </div>
                                        <!-- end of card -->
                                </div> 
                                <div class="col-lg-4 col-md-6 col-sm--12">
                                        <!-- card -->
                                        <div class="card">
                                            <div class="card-header bg-dark text-light">
                                               <h5><span class="pr-2"><i class="fas fa-info-circle"></i></span>Faculty Details</h5> 
                                            </div>
                                            <div class="card-body">
                                            <p>Name: <?php echo htmlspecialchars($faculty['First_name'])." '".htmlspecialchars($faculty['Middle_name'])."' ".htmlspecialchars($faculty['Last_name']); ?> </p>
                                            <p>ID: <?php echo htmlspecialchars($faculty['ID']); ?></p>
                                            <p>Department: <?php echo htmlspecialchars($faculty['Department']); ?></p>
                                            <p>Gender: <?php echo htmlspecialchars($faculty['Gender']); ?> </p>
                                            <p>Present Address: <?php echo htmlspecialchars($faculty['Present_Address']); ?></p>
                                            <p>Contact Number: <?php echo htmlspecialchars($faculty['Contact_Number']); ?></p>
                                            </div>
                                        </div>
                                        <!-- end of card -->
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm--12">
                                        <!-- card -->
                                        <div class="card">
                                            <div class="card-header bg-dark text-light">
                                               <h5><span class="pr-2"><i class="fas fa-info-circle"></i></span>Subject/Course</h5> 
                                            </div>
                                            <div class="card-body">
                                            <p>Subject Code: <?php echo htmlspecialchars($subject['Subject_Code']); ?> </p>
                                            <p>Subject Description: <?php echo htmlspecialchars($subject['Subject_Description']); ?></p>
                                            <p>Course Code: <?php echo htmlspecialchars($course['Course_Code']); ?></p>
                                            <p>Course Description: <?php echo htmlspecialchars($course['Course_Description']); ?> </p>
                                            <p>Year Level: <?php echo htmlspecialchars($schedule['Year_Level']); ?></p>
                                            <p>Semester: <?php echo htmlspecialchars($schedule['Semester']); ?></p>
                                            <p>Section: <?php echo htmlspecialchars($schedule['Section']); ?></p>
                                            </div>
                                        </div>
                                        <!-- end of card -->
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-lg-4">
                                                <div class="card">
                                                    <div class="card-header bg-dark text-light">
                                                        <h5>Score</h5>
                                                    </div>
                                                    <div class="card-body bg-info text-light">
                                                        <h1><?php echo htmlspecialchars($row['Score']); ?>%</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end of col card -->
                                            <div class="col-md-6 col-sm-6 col-lg-4">
                                                <div class="card">
                                                    <div class="card-header bg-dark text-light">
                                                        <h5>Overall Score</h5>
                                                    </div>
                                                    <div class="card-body bg-primary text-light">
                                                        <h1><?php echo round($overall_score['AVG(Score)']); ?>%</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end of col card -->
                                            <?php if($row['Feedback'] != ''){ ?>
                                            <div class="col-md-12 col-sm-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-header bg-dark text-light">
                                                        <h5>Comment</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <p><?php echo htmlspecialchars($row['Feedback']); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end of col card -->
                                            <?php } ?>
                                        </div>
                                        
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

                               <?php } 
                                }else{
                               ?>
                                      </tr>
                            <?php
                               $i = 0;
                               while($seached = $faculty_result->fetch_assoc()){
                                   $i++;
                            ?>
                            <tr <?php if($seached['Status'] == 'uncheck'){ ?>class="bg-secondary text-light"<?php } ?>>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($seached['Faculty_ID']); ?></td>
                                <td><?php echo htmlspecialchars($seached['Student_ID']);?></td>
                                <td><?php echo htmlspceialchars($seached['Subject_Code']);?></td>
                                <td><?php echo htmlspecialchars($seached['Course_Code']); ?></td>
                                <td><?php echo htmlspecialchars($seached['Date_Evaluated']); ?></td>
                                <td><?php echo htmlspecialchars($seached['Score']); ?></td>
                                <td>
                                <a href="evaluate.php?info=<?php echo htmlspecialchars($row['ID']); ?>" class="btn btn-info"><i class="fas fa-chart-line"></i></a>
                                </td>
                                <td>
                                    <?php if($seached['Status'] == 'uncheck'){ ?>
                                      <a href="evaluate.php?status=<?php echo htmlspecialchars($seached['ID']);?>" class="btn btn-success"><i class="fas fa-check-square"></i></a>
                                    <?php } ?>
                                      </td>
                                  <td>
                                  <a href="evaluate.php?delete=<?php echo htmlspecialchars($seached['ID']);?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                  </td>
                            </tr>
                                <?php }
                            } ?>
                                
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid m-5 p-5"></div>

    <!-- importing libraries or frameworks -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- importing footer -->
    <?php require_once('../templates/footer.php') ?>
</body>
</html>