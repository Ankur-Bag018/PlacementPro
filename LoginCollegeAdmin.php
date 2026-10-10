
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PlacementPro</title>
    <link href="LoginCollegeAdmin.css" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
        body {
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            background-color: #fbfdff;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* The Login Card Container */
        .login-card {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-top: 6px solid #4880e1; /* PlacementPro Blue */
            padding: 40px 30px;
            box-sizing: border-box;
        }

        /* Branding and Titles */
        .brand {
            text-align: center;
            color: #4880e1;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .title {
            text-align: center;
            color: #2c3e50;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 25px 0;
        }

        /* Form Layout */
        .form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Input Fields */
        .input {
            padding: 14px 15px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 15px;
            color: #2d3748;
            background-color: #f8fafc;
            transition: all 0.3s ease;
        }

        .input::placeholder {
            color: #a0aec0;
        }

        .input:focus {
            outline: none;
            border-color: #4880e1;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(72, 128, 225, 0.2);
        }

        /* Forgot Password Link */
        .page-link {
            text-align: right;
            margin: -5px 0 5px 0;
        }

        .page-link-label {
            font-size: 13px;
            color: #4880e1;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .page-link-label:hover {
            color: #3566b8;
            text-decoration: underline;
        }

        /* Login Button */
        .form-btn {
            background-color: #4880e1;
            color: white;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        .form-btn:hover {
            background-color: #3566b8;
        }

        .form-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>
    <!-- Login Card -->
    <div class="login-card">
        <div class="form-container">
            <div class="brand">PlacementPro</div>
            <p class="title">Login to your account</p>


            <?php if (!empty($message)): ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>


            <form class="form" action="DB_LoginCollegeAdmin.php" method="POST">
                <input type="text" name="e_id" class="input" placeholder="Employee ID" required>

                <input type="password" name="e_password" class="input" placeholder="Password" required>

                <p class="page-link">

                    <a href="#" class="page-link-label">Forgot Password?</a>
                </p>

                <button type="submit" name="login_btn" class="form-btn">Log in</button>
            </form>
        </div>
    </div>
</body>

</html>