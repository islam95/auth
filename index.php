<?php
$page_title = "Home page";
include_once 'includes/header.php';
?>

    <div class="container">
        <h2>User Authentication System </h2><hr>
        <?php if(!isset($_SESSION['username'])): ?>
            <p class="lead">You are currently not logged in <a href="login.php">Login</a> Not registered? <a href="register.php">Register</a></p>
        <?php else: ?>
            <p class="lead">You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href="logout.php">Logout</a></p>
        <?php endif ?>

    </div> <!-- /.container -->


<?php include_once 'includes/footer.php'; ?>