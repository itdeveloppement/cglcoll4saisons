<?php
// Adresse email du destinataire
$to = "marti.castellano@gmail.com";

// Sujet de l'email
$subject = "Bienvenue chez nous";

// Contenu de l'email en HTML
$message = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email de Bienvenue</title>
</head>
<body>
    <h1 style="color: #4CAF50;">Bienvenue à notre service !</h1>
    <p>Bonjour,</p>
    <p>Nous sommes heureux de vous compter parmi nous.</p>
    
    <a href="https://fourmitest2.cigaleaventure.com/custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864&date=2024-09-16%2004:46:22" target="_blank" style="padding: 10px 15px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Remplissez notre formulaire</a>

    <p>Merci,<br>L\'équipe de support</p>
</body>
</html>
';

// Entêtes pour spécifier que le contenu est en HTML
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Entête de l'expéditeur
$headers .= 'From: support@tonsite.com' . "\r\n";

// Envoi de l'email
if(mail($to, $subject, $message, $headers)) {
    echo 'Email envoyé avec succès';
} else {
    echo 'Erreur lors de l\'envoi de l\'email';
}
?>