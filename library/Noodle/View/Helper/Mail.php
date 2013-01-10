<?php

/**
 * Wrapper dla standardowego zend'owego wysyłania maili 
 */
class Noodle_View_Helper_Mail extends Zend_View_Helper_Abstract {
    
    /**
     * Wyślij maila o temacie $title do odbiorców ($receivers) 
     *  wzór treści wiadomości to $html_templ renderowany z parametrami $html_params 
     * @param String $title Tytuł wiadomości jako obiekt String
     * @param Array $receivers Odbiorcy wiadomości jako tablica ciągów znaków
     * @param String $html_templ Nazwa Widoku do renderowania.
     * @param Map $html_params Mapa wykorzystywana do tworzenia widoku 
     * NP.
     * Zespolowa_View_Helper_Mail::sendHtml(
                    "Temat", 
                    array("adres1@poczta.pl", "adres2@poczta.pl"),
                    "example.phtml",
                    array("arg1"=>"Tekst1", "arg2"=>"Tekst2") );
            );
     */
    public static function sendHtml($title, $receivers, $html_templ, $html_params){
        try{    
            //konfiguracje serwera 
            $env = getenv('APPLICATION_ENV');
            if($env==null || strlen($env)==0){
                $env = 'development';
            }
            $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', $env);
            //$config->doctrine->sql_path;
            $config = array(
            		'ssl' => 'tls',
                    'port'      => $config->mail->port,
                    'auth'      => $config->mail->auth,
                    'username'  => $config->mail->username,
                    'password'  => $config->mail->password);
            //tworzymy instancje serwera (w sensie programistycznym)
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
        
            //jako treść maila wykorzystamy widok znajdujący się w folderze emails
            $html = new Zend_View();
            $html->setScriptPath(APPLICATION_PATH . '/views/emails/');
            //widok będziemy musieli uzupełnić o parametry
            foreach ($html_params as $key => $value) {
                $html->assign($key, $value);
            }
            //ustaw kodowanie znaków
            $mail = new Zend_Mail('utf-8');
            //rederujemy widok 
            $bodyText = $html->render($html_templ);
            //ustaw do kogo wysłać
            foreach ($receivers as $value) {
                $mail->addTo($value);
            }
            //przypisujemy wartości innym parametrom
            $mail->setSubject($title);
            $mail->setFrom('noodlekus@gmail.com', 'Noodle');
            $mail->setBodyHtml($bodyText);
            //ślemy gdzie trzeba
            $mail->send($transport);
        }
        catch(Exception $e){
            //wystąpił wyjątek
            var_dump($e);
        }
    }
    /**
     * Wysyła wiadomość email o temacie $title do odbiorców $receivers,
     *  jego treść to $text
     * @param String $title Tytuł wiadomości jako obiekt String
     * @param Array $receivers Odbiorcy wiadomości jako tablica ciągów znaków
     * @param String $text Tekst wiadomości
     * NP.
     * Zespolowa_View_Helper_Mail::sendText(
                    "Temat", 
                    array("adres1@poczta.pl", "adres2@poczta.pl"),
                    "Witam.." );
     */
    public static function sendText($title,array $receivers, $text){
        try{    
            //konfiguracje serwera 
            $env = getenv('APPLICATION_ENV');
            if($env==null || strlen($env)==0){
                $env = 'development';
            }
            $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', $env);
            $config = array(
                    'port'      => $config->mail->port,
            		//'ssl' => 'tls',
                    'auth'      => $config->mail->auth,
                    'username'  => $config->mail->username,
                    'password'  => $config->mail->password);
            //tworzymy instancje serwera (w sensie programistycznym)
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

            //ustaw kodowanie znaków
            $mail = new Zend_Mail('utf-8');
            //ustaw do kogo wysłać
            foreach ($receivers as $value) {
                $mail->addTo($value);
            }
            //przypisujemy wartości innym parametrom
            $mail->setSubject($title);
            $mail->setFrom('noodlekus@gmail.com', 'Noodle');
            $mail->setBodyText($text);
            //ślemy gdzie trzeba
            $mail->send($transport);
        }
        catch(Exception $e){
            //wystąpił wyjątek
            var_dump($e);
        }
    }
}
