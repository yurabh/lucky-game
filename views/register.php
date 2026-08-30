<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Реєстрація</title>
</head>

<body>
<h2>Реєстрація користувача</h2>
<?php if (isset($_GET['error']) && $_GET['error'] === 'expired'): ?>
    <p>Ваше унікальне посилання недійсне або термін його дії (7 днів) закінчився.</p>
<?php endif; ?>

<form action="/register" method="POST">
    <label>Username: <input type="text" name="username" required></label><br><br>
    <label>Phonenumber: <input type="text" name="phone" required></label><br><br>
    <button type="submit">Register</button>
</form>

</body>
</html>