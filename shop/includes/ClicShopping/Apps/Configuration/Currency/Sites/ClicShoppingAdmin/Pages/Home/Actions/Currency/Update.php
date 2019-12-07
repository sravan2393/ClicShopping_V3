<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\Apps\Configuration\Currency\Sites\ClicShoppingAdmin\Pages\Home\Actions\Currency;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\Cache;
  
  class Update extends \ClicShopping\OM\PagesActionsAbstract
  {
    protected $app;

    public function __construct()
    {
      $this->app = Registry::get('Currency');
    }

    public function execute()
    {
      $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;;

      if (isset($_GET['cID'])) $currencies_id = HTML::sanitize($_GET['cID']);
      $title = HTML::sanitize($_POST['title']);
      $code = HTML::sanitize($_POST['code']);
      $symbol_left = HTML::sanitize($_POST['symbol_left']);
      $symbol_right = HTML::sanitize($_POST['symbol_right']);
      $decimal_point = HTML::sanitize($_POST['decimal_point']);
      $thousands_point = HTML::sanitize($_POST['thousands_point']);
      $decimal_places = HTML::sanitize($_POST['decimal_places']);
      $value = HTML::sanitize($_POST['value']);
      $surcharge = HTML::sanitize($_POST['surcharge']);

      $sql_data_array = ['title' => $title,
        'code' => strtoupper($code),
        'symbol_left' => $symbol_left,
        'symbol_right' => $symbol_right,
        'decimal_point' => $decimal_point,
        'thousands_point' => $thousands_point,
        'decimal_places' => $decimal_places,
        'value' => (float)$value,
        'last_updated' => 'now()',
        'surcharge' => (float)$surcharge
      ];

      $this->app->db->save('currencies', $sql_data_array, ['currencies_id' => (int)$currencies_id]);

      if (isset($_POST['default'])) {
        $this->app->db->save('configuration', [
          'configuration_value' => $code
          ], [
            'configuration_key' => 'DEFAULT_CURRENCY'
          ]
        );
      }

      Cache::clear('currencies');
      
      $this->app->redirect('Currency&page=' . $page . '&cID=' . $currencies_id);
    }
  }