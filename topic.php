<?php
//see the topic replies
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(0);
include 'connect.php';
include 'header.php';
//include 'write_to_console.php';


$sql = "SELECT
    topic_id,
    topic_subject,
    topic_date
FROM
    topics
WHERE
    topics.topic_id =" . mysqli_real_escape_string($conn, $_GET['id']);

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo '<p id="msg">The topic could not be displayed, please try again later.</p>>';
//    die("The query failed!");
} else {
    if (mysqli_num_rows($result) == 0) {
        echo 'No replies for this topic yet.';
    } else {
        //table header
        echo '<table border="1">';
        echo '<tr>';
        echo '<th class="leftpart"></th>';
        echo '</tr>';
        echo '</table>';
        //using an associative array with keys = column names
        while ($row = mysqli_fetch_assoc($result)) {
            //table rows
            echo '<table border="1">';
            echo '<tr id="table_rows">';
            echo '<td class="leftpart">';
            echo '<h3>'. $row['topic_subject'] . '</h3> <h1>"THIS FUNCTIONALITY IS UNDER CONSTRUCTION!"</h1>';
            echo '</td>';
            echo '<td class="rightpart">';
            echo '<a class="topic_subject" href="topic.php?id="></a>';
            echo '</td>';
            echo '</tr>';
            echo '</table>';
//            write_to_console($row);
        }
        
        //release the resource
        mysqli_free_result($result);
    }
}
include 'footer.php';


// 5. Close database connection
mysqli_close($conn);

