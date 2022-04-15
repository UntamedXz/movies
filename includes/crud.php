<?php
    require_once '../connection.php';
    session_start();

// CREATE 
    if (isset($_POST['submit'])) {
        $title = $_POST['inputTitle'];
        $actor = $_POST['inputActor'];
        $genre = $_POST['inputGenre'];
        $director = $_POST['inputDirector'];

        if (empty($title) || empty($actor) || empty($genre) || empty($director)) {
            $_SESSION['status'] = "no input";
            echo '<script>window.location.replace("../index.php");</script>';
        } else {
            $check = mysqli_query($conn, "SELECT * FROM tblmovies WHERE title = '$title'");
            if (mysqli_num_rows($check)) {
                $_SESSION['status'] = "title exist";
                echo '<script>window.location.replace("../index.php");</script>';
            } else {
                $insert = mysqli_query($conn, "INSERT INTO tblmovies (title, actor, genre, director) VALUES ('$title', '$actor', '$genre', '$director')");
                if ($insert) {
                    $_SESSION['status'] = "upload successfully";
                    echo '<script>window.location.replace("../index.php");</script>';
                }
            }
        }
    }

// READ

// UPDATE
    if (isset($_POST['checking_editBtn'])) {
        $movie_id = $_POST['movie_id'];
        $result_array = [];
    
        $query = mysqli_query($conn, "SELECT * FROM tblmovies WHERE movie_id = '$movie_id'");
    
        if (mysqli_num_rows($query) > 0) {
            foreach ($query as $row) {
                array_push($result_array, $row);
                header('Content-type: application/json');
                echo json_encode($result_array);
            }
        } else {
            echo $return = "<h5>No Record Found!</h5>";
        }
    }

    if(isset($_POST['update'])) {
        $id = $_POST['movie-id'];
        $update_title = $_POST['editTitle'];
        $update_actor = $_POST['editActor'];
        $update_genre = $_POST['editGenre'];
        $update_director = $_POST['editDirector'];

        if (empty($update_title) || empty($update_actor) || empty($update_genre) || empty($update_director)) {
            $_SESSION['status'] = "no input in edit";
            echo '<script>window.location.replace("../index.php");</script>';
        } else {
            $query = mysqli_query($conn, "UPDATE tblmovies SET title = '$update_title', actor = '$update_actor', genre = '$update_genre', director = '$update_director' WHERE movie_id= '$id'");
            
            if($query) {
                $_SESSION['status'] = "updated successfully";
                echo '<script>window.location.replace("../index.php");</script>';
            } else {
                $_SESSION['status'] = "update unsuccessfully";
                echo '<script>window.location.replace("../index.php");</script>';
            }
        }
    }

// DELETE
    
?>