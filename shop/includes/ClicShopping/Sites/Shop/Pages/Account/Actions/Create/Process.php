<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  namespace ClicShopping\Sites\Shop\Pages\Account\Actions\Create;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\HTTP;
  use ClicShopping\OM\DateTime;
  use ClicShopping\OM\Is;
  use ClicShopping\OM\Hash;

  use ClicShopping\Apps\Tools\ActionsRecorder\Classes\Shop\ActionRecorder;

  use ClicShopping\Apps\Configuration\TemplateEmail\Classes\Shop\TemplateEmail;

  class Process extends \ClicShopping\OM\PagesActionsAbstract  {

    public function execute()  {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Customer = Registry::get('Customer');
      $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
      $CLICSHOPPING_ShoppingCart = Registry::get('ShoppingCart');
      $CLICSHOPPING_Mail = Registry::get('Mail');
      $CLICSHOPPING_Language = Registry::get('Language');
      $CLICSHOPPING_Hooks = Registry::get('Hooks');

      if (isset($_POST['action']) && ($_POST['action'] == 'process') && isset($_POST['formid']) && ($_POST['formid'] == $_SESSION['sessiontoken'])) {

// error checking when updating or adding an entry
        $error = false;

        $CLICSHOPPING_Hooks->call('Create','PreAction');

        $firstname = HTML::sanitize($_POST['firstname']);
        $lastname = HTML::sanitize($_POST['lastname']);

        if (ACCOUNT_DOB == 'true') $dob = HTML::sanitize($_POST['dob']);

        $email_address = HTML::sanitize($_POST['email_address']);
        $email_address_confirm = HTML::sanitize($_POST['email_address_confirm']);

        if (isset($_POST['newsletter'])) {
          $newsletter = HTML::sanitize($_POST['newsletter']);
        } else {
          $newsletter = 0;
        }

        $password = HTML::sanitize($_POST['password']);
        $confirmation = HTML::sanitize($_POST['confirmation']);

        $customer_agree_privacy = HTML::sanitize($_POST['customer_agree_privacy']);

        if (DISPLAY_PRIVACY_CONDITIONS == 'true') {
          if ($customer_agree_privacy != 'on') {
            $error = true;
            $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_agreement_check_error'), 'error', 'create_account');
          }
        }

// Clients B2C : Controle entree du prenom
        if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
          $error = true;
          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_first_name_error', ['min_length' => ENTRY_FIRST_NAME_MIN_LENGTH]), 'error', 'create_account');
        }

// Clients B2C : Controle entree du nom de famille
        if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_last_name_error', ['min_length' => ENTRY_LAST_NAME_MIN_LENGTH]), 'error', 'create_account');
        }

// Clients B2C : Controle entree date de naissance
        if (ACCOUNT_DOB == 'true') {

          $dobDateTime = new DateTime($dob);

          if ((strlen($dob) < ENTRY_DOB_MIN_LENGTH) || ($dobDateTime->isValid() === false)) {
            $error = true;

            $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_date_of_birth_error'), 'error', 'create_account');
          }
        }

// Clients B2C : Controle entree adresse e-mail
        if (Is::email($email_address) === false) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_email_address_check_error', ['min_length' => ENTRY_EMAIL_ADDRESS_MIN_LENGTH]), 'error', 'create_account');

        } elseif ($email_address != $email_address_confirm) {
          $error = true;
          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_email_address_confirm_not_matching'), 'danger', 'create_account');

        } else {

          $Qcheckemail = $CLICSHOPPING_Db->prepare('select customers_id
                                                    from :table_customers
                                                    where customers_email_address = :customers_email_address
                                                   ');
          $Qcheckemail->bindValue(':customers_email_address', $email_address);

          $Qcheckemail->execute();

          if ($Qcheckemail->fetch() !== false) {
            $error = true;

            $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_email_address_error_exists'), 'error', 'create_account');
          }
        }

// Clients B2C : Controle  du mot de passe
        if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_password_error', ['min_length' => ENTRY_PASSWORD_MIN_LENGTH]), 'error', 'create_account');

        } elseif ($password != $confirmation) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_password_error_not_matching'), 'error', 'create_account');
        }

        Registry::set('ActionRecorder', new ActionRecorder('ar_create_account', ($CLICSHOPPING_Customer->isLoggedOn() ? $CLICSHOPPING_Customer->getID() : null), $lastname));
        $CLICSHOPPING_ActionRecorder = Registry::get('ActionRecorder');

        if (!$CLICSHOPPING_ActionRecorder->canPerform()) {
          $error = true;
          $CLICSHOPPING_ActionRecorder->record(false);

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('error_action_recorder', ['module_action_recorder_create_account_email_minutes' => (defined('MODULE_ACTION_RECORDER_CREATE_ACCOUNT_EMAIL_MINUTES') ? (int)MODULE_ACTION_RECORDER_CREATE_ACCOUNT_EMAIL_MINUTES : 15)]), 'danger', 'create_account');
        }

        if ( $error === false ) {
          $sql_data_array = ['customers_firstname' => $firstname,
                             'customers_lastname' => $lastname,
                             'customers_email_address' => $email_address,
                             'customers_newsletter' => (int)$newsletter,
                             'languages_id' => (int)$CLICSHOPPING_Language->getId(),
                             'customers_password' => Hash::encrypt($password),
                             'member_level' => 1,
                             'client_computer_ip' => HTTP::getIPAddress(),
                             'provider_name_client' => HTTP::getProviderNameCustomer()
                            ];

          if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = $dobDateTime->getRaw(false);

          $CLICSHOPPING_Db->save('customers', $sql_data_array);

          $customer_id = $CLICSHOPPING_Db->lastInsertId();
// save element in address book
          $sql_data_array = ['customers_id' => (int)$customer_id,
                              'entry_firstname' => $firstname,
                              'entry_lastname' => $lastname
                            ];

          $CLICSHOPPING_Db->save('address_book', $sql_data_array);

          $address_id = $CLICSHOPPING_Db->lastInsertId();

          $CLICSHOPPING_Db->save('customers', array('customers_default_address_id' => (int)$address_id),
                                              array('customers_id' => (int)$customer_id)
                                );

          $sql_array = ['customers_info_id' => (int)$customer_id,
                        'customers_info_number_of_logons' => 0,
                        'customers_info_date_account_created' => 'now()'
                        ];

          $CLICSHOPPING_Db->save('customers_info', $sql_array);


          $CLICSHOPPING_Customer->setData($customer_id);

          Registry::get('Session')->recreate();

// restore cart contents
          $CLICSHOPPING_ShoppingCart->getRestoreContents();

// build the message content
          $name = $firstname . ' ' . $lastname;

          $template_email_welcome_catalog = TemplateEmail::getTemplateEmailWelcomeCatalog();

          if (!empty(COUPON_CUSTOMER)) {
            $email_coupon_catalog = TemplateEmail::getTemplateEmailCouponCatalog();
            $email_coupon = $email_coupon_catalog . COUPON_CUSTOMER;
          }

// Content email
          $template_email_signature = TemplateEmail::getTemplateEmailSignature();
          $template_email_footer = TemplateEmail::getTemplateEmailTextFooter();
          $email_subject = CLICSHOPPING::getDef('email_subject', ['store_name' => STORE_NAME]);
          $email_gender = CLICSHOPPING::getDef('female') . ', '.  CLICSHOPPING::getDef('male') . ' '. $lastname;
          $email_text = $email_gender .',<br /><br />'. $template_email_welcome_catalog .'<br /><br />'. $email_coupon .'<br /><br />' .   $template_email_signature . '<br /><br />' . $template_email_footer;

// EEmail send
          $message = $email_text;
          $message = str_replace('src="/', 'src="' . HTTP::typeUrlDomain() . '/', $message);
          $CLICSHOPPING_Mail->addHtmlCkeditor($message);
          $CLICSHOPPING_Mail->build_message();
          $from = STORE_OWNER_EMAIL_ADDRESS;
          $CLICSHOPPING_Mail->send($name, $email_address, '', $from, $email_subject);

// Administrator email
          if (EMAIL_INFORMA_ACCOUNT_ADMIN == 'true') {
            $email_subject_admin = CLICSHOPPING::getDef('admin_email_subject', ['store_name' => STORE_NAME]);
            $admin_email_welcome = CLICSHOPPING::getDef('admin_email_welcome');

            $data_array = ['customer_name' => $lastname,
                           'customer_firstame' => $firstname,
                           'customer_mail' => $email_address
                          ];

            $admin_email_text_admin = CLICSHOPPING::getDef('admin_email_text', $data_array);

            $email_address = STORE_OWNER_EMAIL_ADDRESS;
            $from = STORE_OWNER_EMAIL_ADDRESS;
            $admin_email_text_admin .= $admin_email_welcome . $admin_email_text_admin;
            $CLICSHOPPING_Mail->addHtmlCkeditor($admin_email_text_admin);
            $CLICSHOPPING_Mail->build_message();
            $CLICSHOPPING_Mail->send(STORE_NAME, $email_address, '', $from, $email_subject_admin);
          }

          $CLICSHOPPING_ActionRecorder->record();

          $CLICSHOPPING_Hooks->call('Create','Process');

          CLICSHOPPING::redirect(null, 'Account&Main');
        }
      }
    }
  }