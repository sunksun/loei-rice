<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<?php
if (isset($_POST['form1'])) {

    $cust_name = strip_tags($_POST['cust_name']);
    $cust_cname = strip_tags($_POST['cust_cname']);
    $cust_phone = strip_tags($_POST['cust_phone']);
    $cust_address = strip_tags($_POST['cust_address']);
    $cust_country = strip_tags($_POST['cust_country']);
    $cust_city = strip_tags($_POST['cust_city']);
    $cust_state = strip_tags($_POST['cust_state']);
    $cust_zip = strip_tags($_POST['cust_zip']);
    $cust_city = strip_tags($_POST['cust_city']);


    $valid = 1;

    if(empty($cust_name)) {
        $valid = 0;
        $error_message .= CUSTOMER_NAME_CAN_NOT_BE_EMPTY."\\n";
    }

    if(empty($cust_phone)) {
        $valid = 0;
        $error_message .= PHONE_NUMBER_CAN_NOT_BE_EMPTY."\\n";
    }
    else
    {
        $q = $pdo->prepare("
                    SELECT * 
                    FROM tbl_customer 
                    WHERE cust_phone=? AND cust_phone!=?
                ");
        $q->execute([
                    $cust_phone,
                    $_SESSION['customer']['cust_phone']
                ]);
        $total = $q->rowCount();
        if($total)
        {
            $valid = 0;
            $error_message .= PHONE_NUMBER_ALREADY_EXIST."\\n";
        }
    }

    if(empty($cust_address)) {
        $valid = 0;
        $error_message .= ADDRESS_CAN_NOT_BE_EMPTY."\\n";
    }

    if(empty($cust_country)) {
        $valid = 0;
        $error_message .= YOU_MUST_HAVE_TO_SELECT_A_COUNTRY."\\n";
    }

    if(empty($cust_city)) {
        $valid = 0;
        $error_message .= CITY_CAN_NOT_BE_EMPTY."\\n";
    }

    if(empty($cust_state)) {
        $valid = 0;
        $error_message .= STATE_CAN_NOT_BE_EMPTY."\\n";
    }

    if(empty($cust_zip)) {
        $valid = 0;
        $error_message .= ZIP_CODE_CAN_NOT_BE_EMPTY."\\n";
    }

    if($valid == 1) {

        // update data into the database
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_name=?, cust_cname=?, cust_phone=?, cust_country=?, cust_address=?, cust_city=?, cust_state=?, cust_zip=? WHERE cust_id=?");
        $statement->execute(array(
                    $cust_name,
                    $cust_cname,
                    $cust_phone,
                    $cust_country,
                    $cust_address,
                    $cust_city,
                    $cust_state,
                    $cust_zip,
                    $_SESSION['customer']['cust_id']
                ));  
       
        $success_message = PROFILE_INFORMATION_IS_UPDATED_SUCCESSFULLY;

        $_SESSION['customer']['cust_name'] = $cust_name;
        $_SESSION['customer']['cust_cname'] = $cust_cname;
        $_SESSION['customer']['cust_phone'] = $cust_phone;
        $_SESSION['customer']['cust_country'] = $cust_country;
        $_SESSION['customer']['cust_address'] = $cust_address;
        $_SESSION['customer']['cust_city'] = $cust_city;
        $_SESSION['customer']['cust_state'] = $cust_state;
        $_SESSION['customer']['cust_zip'] = $cust_zip;
    }
}
?>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12"> 
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3>
                        <?php echo UPDATE_PROFILE; ?>
                    </h3>
                    <?php
                    if($error_message != '') {
                        echo "<script>alert('".$error_message."')</script>";
                    }
                    if($success_message != '') {
                        echo "<script>alert('".$success_message."')</script>";
                    }
                    ?>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo FULL_NAME; ?> *</label>
                                <input type="text" class="form-control" name="cust_name" value="<?php echo $_SESSION['customer']['cust_name']; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo COMPANY_NAME; ?></label>
                                <input type="text" class="form-control" name="cust_cname" value="<?php echo $_SESSION['customer']['cust_cname']; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo EMAIL_ADDRESS; ?> *</label>
                                <input type="text" class="form-control" name="" value="<?php echo $_SESSION['customer']['cust_email']; ?>" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo PHONE_NUMBER; ?> *</label>
                                <input type="text" class="form-control" name="cust_phone" value="<?php echo $_SESSION['customer']['cust_phone']; ?>">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for=""><?php echo ADDRESS; ?> *</label>
                                <textarea name="cust_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $_SESSION['customer']['cust_address']; ?></textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo COUNTRY; ?> *</label>
                                <select name="cust_country" class="form-control">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    ?>
                                    <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $_SESSION['customer']['cust_country']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                    <?php
                                }
                                ?>
                                </select>                                    
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo CITY; ?> *</label>
                                <input type="text" class="form-control" name="cust_city" value="<?php echo $_SESSION['customer']['cust_city']; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo STATE; ?> *</label>
                                <input type="text" class="form-control" name="cust_state" value="<?php echo $_SESSION['customer']['cust_state']; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""><?php echo ZIP_CODE; ?> *</label>
                                <input type="text" class="form-control" name="cust_zip" value="<?php echo $_SESSION['customer']['cust_zip']; ?>">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="<?php echo UPDATE; ?>" name="form1">
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>