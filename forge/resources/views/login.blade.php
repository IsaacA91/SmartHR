<?php
// Ima add notes on all the main parts for how they work incase yall wanna reference them

require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // this check if the form was submitted using post if it waz it will proceed to thangle the login logic
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // makes sure no special charcaters are here so no no no injection
    $query = "SELECT * FROM employee WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    // this runs a sql query to find matching user
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['employeeID'] = $user['employeeID'];
        $_SESSION['firstName'] = $user['firstName'];
        $_SESSION['lastName'] = $user['lastName'];
        header('Location: attendance.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }  // if the user you imputed matches with one in the database it will fetch all the info for the, and also stores the key in $_SESSION
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #d85e21ff 0%, #cc3009ff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h3 class="text-center mb-4">SmartHR Login</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <hr>
        <p class="text-center text-muted">Test Account: asmith / pass123</p>
    </div>
</body>
</html>