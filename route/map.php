<?php
switch ($route) {
    case '/':
        return 'index/config/index';
        break;
    case '/oferta':
        return 'offer/config/index';
        break;
    case '/oferta/katalog/typ':
        return 'offer/config/list';
        break;
    case '/oferta/katalog/roslina':
        return 'offer/config/single';
        break;
   
   case '/kontakt':     
        return 'contact/config/contact';
        break; /**/
   case '/kontakt/formularz-wyslij-wiadomosc': 
   return 'contact/config/send';
        break;
       /*   return 'contact/config/contact';
        break;
  case '/ajax/kontakt/wyslij':
        return 'contact/config/send-ajax';
        break;*/
    case '/galeria':
        return 'gallery/config/list';
        break;
    case '/polityka-cookie':
        return 'index/config/cookie';
        break;
    case '/formsan':
        return 'formsan/config/main';
        break;
    case '/formsantemplate':
        return 'formsan/config/template';
        break;
    case '/formsanajax':
        return 'formsan/config/ajax';
        break;
    default:
        return 'common/config/error404';
        break;
}