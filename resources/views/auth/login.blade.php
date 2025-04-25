<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0fdf4;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #349868;
            margin-bottom: 25px;
            font-size: 28px;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 18px;
            font-weight: bold;
            color: #333;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-top: 8px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
            box-sizing: border-box;
        }
        .checkbox-group {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .forgot-password {
            font-size: 14px;
        }
        .forgot-password button {
            background: none;
            border: none;
            color: #349868;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            padding: 0;
        }
        .forgot-password button:hover {
            text-decoration: underline;
        }
        button[type="submit"] {
            margin-top: 30px;
            width: 100%;
            padding: 14px;
            background: #349868;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button[type="submit"]:hover {
            background: #277c5e;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .link {
            margin-top: 25px;
            font-size: 14px;
        }
        .link a {
            color: #349868;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Prisijungti</h1>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">El. paštas</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

        <label for="password">Slaptažodis</label>
        <input id="password" type="password" name="password" required>

        <div class="checkbox-group">
            <div class="checkbox">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin: 0;">Prisiminti mane</label>
            </div>
            <div class="forgot-password">
                <button type="button">Pamiršai slaptažodį?</button>
            </div>
        </div>

        <button type="submit">Prisijungti</button>
    </form>

    <div class="link">
        <a href="{{ route('register') }}">Neturite paskyros? Registruotis</a>
    </div>
</div>
</body>
</html>
