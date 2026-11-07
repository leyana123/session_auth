<?php
include "db.php";

// check if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$message = "";

if (isset($_POST['submit_login'])) {

    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    // check required fields
    if ($login === "" || $password === "") {

        $message = "All fields are required!";

    } else {

        // find username or email
        $stmt = $conn->prepare(
            "SELECT id, username, pass_hash
             FROM users
             WHERE username = ? OR email = ?
             LIMIT 1"
        );

        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            // verify pw
            if (password_verify($password, $user['pass_hash'])) {

                // generate new Session ID
                session_regenerate_id(true);

                // store user information
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // redirect to Dashboard
                header("Location: dashboard.php");
                exit();

            } else {

                $message = "Incorrect password!";

            }

        } else {

            $message = "Account not found!";

        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow mx-auto" style="max-width: 400px;">

        <div class="card-body p-4">

            <h3 class="text-center">Welcome!</h3>

            <p class="text-center text-muted">
                Sign in to your account
            </p>

            <!-- Error Message -->
            <?php if ($message != ""): ?>

                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>

            <!-- LOGIN FORM -->
            <form method="POST" action="">

                <div class="mb-3">

                    <label class="form-label">
                        Username or Email
                    </label>

                    <input
                        type="text"
                        name="login"
                        class="form-control"
                        placeholder="Enter username or email"
                        value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter password"
                        required
                    >

                </div>

                <!-- IMPORTANT: submit_login na ang name -->
                <button
                    type="submit"
                    name="submit_login"
                    class="btn btn-primary w-100">

                    Login

                </button>

            </form>

            <p class="text-center mt-3">

                Don't have an account?

                <a href="register.php">Register here</a>

            </p>

        </div>

    </div>

</div>

</body>
</html>