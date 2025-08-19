<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    protected string $email;
    protected string $name;
    protected string $token;
    
    public function __construct(string $email, string $name, string $token) {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    protected function sendMail(string $subject, string $htmlBody, string $altBody): void {
        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('accounts@devwebcamp.com');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = $subject;

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $mail->AltBody = $altBody;
        $mail->Body = $htmlBody;
        $mail->send();
    }

    public function sendConfirmation(): void {
        $html = "<html><body style='font-family: sans-serif; color: #333;'>";
        $html .= "<p>Hola <strong>{$this->name}</strong>, has registrado correctamente tu cuenta en DevWebCamp. Confírmala en el siguiente enlace:</p>";
        $html .= "<p><a href='{$_ENV['HOST']}/confirm-account?token={$this->token}' style='background-color: #007df4; color: #FFFFFF; padding: 10px 15px; text-decoration: none;'>Confirmar Cuenta</a></p>";
        $html .= "<p>Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p></body></html>";

        $alt = "Hola {$this->name}, confirma tu cuenta en DevWebCamp: {$_ENV['HOST']}/confirm?token={$this->token}";
        $this->sendMail("Confirma tu Cuenta", $html, $alt);
    }

    public function sendInstructions(): void {
        $html = "<html><body style='font-family: sans-serif; color: #333;'>";
        $html .= "<p>Hola <strong>{$this->name}</strong>, parece que has olvidado tu password, sigue el siguiente enlace para recuperarlo:</p>";
        $html .= "<p><a href='{$_ENV['HOST']}/restore?token={$this->token}' style='background-color: #007df4; color: #FFFFFF; padding: 10px 15px; text-decoration: none;'>Restablecer Password</a></p>";
        $html .= "<p>Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p></body></html>";

        $alt = "Hola {$this->name}, restablece tu password en DevWebCamp: {$_ENV['HOST']}/restore?token={$this->token}";
        $this->sendMail("Restablece tu Password", $html, $alt);
    }
}