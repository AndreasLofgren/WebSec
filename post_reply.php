<?php

include 'connect.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    echo 'This file cannot be called directly.';
}
else
{
    //check for sign in status
    if(!$_SESSION['signed_in'])
    {
        echo 'You must be signed in to post a reply.';
    }
    else
    {
        //a real user posted a real reply
        $sql = $conn->prepare('call insertPost(:post_content, NOW(), :post_topic, post_by)');
        $value1 =  val($_POST['reply_content']);
        $sql->bindParam(':post_content', $value1, PDO::PARAM_STR, 4000);
        $value2 = $_GET['id'];
        $sql->bindParam(':post_topic', $value2, PDO::PARAM_STR, 4000);
        $value3 = $_SESSION['user_id'];
        $sql->bindParam(':post_by', $value3, PDO::PARAM_STR, 4000);
        $result = $sql->execute();
        
        if(!$result)
        {
            echo 'Your reply has not been saved, please try again later.';
        }
        else
        {
            echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
        }
    }
}

include 'footer.php';
?>