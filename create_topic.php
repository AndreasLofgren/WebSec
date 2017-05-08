<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
//create topic
include 'connect.php';
include 'header.php';

echo '<h2 id="title">Create a topic</h2>';
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    echo '<p id="msg">Sorry, you have to be <a href="signin.php">signed in</a> to create a topic.</p>';
}
else
{
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    categories";
        
        $result = mysqli_query($conn,$sql);
        
        if(!$result)
        {
            //the query failed, uh-oh :-(
            echo 'Error while selecting from database. Please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                //there are no categories, so a topic can't be posted
                if($_SESSION['user_level'] == 1)
                {
                    echo 'You have not created categories yet.';
                }
                else
                {
                    echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                }
            }
            else
            {
                echo '<form class="form-group" method="post" action="">';
                echo '<div class="form-group">
                        <label for="topic-subject">Subject</label>
                        <input type="text" class="form-control" id="topic-subject" name="topic_subject"
                               placeholder="Type a subject!"></div>';
                echo '<div class="form-group"><label id="label-cat">Category: </label>';
                echo '<select class="form-control" name="topic_cat">';
                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
                echo '</select></div>';
                echo '<div><label>Message: </label>
                        <textarea type="text" rows="5" class="form-control" name="post_content"/>
                       </textarea></div>
                    <input id="btn-create-topic" type="submit" class="btn btn-primary" value="Create topic" />
                 </form>';
            }
        }
    }
    else
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysqli_query($conn, $query);
        
        if(!$result)
        {
            //the query failed
            echo '<p id="msg">An error occured while creating your topic. Please try again later.</p>';
        }
        else
        {
            
            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
            $sql = "INSERT INTO
                        topics(topic_subject,
                               topic_date,
                               topic_cat,
                               topic_by)
                   VALUES('" . mysqli_real_escape_string($conn, $_POST['topic_subject']) . "',
                               NOW(),
                               " . mysqli_real_escape_string($conn, $_POST['topic_cat']) . ",
                               " . $_SESSION['user_id'] . "
                               )";
            
            $result = mysqli_query($conn, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'An error occured while inserting your data. Please try again later.' . mysqli_error($conn);
                $sql = "ROLLBACK;";
                $result = mysqli_query($conn, $sql);
            }
            else
            {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $topicid = mysqli_insert_id($conn);
                
                $sql = "INSERT INTO
                            posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysqli_real_escape_string($conn, $_POST['post_content']) . "',
                                  NOW(),
                                  " . $topicid . ",
                                  " . $_SESSION['user_id'] . "
                            )";
                $result = mysqli_query($conn, $sql);
                
                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'An error occured while inserting your post. Please try again later.' . mysqli_error();
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($conn, $sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($conn, $sql);
                    
                    //after a lot of work, the query succeeded!
                    echo '<p id="msg">You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.</p>';
                }
            }
        }
    }
}
include 'footer.php';