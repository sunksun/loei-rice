<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    
    $statement = $pdo->prepare("UPDATE tbl_setting_payment SET paypal_status=?,paypal_email=?,stripe_status=?, stripe_public_key=?, stripe_secret_key=?, bank_status=?, bank_detail=?, cash_on_delivery_status=? WHERE id=1");
    $statement->execute(array($_POST['paypal_status'],$_POST['paypal_email'],$_POST['stripe_status'],$_POST['stripe_public_key'],$_POST['stripe_secret_key'],$_POST['bank_status'],$_POST['bank_detail'],$_POST['cash_on_delivery_status']));

    $success_message = 'Payment setting is updated successfully.';
    
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Setting - Payment</h1>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_setting_payment WHERE id=1");
$statement->execute();
$result = $statement->fetchAll();                           
foreach ($result as $row) {
    $paypal_status           = $row['paypal_status'];
    $paypal_email            = $row['paypal_email'];
    $stripe_status           = $row['stripe_status'];
    $stripe_public_key       = $row['stripe_public_key'];
    $stripe_secret_key       = $row['stripe_secret_key'];
    $bank_status             = $row['bank_status'];
    $bank_detail             = $row['bank_detail'];
    $cash_on_delivery_status = $row['cash_on_delivery_status'];
}
?>


<section class="content" style="min-height:auto;margin-bottom: -30px;">
    <div class="row">
        <div class="col-md-12">
            <?php if($error_message): ?>
            <div class="callout callout-danger">
            <p>
            <?php echo $error_message; ?>
            </p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
            <div class="callout callout-success">
            <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info" style="padding-top:0;">
                    <div class="box-body">

                        <h3 class="s-title" style="margin-top:0;">PayPal</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">PayPal Status </label>
                            <div class="col-sm-2">
                                <select name="paypal_status" class="form-control select2" style="width:100%;">
                                    <option value="Active" <?php if($paypal_status=='Active') {echo 'selected';} ?>>Active</option>
                                    <option value="Inactive" <?php if($paypal_status=='Inactive') {echo 'selected';} ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">PayPal - Business Email </label>
                            <div class="col-sm-5">
                                <input type="text" name="paypal_email" class="form-control" value="<?php echo $paypal_email; ?>">
                            </div>
                        </div>

                        <h3 class="s-title" style="margin-top:0;">Stripe</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Stripe Status </label>
                            <div class="col-sm-2">
                                <select name="stripe_status" class="form-control select2" style="width:100%;">
                                    <option value="Active" <?php if($stripe_status=='Active') {echo 'selected';} ?>>Active</option>
                                    <option value="Inactive" <?php if($stripe_status=='Inactive') {echo 'selected';} ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Stripe - Public Key </label>
                            <div class="col-sm-5">
                                <input type="text" name="stripe_public_key" class="form-control" value="<?php echo $stripe_public_key; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Stripe - Secret Key </label>
                            <div class="col-sm-5">
                                <input type="text" name="stripe_secret_key" class="form-control" value="<?php echo $stripe_secret_key; ?>">
                            </div>
                        </div>

                        <h3 class="s-title" style="margin-top:0;">Bank Deposit</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Bank Payment Status </label>
                            <div class="col-sm-2">
                                <select name="bank_status" class="form-control select2" style="width:100%;">
                                    <option value="Active" <?php if($bank_status=='Active') {echo 'selected';} ?>>Active</option>
                                    <option value="Inactive" <?php if($bank_status=='Inactive') {echo 'selected';} ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Bank Information </label>
                            <div class="col-sm-5">
                                <textarea name="bank_detail" class="form-control" cols="30" rows="10" style="height:140px;"><?php echo $bank_detail; ?></textarea>
                            </div>
                        </div>

                        <h3 class="s-title" style="margin-top:0;">Cash On Delivery</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Status </label>
                            <div class="col-sm-2">
                                <select name="cash_on_delivery_status" class="form-control select2" style="width:100%;">
                                    <option value="Active" <?php if($cash_on_delivery_status=='Active') {echo 'selected';} ?>>Active</option>
                                    <option value="Inactive" <?php if($cash_on_delivery_status=='Inactive') {echo 'selected';} ?>>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                
        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>