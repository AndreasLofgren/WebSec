<?php
/**
 * Created by PhpStorm.
 * User: negut_000
 * Date: 5/5/2017
 * Time: 17:42
 */

//index.php
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(0);
include 'connect.php';
include 'header.php';
//include 'write_to_console.php';
session_start();
echo '<h2 id="title">Forum overview</h2>';
if (!$_SESSION['signed_in']) {
    echo '<p id="msg">You must be <a href="signin.php">signed in</a> to view the forum\'s content!</p>';
} else {
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);

//write_to_console($result);
    if (!$result) {
        echo '<p id="msg">The categories could not be displayed, please try again later.</p></br>';
//        die("The query failed!" . mysqli_error($conn));
    } else {
        if (mysqli_num_rows($result) == 0) {
            echo 'No categories defined yet.';
        } else {
            //table header
            echo '<table border="1">';
            echo '<tr>';
            echo '<th class="leftpart">Category</th>';
            echo '<th class="rightpart">Navigate to topics</th>';
            echo '</tr>';
            echo '</table>';
            $prev_topic_date = "";
            //using an associative array with keys = column names
            while ($row = mysqli_fetch_assoc($result)) {
                //table rows
                echo '<table border="1">';
                echo '<tr id="table_rows">';
                echo '<td class="leftpart">';
                echo '<h3><a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';
                echo '<a class="topic_subject" href="category.php?id=' . $row['cat_id'] . '">Go to ' . $row['cat_name'] . ' topics</a>';
                echo '</td>';
                echo '</tr>';
                echo '</table>';
//            write_to_console($row);
            }
            
            //release the resource
            mysqli_free_result($result);
        }
    }
}
include 'footer.php';


// 5. Close database connection
mysqli_close($conn);

