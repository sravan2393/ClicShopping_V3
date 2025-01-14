<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\Apps\Tools\Upgrade\Sites\ClicShoppingAdmin\Pages\Home;

  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\Tools\Upgrade\Upgrade;

  class Home extends \ClicShopping\OM\PagesAbstract
  {
    public mixed $app;

    protected function init()
    {
      $CLICSHOPPING_Upgrade = new Upgrade();
      Registry::set('Upgrade', $CLICSHOPPING_Upgrade);

      $this->app = Registry::get('Upgrade');

      $this->app->loadDefinitions('Sites/ClicShoppingAdmin/main');
    }
  }
