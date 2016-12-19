
<?php
$page_title = "Register page";
include_once 'includes/header.php';
?>
    <div class="container">
    <section class="col col-lg-5">
        <h3>Register Form</h3><hr>
        <?php if(isset($result)) echo $result; ?>
        <?php if(!empty($form_errors)) echo showErrors($form_errors); ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="email"></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="username"></label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password"></label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <button type="submit" name="btn_register" class="btn btn-primary">Register</button>
        </form>
    </section>
    <p><a href="index.php">Back</a> </p>
    </div>

<?php include_once 'includes/footer.php'; ?>