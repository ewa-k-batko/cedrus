<?php
//error_reporting(255);
//ini_set('display_errors', '1');

spl_autoload_register('__autoload');

use Zend\Mail\Message as Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions as SmtpOptions;

use Zend\Validator\EmailAddress as EmailAddressValidator;


/**
 *   https://code.google.com/apis/console   => klucz api do map
 */

class Contact_Module_Main extends Module_Abstract {

    function execute() {

        //csrf zawsze jest
        $token = $this->request->post('token', 'strict');

        if (strlen($token) > 10) {

            //contener na bledy
            $this->out['errors'] = array();

            try {
                $this->out['form']['surname'] = $this->request->post('surname', 'strict');
                $this->out['form']['mail'] = $this->request->post('mail', 'strict');
                $this->out['form']['message'] = $this->request->post('message', 'strict');

                //minimalna ikosc znaokow
                if (strlen($this->out['form']['surname']) < 3) {
                    $this->out['errors']['surname'] = 1;
                }
                if (strlen($this->out['form']['mail']) < 5) {
                    $this->out['errors']['mail'] = 1;
                }
                if (strlen($this->out['form']['message']) < 10) {
                    $this->out['errors']['message'] = 1;
                }

                //przerwij spr. jak powyzsze brak
                if (count($this->out['errors']) > 0) {
                    throw new Exception();
                }

                //start spr. poprawny email
                $valid = new EmailAddressValidator(array('allow' => Zend\Validator\Hostname::ALLOW_DNS | Zend\Validator\Hostname::ALLOW_LOCAL,
                    'useMxCheck' => true));
                if (!$valid->isValid($this->out['form']['mail'])) {
                    $this->out['errors']['mail'] = 1;
                    if (Manager_Config::isDev()) {
                        $this->out['details'] = null;
                        foreach ($valid->getMessages() as $message) {
                           $this->out['details'] .= $message. "\n";
                        }
                    }
                }

                //start spr. captcha i token-csrf
                $captchaId = $this->request->post('captcha-id', 'strict');
                $captchaInput = $this->request->post('captcha-input', 'strict');

                if (!Model_Form_Captcha::isValid($captchaId, $captchaInput)) {
                    $this->out['errors']['captcha'] = 1;
                }

                if (!Model_Form_Csrf::getInstance()->isValid($token)) {
                    $this->out['errors']['token'] = 1;
                }

                //przerwij wysylke jak bledy
                if (count($this->out['errors']) > 0) {
                    throw new Exception();
                }

                //buduj wiadomosc
                $topic = 'Wiadmość wysłana z witryny: sadzonka.eu przez formularz kontaktowy';
                $this->out['form']['message'] .= $this->out['form']['surname'];
                $this->out['form']['message'] .= $this->out['form']['mail'];

                require_once '/Zend/Loader/StandardAutoloader.php';
                $autoloader = new Zend\Loader\StandardAutoloader(array(
                    'fallback_autoloader' => true,
                ));
                $autoloader->register();

                $message = new Message();
                $message->addTo($this->in['to'])
                        ->addFrom($this->in['from'])
                        ->setSubject($topic)
                        ->setBody($this->out['form']['message']);
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

                //wysylka udana
                $this->out['result'] = 1;
            } catch (Exception $e) {
                
                //wysylka nieudana wystapil wyjatek
                $this->out['result'] = -1;
                $this->out['details'] = Manager_Config::isDev() ? $e->getMessage() : 'Nie wysłano wiadomości, wystąpił błąd.';

                
                //tworz nowa captcha + csrf dla ponownie wyswietlonego formularza
                $this->out['captcha'] = Model_Form_Captcha::getInstance()->get();
                $this->out['csrf'] = Model_Form_Csrf::getInstance()->get();
            }
        } else {

            //formularz nie byl wypeniany jeszcze  => tworz  captcha + csrf
            $this->out['captcha'] = Model_Form_Captcha::getInstance()->get();
            $this->out['csrf'] = Model_Form_Csrf::getInstance()->get();
        }

        //@todo  ajax
        $this->template = 'contact/view/main.phtml';
        parent::execute();
    }

}
