<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\Apps\Configuration\ProductsQuantityUnit\Sites\ClicShoppingAdmin\Pages\Home\Actions;

  use ClicShopping\OM\Registry;

  class Configure extends \ClicShopping\OM\PagesActionsAbstract
  {
    public function execute()
    {
      $CLICSHOPPING_ProductsQuantityUnit = Registry::get('ProductsQuantityUnit');

      $this->page->setFile('configure.php');
      $this->page->data['action'] = 'Configure';

      $CLICSHOPPING_ProductsQuantityUnit->loadDefinitions('ClicShoppingAdmin/configure');

      $modules = $CLICSHOPPING_ProductsQuantityUnit->getConfigModules();

      $default_module = 'PQ';

      foreach ($modules as $m) {
        if ($CLICSHOPPING_ProductsQuantityUnit->getConfigModuleInfo($m, 'is_installed') === true) {
          $default_module = $m;
          break;
        }
      }

      $this->page->data['current_module'] = (isset($_GET['module']) && \in_array($_GET['module'], $modules)) ? $_GET['module'] : $default_module;
    }
  }