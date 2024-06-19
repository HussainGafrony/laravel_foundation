<?php

include './controller/comment.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createComment'])) {
    createComment();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteComment'])) {
    deleteComment();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editComment'])) {
    editComment();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getComment'])) {
    $comment_id = validateInput('comment_id');
    $_SESSION['comment_id'] = $comment_id;
}

?>
<main id="main" class="main">
    <?php
    if (isset($_SESSION['msg'])) {
        echo '<div id="alert" class="alert alert-success w-50 mx-auto" role="alert">';
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        echo '</div>';
    }
    ?>

    <div class="card">

        <div class="card-body text-end pb-2 me-2">
            <a class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#commentModal">Add Comment</a>
        </div>
        <div class="card-body">
            <?php
            $comments = getComment($_GET['task_id']);
            if (!$comments) {
                returnResponse('Error when getting comment');
            }
            ?>

            <table id="myTable" class="table table-bordered hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Comment</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$comments) {

                        echo "<tr>";
                        echo "<td colspan='4' class='text-center'>No comments available for this task.</td>";
                        echo "</tr>";
                    } else {
                        foreach ($comments as $comment) {
                            echo "<tr>";
                            echo "<td>" . $comment['name'] . "</td>";
                            echo "<td>" . $comment['comment'] . "</td>";
                            echo "<td>" . $comment['created_at'] . "</td>";
                            echo "<td>";
                            $disableButton = $comment['user_id'] == $_SESSION['user']['id'];
                            echo "<form action='' method='POST' style='display: inline;'>";
                            echo "<input type='hidden' name='comment_id' value='" . $comment['id'] . "'>";
                            echo "<button type='submit' class='me-3 btn btn-primary' name='getComment' " . ($disableButton ? "" : "disabled") . ">
                            <a data-bs-toggle='modal' data-bs-target='#editComment' >Edit</a> </button>";
                            echo "</form>";

                            // action='" . $_SERVER["PHP_SELF"] . "'
                            echo "<form action='' method='POST' style='display: inline;'>";
                            echo "<input type='hidden' name='comment_id' value='" . $comment['id'] . "'>";
                            echo "<button type='submit' class='me-3 btn btn-danger' name='deleteComment' " . ($disableButton ? "" : "disabled") . ">Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- Create Commment -->
    <div class="modal modal-lg" id="commentModal" tabindex="-1" aria-labelledby="commentModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="commentModal">Add Comment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Statred -->
                    <form action="" method="POST">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id']; ?>">
                        <input type="hidden" name="task_id" value="<?= $_GET['task_id'] ?>">
                        <div class="row mb-3">
                            <label for="comment" class="col-md-4 col-lg-3 col-form-label">Comment</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="comment" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="createComment">Save</button>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Comment -->
    <div class="modal fade" id="editComment" tabindex="-1" aria-labelledby="editComment" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php
                $result = getCommentByID($_SESSION['comment_id']);
                print_r($result);
                ?>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editComment">Edit Comment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Statred -->
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="row mb-3">
                            <input name="comment_id" type="hidden" class="form-control" id="comment_id" value="<?= $result['id'] ?>" required>

                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Comment</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="comment" type="text" class="form-control" value="<?= $result['comment'] ?>" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="editComment">Save</button>
                        </div>
                    </form>
                    <!-- Form End -->

                </div>
            </div>
        </div>
    </div>
</main>