<?php
use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController {

    private $twig;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader('./app/templates');
        $this->twig = new \Twig\Environment($loader);
    }
    
    public function sendEmail($destinatarios, $assunto, $nomeRemetente, $emailResposta){

        try {
    
            $recipients = [];
    
            foreach ($destinatarios as $dest) {
                $recipients[] = new Recipient($dest["email"], $dest["nome"]);
            }
    
            $emailParams = (new EmailParams())
                ->setFrom('lucasberriel@trial-7dnvo4drxwng5r86.mlsender.net')
                ->setFromName($nomeRemetente)
                ->setRecipients($recipients)
                ->setSubject($assunto)
                ->setHtml($conteudo)
                ->setReplyTo($emailResposta)
                ->setReplyToName($nomeRemetente);
    
            $this->mailer->email->send($emailParams);
            return true;
        } catch (\Throwable $err) {
            return false;
        }
    }
    
    public function sendEmailNewUser($destNome, $destEmail, $emailResposta, $urlNewPassword){

        $mail = new PHPMailer(true);

        try {
            // SMTP
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();
            $mail->Host       = $_ENV["HOST_SMTP"];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV["USER_NAME_SMTP"];
            $mail->Password   = $_ENV["PASS_SMTP"]; // Senha temporária, apenas para correção do trabalho
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('lucas.if.usuario@gmail.com', 'Equipe Ozzy');
            $mail->addAddress($destEmail, $destNome);
            $mail->addReplyTo($emailResposta, 'Equipe Ozzy');

            $conteudo = $this->twig->render('EmailNewAcess.html', ["nome" => $destNome, "url" => $urlNewPassword]);
            $mail->isHTML(true);
            $mail->Subject = 'ACESSO CRIADO NA PLATAFORMA OZZY 🐶💚';
            $mail->Body    = $conteudo;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo "Falha ao enviar o e-mail. Erro: {$mail->ErrorInfo}";
            return false;
        }

    }

    public function sendEmailNewClient($destNome, $destEmail, $emailResposta, $urlNewPassword) {
        $mail = new PHPMailer(true);

        try {
            // SMTP
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();
            $mail->Host       = $_ENV["HOST_SMTP"];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV["USER_NAME_SMTP"];
            $mail->Password   = $_ENV["PASS_SMTP"]; // Senha temporária, apenas para correção do trabalho
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('lucas.if.usuario@gmail.com', 'Equipe Ozzy');
            $mail->addAddress($destEmail, $destNome);
            $mail->addReplyTo($emailResposta, 'Equipe Ozzy');

            $conteudo = $this->twig->render('EmailNewAcess.html', ["nome" => $destNome, "url" => $urlNewPassword]);
            $mail->isHTML(true);
            $mail->Subject = 'BEM-VINDO(A) À PLATAFORMA OZZY 🐶💚';
            $mail->Body    = $conteudo;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo "Falha ao enviar o e-mail. Erro: {$mail->ErrorInfo}";
            return false;
        }
    }

    public function sendEmailNewPass($destNome, $destEmail, $emailResposta, $urlNewPassword) {
        $mail = new PHPMailer(true);

        try {
            // SMTP
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();
            $mail->Host       = $_ENV["HOST_SMTP"];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV["USER_NAME_SMTP"];
            $mail->Password   = $_ENV["PASS_SMTP"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('lucas.if.usuario@gmail.com', 'Equipe Ozzy');
            $mail->addAddress($destEmail, $destNome);
            $mail->addReplyTo($emailResposta, 'Equipe Ozzy');

            $conteudo = $this->twig->render('EmailNewPass.html', ["nome" => $destNome, "url" => $urlNewPassword]);
            $mail->isHTML(true);
            $mail->Subject = '[OZZY] SOLICITAÇÃO TROCA DE SENHA 🔐🐶';
            $mail->Body    = $conteudo;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo "Falha ao enviar o e-mail. Erro: {$mail->ErrorInfo}";
            return false;
        }
    }
    
}

?>