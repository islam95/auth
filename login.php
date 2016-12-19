<?php
$page_title = "Login page";
include_once 'includes/header.php';
include_once 'includes/includeLogin.php';
?>

<div class="container">
    <section class="col col-lg-5">
        <h3>Login Form</h3><hr>
        <div>
        <?php if(isset($result)) echo $result; ?>
        <?php if(!empty($form_errors)) echo showErrors($form_errors); ?>
        </div>
        <div class="clearfix"></div>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="*************">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <a href="forgot_password.php" class="pull-right">Forgot password?</a>
            <button type="submit" name="btn_login" class="btn btn-primary">Login</button>
        </form>
    </section>
    <p><a href="index.php">Back</a> </p>
</div>

<?php include_once 'includes/footer.php'; ?>