<?php

/**
 * 
 * 
 * example of use:
 * 
 * Model_Mailer::getInstance()
 *  ->send(array('tworzenieweb@gmail.com' => 'Łukasz Adamczewski'), 'Test', 'Test');
 * 
 */

class Model_Mailer extends Model {
    
    private static $instance;
    private $transport;
    private $mailer;

    private function __construct()
    {
        $username = Kohana::config('globals.sendgrid_username');
        $password = Kohana::config('globals.sendgrid_password');
        $host = Kohana::config('globals.sendgrid_host');
        $port = Kohana::config('globals.sendgrid_port');
        
        $this->transport = Swift_SmtpTransport::newInstance($host, $port)
                ->setUsername($username)
                ->setPassword($password);
        
    }
    
    /**
     * Return singleton instance
     * @return Model_Mailer
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    /**
     * Send email using swift mailer
     * @param array $to Recipients like array('john.smith@gmail.com' => 'John Smith');
     * @param string $subject
     * @param string $body
     * @return The return value is the number of recipients who were accepted for
   * delivery.
     */
    public function send($to, $subject, $body, $attachment, $from = null) {
        
        
        $from = $from ? $from : Kohana::config('globals.from_email');
        

        $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($body, 'text/html');
                
                
        if($attachment) {
            $a = Swift_Attachment::newInstance(current($attachment), key($attachment), "application/pdf");
            $message->attach($a);
        }
        
        
        $mailer = new Swift_Mailer($this->transport);
        return $mailer->send($message);
        
        
    }
    
    
}

?>
