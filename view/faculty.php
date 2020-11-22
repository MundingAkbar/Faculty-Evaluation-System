<?php
    session_start();
    // check if admin session is set if not go to login page
    if(!isset($_SESSION['admin'])){
        header("Location: ../index.php");
    }
    // session for active navigation
    $_SESSION['page'] = "faculty";

    
    // connecting to database
    $mysqli = new mysqli('localhost','root','','faculty_evaluation') or die($mysqli->error());

        // global variables
        $faculty_id = '';
        $first_name = '';
        $middle_name = '';
        $last_name = '';
        $present_address = '';
        $contact_number = '';

        $searching = false;

        //edit data
        if(isset($_GET['edit'])){
            $id = $_GET['edit'];

            $result = $mysqli->query("SELECT * FROM Faculty WHERE ID = '$id';") or die($mysqli->error);
            if(count($result) == 1){
                $row = $result->fetch_array();
                $faculty_id = $row['ID'];
                $first_name = $row['First_name'];
                $middle_name = $row['Middle_name'];
                $last_name = $row['Last_name'];
                $present_address = $row['Present_Address'];
                $contact_number = $row['Contact_Number'];
            }
        }

        // showing info data
        if(isset($_GET['info'])){
            $id = $_GET['info'];

            $result = $mysqli->query("SELECT * FROM Student WHERE ID = '$id';") or die($mysqli->error());
            if(count($result) == 1){
                $row = $result->fetch_assoc();
                $faculty_id = $row['ID'];
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

        //searching data
        if(isset($_GET['search'])){
            $id = $_GET['search_id'];
    
            $result = $mysqli->query("SELECT * FROM Faculty WHERE ID='$id';");
            
            if(mysqli_num_rows($result) == 1){
                $searching = true;
                $searched = $result->fetch_assoc();
            }else{
                // show error message
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
            <!-- faculty form -->
            <div class="col-md-4">
                <form action="../services/process_faculty.php" method="POST" class="form-custom p-2">
                      <img src="../images/teacher.svg" alt="user logo" class="form-logo">
                    <div class="form-group pt-2">
                        <input required type="text" class="form-control" placeholder="Faculty-ID" name="faculty_id" value="<?php echo htmlspecialchars($faculty_id); ?>">
                    </div>
                    <div class="form-group">
                        <input required type="text" class="form-control" placeholder="First Name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                    </div>
                    <div class="form-group">
                        <input required type="text" class="form-control" placeholder="Middle Name" name="middle_name" value="<?php echo htmlspecialchars($middle_name); ?>">
                    </div>
                    <div class="form-group ">
                        <input required type="text" class="form-control" placeholder="Last Name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                    </div>
                    <div class="form-group ">
                        <input required type="text" class="form-control" placeholder="Present Address" name="present_address" value="<?php echo htmlspecialchars($present_address); ?>">
                    </div>
                    <div class="form-group ">
                        <input  required type="text" class="form-control" placeholder="Contact Number" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>">
                    </div>
                    <!-- not dynamic department (dynamic department feature coming soon...) -->
                    <div class="input-group ">
                        <select class="custom-select" id="inputGroupSelect02" name="department">
                            <option value="ICS" selected>ICS</option>
                            <option value="CET">CET</option>
                            <option value="HRM">HRM</option>
                        </select>
                        <div class="input-group-append">
                            <label class="input-group-text text" for="inputGroupSelect02">Department</label>
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
                    <!-- button for operations -->
                    <button type="submit" class="btn btn-success" name="add">Add</button>
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <button type="submit" class="btn btn-warning mt-2" name="clear">Clear</button>
                </form>
                
            </div>                   
            <div class="col-md-8 mt-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                            <!-- dynamic faculty details -->
                                <h3>Faculty Details</h3>
                            </div>
                            <div class="col-md-6 col-sm-12">
                            <form action="faculty.php" method="GET" class="ml-auto">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Search (Faculty ID)" name="search_id">
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
                                <th>Department</th>
                                <th>Contact Number</th>
                                <th>Info</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            </tr>
                              <!-- dynamic table -->
                                                        
                             <?php 

                            if($searching == false){
                                    $i =0;

                                $result =  $mysqli->query("SELECT * FROM Faculty;");
                                while($row = $result->fetch_assoc()):
                                    $i++;

                            ?>

                            <tr>
                            <td><?php echo htmlspecialchars($row['ID']);?></td>
                            <td><?php echo htmlspecialchars($row['First_name']);?></td>
                            <td><?php echo htmlspecialchars($row['Middle_name']);?></td>
                            <td><?php echo htmlspecialchars($row['Last_name']);?></td>
                            <td><?php echo htmlspecialchars($row['Department']);?></td>
                            <td><?php echo htmlspecialchars($row['Contact_Number']);?></td>
                            <td>
                                <a class="btn btn-info" type="button" data-toggle="modal" data-target="#info<?php echo $i; ?>" id="<?php echo htmlspecialchars($row['ID']); ?>"><i class="fas fa-info-circle"></i></a>
                            </td>
                            <td>
                                <a href="faculty.php?edit=<?php echo htmlspecialchars($row['ID']); ?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
                                </td>
                            <td>
                                <a href="../services/process_faculty.php?delete=<?php echo $row['ID'];?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                            </td>
                            </tr>

                            <!-- Modal -->
                                <div class="modal fade" id="info<?php echo $i; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"><?php echo ucfirst($row['First_name'])." '".ucfirst($row['Middle_name'])."' ".ucfirst($row['Last_name']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center text-info">
                                        <p>Faculty ID:<b> <?php echo $row['ID'] ?></b></p>
                                        <p>Present Address: <b><?php echo $row['Present_Address'] ?></b> </p>
                                        <p>Contact Number: <b><?php echo $row['Contact_Number'] ?></b> </p>
                                        <p>Department: <b><?php echo $row['Department'] ?></b></p>
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
                                <td><?php echo $searched['Department']?></td>
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
                                        <h5 class="modal-title" id="staticBackdropLabel"><?php echo ucfirst($searched['First_name'])." '".ucfirst($searched['Middle_name'])."' ".ucfirst($searched['Last_name']); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center text-info">
                                        <p>Faculty ID:<b> <?php echo $searched['ID'] ?></b></p>
                                        <p>Present Address: <b><?php echo $searched['Present_Address'] ?></b> </p>
                                        <p>Contact Number: <b><?php echo $searched['Contact_Number'] ?></b> </p>
                                        <p>Department: <b><?php echo $searched['Department'] ?></b></p>
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
    

    <!-- importing frameworks and libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!--  importing footer template -->
    <?php require_once('../templates/footer.php') ?>
</body>
</html>