<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

// Define valid users
$valid_users = [
    'admin' => [
        'password' => 'parola1',
        'role' => 'admin'
    ],
    'user' => [
        'password' => 'parola2',
        'role' => 'user'
    ]
];

// Initialize error message
$error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (isset($valid_users[$username]) && $password === $valid_users[$username]['password']) {
        // Successful login
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $valid_users[$username]['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        // Failed login
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        /* Reset simplu */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../images/login.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .login-box {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            width: 350px;
            max-width: 90%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, #667eea 0%, transparent 70%);
            opacity: 0.15;
            pointer-events: none;
            transform: rotate(45deg);
        }

        h2 {
            margin-bottom: 30px;
            font-weight: 700;
            color: #4a4a4a;
            letter-spacing: 1.2px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            user-select: none;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            outline-offset: 2px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.6);
        }

        button {
            width: 100%;
            padding: 14px 0;
            background: #667eea;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s ease;
            letter-spacing: 1px;
            box-shadow: 0 8px 15px rgba(102, 126, 234, 0.3);
        }

        button:hover {
            background: #5a67d8;
            box-shadow: 0 12px 20px rgba(90, 103, 216, 0.5);
        }

        .error {
            background: #ffe6e6;
            color: #cc0000;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(204, 0, 0, 0.2);
            user-select: none;
        }

        @media (max-width: 400px) {
            .login-box {
                padding: 30px 20px;
                width: 90%;
            }
            button {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Sign In</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" novalidate>
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" required autocomplete="username" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" />
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>