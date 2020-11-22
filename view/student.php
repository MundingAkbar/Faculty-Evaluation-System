<?php
    session_start();
    
    // check if admin session is set if not go to login page
    if(!isset($_SESSION['admin'])){
        header("Location: ../index.php");
    }
    // sesssion for active navigation
    $_SESSION['page'] = "student";

    // connection to database
    $mysqli = new mysqli('localhost','root','','faculty_evaluation') or die($mysqli->error());

        // global variables
        $id = '';
        $first_name = '';
        $middle_name = '';
        $last_name = '';
        $present_address = '';
        $contact_number = '';
        $guardian_name = '';
        $guardian_contact_number = '';
        $password = '';

        $searching = false;

        //edit data
        if(isset($_GET['edit'])){
            $id = $_GET['edit'];

            $result = $mysqli->query("SELECT * FROM Student WHERE ID = '$id';") or die($mysqli->error());
            if(count($result) == 1){
                $row = $result->fetch_array();
                $id = $row['ID'];
                $first_name = $row['First_name'];
                $middle_name = $row['Middle_name'];
                $last_name = $row['Last_name'];
                $present_address = $row['Present_Address'];
                $contact_number = $row['Contact_Number'];
                $guardian_name = $row['Guardian'];
                $guardian_contact_number = $row['Guardian_Contact_Number'];
                $password = $row['Password'];
            }
        }

        // showing info data
        if(isset($_GET['info'])){
            $id = $_GET['info'];

            $result = $mysqli->query("SELECT * FROM Student WHERE ID = '$id';") or die($mysqli->error());
            if(count($result) == 1){
                $row = $result->fetch_assoc();
                $id = $row['ID'];
                $first_name = $row['First_name'];
                $middle_name = $row['Middle_name'];
                $last_name = $row['Last_name'];
                $present_address = $row['Present_Address'];
                $contact_number = $row['Contact_Number'];
                $guardian_name = $row['Guardian'];
                $guardian_contact_number = $row['Guardian_Contact_Number'];
                $password = $row['Password'];
            }
        }

        // searching data
        if(isset($_GET['search'])){
            $id = $_GET['search_id'];
    
            $result = $mysqli->query("SELECT * FROM Student WHERE ID='$id';");
            
            if(mysqli_num_rows($result) == 1){
                $searching = true;
                $searched = $result->fetch_assoc();
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
        <div class="row mt-5">
            <!-- Student form -->
            <div class="col-md-4">
                <form action="../services/process_student.php" class="form-custom p-2" method="POST">
                      <img src="../images/reading.svg" alt="user logo" class="form-logo">
                    <div class="form-group pt-2">
                        <input type="text" class="form-control" required placeholder="Student-ID" name="student_id" value="<?php echo $id; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" required placeholder="First Name" name="first_name" value="<?php echo $first_name;?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" required placeholder="Middle Name" name="middle_name" value="<?php echo $middle_name; ?>">
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" required placeholder="Last Name" name="last_name" value="<?php echo $last_name; ?>">
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" required placeholder="Present Address" name="present_address" value="<?php echo $present_address; ?>">
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" required placeholder="Contact Number (Ex: 09123456789)" name="contact_number" value="<?php echo $contact_number; ?>">
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" required placeholder="Guardian Name" name="guardian_name" value="<?php echo $guardian_name; ?>">
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" placeholder="Guardian Contact Number" name="guardian_contact_number" value="<?php echo $guardian_contact_number; ?>">
                    </div>
                    <div class="form-group ">
                        <input type="password" class="form-control" required placeholder="Password" name="password"  value="<?php echo $password; ?>">
                    </div>
                    <!-- select for course or major -->
                    <div class="input-group ">
                        <select class="custom-select" id="inputGroupSelect02" name="majors">                   
                                <?php
                                    $result = $mysqli->query("SELECT Course_Code FROM Course;") or die($mysqli->error());
                                    while($row = $result->fetch_assoc()):
                                ?>
                            <option value="<?php echo $row['Course_Code']; ?>"><?php echo $row["Course_Code"]; ?></option>
                                    <?php endwhile; ?>
                        </select>
                        <div class="input-group-append">
                            <label class="input-group-text text" for="inputGroupSelect02">Major</label>
                        </div>
                    </div>
                    <!-- gender fieldset -->
                    <fieldset class="form-group text-light">
                        <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Gender:</legend>
                        <div class="col-sm-10">
                            <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="Male" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Male
                            </label>
                            </div>
                            <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="Female">
                            <label class="form-check-label" for="gridRadios2">
                                Female
                            </label>
                            </div>
                        </div>
                        </div>
                    </fieldset>
                    <!-- buttons for operations -->
                    <button type="submit" class="btn btn-success" name="add">Add</button>
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <button type="submit" class="btn btn-warning mt-2" name="clear">Clear</button>
                </form>
                
            </div>                   
            <div class="col-md-8 mt-5">
                    <div class="container">
                        <div class="row">
                            <!-- dynamic Student details -->
                            <div class="col-md-6 col-sm-12">
                                <h3>Student Details</h3>
                            </div>
                            <div class="col-md-6 col-sm-12">
                            <form action="student.php" class="ml-auto" method="GET">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                    <input type="text" class="form-control" placeholder="Search (Student ID)" name="search_id">
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
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Major</th>
                                <th>Contact Number</th>
                                <th>Info</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            </tr>

                            <!-- dynamic table -->
                            
                            <?php 

                                if($searching == false){
                               $result =  $mysqli->query("SELECT * FROM Student;");
                                    $i =0;
                               while($row = $result->fetch_assoc()):
                               $i++;

                            ?>

                            <tr>
                                <td><?php echo $row['ID']?></td>
                                <td><?php echo $row['First_name']?></td>
                                <td><?php echo $row['Middle_name']?></td>
                                <td><?php echo $row['Last_name']?></td>
                                <td><?php echo $row['Major']?></td>
                                <td><?php echo $row['Contact_Number']?></td>
                                <td>
                                      <a class="btn btn-info" type="button" data-toggle="modal" data-target="#info<?php echo $i; ?>" id="<?php echo $row['ID'] ?>"><i class="fas fa-info-circle"></i></a>
                                </td>
                                <td>
                                      <a href="student.php?edit=<?php echo $row['ID']; ?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
                                      </td>
                                  <td>
                                      <a href="../services/process_student.php?delete=<?php echo $row['ID'];?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                  </td>
                            </tr>

                                  <!-- Modal -->
                                    <div class="modal fade" id="info<?php echo $i; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title" id="staticBackdropLabel"><?php echo ucfirst($row['First_name'])." '".ucfirst($row['Middle_name']." '".ucfirst($row['Last_name'])); ?></h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center text-info">
                                            <p>Student ID:<b> <?php echo $row['ID'] ?></b></p>
                                            <p>Present Address: <b><?php echo $row['Present_Address'] ?></b> </p>
                                            <p>Contact Number: <b><?php echo $row['Contact_Number'] ?></b> </p>
                                            <p>Guardian Name: <b><?php echo $row['Guardian'] ?></b> </p>
                                            <p>Guardian Contact Number: <b><?php echo $row['Guardian_Contact_Number'] ?></b> </p>
                                            <p>Password: <b> <?php echo $row['Password'] ?></b></p>
                                            <p>Major: <b><?php echo $row['Major'] ?></b></p>
                                            <p>Gender: <b> <?php echo $row['Gender'] ?></b></p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- End of Modal -->
                               <?php endwhile; ?>
                               <?php }else{ ?>

                                <tr>
                                <td><?php echo $searched['ID']?></td>
                                <td><?php echo $searched['First_name']?></td>
                                <td><?php echo $searched['Middle_name']?></td>
                                <td><?php echo $searched['Last_name']?></td>
                                <td><?php echo $searched['Major']?></td>
                                <td><?php echo $searched['Contact_Number']?></td>
                                <td>
                                      <a href="student.php?info=<?php echo $searched['ID']; ?>" class="btn btn-info" data-toggle="modal" data-target="#this-data"><i class="fas fa-info-circle"></i></a>
                                </td>
                                <td>
                                      <a href="student.php?edit=<?php echo $searched['ID']; ?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
                                      </td>
                                  <td>
                                      <a href="../services/process_student.php?delete=<?php echo $searched['ID'];?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                  </td>
                            </tr>
                             <!-- Modal -->
                             <div class="modal fade" id="this-data" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="staticBackdropLabel"><?php echo ucfirst($searched['First_name'])." '".ucfirst($searched['Middle_name']." '".ucfirst($searched['Last_name'])); ?></h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center text-info">
                                            <p>Student ID:<b> <?php echo $searched['ID'] ?></b></p>
                                            <p>Present Address: <b><?php echo $searched['Present_Address'] ?></b> </p>
                                            <p>Contact Number: <b><?php echo $searched['Contact_Number'] ?></b> </p>
                                            <p>Guardian Name: <b><?php echo $searched['Guardian'] ?></b> </p>
                                            <p>Guardian Contact Number: <b><?php echo $searched['Guardian_Contact_Number'] ?></b> </p>
                                            <p>Password: <b> <?php echo $searched['Password'] ?></b></p>
                                            <p>Major: <b><?php echo $searched['Major'] ?></b></p>
                                            <p>Gender: <b> <?php echo $searched['Gender'] ?></b></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- End of Modal -->

                               <?php } ?>
                            <!-- end of dynamic table -->
                            
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    </div>


    <!-- import frameworks or libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- footer templates -->
    <?php require_once('../templates/footer.php') ?>
</html>