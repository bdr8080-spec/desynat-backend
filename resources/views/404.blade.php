<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            background-color: #f4f4f9;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            padding: 60px 20px;
        }

        .error-container {
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            font-size: 100px;
            margin: 0;
            color: #ff4c4c;
        }

        h2 {
            font-size: 28px;
            margin: 20px 0;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        a {
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }

        .illustration {
            margin: 30px 0;
        }

        .illustration img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1>404</h1>
        <h2>Oops! Page not found</h2>
        <p>Sorry, the page you’re looking for doesn’t exist or has been moved.</p>
        <div class="illustration">
            <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Not Found">
        </div>
        <a href="{{ url('/') }}">Go Back Home</a>
    </div>
</body>

</html>
