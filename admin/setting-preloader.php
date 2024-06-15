<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_setting_preloader SET preloader_status=? WHERE id=1");
    $statement->execute(array($_POST['preloader_status']));

    $success_message = 'Preloader setting is updated successfully.';
    
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Setting - Preloader</h1>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_setting_preloader WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $preloader_status = $row['preloader_status'];
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
                            <label for="" class="col-sm-2 control-label">Preloader Status </label>
                            <div class="col-sm-3">
                                <select name="preloader_status" class="form-control" style="width:auto;">
                                    <option value="On" <?php if($preloader_status == 'On') {echo 'selected';} ?>>On</option>
                                    <option value="Off" <?php if($preloader_status == 'Off') {echo 'selected';} ?>>Off</option>
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