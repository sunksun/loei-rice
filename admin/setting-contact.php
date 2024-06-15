<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    
    // updating the database
    $statement = $pdo->prepare("UPDATE tbl_setting_contact SET contact_address=?, contact_email=?, contact_phone=?, contact_map_iframe=? WHERE id=1");
    $statement->execute(array($_POST['contact_address'],$_POST['contact_email'],$_POST['contact_phone'],$_POST['contact_map_iframe']));

    $success_message = 'Contact setting is updated successfully.';
    
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Setting - Contact</h1>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_setting_contact WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $contact_address    = $row['contact_address'];
    $contact_email      = $row['contact_email'];
    $contact_phone      = $row['contact_phone'];
    $contact_map_iframe = $row['contact_map_iframe'];
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
                            <label for="" class="col-sm-2 control-label">Contact Address </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="contact_address" style="height:70px;"><?php echo $contact_address; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Contact Email </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="contact_email" value="<?php echo $contact_email; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Contact Phone Number </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="contact_phone" value="<?php echo $contact_phone; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Contact Map iFrame </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="contact_map_iframe" style="height:150px;"><?php echo $contact_map_iframe; ?></textarea>
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