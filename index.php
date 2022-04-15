<?php 
    require_once 'connection.php'; 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#movie').dataTable({
            "scrollY": "55vh",
            "scrollX": true,
            "scrollCollapse": true,
            "paging": false
        });
    });
    </script>
    <title>Movies</title>
</head>

<body>
    <?php include 'includes/navbar.php';?>

<!-- VIEW MODAL -->
    <div class="modal fade" id="movie-detailsView" tabindex="-1" aria-labelledby="movie-detailsViewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="movie-detailsViewLabel" style="color: teal; font-weight: 700;">View Movie Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="movie-detailsView">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<!-- EDIT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel" style="color: teal; font-weight: 700;">Edit Movie Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/crud.php" method="POST">
                        <div class="mb-3" style="display: none;">
                            <label for="movie-id" class="form-label">Movie ID</label>
                            <input type="text" class="form-control" placeholder="Movie ID" id="movie-id"
                                name="movie-id">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" placeholder="Enter Movie Title" id="edit-title"
                                name="editTitle">
                        </div>
                        <div class="mb-3">
                            <label for="actor" class="form-label">Actor</label>
                            <input type="text" class="form-control" placeholder="Enter Movie Actor" id="edit-actor"
                                name="editActor">
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input type="text" class="form-control" placeholder="Enter Movie Genre" id="edit-genre"
                                name="editGenre">
                        </div>
                        <div class="mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="text" class="form-control" placeholder="Enter Movie Director"
                                id="edit-director" name="editDirector">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel" style="color: teal; font-weight: 700;">Edit Movie Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/crud.php" method="POST">
                        <div class="mb-3" style="display: none;">
                            <label for="movie-id" class="form-label">Movie ID</label>
                            <input type="text" class="form-control" placeholder="Movie ID" id="delete_movie-id" name="movie-id">
                        </div>
                        <h6>Are you sure, you want to delete this movie?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<!-- ADD MOVIES -->
    <div class="container mt-3">
        <div class="card" style="width: 100%; padding: 10px; margin-top: 80px;">
            <div class="row gx-2 gy-2">
                <div class="col-md-3 mx-0">
                    <div class="card" style="width: 100%; padding: 10px;">
                        <form action="includes/crud.php" method="POST">
                            <?php 
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'no input') {
                                    echo '<div class="alert alert-danger" id="required-alert" role="alert">
                                    All fields are required.
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'title exist') {
                                    echo '<div class="alert alert-danger" id="title-alert" role="alert">
                                    Title already exist.
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'upload successfully') {
                                    echo '<div class="alert alert-success" id="success" role="alert">
                                    Movie added successfully!
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                            ?>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Enter Movie Title" id="title"
                                    name="inputTitle">
                            </div>
                            <div class="mb-3">
                                <label for="actor" class="form-label">Actor</label>
                                <input type="text" class="form-control" placeholder="Enter Movie Actor" id="actor"
                                    name="inputActor">
                            </div>
                            <div class="mb-3">
                                <label for="genre" class="form-label">Genre</label>
                                <input type="text" class="form-control" placeholder="Enter Movie Genre" id="genre"
                                    name="inputGenre">
                            </div>
                            <div class="mb-3">
                                <label for="director" class="form-label">Director</label>
                                <input type="text" class="form-control" placeholder="Enter Movie Director" id="director"
                                    name="inputDirector">
                            </div>
                            <center><button type="submit" class="btn btn-primary" style="width: 100%;"
                                    name="submit">Insert</button></center>
                        </form>
                    </div>
                </div>

<!-- MOVIES LIST TABLE -->
                <div class="col-md-9 mx-0">
                    <div class="card" style="width: 100%; padding: 10px;">
                        <form action="">
                            <?php 
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'no input in edit') {
                                    echo '<div class="alert alert-danger" id="title-alert" role="alert">
                                    All fields are required.
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'title already exist') {
                                    echo '<div class="alert alert-danger" id="title-alert" role="alert">
                                    Title already exist!
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'update unsuccessfully') {
                                    echo '<div class="alert alert-danger" id="title-alert" role="alert">
                                    Movie details update unsuccessfully!
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'updated successfully') {
                                    echo '<div class="alert alert-success" id="success" role="alert">
                                    Movie details updated successfully!
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'deleted successfully') {
                                    echo '<div class="alert alert-success" id="success" role="alert">
                                    Movie deleted successfully!
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                                if(isset($_SESSION['status']) && $_SESSION['status'] == 'delete unsuccessfully') {
                                    echo '<div class="alert alert-danger" id="title-alert" role="alert">
                                    Movie delete unsuccessfully!
                                    </div>';
                                    unset($_SESSION['status']);
                                }
                            ?>
                        </form>
                        <table id="movie" class="hover" style="border-color: teal; width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Movie ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Actor</th>
                                    <th scope="col">Genre</th>
                                    <th scope="col">Director</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM tblmovies";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_array($result)):
                                ?>
                                <tr>
                                    <td class="id" name="mid"><?php echo $row['movie_id']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['actor']; ?></td>
                                    <td><?php echo $row['genre']; ?></td>
                                    <td><?php echo $row['director']; ?></td>
                                    <td class="action">
                                        <center>
                                            <a href="#" class="view" data-bs-toggle="modal"
                                                data-bs-target="#movie-detailsView"><i class="fa-solid fa-eye"></i></a>
                                            <a href="#" class="edit" data-bs-toggle="modal"
                                                data-bs-target="#editModal"><i
                                                    class="fa-solid fa-pen-to-square "></i></a>
                                            <a href="#" class="delete" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></a>
                                        </center>
                                    </td>
                                </tr>
                                <?php
                                    endwhile;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
    $(document).ready(function() {
        $('.view').click(function(e) {
            e.preventDefault();

            var id = $(this).closest('tr').find('.id').text();
            
            $.ajax({
                type: "POST",
                url: "includes/crud.php",
                data: {
                    'checking_viewBtn': true,
                    'movie_id': id,
                },
                success: function(response) {
                    $('.movie-detailsView').html(response)
                }
            });
        });

        $('.edit').click(function(e) {
            e.preventDefault();

            var id = $(this).closest('tr').find('.id').text();
            // console.log(movie_id);

            $.ajax({
                type: "POST",
                url: "includes/crud.php",
                data: {
                    'checking_editBtn': true,
                    'movie_id': id,
                },
                success: function(response) {
                    $.each(response, function(key, value) {
                        $('#movie-id').val(value['movie_id']);
                        $('#edit-title').val(value['title']);
                        $('#edit-actor').val(value['actor']);
                        $('#edit-genre').val(value['genre']);
                        $('#edit-director').val(value['director']);
                    });
                }
            });
        });

        $('.delete').click(function(e) {
            e.preventDefault();

            var id = $(this).closest('tr').find('.id').text();
            
            $('#delete_movie-id').val(id);
        });
    });
    </script>
</body>

</html>