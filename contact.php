<?php
// Anti-spam honeypot
if (!empty($_POST['website'])) {
    http_response_code(403);
    exit;
}

// Validation
$nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
$sujet_in = htmlspecialchars(trim($_POST['sujet'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

if (!$nom || !$email || !$message) {
    http_response_code(400);
    echo 'Champs obligatoires manquants.';
    exit;
}

// Configuration
$destinataire = 'contact@steshaia.fr';
$sujet = 'Nouveau message depuis le site - ' . $nom;

// Corps du mail
$corps = "Nom : $nom\n";
$corps .= "Email : $email\n";
if ($telephone) $corps .= "Telephone : $telephone\n";
if ($sujet_in) $corps .= "Objet : $sujet_in\n";
$corps .= "\nMessage :\n$message\n";

// En-tetes
$headers = "From: noreply@steshaia.fr\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Envoi
$sent = mail($destinataire, $sujet, $corps, $headers);

if ($sent) {
    header('Location: /#contact');
    exit;
} else {
    http_response_code(500);
    echo 'Erreur lors de l\'envoi. Veuillez reessayer.';
}
?>
