<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
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
            max-width: 500px;
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
        h2 {
            margin-top: 35px;
            color: #555;
            font-size: 22px;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 18px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
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
        button {
            margin-top: 35px;
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
        button:hover {
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
    <h1>Registracija</h1>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">Vardas</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required>

        <label for="email">El. paštas</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>

        <label for="password">Slaptažodis</label>
        <input id="password" type="password" name="password" required>

        <label for="password_confirmation">Patvirtinkite slaptažodį</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <h2>Įmonės informacija</h2>

        <label for="company_name">Įmonės pavadinimas</label>
        <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" required>

        <label for="company_code">Įmonės kodas</label>
        <input id="company_code" type="text" name="company_code" value="{{ old('company_code') }}" required>

        <label for="industry">Veiklos sritis</label>
        <input id="industry" type="text" name="industry" value="{{ old('industry') }}" required>

        <label for="country">Šalis</label>
        <input id="country" type="text" name="country" value="{{ old('country') }}" required>

        <label for="size">Įmonės dydis</label>
        <input id="size" type="text" name="size" value="{{ old('size') }}" required>

        <button type="submit">Registruotis</button>
    </form>

    <div class="link">
        <a href="{{ route('login') }}">Jau turite paskyrą? Prisijunkite</a>
    </div>
</div>
</body>
</html>
