<?php
//signup.php
error_reporting(E_ALL & ~E_NOTICE);
include 'connect.php';
include 'header.php';
include 'enc.php';


echo '<h2 id="sign-up-title">Sign up</h2>';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    ?>
    <div id="form-sign-up">
        <form id="sign-up-form" class="col-sm-6 form-horizontal" action="" method="post">
            <div class="form-group">
                <label for="user_name">Username: </label>
                <input type="text" class="form-control" id="user_name" name="user_name"
                       placeholder="Your user name!">
            </div>
            <div class="form-group">
                <label for="user_pass">Password: </label>
                <input type="password" class="form-control" id="user_pass" name="user_pass"
                       placeholder="Type your password!">
            </div>
            <div class="form-group">
                <label for="user_pass_check">Retype your password: </label>
                <input type="password" class="form-control" id="user_pass_check" name="user_pass_check"
                       placeholder="Retype your password!">
            </div>
            <div class="form-group">
                <label for="user_email">E-mail</label>
                <input type="email" class="form-control" id="user_email" name="user_email"
                       placeholder="Type your email!"></input>
            </div>
            <button type="submit" class="btn btn-primary" name="submitButton" id="sign-up-btn">Create Account</button>
        </form>
    </div>
    <?php
} else {
    /* so, the form has been posted, we'll process the data in three steps:
        1.  Check the data
        2.  Let the user refill the wrong fields (if necessary)
        3.  Save the data
    */
    $errors = array(); /* declare the array for later use */
    
    if (isset($_POST['user_name'])) {
        //the user name exists
        if (!ctype_alnum($_POST['user_name'])) { //check for alphanumeric chars
            $errors[] = 'The username can only contain letters and digits.';
        }
        if (strlen($_POST['user_name']) > 30) {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    } else {
        $errors[] = 'The username field must not be empty.';
    }
    
    
    if (isset($_POST['user_pass'])) {
        if ($_POST['user_pass'] != $_POST['user_pass_check']) {
            $errors[] = 'The two passwords did not match.';
        }
    } else {
        $errors[] = 'The password field cannot be empty.';
    }
    
    if (!empty($errors)) /*if the errors array is not empty display them...*/ {
        echo 'A couple of fields are not filled in correctly!';
        echo '<ul>';
        foreach ($errors as $key => $value) /* walk through the array so all the errors get displayed */ {
            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
        }
        echo '</ul>';
    } else {
        //save the user details in the db
        $sql = $conn->exec('call insertUser('.val($_POST['user_name']).', '.hash_bcrypt($_POST['user_pass']).', '.val( $_POST['user_email']).', '.NOW().', 0)');
        $result = $conn->query('select '.$_GET['name'])->fetchAll();

        if (!$result) {
            //something went wrong, display the error
            echo 'Something went wrong while registering. Please try again later. Possible reasons: user or email already exist.';
            //echo mysql_error(); //debugging purposes, uncomment when needed
        } else {
            echo '<p id="reg-msg">Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)<p>';
        }
    }
}

include 'footer.php';
