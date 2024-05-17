<?php
require './db_connection.php';
?>
<?php
if (isset($_POST['createUser'])) {
    insertData(rand(12, 45) . 'hussein', uniqid() . '@gmail.com', rand(12, 45) . 'husein54', 'users');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class=" col-md-8">
                <button class="btn btn-outline-danger">Users</button>

                <div class="alert alert-secondary mt-3" role="alert">
                    <?php
                    $result = getUsers();
                    if (isset($result['output']) && $result['output'] === '0 results') {
                        echo 'data empty';
                    } else {
                        $result; // Assuming $result contains the output data
                    }

                    ?>
                </div>

            </div>
            <div class="col-md-4">
                <form method="post">
                    <button class=" btn btn-outline-danger" type="submit" name="createUser">CreateUser </button>

                </form>


            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="./assets/js/main.js"></script>
</body>

</html>