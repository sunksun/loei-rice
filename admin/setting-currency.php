<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1']))
{  
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_setting_currency SET currency_code=?, currency_symbol=?, currency_position=?, currency_value_per_usd=? WHERE id=1");
    $statement->execute(array($_POST['currency_code'],$_POST['currency_symbol'],$_POST['currency_position'], $_POST['currency_value_per_usd']));

    $success_message = 'Currency setting is updated successfully.';
    
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Setting - Currency</h1>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_setting_currency WHERE id=1");
$statement->execute();
$result = $statement->fetchAll();                           
foreach ($result as $row) {
    $currency_code   = $row['currency_code'];
    $currency_symbol = $row['currency_symbol'];
    $currency_position = $row['currency_position'];
    $currency_value_per_usd = $row['currency_value_per_usd'];
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
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Currency Code *</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="currency_code" value="<?php echo $currency_code; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Currency Symbol *</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="currency_symbol" value="<?php echo $currency_symbol; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Currency Position *</label>
                            <div class="col-sm-2">
                                <select name="currency_position" class="form-control">
                                    <option value="Before" <?php if($currency_position=='Before') {echo 'selected';} ?>>Before</option>
                                    <option value="After" <?php if($currency_position=='After') {echo 'selected';} ?>>After</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Currency Value per USD *</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="currency_value_per_usd" value="<?php echo $currency_value_per_usd; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-2">
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