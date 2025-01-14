<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;
?>
  <div class="col-md-<?php echo $content_width; ?>">
    <div class="row">
      <div class="separator"></div>
      <span class="col-md-4 headerMultiTemplateDefaultLogo"><?php echo $logo_header; ?><br /><br /></span>
      <span class="col-md-8">
        <span class="text-end headerMultiTemplateDefaultTitle">
<?php
  if (!$CLICSHOPPING_Customer->isLoggedOn()) {
?>
          <a data-bs-toggle="modal" data-bs-target="#loginModal"><?php echo CLICSHOPPING::getDef('modules_header_multi_template_account_login'); ?></a> |
          <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel"><?php echo CLICSHOPPING::getDef('modules_header_multi_template_account_login') ?></h4>
                </div>
                <div class="modal-body text-center">
                  <?php echo $form; ?>
                  <div class="separator"></div>
                  <div class="row">
                    <div class="col-md-12">
                      <label for="inputAddressEmailLogin" class="visually-hidden"></label>
                      <span class="col-md-3 float-start text-start headerMultiTemplateDefaultLoginText"  id="inputAddressEmailLogin"><?php echo CLICSHOPPING::getDef('modules_header_multi_template_header_email_address'); ?></span>
                      <span class="col-md-9 float-end"><?php echo HTML::inputField('email_address', null, 'id="inputAddressEmail" autocomplete="username" aria-describedby="' . CLICSHOPPING::getDef('modules_header_multi_template_header_email_address') . '" placeholder="' . CLICSHOPPING::getDef('modules_header_multi_template_header_email_address') . '"', 'email'); ?></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label for="inputAddressPasswordLogin" class="visually-hidden"></label>
                      <span class="col-md-3 float-start text-start headerMultiTemplateDefaultPasswordText" id="inputAddressPasswordLogin"><?php echo CLICSHOPPING::getDef('modules_header_multi_template_account_password'); ?></span>
                      <span class="col-md-9 float-end"><?php echo HTML::inputField('password', null, 'id="current-password" autocomplete="current-password" aria-describedby="' . CLICSHOPPING::getDef('modules_header_multi_template_account_password') . '" placeholder="' . CLICSHOPPING::getDef('modules_header_multi_template_account_password') . '"', 'password'); ?></span>
                    </div>
                  </div>
                  <div class="separator"></div>
                  <div>
                    <span class="headerMultiTemplateDefaultPassword col-md-6"><?php echo HTML::link(CLICSHOPPING::link(null, 'Account&PasswordForgotten'), CLICSHOPPING::getDef('modules_header_multi_template_password_forgotten')); ?></span>
                    <span class="text-end col-md-6"><label for="<?php echo CLICSHOPPING::getDef('modules_header_multi_template_account_login'); ?>"><?php echo $login; ?></label></span>
                  </div>
                  <?php echo $endform; ?>
                </div>
              </div>
            </div>
          </div>
<?php
  } else {
?>
          <span>
            <?php echo HTML::link(CLICSHOPPING::link(null, 'Account&LogOff'), CLICSHOPPING::getDef('modules_header_multi_template_account_logoff'));?> |
<?php
      if ($CLICSHOPPING_Customer->getCustomerGuestAccount($CLICSHOPPING_Customer->getID()) == 0) {
        echo HTML::link(CLICSHOPPING::link(null, 'Account&Main'), CLICSHOPPING::getDef('modules_header_multi_template_my_account')) .  ' | ';
      }
?>
</span>
<?php
  }
  if (!$CLICSHOPPING_Customer->isLoggedOn()) {
?>
          <span><?php echo HTML::link(CLICSHOPPING::link(null, 'Account&LogIn'), CLICSHOPPING::getDef('modules_header_multi_template_create_account')); ?> | </span>
 <?php
  }
