<?php
    session_start();
    
    // check if admin session is set if not go to login page
    if(!isset($_SESSION['admin'])){
        header("Location: ../index.php");
    }
    // setting session for navigation
    $_SESSION['page'] = "questioner";

    // database connection
    $mysqli = new mysqli("localhost","root","","faculty_evaluation") or die($mysqli->error);

      // global variables
      $question = '';
      $date_added = '';
  
      $searching = false;

    //edit data
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];

        $result = $mysqli->query("SELECT * FROM Questioner WHERE ID = $id;") or die($mysqli->error);
        if(count($result) == 1){
           $row = $result->fetch_array();
           $id = $row['ID'];
           $question = $row['Question'];
           $date_added = $row['Date_Added'];
        }
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
                <form action="../services/process_questioner.php" method="POST" class="form-custom p-2">
                      <img src="../images/test.svg" alt="user logo" class="form-logo">
                      <div class="input-group pt-3 pb-3">
                            <textarea required class="form-control" aria-label="With textarea" rows="10" placeholder="What question to add?..." name="question" echo $question; ?><?php echo $question ?></textarea>
                     </div>
                    <button type="submit" class="btn btn-success" name="add">Add</button>
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <button type="submit" class="btn btn-warning mt-2" name="clear">Clear</button>
                </form>
                
            </div>                   
            <div class="col-md-8 mt-5 myTable" >
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h3>Question Details</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>No.</th>
                                <th>Question</th>
                                <th>Date Added</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                                <?php 
                                         $i =0;
                                        $result =  $mysqli->query("SELECT * FROM Questioner;") or die($mysqli->error);
                                        while($row = $result->fetch_assoc()):
                                            $i++;
                                    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($row["Question"]); ?></td>
                                <td><?php echo htmlspecialchars($row["Date_Added"]);?></td>
                                <td>
                                <a href="questioner.php?edit=<?php echo $row['ID']; ?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
                                      </td>
                                  <td>
                                  <a href="../services/process_questioner.php?delete=<?php echo htmlspecialchars($row['ID']); ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                  </td>
                            </tr>
                        <?php endwhile; ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
    

    <!-- importing libaries and frameworks -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- importing footer template -->
    <?php require_once('../templates/footer.php') ?>
</body>
</html>