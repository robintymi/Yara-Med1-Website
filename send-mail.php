<?php
// Yara-Med1 Kontaktformular - E-Mail Versand
// Empfänger
$to = 'r.erike@yara-med1.de';

// Nur POST-Requests erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

// Honeypot Spam-Schutz (Bot füllt verstecktes Feld aus)
if (!empty($_POST['website'])) {
    header('Location: danke.html');
    exit;
}

// Eingaben lesen und bereinigen
$name    = isset($_POST['name'])    ? trim(strip_tags($_POST['name']))    : '';
$phone   = isset($_POST['phone'])   ? trim(strip_tags($_POST['phone']))   : '';
$email   = isset($_POST['email'])   ? trim(strip_tags($_POST['email']))   : '';
$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

// Pflichtfelder prüfen
if ($name === '' || $phone === '' || $message === '') {
    header('Location: index.html?fehler=pflichtfelder#kontakt');
    exit;
}

// E-Mail-Adresse validieren (falls angegeben)
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.html?fehler=email#kontakt');
    exit;
}

// E-Mail zusammenbauen
$subject = 'Kontaktanfrage von ' . $name . ' – yara-med1.de';

$body  = "Neue Kontaktanfrage über die Website:\n";
$body .= "=========================================\n\n";
$body .= "Name:     $name\n";
$body .= "Telefon:  $phone\n";
$body .= "E-Mail:   " . ($email !== '' ? $email : 'nicht angegeben') . "\n\n";
$body .= "Nachricht:\n";
$body .= "-----------------------------------------\n";
$body .= "$message\n";
$body .= "-----------------------------------------\n\n";
$body .= "Gesendet am: " . date('d.m.Y \u\m H:i \U\h\r') . "\n";

// Header
$headers  = "From: noreply@yara-med1.de\r\n";
if ($email !== '') {
    $headers .= "Reply-To: $email\r\n";
}
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: Yara-Med1 Kontaktformular\r\n";

// Senden
$success = mail($to, $subject, $body, $headers);

if ($success) {
    header('Location: danke.html');
} else {
    header('Location: index.html?fehler=senden#kontakt');
}
exit;
