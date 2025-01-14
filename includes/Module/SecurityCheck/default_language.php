<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;

  class securityCheck_default_language
  {
    public string $type = 'danger';

    public function __construct()
    {
      $CLICSHOPPING_Language = Registry::get('Language');

      $CLICSHOPPING_Language->loadDefinitions('modules/SecurityCheck/default_language', null, null, 'Shop');
    }

    public function pass()
    {
      return \defined('DEFAULT_LANGUAGE');
    }

    public function getMessage()
    {
      return CLICSHOPPING::getDef('error_no_default_language_defined');
    }
  }