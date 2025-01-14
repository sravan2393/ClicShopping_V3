<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\Sites\Shop\Pages\Products\Actions;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;

  class ProductsNew extends \ClicShopping\OM\PagesActionsAbstract
  {

    public function execute()
    {
      $CLICSHOPPING_Template = Registry::get('Template');
      $CLICSHOPPING_Breadcrumb = Registry::get('Breadcrumb');
      $CLICSHOPPING_Language = Registry::get('Language');

// templates
      $this->page->setFile('products_new.php');
//Content
      $this->page->data['content'] = $CLICSHOPPING_Template->getTemplateFiles('products_new');
//language
      $CLICSHOPPING_Language->loadDefinitions('products_new');

      $CLICSHOPPING_Breadcrumb->add(CLICSHOPPING::getDef('navbar_title'), CLICSHOPPING::link(null, 'Products&ProductsNew'));
    }
  }
