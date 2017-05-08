<?php
//signin.php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include 'connect.php';
include 'header.php';
include 'enc.php';

echo '<h2 id="title">Sign in</h2>';

//first, check if the user is already signed in. If that is the case, there is no need to display this page
if (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
    echo '<p id="msg">You are already signed in, you can <a href="signout.php">sign out</a> if you want.<p>';
} else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form class="form-inline"  method="post" action="">
            <div class="form-group">
            <label id="signin-label1" for="user_name">Username: </label><input class="form-control" type="text" name="user_name" />
            </div>
            <div class="form-group">
            <label id="signin-label2" for="user_pass">Password: </label><input class="form-control" type="password" name="user_pass">
            </div>
            <input id="signin-btn" class="btn btn-primary" type="submit" value="Sign in" />
         </form>';
    } else {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */
        
        if (!isset($_POST['user_name'])) {
            $errors[] = 'The username field must not be empty.';
        }
        
        if (!isset($_POST['user_pass'])) {
            $errors[] = 'The password field must not be empty.';
        }
        
        if (!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/ {
            echo 'Some fields are not filled in correctly!';
//            echo '<ul>';
//            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
//            {
//                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
//            }
//            echo '</ul>';
        } else {
            //the form has been posted without errors, so save it
            //mysql_real_escape_string, keep everything safe!
            $sql = "SELECT 
                        user_id,
                        user_name,
                        user_level,
                        user_pass
                    FROM
                        users
                    WHERE
                        user_name = '" . mysqli_real_escape_string($conn, $_POST['user_name']) . "'";
            
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0) {
                //something went wrong, display the error
                echo '<p id="msg">The user does\'n exist. Please<a href="signup.php"> sign-up<a>!</p>';
                //echo mysqli_error($conn); //debugging purposes, uncomment when needed
            } else {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                while ($row = mysqli_fetch_assoc($result)) {
                    if ( !password_verify( $_POST['user_pass'], $row['user_pass'] ) ) {
                        echo '<p id="msg">You have supplied a wrong username or password. Please try again.</p>';
                    } else {
                        $_SESSION['signed_in'] = true;
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_name'] = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                        
                        echo '<p id="msg">Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.<p>';
                        
                    }
                }
                mysqli_free_result($result);
            }
        }
    }
}
include 'footer.php';
