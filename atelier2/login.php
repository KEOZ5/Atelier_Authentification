<?php
// Vérifier si l'utilisateur est déjà authentifié (cookie existant et valide)
if (isset($_COOKIE['authToken']) && (time() - $_COOKIE['authToken'] < 60)) {
    // Si le cookie est valide (moins de 1 minute), afficher un message
    echo "Bienvenue, votre session est toujours valide.";
} else {
    // Si le cookie est absent ou a expiré, afficher un message de connexion
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Ici, vous pouvez ajouter une validation d'identifiants
        // Pour l'exercice, on suppose que l'utilisateur est authentifié
        $token = bin2hex(random_bytes(16)); // Génération d'un token aléatoire
        setcookie('authToken', $token, time() + 60, '/'); // Créer un cookie valable 1 minute

        echo "Vous êtes maintenant connecté. Votre cookie a été créé.";
    } else {
        // Formulaire de connexion
        echo '<form method="POST">
                <button type="submit">Se connecter</button>
              </form>';
    }
}
?>
