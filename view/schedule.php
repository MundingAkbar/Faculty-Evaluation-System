<?php
    session_start();
    
    // check if admin session is set if not go to login page
    if(!isset($_SESSION['admin'])){
        header("Location: ../index.php");
    }
    // session for active navigation
    $_SESSION['page'] = "schedule";
    // connecting to database
    $mysqli = new mysqli('localhost','root','','faculty_evaluation') or die($mysqli->error());

        // global variables
        $id = '';
        $semester = '';
        $section = '';
        $year_level = '';
        $faculty_id = '';
        $subject_code = '';
        $course_code = '';

        $searching = false;

        //edit data
        if(isset($_GET['edit'])){
            $id = $_GET['edit'];

            $result = $mysqli->query("SELECT * FROM Schedule WHERE ID = $id;") or die($mysqli->error);
            if(count($result) == 1){
                
                $row = $result->fetch_array();
                $id = $row['ID'];
                $semester = $row['Semester'];
                $section = $row['Section'];
                $year_level = $row['Year_Level'];
                $faculty_id = $row['Faculty_ID'];
                $subject_code = $row['Subject_Code'];
                $course_code = $row['Course_Code'];
            }
        }

        // showing info data
        if(isset($_GET['info'])){
            $id = $_GET['info'];

            $result = $mysqli->query("SELECT * FROM Schedule WHERE ID = $id;") or die($mysqli->error());
            if(count($result) == 1){
                $row = $result->fetch_assoc();
                $id = $row['ID'];
                $semester = $row['Semester'];
                $section = $row['Section'];
                $year_level = $row['Year_Level'];
                $faculty_id = $row['Faculty_ID'];
                $subject_code = $row['Subject_Code'];
                $course_code = $row['Course_Code'];
            }
        }

        //searching data
        if(isset($_GET['search'])){
            $subject_code = $_GET['search_subject'];
    
            $result = $mysqli->query("SELECT * FROM Schedule WHERE Subject_Code='$subject_code';") or die($mysqli->error);
            
            if(mysqli_num_rows($result) >= 1){
                $searching = true;
            }else{
                echo "no data";
            }
        }

        // showing all data
        if(isset($_GET['show_all'])){
            $searching = false;
        }
        
?>

