<?php

error_reporting(255);
ini_set('display_errors', '1');

use Zend\Mail\Message as Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions as SmtpOptions;

class Contact_Module_Send extends Module_Abstract {

    function execute() {

        $sender = $this->request->post('surname', 'strict');
        $email = $this->request->post('mail', 'strict');
        $text = $this->request->post('message', 'strict');

        $topic = 'Wiadmość wysłana z witryny: sadzonka.eu przez formularz kontaktowy';

        $text .= $sender;
        $text .= $email;

        if (!empty($email) && !empty($topic) && !empty($text)) {

            try {


                require_once '/Zend/Loader/StandardAutoloader.php';
                $autoloader = new Zend\Loader\StandardAutoloader(array(
                    'fallback_autoloader' => true,
                ));
                $autoloader->register();

                $message = new Message();
                $message->addTo($this->in['to'])
                        ->addFrom($this->in['from'])
                        ->setSubject($topic)
                        ->setBody($text);
                $transport = new SmtpTransport();
                $options = new SmtpOptions(array(
                    'name' => 'E-Mail',
                    'host' => $this->in['host'],
                    'port' => $this->in['port'],
                    'connection_class' => 'login',
                    'connection_config' => array(
                        'username' => $this->in['username'],
                        'password' => $this->in['password'],
                    ),
                ));
                $transport->setOptions($options);
                $transport->send($message);

                $this->out['result'] = 1;
            } catch (Exception $e) {
                $this->out['result'] = -1;
                $this->out['details'] = $e->getMessage();

                echo $e->getMessage();
            }
        }

        spl_autoload_register('__autoload');


        //@todo  ajax
        $this->template = 'Contact/View/Main.phtml';
        parent::execute();
    }

}
