<?php
  /**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  namespace ClicShopping\Apps\Payment\Stripe\Module\ClicShoppingAdmin\Config\ST\Params;

  class public_key_test extends \ClicShopping\Apps\Payment\Stripe\Module\ClicShoppingAdmin\Config\ConfigParamAbstract {
    public $default = '';
    public ?int $sort_order = 47;

    protected function init() {
      $this->title = $this->app->getDef('cfg_stripe_public_key_test_title');
      $this->description = $this->app->getDef('cfg_stripe_public_key_test_desc');
    }
  }
