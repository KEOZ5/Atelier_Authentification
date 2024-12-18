<?php
// Liste des utilisateurs et mots de passe
$users = [
    'admin' => 'secret',
    'user' => '1234',
];

// Gérer la déconnexion
if (isset($_GET['logout'])) {
    // Envoyer un header pour forcer la déconnexion
    header('WWW-Authenticate: Basic realm="Zone Protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Vous avez été déconnecté. <a href="index.php">Retour à l\'authentification</a>';
    exit;
}

// Vérifier si l'utilisateur a envoyé des identifiants
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    // Envoyer un header HTTP pour demander les informations
    header('WWW-Authenticate: Basic realm="Zone Protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Vous devez entrer un nom d\'utilisateur et un mot de passe pour accéder à cette page.';
    exit;
}

// Vérifier les identifiants envoyés
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

if (!isset($users[$username]) || $users[$username] !== $password) {
    // Si les identifiants sont incorrects
    header('WWW-Authenticate: Basic realm="Zone Protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Nom d\'utilisateur ou mot de passe incorrect.';
    exit;
}

// Si les identifiants sont corrects
$is_admin = $username === 'admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page protégée</title>
</head>
<body>
    <h1>Bienvenue sur la page protégée</h1>
    <p>Ceci est une page protégée par une authentification simple via le header HTTP.</p>
    <p>C'est le serveur qui vous demande un nom d'utilisateur et un mot de passe via le header WWW-Authenticate.</p>
    <p>Vous êtes connecté en tant que : <strong><?php echo htmlspecialchars($username); ?></strong></p>

    <?php if ($is_admin): ?>
        <h2>Contenu réservé à l'administrateur</h2>
        <p>En tant qu'administrateur, vous avez accès à des informations supplémentaires.</p>
        <ul>
            <li>Accès complet à la page.</li>
            <li>Capacité à modifier les configurations.</li>
            <li>Visualisation des logs du système.</li>
        </ul>
    <?php else: ?>
        <h2>Contenu utilisateur</h2>
        <p>En tant qu'utilisateur standard, vous avez un accès limité à cette page.</p>
        <p>Contactez l'administrateur pour obtenir plus d'accès.</p>
    <?php endif; ?>
    
    <!-- Lien pour se déconnecter -->
    <p><a href="?logout=true">Se déconnecter</a></p>
    
    <!-- Explications sur les headers -->
    <h2>Informations sur les headers utilisés</h2>
    <ul>
        <li><strong>WWW-Authenticate :</strong> Demande des informations d'authentification au client (nom d'utilisateur et mot de passe).</li>
        <li><strong>Authorization :</strong> Contient les informations d'authentification fournies par le client.</li>
        <li><strong>401 Unauthorized :</strong> Code de réponse HTTP indiquant un accès refusé en cas d'authentification échouée.</li>
    </ul>
    <p>Pour visualiser les headers envoyés et reçus, utilisez les outils de développement de votre navigateur (onglet Réseau).</p>
    
    <a href="../index.html">Retour à l'accueil</a>  
</body>
</html>
