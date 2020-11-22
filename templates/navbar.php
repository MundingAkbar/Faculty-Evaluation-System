<nav class="navbar sticky-top navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#"><?php echo ucfirst($_SESSION['page']); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item">
      <a <?php if($_SESSION['page'] == "home" ){ ?> class="nav-link active" <?php } else { ?> class="nav-link"  <?php } ?> href="../view/home.php"><span><i class="fas fa-chart-line"></i></span> Dashboard</a>
      </li>
      <li class="nav-item">
        <a <?php if($_SESSION['page'] == "student" ){ ?> class="nav-link active" <?php } else { ?> class="nav-link"  <?php } ?>  href="../view/student.php"><span><i class="fas fa-user"></i></span> Student</a>
      </li>
      <li class="nav-item">
        <a <?php if($_SESSION['page'] == "faculty" ){ ?> class="nav-link active" <?php } else { ?> class="nav-link"  <?php } ?> class="nav-link" href="../view/faculty.php"><span><i class="fas fa-user"></i></span> Faculty</a>
      </li>
      <li class="nav-item">
        <a <?php if($_SESSION['page'] == "course" ){ ?> class="nav-link active" <?php } else { ?> class="nav-link"  <?php } ?> class="nav-link" href="../view/course.php"><span><i class="fas fa-university"></i></span> Course</a>
      </li>
      <li class="nav-item">
        <a <?php if($_SESSION['page'] == "subject" ){ ?> class="nav-link active" <?php } else { ?> class="nav-link"  <?php } ?> class="nav-link" href="../view/subject.php"><span><i class="fas fa-book"></i></span> Subject</a>
      </li>
      <li class="nav-item">
        <a <?php if($_SESSION['page'] == "schedule" ){ ?> class="nav-link active" <?php } else { ?> class="nav-link"  <?php } ?> class="nav-link" href="../view/schedule.php"><span><i class="fas fa-calendar-alt"></i></span> Schedule</a>
      </li>
      <li class="nav-item">
        <a <?php if($_SESSION['page'] == "questioner" ){ ?> class="nav-link active" <?php } else { ?> class="nav-link"  <?php } ?> class="nav-link" href="../view/questioner.php"><span><i class="fas fa-clipboard-list"></i></span> Questioner</a>
      </li>
      <li class="nav-item">
        <a <?php if($_SESSION['page'] == "evaluate" ){ ?> class="nav-link active" <?php } else { ?> class="nav-link"  <?php } ?> class="nav-link" href="../view/evaluate.php"><span><i class="far fa-edit"></i></span> Evaluation</a>
      </li>
        <button class="btn bg-danger text-light" type="button" data-toggle="modal" data-target="#staticBackdrop"><span><i class="fas fa-sign-out-alt"></i></span> Logout</button>
    
    </ul>
  </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout now?</p>
      </div>
      <div class="modal-footer">
        <form action="../services/process.php" method="GET">
           <button type="submit" class="btn btn-primary" name="logout">Yes</button>
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>