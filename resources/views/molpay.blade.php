<form action="<?php echo $action; ?>" method="post" id="payment">

  <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
  <input type="hidden" name="orderid" value="<?php echo $orderid; ?>" />
  <input type="hidden" name="bill_name" value="<?php echo $bill_name; ?>" />
  <input type="hidden" name="bill_email" value="<?php echo $bill_email; ?>" />
  <input type="hidden" name="bill_mobile" value="<?php echo $bill_mobile; ?>" />
  <input type="hidden" name="country" value="<?php echo $country; ?>" />
  <input type="hidden" name="currency1" value="<?php echo $currency;?>" />
  <input type="hidden" name="vcode" value="<?php echo $vcode?>">
  <input type="hidden" name="returnurl" value="<?php echo $returnurl; ?>" />

  <input type="hidden" name="bill_desc" value="<?php echo implode("\n",$prod_desc);?>" />
  <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
    </div>
  </div>
</form>
