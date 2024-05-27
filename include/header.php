<!--The navbar or the header-->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <nav class="navbar bg-body-tertiary">
            <div class="container">
              <a class="navbar-brand" href="index.php">
                <img src="images/traditional-crafts-logo-removebg-preview.png" alt="Bootstrap" width="100" height="84">
              </a>
            </div>
        </nav>        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Categories
            </a>
            <ul class="dropdown-menu">

                <?php
                    foreach($categorie as $categorie) {
                        print '<li><a class="dropdown-item" href="#">'.$categorie['name'].'</a></li>';
                    }
                ?>

            </ul>
            </li>

            <?php if (isset( $_SESSION['full_name'])) {
                print '
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Profile.php">Profile</a>
                    </li>';
            } else {
                print '
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Login.php">LOGIN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Signup.php">SIGNUP</a>
                </li>';
            }
            ?>

        </ul>
        <form class="d-flex" role="search" action="index.php" method="POST">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>  

        <?php
            if ( isset($_SESSION['full_name'])) {
                print ' <a href="Logout.php" class="btn btn-primary"> Log Out </a>';
            }
        ?>
        </div>
    </div>
    </nav>
