<?php

//use Zend\Loader\StandardAutoloader;
use Zend\Mail\Message  as Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions as SmtpOptions;

class Contact_Module_Send extends Module_Abstract {

    function execute() {

        $sender = $this->request->post('nadawca', 'strict');
        $email = $this->request->post('email', 'strict');
        $text = $this->request->post('wiadomosc', 'strict');

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
                
              /* ( new Zend\Loader\StandardAutoloader(array(
                    'fallback_autoloader' => true,
                )))->register();*/
                
                //spl_autoload_register(array('Zend\Loader\StandardAutoloader','autoload'));
//echo 33;
                
                
//spl_autoload_register('Zend\Loader\StandardAutoloader::autoload'); 

                $message = new Message();
                //echo 44;
                $message->addTo($this->in['to'])
                        ->addFrom($this->in['from'])
                        ->setSubject($topic)
                        ->setBody($text);
                $transport = new SmtpTransport();
               // echo 55;
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
               // echo 66;
                $transport->setOptions($options);
                $transport->send($message);
//echo 77;
                /*  require_once '/Zend/Loader/StandardAutoloader.php';
                  $autoloader = new Zend\Loader\StandardAutoloader(array(
                  'fallback_autoloader' => true,
                  ));
                  $autoloader->register();
                  var_dump($autoloader);




                  $message = new Message();
                  $message->addTo('rena.sonko@interia.pl')
                  ->addFrom('serwer1413186@szkolka-cedrus.pl')
                  ->setSubject('Greetings and Salutations!')
                  ->setBody("Sorry, I'm going to be late today!");

                  // Setup SMTP transport using LOGIN authentication y^YBdH75I6;p
                  $transport = new SmtpTransport();
                  $options   = new SmtpOptions(array(
                  'name'              => 'E-Mail',
                  'host'              => 'serwer1413186.home.pl',
                  'port' => 25,
                  'connection_class'  => 'login',
                  'connection_config' => array(
                  'username' => 'serwer1413186',
                  'password' => 'sylwia93cedr',
                  ),
                  ));
                  $transport->setOptions($options);
                  $res = $transport->send($message); */
                //print_r($transport);
                $this->out['result'] = 1;
            } catch (Exception $e) {
                $this->out['result'] = -1;
                $this->out['details'] = $e->getMessage();

                echo $e->getMessage();
            }
        } else {
            echo 'wiadomsoc nie wyslana';
        }

//spl_autoload_unregister(array('Zend_Loader_Autoloader','autoload'));

spl_autoload_register('__autoload');

        /* require_once '/Zend/Loader/StandardAutoloader.php';
          $autoloader = new Zend\Loader\StandardAutoloader(array(
          'fallback_autoloader' => true,
          ));
          $autoloader->register(); */



        //@todo  ajax
        $this->template = 'contact/view/sender.phtml';
        parent::execute();
    }

}