<!DOCTYPE html>
<html lang="en">
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
        <div class="row mt-5">
            <div class="col-md-4">
                <form action="../services/process_schedule.php" method="POST" class="form-custom p-2">
                <input type="hidden" class="form-control" placeholder="Section" name="id" value="<?php echo $id; ?>">
                      <img src="../images/schedule.svg" alt="user logo" class="form-logo">
                      <div class="input-group pb-3 pt-3">
                        <select class="custom-select" id="inputGroupSelect02" name="semester">
                            <option value="1st" selected>1st</option>
                            <option value="2nd">2nd</option>
                        </select>
                        <div class="input-group-append">
                            <label class="input-group-text text" for="inputGroupSelect02">Semester</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input required type="text" class="form-control" placeholder="Section" name="section" value="<?php echo $section; ?>">
                    </div>
                    <div class="form-group ">
                        <input required type="text" class="form-control" placeholder="Year Level (Ex: 1st/2nd/3rd)" name="year_level" value="<?php echo $year_level; ?>">
                    </div>
                    <div class="form-group ">
                        <input required type="text" class="form-control" placeholder="Facutly ID" name="faculty_id" value="<?php echo $faculty_id; ?>">
                    </div>
                    <div class="form-group ">
                        <input required type="text" class="form-control" placeholder="Subject Code" name="subject_code" value="<?php echo $subject_code; ?>">
                    </div>
                    <div class="form-group ">
                        <input required type="text" class="form-control" placeholder="Course Code" name="course_code" value="<?php echo $course_code; ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-success" name="add">Add</button>
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <button type="submit" class="btn btn-warning mt-2" name="clear">Clear</button>
                </form>
                
            </div>                   
            <div class="col-md-8 mt-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h3>Schedule Details</h3>
                            </div>
                            <div class="col-md-6 col-sm-12">
                            <form action="schedule.php" method="GET" class="ml-auto">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                    <input type="text" class="form-control" placeholder="Search Schedule(Subject code)" name="search_subject">
                                    <button type="submit" class="btn btn-secondary" name="search">Search</button>
                                    <?php if($searching == true): ?>
                                        <button type="submit" class="btn btn-primary" name="show_all">Show All</button>
                                        <?php endif; ?>
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
                                <th>Subject Code</th>
                                <th>Course Code</th>
                                <th>Semester</th>
                                <th>Section</th>
                                <th>Year Level</th>
                                <th>Info</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            </tr>
                     <!-- dynamic table -->
                                                        
                          <?php 

                            if($searching == false){
                                    $i =0;

                                $result =  $mysqli->query("SELECT * FROM Schedule;");
                                    while($row = $result->fetch_assoc()):
                                            $i++;
                            ?>

                                <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $row['Faculty_ID']?></td>
                                <td><?php echo $row['Subject_Code']?></td>
                                <td><?php echo $row['Course_Code']?></td>
                                <td><?php echo $row['Semester']?></td>
                                <td><?php echo $row['Section']?></td>
                                <td><?php echo $row['Year_Level']?></td>
                                <td>
                                    <a class="btn btn-info" type="button" data-toggle="modal" data-target="#info<?php echo $i; ?>" id="<?php echo $row['ID'] ?>"><i class="fas fa-info-circle"></i></a>
                                </td>
                                <td>
                                    <a href="schedule.php?edit=<?php echo $row['ID']; ?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
                                    </td>
                                <td>
                                    <a href="../services/process_schedule.php?delete=<?php echo $row['ID'];?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                </td>
                                </tr>

                                <!-- Modal -->
                                    <div class="modal fade" id="info<?php echo $i; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            
                                            <?php 
                                            // fetching faculty
                                            $current_id = $row['Faculty_ID'];
                                            $results = $mysqli->query("SELECT * FROM Faculty WHERE ID = '$current_id'") or die($mysqli->error); 
                                            if(count($results) == 1){
                                                $faculty_data = $results->fetch_array();
                                            }
                                            // fetching subject
                                            $current_subject_code = $row['Subject_Code'];
                                            $result_subject = $mysqli->query("SELECT * FROM Subject WHERE Subject_Code = '$current_subject_code';") or die($mysqli->error); 
                                            if(count($result_subject) == 1){
                                                $subject_data = $result_subject->fetch_array();
                                            }
                                            // fetching course
                                            $current_course_code = $row['Course_Code'];
                                            $result_course = $mysqli->query("SELECT * FROM Course WHERE Course_Code = '$current_course_code';") or die($mysqli->error); 
                                            if(count($result_course) == 1){
                                                $course_data = $result_course->fetch_array();
                                            }
                                            ?>
                                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo ucfirst($faculty_data['First_name'])." '".ucfirst($faculty_data['Middle_name'])."' ".ucfirst($faculty_data['Last_name']); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center text-info">
                                            <p>Subject Code:<b> <?php echo $subject_data['Subject_Code'] ?></b></p>
                                            <p>Subject Description:<b> <?php echo $subject_data['Subject_Description']; ?></b></p>
                                            <p>Section: <b><?php echo $row['Section'] ?></b> </p>
                                            <p>Year Level:<b> <?php echo $row['Year_Level'] ?></b></p>
                                            <p>Faculty ID:<b> <?php echo $faculty_data['ID'] ?></b></p>
                                            <p>Faculty Department:<b> <?php echo $faculty_data['Department'] ?></b></p>
                                            <p>Course Code: <b><?php echo $course_data['Course_Code'] ?></b> </p>
                                            <p>Course Description: <b><?php echo $course_data['Course_Description'] ?></b></p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                        </div>
                                    </div>
                                    </div>
                            <!-- End of Modal -->
                        <?php endwhile; ?>
                        <?php }else{ 
                                $counter = 0;
                                while($searched = $result->fetch_assoc()):
                                    $counter++;
                            ?>

                            <tr>
                            <td><?php echo $searched['ID']?></td>
                                <td><?php echo $searched['Faculty_ID']?></td>
                                <td><?php echo $searched['Subject_Code']?></td>
                                <td><?php echo $searched['Course_Code']?></td>
                                <td><?php echo $searched['Semester']?></td>
                                <td><?php echo $searched['Section']?></td>
                                <td><?php echo $searched['Year_Level']?></td>
                            <td>
                                <a href="schedule.php?info=<?php echo $searched['ID']; ?>" class="btn btn-info" data-toggle="modal" data-target="#counter<?php echo $counter; ?>"><i class="fas fa-info-circle"></i></a>
                            </td>
                            <td>
                                <a href="schedule.php?edit=<?php echo $searched['ID']; ?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
                                </td>
                            <td>
                                <a href="../services/process_schedule.php?delete=<?php echo $searched['ID'];?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                            </td>
                            </tr>
                           <!-- Modal -->
                           <div class="modal fade" id="counter<?php echo $counter; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            
                                            <?php 
                                            // fetching faculty
                                            $current_id = $searched['Faculty_ID'];
                                            $results = $mysqli->query("SELECT * FROM Faculty WHERE ID = '$current_id'") or die($mysqli->error); 
                                            if(count($results) == 1){
                                                $faculty_data = $results->fetch_array();
                                            }
                                            // fetching subject
                                            $current_subject_code = $searched['Subject_Code'];
                                            $result_subject = $mysqli->query("SELECT * FROM Subject WHERE Subject_Code = '$current_subject_code';") or die($mysqli->error); 
                                            if(count($result_subject) == 1){
                                                $subject_data = $result_subject->fetch_array();
                                            }
                                            // fetching course
                                            $current_course_code = $searched['Course_Code'];
                                            $result_course = $mysqli->query("SELECT * FROM Course WHERE Course_Code = '$current_course_code';") or die($mysqli->error); 
                                            if(count($result_course) == 1){
                                                $course_data = $result_course->fetch_array();
                                            }
                                            ?>
                                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo ucfirst($faculty_data['First_name'])." '".ucfirst($faculty_data['Middle_name'])."' ".ucfirst($faculty_data['Last_name']); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center text-info">
                                            <p>Subject Code:<b> <?php echo $subject_data['Subject_Code'] ?></b></p>
                                            <p>Subject Description:<b> <?php echo $subject_data['Subject_Description']; ?></b></p>
                                            <p>Section: <b><?php echo $searched['Section'] ?></b> </p>
                                            <p>Year Level:<b> <?php echo $searched['Year_Level'] ?></b></p>
                                            <p>Faculty ID:<b> <?php echo $faculty_data['ID'] ?></b></p>
                                            <p>Faculty Department:<b> <?php echo $faculty_data['Department'] ?></b></p>
                                            <p>Course Code: <b><?php echo $course_data['Course_Code'] ?></b> </p>
                                            <p>Course Description: <b><?php echo $course_data['Course_Description'] ?></b></p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                        </div>
                                    </div>
                                    </div>
                            <!-- End of Modal -->
                            <?php 
                            endwhile;
                        } ?>
                            <!-- end of dynamic table -->
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
    

    <!-- importing libraries and frameworks -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- importing footer template -->
    <?php require_once('../templates/footer.php') ?>
</body>
</html>                                                                                                                                              