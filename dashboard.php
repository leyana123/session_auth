<?php

include "db.php";

// check if user is logged in
if (!isset($_SESSION['user_id'])) {

    header("Location: index.php");
    exit();

}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body {
            background-color: #f8f9fa;
        }

        .hero {
            background: white;
            padding: 40px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .info-card {
            min-height: 160px;
        }

    </style>

</head>

<body>

<!-- navs -->

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand fw-bold" href="dashboard.php">
            SessionAuthSystem
        </a>

        <div class="text-white">

            <?php echo htmlspecialchars($_SESSION['username']); ?>

            <a href="logout.php" class="btn btn-danger btn-sm ms-2">
                Logout
            </a>

        </div>

    </div>

</nav>


<div class="container mt-5">

    <div class="hero shadow-sm mb-4">

        <h1 class="text-primary fw-bold">

            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!

        </h1>

        <p class="text-muted">

            This page is protected and only visible to logged-in users.

        </p>

        <button type="button" class="btn btn-primary">

            Explore Dashboard

        </button>

    </div>

    <div class="row g-3">


        <div class="col-md-4">

            <div class="card shadow-sm info-card">

                <div class="card-body">

                    <h5 class="text-success">
                        Account Status
                    </h5>

                    <p>
                        Your session is active and protected against Session
                    </p>

                    <small class="text-muted">

                        Fixation using session_regenerate_id(true).

                    </small>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm info-card">

                <div class="card-body">

                    <h5 class="text-primary">
                        User Details
                    </h5>

                    <p>

                        User ID:

                        <?php echo $_SESSION['user_id']; ?>

                    </p>

                    <p>

                        Username:

                        <?php echo htmlspecialchars($_SESSION['username']); ?>

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm info-card">

                <div class="card-body">

                    <h5 class="text-warning">
                        Active Session ID
                    </h5>

                    <p style="word-break: break-all;">

                    <p>
                        Current Session ID:

                        <?php echo session_id(); ?>

                    </p>

                    <small class="text-muted">

                        Generated after login call to session_regenerate_id(true).

                    </small>

                </div>

            </div>

        </div>

    </div>


    <p class="text-muted mt-4">

        You can log out and log back in to see session regeneration in action.

    </p>

</div>

</body>
</html>