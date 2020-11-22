<?php
    session_start();
    
    // check if admin session is set if not go to login page
    if(!isset($_SESSION['admin'])){
        header("Location: ../index.php");
    }
    // setting up sessions
    $_SESSION['page'] = "subject";

    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error);

      // global variables
      $subject_code = '';
      $subject_description = '';
      $date_added = '';
  
      $searching = false;

    //edit data
    if(isset($_GET['edit'])){
        $subject_code = $_GET['edit'];

        $result = $mysqli->query("SELECT * FROM Subject WHERE Subject_Code = '$subject_code';") or die($mysqli->error);
        if(count($result) == 1){
           $row = $result->fetch_array();
           $subject_code = $row['Subject_Code'];
           $subject_description = $row['Subject_Description'];
           $date_added = $row['Date_Added'];
        }
    }

      //searching data
        if(isset($_GET['search'])){
            $subject_code = $_GET['search_id'];

            $result = $mysqli->query("SELECT * FROM Subject WHERE Subject_Code='$subject_code';");
            
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
    <!-- importing templates header and navbar -->
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
                <form action="../services/process_subject.php" method="POST" class="form-custom p-2">
                      <img src="../images/lesson.svg" alt="user logo" class="form-logo">
                      <input type="hidden" name="subject_id" value="<?php echo $subject_code; ?>">
                    <div class="form-group pt-2">
                    <input required type="text" class="form-control" placeholder="Subject Code" value="<?php  echo $subject_code;?>" name="subject_code">
                    </div>
                       <div class="form-group">
                        <input required type="text" class="form-control" placeholder="Subject Description" value="<?php  echo $subject_description;?>" name="subject_description">
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
                                <h3>Subject Details</h3>
                            </div>
                            <div class="col-md-6 col-sm-12">
                            <form action="subject.php" method="GET" class="ml-auto">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                    <input type="text" class="form-control" placeholder="Search" name="search_id">
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
                                <th>Subject Code</th>
                                <th>Subject Description</th>
                                <th>Date Added</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            </tr>
                            <?php
                                if($searching == false){
                                $result =  $mysqli->query("SELECT * FROM Subject;");
                                while($row = $result->fetch_assoc()):
                            ?>        <tr>
                                <td><?php echo $row['Subject_Code']; ?></td>
                                <td><?php echo $row['Subject_Description'] ?></td>
                                <td><?php echo $row['Date_Added']; ?></td>
                                <td>
                                      <a href="subject.php?edit=<?php echo $row['Subject_Code'];?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
                                      </td>
                                  <td>
                                      <a href="../services/process_subject.php?delete=<?php echo $row['Subject_Code']; ?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                  </td>
                            </tr>
                                <?php endwhile; }else{?>
                                    <tr>
                                    <td><?php echo $searched['Subject_Code']; ?></td>
                                    <td><?php echo $searched['Subject_Description'] ?></td>
                                    <td><?php echo $searched['Date_Added']; ?></td>
                                    <td>
                                        <a href="subject.php?edit=<?php echo $searched['Subject_Code'];?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
                                        </td>
                                    <td>
                                        <a href="../services/process_subject.php?delete=<?php echo $searched['Subject_Code']; ?>" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                    </td>
                                    </tr>
                                <?php } ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
    <!-- importing libraries/frameworks/template footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <?php require_once('../templates/footer.php') ?>
</body>
</html>