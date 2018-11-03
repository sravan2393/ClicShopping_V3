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

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;
?>
<div class="col-md-<?php echo $content_width; ?>" id="RowContentPricacyCondition1">
  <div class="separator"></div>
  <div class="col-md-12">
    <div class="separator"></div>
    <div class="modulesCreateAccountRegistrationTextPrivacy">
<?php
  echo HTML::checkboxField('customer_agree_privacy', null, 'required aria-required="true"') . ' ' . CLICSHOPPING::getDef('text_privacy_conditions_agree') . '<br />';
  echo CLICSHOPPING::getDef('text_privacy_conditions_description', ['store_name' => STORE_NAME, 'privacy_url' => CLICSHOPPING::link(SHOP_CODE_URL_CONFIDENTIALITY)]);
?>
    </div>
  </div>
</div>