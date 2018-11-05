<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4 
 *
 *
 */

  namespace ClicShopping\OM\Modules;

  interface AdminDashboardInterface
  {
      public function getOutput();
      public function install();
      public function keys();
      public function isEnabled();
      public function check();
      public function remove();
  }