<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"-->
<!--        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="A simple Forum"/>
    <meta name="keywords" content="no keywords needed for now: keyword1, keyword2, keyword_n"/>
    <title>Simple Forum</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<h1 id="forum_title">Team's 21 forum</h1>
<div id="wrapper">
    <div id="menu">
        <a class="item" href="index.php">Home</a> -
        <a class="item" href="create_topic.php">Create a topic</a> -
        <a class="item" href="create_cat.php">Create a category</a>

        <div id="userbar">
            <?php
            session_start();
            echo '<div id = "userbar">';
            if ($_SESSION['signed_in']) {
                echo 'Hello <span id="user-name"> ' . $_SESSION['user_name'] . '</span> Not you? <a href="signout.php">Sign out</a>';
            } else {
                echo '<a class="item" href="signin.php">Sign in</a> or <a class="item" href="signup.php">Create an account</a>';
            }
            echo '</div ><!--close #userbar-->';
            ?>
        </div>
    </div><!--close #menu-->
    <div id="content">