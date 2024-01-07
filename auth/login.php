
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Your existing CSS styles */
        :root {
            --primary: #FEA116;
            --light: #F1F8FF;
            --dark: #0F172B;
        }

        .fw-medium {
            font-weight: 500 !important;
        }

        .fw-semi-bold {
            font-weight: 600 !important;
        }

        .back-to-top {
            /* ... (your existing styles) */
        }

        .room-box {
            /* ... (your existing styles) */
        }

        /* Additional styles for the login page */
        body {
            background-color: var(--light);
        }

        .login-container {
            margin-top: 100px;
        }

        .login-box {
            max-width: 400px;
            margin: auto;
            background: #FFFFFF;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-box h2 {
            text-align: center;
            color: var(--dark);
        }

        .login-box .form-group {
            margin-bottom: 20px;
        }

        .login-box .form-control {
            border-radius: 2px;
        }

        .login-box .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .login-box .btn-primary:hover {
            background-color: var(--dark);
            border-color: var(--dark);
        }
    </style>
    <title>Login | NYUMBANI</title>
</head>
<body>

<div class="container login-container">
    <div class="row">
        <div class="col-md-6 offset-md-3 login-box">
        <h1 class="mb-5">Nyumbani <span class="text-primary text-uppercase">LODGE</span></h1>        
            <form action='../backend/backend_login.php' method='POST'>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter your username" name='username' required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" name='password' required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
