<?php
include "db.php";

$message = "";
$success = false;

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {

        $message = "All fields are required!";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Invalid email address!";

    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE username = ? OR email = ?"
        );

        $check->bind_param("ss", $username, $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "Username or Email already exists!";

        } else {

            // bycrypt pw
            $pass_hash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare(
                "INSERT INTO users (username, email, pass_hash)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param("sss", $username, $email, $pass_hash);

            if ($stmt->execute()) {

                $success = true;

                $message = "Registration successful! Proceed to log in.";

            } else {

                $message = "Registration failed!";

            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow mx-auto" style="max-width: 400px;">

        <div class="card-body p-4">

            <h3 class="text-center">Create Account</h3>

            <p class="text-center text-muted">
                Sign up to get started
            </p>

            <!-- SUCCESS OR ERROR MESSAGE -->
            <?php if ($message != ""): ?>

                <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>">

                    <?php echo htmlspecialchars($message); ?>

                </div>

            <?php endif; ?>


            <?php if (!$success): ?>

                <!-- REGISTRATION FORM -->

                <form method="POST" action="">

                    <div class="mb-3">

                        <label class="form-label">Username</label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Enter username"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">Email Address</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="name@example.com"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Create a password"
                            minlength="8"
                            required
                        >

                    </div>


                    <button type="submit" name="register"
                        class="btn btn-success w-100">

                        Register

                    </button>

                </form>

            <?php else: ?>

                <!-- LOGIN LINK AFTER SUCCESSFUL REGISTRATION -->

                <a href="index.php" class="btn btn-primary w-100">

                    Proceed to Log in

                </a>

            <?php endif; ?>


            <p class="text-center mt-3">

                Already have an account?

                <a href="index.php">Login here</a>

            </p>

        </div>

    </div>

</div>

</body>
</html>