<?php
//see the topic replies
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(0);
include 'connect.php';
include 'header.php';
//include 'write_to_console.php';

$sql = $conn->prepare('call getTopic(?)');
$sql->bindValue(1, $_GET['id']);
$sql->bindParam(1, $result, PDO::PARAM_STR, 4000);
$sql->execute();

if (!$result) {
    echo '<p id="msg">The topic could not be displayed, please try again later.</p>>';
//    die("The query failed!");
} else {
    if ($sql->rowCount($result) == 0) {
        echo 'No replies for this topic yet.';
    } else {
        //table header
        echo '<table border="1">';
        echo '<tr>';
        echo '<th class="leftpart"></th>';
        echo '</tr>';
        echo '</table>';
        //using an associative array with keys = column names
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
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
        unset($result);
    }
}
include 'footer.php';


// 5. Close database connection
$conn = null;

