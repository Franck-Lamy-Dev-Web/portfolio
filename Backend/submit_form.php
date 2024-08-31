<?php


// Autoriser les requêtes provenant de toutes les origines (ou spécifiez un domaine spécifique à la place de *)
header("Access-Control-Allow-Origin: *");

// Optionnel : si vous prévoyez d'envoyer des en-têtes spécifiques ou d'autoriser des méthodes spécifiques
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

header('Content-Type: application/json'); // Définit le type de contenu comme JSON
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage des données entrées
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation des champs vides
    if (empty($nom) || empty($prenom) || empty($email) || empty($message)) {
        die("Tous les champs sont requis.");
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse email invalide.");
    }

    try {
        // Créer une instance de PHPMailer pour l'e-mail au destinataire
        $mail = new PHPMailer(true);

        // Paramètres SMTP pour Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'francklamymagie@gmail.com'; // Votre adresse e-mail Gmail
        $mail->Password = 'ooevuwksdvycwmuh';   // Votre mot de passe Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Activer le chiffrement TLS
        $mail->Port = 587; // Le port SMTP de Gmail

        // Destinataire et contenu de l'e-mail
        $mail->setFrom('francklamymagie@gmail.com', 'Franck');
        $mail->addAddress('lamy.franck@hotmail.fr', 'Destinataire');
        $mail->Subject = 'Nouvelle demande de renseignements';
        $mail->CharSet = 'UTF-8'; // Définir l'encodage UTF-8
        $mail->isHTML(true);
        $mail->Body = "
            <html>
            <head>
                <title>Nouvelle demande de renseignements</title>
            </head>
            <body>
                <h2>Nouvelle demande de renseignements</h2>
                <p><strong>Nom :</strong> {$nom}</p>
                <p><strong>Prénom :</strong> {$prenom}</p>
                <p><strong>Email :</strong> {$email}</p>
                <p><strong>Message :</strong> {$message}</p>
            </body>
            </html>
        ";

        // Envoyer l'e-mail
        $mail->send();

        // Créer une nouvelle instance de PHPMailer pour l'e-mail de confirmation à l'utilisateur
        $confirmationMail = new PHPMailer(true);
        
        // Utiliser les mêmes paramètres SMTP
        $confirmationMail->isSMTP();
        $confirmationMail->Host = 'smtp.gmail.com';
        $confirmationMail->SMTPAuth = true;
        $confirmationMail->Username = 'francklamymagie@gmail.com';
        $confirmationMail->Password = 'ooevuwksdvycwmuh';
        $confirmationMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $confirmationMail->Port = 587;

        // Destinataire et contenu de l'e-mail de confirmation
        $confirmationMail->setFrom('francklamymagie@gmail.com', 'Franck Lamy');
        $confirmationMail->addAddress($email, "{$prenom} {$nom}");
        $confirmationMail->Subject = 'Confirmation de votre demande de renseignements';
        $confirmationMail->CharSet = 'UTF-8';
        $confirmationMail->isHTML(true);
        $confirmationMail->Body = "
            <html>
            <head>
                <title>Confirmation de votre demande</title>
            </head>
            <body>
                <h2>Confirmation de votre demande</h2>
                <p>Bonjour {$prenom} {$nom},</p>
                <p>Merci de nous avoir contactés. Nous avons bien reçu votre demande de renseignements.</p>
                <p>Nous reviendrons vers vous dans les plus brefs délais avec les informations demandées.</p>
                <p>Voici un récapitulatif de votre demande :</p>
                <p><strong>Nom :</strong> {$nom}</p>
                <p><strong>Prénom :</strong> {$prenom}</p>
                <p><strong>Email :</strong> {$email}</p>
                <p><strong>Message :</strong> {$message}</p>
                <p>Cordialement,</p>
                <p>Franck</p>
            </body>
            </html>
        ";

        // Envoyer l'e-mail de confirmation
        $confirmationMail->send();

        echo json_encode(['message' => 'Emails envoyés avec succès']);
        // header("Location: index.html?status=success");
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de l\'envoi de l\'email : ' . $mail->ErrorInfo]);
        // header("Location: index.html?status=error");
    }
}
?>
