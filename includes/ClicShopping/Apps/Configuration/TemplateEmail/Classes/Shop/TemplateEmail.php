<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\Apps\Configuration\TemplateEmail\Classes\Shop;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTTP;
  use ClicShopping\OM\Is;

  class TemplateEmail
  {
    /**
     * the name of the template
     *
     * @param int $template_email_id
     * @param int $language_id
     * @return string $template_email_name['template_name'],  name.of the template email
     *
     */
    public static function getTemplateEmailName(int $template_email_id, int $language_id) :string
    {
      $CLICSHOPPING_Db = Registry::get('Db');

      $QtemplateEmail = $CLICSHOPPING_Db->prepare('select template_email_name
                                                  from :table_template_email_description
                                                  where template_email_id = :template_email_id
                                                  and language_id = :language_id
                                                 ');
      $QtemplateEmail->bindInt(':template_email_id', (int)$template_email_id);
      $QtemplateEmail->bindInt(':language_id', (int)$language_id);
      $QtemplateEmail->execute();

      $template_email_name = $QtemplateEmail->fetch();

      return $template_email_name['template_email_name'];
    }


    /**
     * the template email short description
     *
     * @param int $template_email_id
     * @param int $language_id
     * @return string $template_email['template_short_description'],  the short description of the template email
     *
     */
    public static function getTemplateEmailShortDescription(int $template_email_id, int $language_id) :string
    {
      $CLICSHOPPING_Db = Registry::get('Db');

      $QtemplateEmailShortDescription = $CLICSHOPPING_Db->prepare('select template_email_short_description
                                                                  from :table_template_email_description
                                                                  where template_email_id = :template_email_id
                                                                  and language_id = :language_id
                                                                 ');
      $QtemplateEmailShortDescription->bindInt(':template_email_id', $template_email_id);
      $QtemplateEmailShortDescription->bindInt(':language_id', $language_id);
      $QtemplateEmailShortDescription->execute();

      $template_email_short_description = $QtemplateEmailShortDescription->fetch();

      return $template_email_short_description['template_email_short_description'];
    }

    /**
     * the template email description who is sent
     *
     * @param int $template_email_id
     * @param int $language_id
     * @return string $template_email['template_email_description'],  the description of the template email who is sent
     *
     */
    public static function getTemplateEmailDescription(int $template_email_id, int $language_id) :string
    {

      $CLICSHOPPING_Db = Registry::get('Db');

      $QtemplateEmailDescription = $CLICSHOPPING_Db->prepare('select template_email_description
                                                              from :table_template_email_description
                                                              where template_email_id = :template_email_id
                                                              and language_id = :language_id
                                                             ');
      $QtemplateEmailDescription->bindInt(':template_email_id', $template_email_id);
      $QtemplateEmailDescription->bindInt(':language_id', $language_id);
      $QtemplateEmailDescription->execute();

      $template_email_description = $QtemplateEmailDescription->fetch();

      return $template_email_description['template_email_description'];
    }

    /**
     * the footer of email
     *
     * @return string $template_email_footer,  the footer of the email template who is sent
     *
     */
    public static function getTemplateEmailTextFooter() :string
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');

      $QtextTemplateEmailFooter = $CLICSHOPPING_Db->prepare('select te.template_email_variable,
                                                              ted.template_email_description
                                                       from :table_template_email te,
                                                            :table_template_email_description  ted
                                                       where te.template_email_variable = :template_email_variable
                                                       and te.template_email_id = ted.template_email_id
                                                       and ted.language_id = :language_id
                                                      ');

      $QtextTemplateEmailFooter->bindValue(':template_email_variable', 'TEMPLATE_EMAIL_TEXT_FOOTER');
      $QtextTemplateEmailFooter->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
      $QtextTemplateEmailFooter->execute();

      $template_email_footer = $QtextTemplateEmailFooter->value('template_email_description');

      $keywords = ['/{{store_name}}/',
        '/{{store_owner_email_address}}/',
        '/{{http_shop}}/'
      ];

      $replaces = [
        STORE_NAME,
        STORE_OWNER_EMAIL_ADDRESS,
        HTTP::getShopUrlDomain()
      ];


      $template_email_footer = preg_replace($keywords, $replaces, $template_email_footer);

      return $template_email_footer;
    }


    /**
     * the signature of email
     *
     * @return string $template_email_signature,  the signature of the email template who is sent
     *
     */
    public static function getTemplateEmailSignature() :string
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');

      $QtextTemplateEmailSignature = $CLICSHOPPING_Db->prepare('select te.template_email_variable,
                                                              ted.template_email_description
                                                       from :table_template_email te,
                                                            :table_template_email_description  ted
                                                       where te.template_email_variable = :template_email_variable
                                                       and te.template_email_id = ted.template_email_id
                                                       and ted.language_id = :language_id
                                                      ');

      $QtextTemplateEmailSignature->bindValue(':template_email_variable', 'TEMPLATE_EMAIL_SIGNATURE');
      $QtextTemplateEmailSignature->bindInt(':language_id', $CLICSHOPPING_Language->getId());
      $QtextTemplateEmailSignature->execute();

      $template_email_signature = $QtextTemplateEmailSignature->value('template_email_description');

      $keywords = ['/{{store_name}}/',
        '/{{store_owner_email_address}}/',
        '/{{http_shop}}/'
      ];

      $replaces = [
        STORE_NAME,
        STORE_OWNER_EMAIL_ADDRESS,
        HTTP::getShopUrlDomain()
      ];

      $template_email_signature = preg_replace($keywords, $replaces, $template_email_signature);

      return $template_email_signature;
    }


    /**
     * the template email welcome catalog who is sent
     *
     * @return string $template_email_welcome_admin,  the description of the template email welcome admin who is sent
     *
     */
    public static function getTemplateEmailWelcomeCatalog()
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');

      $QtextTemplateEmailWelcomeCatalog = $CLICSHOPPING_Db->prepare('select te.template_email_variable,
                                                                        ted.template_email_description
                                                                 from :table_template_email te,
                                                                      :table_template_email_description  ted
                                                                 where te.template_email_variable = :template_email_variable
                                                                 and te.template_email_id = ted.template_email_id
                                                                 and ted.language_id = :language_id
                                                                ');

      $QtextTemplateEmailWelcomeCatalog->bindValue(':template_email_variable', 'TEMPLATE_EMAIL_WELCOME');
      $QtextTemplateEmailWelcomeCatalog->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
      $QtextTemplateEmailWelcomeCatalog->execute();

      $template_email_welcome_catalog = $QtextTemplateEmailWelcomeCatalog->value('template_email_description');

      $keywords = ['/{{store_name}}/',
        '/{{store_owner_email_address}}/',
        '/{{http_shop}}/'
      ];

      $replaces = [
        STORE_NAME,
        STORE_OWNER_EMAIL_ADDRESS,
        HTTP::getShopUrlDomain()
      ];

      $template_email_welcome_catalog = preg_replace($keywords, $replaces, $template_email_welcome_catalog);

      return $template_email_welcome_catalog;
    }


    /**
     * the template email coupon who is sent
     *
     * @return string $template_email_coupon_admin,  the description of the template email coupon who is sent
     *
     */
    public static function getTemplateEmailCouponCatalog() :string
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');

      $QtextTemplateEmailCouponCatalog = $CLICSHOPPING_Db->prepare('select te.template_email_variable,
                                                                          ted.template_email_description
                                                                   from :table_template_email te,
                                                                        :table_template_email_description  ted
                                                                   where te.template_email_variable = :template_email_variable
                                                                   and te.template_email_id = ted.template_email_id
                                                                   and ted.language_id = :language_id
                                                                  ');

      $QtextTemplateEmailCouponCatalog->bindValue(':template_email_variable', 'TEMPLATE_EMAIL_TEXT_COUPON');
      $QtextTemplateEmailCouponCatalog->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
      $QtextTemplateEmailCouponCatalog->execute();

      $template_email_coupon_catalog = $QtextTemplateEmailCouponCatalog->value('template_email_description');

      $keywords = ['/{{store_name}}/',
        '/{{store_owner_email_address}}/',
        '/{{http_shop}}/'
      ];

      $replaces = [
        STORE_NAME,
        STORE_OWNER_EMAIL_ADDRESS,
        HTTP::getShopUrlDomain()
      ];

      $template_email_coupon_catalog = preg_replace($keywords, $replaces, $template_email_coupon_catalog);

      return $template_email_coupon_catalog;
    }

    /**
     * the template order intro command who is sent
     *
     * @return string $template_email_intro_command,  the description of the template email order intro command who is sent
     *
     */
    public static function getTemplateEmailIntroCommand() :string
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');

      $QtextTemplateEmailIntroCommand = $CLICSHOPPING_Db->prepare('select te.template_email_variable,
                                                                          ted.template_email_description
                                                                   from :table_template_email te,
                                                                        :table_template_email_description  ted
                                                                   where te.template_email_variable = :template_email_variable
                                                                   and te.template_email_id = ted.template_email_id
                                                                   and ted.language_id = :language_id
                                                                  ');

      $QtextTemplateEmailIntroCommand->bindValue(':template_email_variable', 'TEMPLATE_EMAIL_INTRO_COMMAND');
      $QtextTemplateEmailIntroCommand->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
      $QtextTemplateEmailIntroCommand->execute();

      $template_email_intro_command = $QtextTemplateEmailIntroCommand->value('template_email_description');

      $keywords = ['/{{store_name}}/',
        '/{{store_owner_email_address}}/',
        '/{{http_shop}}/'
      ];

      $replaces = [
        STORE_NAME,
        STORE_OWNER_EMAIL_ADDRESS,
        HTTP::getShopUrlDomain()
      ];

      $template_email_intro_command = preg_replace($keywords, $replaces, $template_email_intro_command);

      return $template_email_intro_command;
    }

    /**
     * Extract email to send more
     * @param string $contactString
     * @return array
     */
    public static function getExtractEmailAddress(string $contactString): array
    {
      if (!preg_match_all('/<(?<emails>[^>]+)>/', $contactString, $matches)) {
        return [];
      }

      return array_filter(array_map(static function (string $email): ?string {
        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        return filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL) ? $sanitizedEmail : null;
      }, $matches['emails']));
    }
  }