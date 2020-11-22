<nav class="navbar sticky-top navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#"><?php echo ucfirst($_SESSION['page']); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
      
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