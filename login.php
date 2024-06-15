<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_setting_banner WHERE id=1");
$statement->execute();
$result = $statement->fetchAll();                            
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>

<?php
// Check if this comes from checkout page
if(isset($_POST['form_from_page']))
{
    $from_page = strip_tags($_POST['from_page']);
    $_SESSION['from_page'] = $from_page;
}
?>

<?php
if(isset($_POST['form1'])) {
        
    if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
        $error_message = EMAIL_AND_OR_PASSWORD_CAN_NOT_BE_EMPTY.'<br>';
    } else {
        
        $cust_email = strip_tags($_POST['cust_email']);
        $cust_password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
        $statement->execute(array($cust_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll();
        foreach($result as $row) {
            $cust_status = $row['cust_status'];
            $row_password = $row['cust_password'];
        }

        if($total==0) {
            $error_message .= EMAIL_ADDRESS_DOES_NOT_MATCH.'<br>';
        } else {

            if( $row_password != md5($cust_password) ) {
                $error_message .= PASSWORDS_DO_NOT_MATCH.'<br>';
            } else {
                if($cust_status == 0) {
                    $error_message .= ACCOUNT_INACTIVE_MESSAGE.'<br>';
                } else {
                    $_SESSION['customer'] = $row;

                    if(isset($_SESSION['from_page']))
                    {
                        header("location: ".BASE_URL."checkout.php");
                    }
                    else
                    {
                        header("location: ".BASE_URL."dashboard.php");    
                    }
                }
            }
            
        }
    }
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_login; ?>);">
    <div class="inner">
        <h1><?php echo CUSTOMER_LOGIN; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">

                    
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>                  
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <div class="form-group">
                                    <label for=""><?php echo EMAIL_ADDRESS; ?> *</label>
                                    <input type="email" class="form-control" name="cust_email">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo PASSWORD; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="<?php echo SUBMIT; ?>" name="form1">
                                </div>
                                <a href="forget-password.php" style="color:#e4144d;"><?php echo FORGET_PASSWORD; ?></a>
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>