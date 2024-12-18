<?php
// Démarre la session
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Redirection selon le rôle
    if ($_SESSION['role'] === 'admin') {
        header('Location: page_admin.php');
    } elseif ($_SESSION['role'] === 'user') {
        header('Location: page_user.php');
    }
    exit();
}

// Gérer le formulaire de connexion
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification simple des identifiants
    if ($username === 'admin' && $password === 'secret') {
        // Stocker les informations utilisateur dans la session
        session_regenerate_id(true); // Sécurisation de session
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin';

        // Redirection Admin
        header('Location: page_admin.php');
        exit();
    } elseif ($username === 'user' && $password === 'utilisateur') {
        // Stocker les informations utilisateur dans la session
        session_regenerate_id(true); // Sécurisation de session
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';

        // Redirection Utilisateur
        header('Location: page_user.php');
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Atelier authentification par Session</h1>
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Se connecter</button>
    </form>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <br>
    <a href="../index.html">Retour à l'accueil</a>
</body>
</html>
