<?php

//create category
error_reporting(E_ALL & ~E_NOTICE);
include 'connect.php';
include 'header.php';
include 'validation.php';
//include 'write_to_console.php';

echo '<h2 id="title">Create a category</h2>';
if( $_SESSION['user_level'] != 1 )
{
    //the user is not signed in as admin
    echo '<p id="msg">Sorry, you have to be signed in as Admin to create a category.<p>';
} else if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    ?>
<!--    display the form if the request is not POST-->


<form action="" method="post">
    <div class="form-group">
        <label for="catName">Category Name</label>
        <input type="text" class="form-control" id="catName" name="cat_name"
               placeholder="Type a category name!">
    </div>
    <div class="form-group">
        <label for="catDescr">Category Description</label>
        <textarea type="text" class="form-control" rows="3" id="catDescr" name="cat_description"
                  placeholder="Type a category description!"></textarea>
    </div>
    <button type="submit" class="btn btn-primary" name="submitButton">Add category</button>
    </form>
    <?php
    
} else {
//    the form has been posted, saving the category in the db


    $sql = $conn->prepare('call insertCategory(?, ?)');
    $sql->bindValue(1, val($_POST['cat_name']));
    $sql->bindValue(2, val($_POST['cat_description']));
    $result = $conn->execute();
    if (!$result) {
        //something went wrong, display the error
        echo 'Error' . $conn->errorInfo();
    } else {
        echo '<p id="msg">New category successfully added.</p>';
    };
}

$conn = null;
include 'footer.php'; ?>