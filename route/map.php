<?php
class Route_Map {

    public static function get($route) {
      
switch ($route) {
    case '/':
        return new Module_Index_Config_Index();
        break;
    case '/oferta':
        return new Module_Offer_Config_Index();
        break;
    case '/oferta/katalog/typ':
        return new Module_Offer_Config_List();
        break;
    case '/oferta/katalog/roslina':
        return new Module_Offer_Config_Single();
        break;
   
   case '/kontakt':     
        return new Module_Contact_Config_Contact();
        break; /**/
   case '/kontakt/formularz-wyslij-wiadomosc': 
   case '/kontakt/formularz': 
   return new Module_Contact_Config_Send();
        break;
       /*   return 'contact/config/contact';
        break;
  case '/ajax/kontakt/wyslij':
        return 'contact/config/send-ajax';
        break;*/
    case '/galeria':
        //return 'Gallery/Config/List';
        return new Module_Gallery_Config_List();
        break;
    case '/polityka-cookie':
    case '/polityka':
        return new Module_Index_Config_Cookie();
        break;
    case '/formsan':
        return new Module_Formsan_Config_Main();
        break;
    case '/formsantemplate':
        return new Module_Formsan_Config_Template();
        break;
    case '/formsanajax':
        return new Module_Formsan_Config_Ajax();
        break;
     case '/formsan/pdf':
        return new Module_Formsan_Config_Pdf();
        break;
    default:
        return new Module_Common_Config_Error404();
        break;
        }
    }

}