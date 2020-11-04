<?php
  require '../config/config.php';
  session_start();
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
  
}

?>

<?php include('header.html')?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog listings</h3>
                
              </div>
              <!-- /.card-header -->
              <?php
                if($_GET['pageno']){
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }
                $numOfrecords = 5;
                $offest = ($pageno-1)* $numOfrecords;

                $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult)/$numOfrecords);

                $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offest,$numOfrecords");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();

              ?>
              
              <div class="card-body">
                <div>
                  <a href="add.php" type="button" class="btn btn-success">New Blog Post</a>
                </div><br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($result){
                    $i=1;
                    foreach($result as $value){ 
                    ?>
                      <tr>
                      <td><?php echo $i ?></td>
                      <td><?php echo $value['title'] ?></td>
                      <td><?php echo substr($value['content'],0,90) ?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                            <a href="edit.php?id=<?php echo $value['id']?>" type="button" class="btn btn-warning">Edit</a>
                          </div>
                          <div class="container">
                            <a href="delete.php?id=<?php echo $value['id']?>" type="button" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                          </div>
                        </div>
                      </td>
                      </tr>
                    <?php
                    $i++;
                    }
                    }
                    ?>
                  </tbody>
                </table><br>
                <nav aria-label="Page navigation example" style="float:right">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){echo'disabled';}?>">
                    <a class="page-link" href="<?php if($pageno <= 1){echo "#";}else{ echo "?page=".($pageno-1);?>">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno;?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){echo'disabled';}?>">
                    <a class="page-link" href="<?php if($pageno >= $total_pages){echo "#";}else{ echo "?page=".($pageno+1);?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages;?>">Last</a></li>
                  </ul>
                </nav>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('footer.html')?>
