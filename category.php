<?php
//create_cat.php
include 'connect.php';
include 'header.php';

//first select the category based on $_GET['id'] passed from the index.php page

$sql = $conn->exec('call getCategory('.$_GET['id'].')');
$result = $conn->query('select '.$_GET['id'])->fetchAll();

if(!$result)
{
    echo 'The category could not be displayed, please try again later.' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo '<p id="msg">This category does not exist.</p>';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc( $result))
        {
            echo '<h2 id="title">Topics in "' . $row['cat_name'] . '" category</h2>';
        }
        
        //do a query for the topics
        $sql = $conn->exec('call getTopicCat('.$_GET['id'].')');

        
        $result = $conn->query('select '.$_GET['id'])->fetchAll();
        
        if(!$result)
        {
            echo '<p id="msg">The topics could not be displayed, please try again later.</p>';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo '<p id="msg">There are no topics in this category yet.</p>';
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                      <tr>
                        <th class="leftpart">Topic</th>
                        <th class="rightpart">Created on</th>
                      </tr>
                      </table>';
                
                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<table border="1">';
                    echo '<tr id="table_rows">';
                    echo '<td class="leftpart">';
                    echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>';
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo date('d-m-Y h:i a', strtotime($row['topic_date']));
                    echo '</td>';
                    echo '</tr>';
                    echo '</table>';
                }
            }
        }
    }
}

include 'footer.php';
