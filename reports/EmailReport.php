<?php

class MailerReport
{
    public function reportSuporteTI($data)
    {
        ob_start();
    ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Suporte TI</title>
        </head>
        <body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 20px 0;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="400" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 1px solid #dddddd;">
                            <tr>
                                <td bgcolor="#0056b3" style="padding: 20px; text-align: center;">
                                    <h3 style="color: #ffffff; margin: 0; font-size: 18px; letter-spacing: 1px;">Preventiva T.I</h3>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 30px; text-align: center;">
                                    <p style="font-size: 16px; color: #333333; margin-bottom: 10px;">Olá! Vamos alterar a senha?</p>
                                    <p style="font-size: 14px; color: #666666; margin-bottom: 25px;">Clique no botão abaixo para realizar o procedimento de forma segura.</p>
                                    
                                    <!-- <a href="http://portal.hap.org.br/Preventiva%20-%20HAP/view/login?url=suporte&tipo=alterarsenha&email=<?= $data['email'] ?>"  -->
                                    <a href="http://localhost/preventiva/view/login?url=suporte&tipo=esqueci_minha_senha&email=<?= $data['email'] ?>" style="background-color: #28a745; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; font-size: 14px;">
                                        <p>Alterar Minha Senha</p>
                                    </a>
                                    <p style="font-size: 12px; color: #999999; margin-top: 25px;">Caso não tenha sido você, ignore este e-mail.</p>
                                </td>
                            </tr>                            
                            <tr>
                                <td style="padding: 20px; text-align: center; border-top: 1px solid #eeeeee; background-color: #fafafa;">
                                    <p style="font-size: 13px; color: #555555; margin: 0 0 10px 0;">Att, <strong>Equipe Suporte T.I</strong></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
    <?php
        return ob_get_clean(); 
    }

    public function reportUsuarioAssinar()
    {
        ob_start();
    ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Assinar</title>
        </head>
        <body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 20px 0;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="400" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 1px solid #dddddd;">
                            <tr>
                                <td bgcolor="#0056b3" style="padding: 20px; text-align: center;">
                                    <h3 style="color: #ffffff; margin: 0; font-size: 18px; letter-spacing: 1px;">Preventiva T.I</h3>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 30px; text-align: center;">
                                    <p style="font-size: 16px; color: #333333; margin-bottom: 10px;">Olá! Vamos assinar a preventiva?</p>
                                    <p style="font-size: 14px; color: #666666; margin-bottom: 25px;">Clique no botão abaixo para realizar o procedimento de acesso.</p>
                                    
                                    <!-- <a href="http://portal.hap.org.br/Preventiva%20-%20HAP/view/login"  -->
                                    <a href="http://localhost/preventiva/view/login" style="background-color: #28a745; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; font-size: 14px;">
                                        <p>Acessar Preventiva T.I</p>
                                    </a>
                                    <p style="font-size: 12px; color: #999999; margin-top: 25px;">Contamos com a sua participação!</p>
                                </td>
                            </tr>                            
                            <tr>
                                <td style="padding: 20px; text-align: center; border-top: 1px solid #eeeeee; background-color: #fafafa;">
                                    <p style="font-size: 13px; color: #555555; margin: 0 0 10px 0;">Att, <strong>Equipe Suporte T.I</strong></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
    <?php
        return ob_get_clean(); 
    }
}