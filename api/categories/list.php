<?php

session_start();
include "../../include/functions.php";
$categories = getAllCategories();
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

    <title>Profile admin : Dashboard</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/dashboard.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="../Logout.php">Log Out</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link " href="#">
                  <span data-feather="home"></span>
                  Home <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="file"></span>
                  Categories
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="shopping-cart"></span>
                  Products
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  Customers
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="bar-chart-2"></span>
                  Reports
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../profile.php">
                  <span data-feather="layers"></span>
                  Profile
                </a>
              </li>
            </ul>

           
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Categories</h1>
              
            <div>
              <a class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal">Add</a>
            </div>
          </div>

          <!-- List Start -->
          <div> 
             
              <?php 
                if (isset($_GET['add']) && $_GET['add'] == "ok"){
                    print '
                      <div class="alert alert-success">
                        Categorie added successfully
                      </div>';
              }
              ?>

            <?php 
               if (isset($_GET['modif']) && $_GET['modif'] == "ok"){
                   print '
                      <div class="alert alert-success">
                         Categorie modified successfully
                      </div>';
                }
          ?>
          
     
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                        $i=0;
                        foreach($categories as $categorie) {
                          $i++;
                              print '      
                              <tr>
                                <th scope="row">'.$i.'</th>
                                <td>'.$categorie['name'].'</td>
                                <td>'.$categorie['description'].'</td>
                                  <td>
              
                                    <a data-toggle="modal" data-target="#editModal'.$categorie['id'].'" class="btn btn-success">Modify</a>
                                    <a href="delete.php?idc='.$categorie['id'].'" class="btn btn-danger">Delete</a>
              
                                  </td>
                            </tr>';
                        }
                  ?>
            
                </tbody>
              </table>

            
            </div>
        </main>
      </div>
    </div>


  

    <!-- Modal Add-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="add.php" method="post">
              <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="category name">
              </div>
              <div class="form-group">
                  <textarea name="description" class="form-control" placeholder="category description"></textarea>
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <?php 
      foreach($categories as $index => $categorie) { ?>
          <!-- Modal Modify-->
          <div class="modal fade" id="editModal<?php echo $categorie['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modify category</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="modify.php" method="post">
                    <input type="hidden" value="<?php echo $categorie['id']; ?>" name="idc" />
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" value="<?php echo $categorie['name']; ?>" placeholder="category name">
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" placeholder="category description"> <?php echo $categorie['description']; ?> </textarea>
                    </div>
                  
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modify</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
      <?php
      }
    ?>
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.1/dist/Chart.min.js"></script>
  </body>
</html>
