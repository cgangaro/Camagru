<?php

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendVerificationMail($username, $email, $verificationToken)
{
    $mail = initMail();
    $mail->Subject = "Camagru: Email Verification";
    $mail->Body = "Hi $username!\nClick on the following link to activate your account:\nhttp://" . $_SERVER['HTTP_HOST'] . "/Controller/verify.inc.php?token=$verificationToken";
    $mail->addAddress($email);
    if ($mail->Send()) {
        $mail->smtpClose();
        return true;
    } else {
        $mail->smtpClose();
        return false;
    }
}

function sendResetPasswordMail($email, $verificationToken)
{
    $mail = initMail();
    $mail->Subject = "Camagru: Reset Password";
    $mail->Body = "Hi!\nClick on the following link to reset your password:\nhttp://" . $_SERVER['HTTP_HOST'] . "/View/Reset/reset.php?token=$verificationToken";
    $mail->addAddress($email);
    if ($mail->Send()) {
        $mail->smtpClose();
        return true;
    } else {
        $mail->smtpClose();
        return false;
    }
}

function sendCommentNotifMail($email)
{
    if (empty($email)) {
        return false;
    }
    $mail = initMail();
    $mail->Subject = "Camagru: Comment Notification";
    $mail->Body = "Hi!\nYou have a new comment under your photo.";
    $mail->addAddress($email);
    if ($mail->Send()) {
        $mail->smtpClose();
        return true;
    } else {
        $mail->smtpClose();
        return false;
    }
}

function initMail()
{
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
    $mail->Username = $_ENV['PHP_MAIL_USER'];
    $mail->Password = $_ENV['PHP_MAIL_PASSWORD'];
    $mail->setFrom($_ENV['PHP_MAIL_USER']);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    return $mail;
}