?>
          <span><?php echo HTML::link(CLICSHOPPING::link(null, 'Info&Contact'), CLICSHOPPING::getDef('modules_header_multi_template_title_contact_us')); ?></span>
        </span>
        <span class="float-end text-end">
          &nbsp;&nbsp;&nbsp;<?php echo $currency_header; ?>
        </span>
        <span class="float-end headerMultiTemplateDefaultLanguage">
          <ul>
            <li class="headerMultiTemplateDefaultLanguage"><?php echo $languages_string; ?></li>
          </ul>
        </span>

        <span class="col-md-6 float-start headerMultiTemplateDefaultHeaderSearch">
          <?php echo $form_advanced_result; ?>
          <div class="input-group col-md-12 advancedSearchCriteria">
            <label for="inputKeywordsSearchLogin" class="visually-hidden"></label>
              <?php echo HTML::inputField('keywords', null, 'required aria-required="true" id="inputKeywordsSearchLogin" placeholder="' . CLICSHOPPING::getDef('modules_header_multi_template_header_search') . '"', 'search'); ?>
              <span id="buttonKeywordsSearch"><label for="buttonKeywordsSearch"><?php echo HTML::button(null, 'bi bi-search', null, 'primary', null, 'sm'); ?></label></span>
          </div>
           <div class="text-center advancedSearchLink"><?php echo HTML::link(CLICSHOPPING::link(null, 'Search&AdvancedSearch'), CLICSHOPPING::getDef('modules_header_multi_template_title_advanced_search')); ?></div>
          <?php echo HTML::hiddenField('search_in_description', '1'); ?>
          <?php echo $endform; ?>
        </span>
        <span class="col-md-6 float-end headerMultiTemplateDefaultShoppingCartImage"><?php echo $banner_header; ?></span>
      </span>
    </div>
    <div class="row">
      <div class="col-md-12 group">
        <span class="col-md-10 float-end text-end headerMultiTemplateDefaultCartLink">
<?php
  if ($CLICSHOPPING_ShoppingCart->getCountContents() > 0) {
?>
         <ul>
          <li class="dropdown headerMultiTemplateDefaultShoppingCart">
            <a class="dropdown-toggle headerMultiTemplateDefaultShoppingCart" data-bs-toggle="dropdown" href="#"><?php echo '<i class="bi bi-cart-fill headerMultiTemplateDefaultShoppingCart" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;' . $shopping_cart ?></a>
            <ul class="dropdown-menu">
              <li role="separator"></li>
<?php
  $products = $CLICSHOPPING_ShoppingCart->get_products();

  foreach ($products as $k => $v) {
    echo '<li class="headerMultiTemplateDefaultLi">&nbsp;&nbsp;
            <span class="float-start">' . $v['quantity'] . ' - ' . $v['name'] . '</span>
            <span class="float-end">' .  $CLICSHOPPING_Currencies->displayPrice($v['final_price'], $CLICSHOPPING_Tax->getTaxRate($v['tax_class_id']), $v['quantity']) . '</span>
         </li>
         ';
  }
?>
                <li role="separator" class="h-divider"></li>
                <li class="headerMultiTemplateDefaultLi">&nbsp;&nbsp;
                  <span class="float-start"><?php echo CLICSHOPPING::getDef('modules_header_multi_template_shopping_cart_total_content'); ?></span>
                  <span class="float-end text-end"><?php echo $CLICSHOPPING_Currencies->format($CLICSHOPPING_ShoppingCart->show_total()); ?></span>
                </li>
                <li role="separator" class="h-divider"></li>
                <li class="headerMultiTemplateDefaultLi">
                  <span class="float-start headerMultiTemplateDefaultShoppingSmallCart"><i class="bi bi-cart-fill">&nbsp;&nbsp;</i><?php echo HTML::link(ClicShopping::link(null, 'Cart'), CLICSHOPPING::getDef('modules_header_multi_template_shopping_cart_view_cart')); ?></span>
                  <span class="float-end headerMultiTemplateDefaultCheckout"><i class="bi bi-arrow-right-square-fill"></i>&nbsp;&nbsp;<?php echo HTML::link(ClicShopping::link(null, 'Checkout&Shipping'), CLICSHOPPING::getDef('modules_header_multi_template_shopping_cart_checkout')); ?></span>
                </li>
              </ul>
            </li>
         </ul>
 <?php
  } else {
    echo '<ul>
            <li class="headerMultiTemplateDefaultShoppingCart"><i class="bi bi-cart-fill headerMultiTemplateDefaultShoppingCart" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;' . CLICSHOPPING::getDef('modules_header_multi_template_shopping_cart_no_content') . '</li>
         </ul>
         ';
  }
?>
        </span>
      </div>
    </div>
  </div>
