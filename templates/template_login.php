<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "" ?></title>
</head>

<body>
    <main class="container">
    <div>
        <h1>Se connecter</h1>
        <form action="" method="post">
            <input type="email" name="email" id="" placeholder="saisir votre email">
            <input type="password" name="password" id="" placeholder="saisir votre mot de passe">
            <input type="submit" value="Ajouter" name="submit">
        </form>
        <p><?= $data["message"] ?? "" ?></p>
    </div>
</main>
</body>

</html>