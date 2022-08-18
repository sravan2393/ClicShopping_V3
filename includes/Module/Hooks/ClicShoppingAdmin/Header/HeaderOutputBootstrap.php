<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\OM\Module\Hooks\ClicShoppingAdmin\Header;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTTP;
  
  class HeaderOutputBootstrap
  {
    /**
     * @return string
     */
    public function display(): string
    {
//Note : Could be relation with a meta tag allowing to implement a new boostrap theme : Must be installed
      $output = '<!-- Start Bootstrap -->' . "\n";
      $output .= '<!-- CSS only -->';
      $output .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">' . "\n";
      $output .= '<link rel="stylesheet" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">';
      $output .= '<link rel="stylesheet" href="' . CLICSHOPPING::link('css/bootstrap_icons_customize.css')  . '" media="screen, print">';
      $output .= '<!-- Start Bootstrap -->' . "\n";
      
      return $output;
    }
  }