<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Unauthorized</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            max-width: 480px;
            width: 90%;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-dashboard {
            background: #27ae60;
            color: white;
        }

        .btn-dashboard:hover {
            background: #219150;
            transform: scale(1.05);
        }

        .btn-login {
            background: #2980b9;
            color: white;
        }

        .btn-login:hover {
            background: #2471a3;
            transform: scale(1.05);
        }

        .timer {
            margin-top: 25px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #f1c40f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Unauthorized</h1>
        <p>
            You do not have access or are not registered from the application.<br>
            Please return to the application portal dashboard.
        </p>

        <div class="buttons">
            <button class="btn btn-dashboard" onclick="window.location.href='{{ $portalUrl }}/dashboard'">Go to
                Portal Dashboard</button>
            <button class="btn btn-login" onclick="window.location.href='{{ $portalUrl }}/dashboard/login'">Portal
                Login</button>
        </div>

        <div class="timer">
            Redirecting to portal dashboard in <span id="countdown">5</span> second(s)...
        </div>
    </div>

    <script>
        let seconds = 5;
        const countdownEl = document.getElementById("countdown");

        const interval = setInterval(() => {
            seconds--;
            countdownEl.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = "{{ $portalUrl }}/dashboard";
            }
        }, 1000);
    </script>
</body>

</html>