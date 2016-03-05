<?php

error_reporting(255);
ini_set('display_errors', '1');

//use Zend\Mail;//  as Mail;

//use Zend\Mail\Message;
//use Zend\Mail\Transport\Smtp;// as SmtpTransport;
//use Zend\Mail\Transport\SmtpOptions;

//use  Zend\Mail\Transport as SmtpTransport;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

//use Zend\Mail\Protocol\Smtp\Auth;
//use Zend\Mail\Protocol\Smtp\Auth;

class Contact_Module_Main extends Module_Abstract {

    function execute() {

        $id = $this->request->get('mail', 'i');

        //$mail = new Zend_Mail();
        if ($id > 0) {

            try {
                
                
                
                

                require_once '/Zend/Loader/StandardAutoloader.php';
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
$res = $transport->send($message);
               
      print_r($transport);         
            
               
               
        echo '----end--------------';       
               
               
             return;     
               
               
               exit;
                echo 888;

                 $mail = new \Zend\Mail\Message();

                  echo 666;
                  print_r($mail); //exit;
               /*   $mail->setBody('This is the text of the email.');
                  //$mail->setFrom('biuro@szkolka-cedrus.pl', 'Sender\'s name');
                  $mail->addTo('biuro@szkolka-cedrus.pl', 'Name of recipient');
                  $mail->setSubject('TestSubject');

                  $transport = new Zend\Mail\Transport\Sendmail('-freturn_to_biuro@szkolka-cedrus.pl');
                  $transport->send($mail); 

              $message = new Message();
                $message->addTo('ewa.k.batko@gmail.com')
                        ->addFrom('biuro@szkolka-cedrus.pl')
                        ->setSubject('Greetings and Salutations!')
                        ->setBody("Sorry, I'm going to be late today!");

// Setup SMTP transport using LOGIN authentication
                $transport = new SmtpTransport();
             $options = new SmtpOptions(array(
                    'name' => 'serwer1413186',
                 'port' => 25,
                  // 'port' => 465,
                 //  'ssl' => 'ssl',
                 'host' => 'serwer1413186.home.pl',
                    'connection_class' => 'login',
                    'connection_config' => array(
                        'username' => 'serwer1413186',
                        'password' => 'sylwia93cedr',//y^YBdH75I6;p
                        
                   ),
                ));
                $transport->setOptions($options);
                $transport->send($message);*/
                
                    $config = array('host' => 'serwer1413186.home.pl',
                        'auth' => 'login',
                    'username' => 'serwer1413186',
                    'password' => 'sylwia93cedr');
     echo 22;
    $transport = new SmtpTransport\Smtp( $config);
     var_dump($transport);exit;
    $mail = new Mail();
    $mail->setBodyText('This is the text of the mail.');
    $mail->setFrom('sender@test.com', 'Some Sender');
    //$mail->addTo('biuro@sadzonka.eu', 'Some Recipient');
    $mail->addTo('ewa.k.batko@gmail.com', 'Some Recipient');
    $mail->setSubject('TestSubject');
    
    var_dump($mail);
    $res = $mail->send($transport);
    
    var_dump($res);
                
                // The message
/*$message = "Line 1\r\nLine 2\r\nLine 3";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Send
mail('ewa.k.batko@gmail.com', 'My Subject', $message);*/
            } catch (Exception $e) {
                var_dump($e);
            }


            //exit;
        }



        $this->template = 'contact/view/main.phtml';
        parent::execute();
    }

}
