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
if (isset($_POST['form1'])) 
{

    $cust_shipping_billing_same = strip_tags($_POST['cust_shipping_billing_same']);

    $cust_b_name    = strip_tags($_POST['cust_b_name']);
    $cust_b_cname   = strip_tags($_POST['cust_b_cname']);
    $cust_b_phone   = strip_tags($_POST['cust_b_phone']);
    $cust_b_country = strip_tags($_POST['cust_b_country']);
    $cust_b_address = strip_tags($_POST['cust_b_address']);
    $cust_b_city    = strip_tags($_POST['cust_b_city']);
    $cust_b_state   = strip_tags($_POST['cust_b_state']);
    $cust_b_zip     = strip_tags($_POST['cust_b_zip']);

    if($cust_shipping_billing_same == 1)
    {
        $cust_s_name    = strip_tags($_POST['cust_b_name']);
        $cust_s_cname   = strip_tags($_POST['cust_b_cname']);
        $cust_s_phone   = strip_tags($_POST['cust_b_phone']);
        $cust_s_country = strip_tags($_POST['cust_b_country']);
        $cust_s_address = strip_tags($_POST['cust_b_address']);
        $cust_s_city    = strip_tags($_POST['cust_b_city']);
        $cust_s_state   = strip_tags($_POST['cust_b_state']);
        $cust_s_zip     = strip_tags($_POST['cust_b_zip']);
    }
    else
    {
        $cust_s_name    = strip_tags($_POST['cust_s_name']);
        $cust_s_cname   = strip_tags($_POST['cust_s_cname']);
        $cust_s_phone   = strip_tags($_POST['cust_s_phone']);
        $cust_s_country = strip_tags($_POST['cust_s_country']);
        $cust_s_address = strip_tags($_POST['cust_s_address']);
        $cust_s_city    = strip_tags($_POST['cust_s_city']);
        $cust_s_state   = strip_tags($_POST['cust_s_state']);
        $cust_s_zip     = strip_tags($_POST['cust_s_zip']);
    }


    $valid = 1;

    if(empty($cust_b_name))
    {
        $valid = 0;
        $error_message .= CUSTOMER_NAME_CAN_NOT_BE_EMPTY.'\\n';
    }

    if(empty($cust_b_phone))
    {
        $valid = 0;
        $error_message .= PHONE_NUMBER_CAN_NOT_BE_EMPTY.'\\n';
    }

    if(empty($cust_b_country))
    {
        $valid = 0;
        $error_message .= YOU_MUST_HAVE_TO_SELECT_A_COUNTRY.'\\n';
    }

    if(empty($cust_b_address))
    {
        $valid = 0;
        $error_message .= ADDRESS_CAN_NOT_BE_EMPTY.'\\n';
    }

    if(empty($cust_b_city))
    {
        $valid = 0;
        $error_message .= CITY_CAN_NOT_BE_EMPTY.'\\n';
    }

    if(empty($cust_b_state))
    {
        $valid = 0;
        $error_message .= STATE_CAN_NOT_BE_EMPTY.'\\n';
    }

    if(empty($cust_b_zip))
    {
        $valid = 0;
        $error_message .= ZIP_CODE_CAN_NOT_BE_EMPTY.'\\n';
    }


    if($valid == 1)
    {
        // update data into the database
        $statement = $pdo->prepare("UPDATE tbl_customer SET 
                                cust_b_name=?, 
                                cust_b_cname=?, 
                                cust_b_phone=?, 
                                cust_b_country=?, 
                                cust_b_address=?, 
                                cust_b_city=?, 
                                cust_b_state=?, 
                                cust_b_zip=?,
                                cust_s_name=?, 
                                cust_s_cname=?, 
                                cust_s_phone=?, 
                                cust_s_country=?, 
                                cust_s_address=?, 
                                cust_s_city=?, 
                                cust_s_state=?, 
                                cust_s_zip=?,
                                cust_shipping_billing_same=?

                                WHERE cust_id=?");
        $statement->execute(array(
                                $cust_b_name,
                                $cust_b_cname,
                                $cust_b_phone,
                                $cust_b_country,
                                $cust_b_address,
                                $cust_b_city,
                                $cust_b_state,
                                $cust_b_zip,
                                $cust_s_name,
                                $cust_s_cname,
                                $cust_s_phone,
                                $cust_s_country,
                                $cust_s_address,
                                $cust_s_city,
                                $cust_s_state,
                                $cust_s_zip,
                                $cust_shipping_billing_same,
                                $_SESSION['customer']['cust_id']
                            ));  
       
        $success_message = BILLING_AND_SHIPPING_INFORMATION_IS_UPDATED_SUCCESSFULLY;

        $_SESSION['customer']['cust_b_name']                = $cust_b_name;
        $_SESSION['customer']['cust_b_cname']               = $cust_b_cname;
        $_SESSION['customer']['cust_b_phone']               = $cust_b_phone;
        $_SESSION['customer']['cust_b_country']             = $cust_b_country;
        $_SESSION['customer']['cust_b_address']             = $cust_b_address;
        $_SESSION['customer']['cust_b_city']                = $cust_b_city;
        $_SESSION['customer']['cust_b_state']               = $cust_b_state;
        $_SESSION['customer']['cust_b_zip']                 = $cust_b_zip;
        $_SESSION['customer']['cust_s_name']                = $cust_s_name;
        $_SESSION['customer']['cust_s_cname']               = $cust_s_cname;
        $_SESSION['customer']['cust_s_phone']               = $cust_s_phone;
        $_SESSION['customer']['cust_s_country']             = $cust_s_country;
        $_SESSION['customer']['cust_s_address']             = $cust_s_address;
        $_SESSION['customer']['cust_s_city']                = $cust_s_city;
        $_SESSION['customer']['cust_s_state']               = $cust_s_state;
        $_SESSION['customer']['cust_s_zip']                 = $cust_s_zip;
        $_SESSION['customer']['cust_shipping_billing_same'] = $cust_shipping_billing_same;
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
                            <div class="col-md-6">
                                <h3><?php echo UPDATE_BILLING_ADDRESS; ?></h3>
                                <div class="billing_shipping_checkbox_container"></div>
                                <div class="form-group">
                                    <label for=""><?php echo FULL_NAME; ?> *</label>
                                    <input type="text" class="form-control" name="cust_b_name" value="<?php echo $_SESSION['customer']['cust_b_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo COMPANY_NAME; ?></label>
                                    <input type="text" class="form-control" name="cust_b_cname" value="<?php echo $_SESSION['customer']['cust_b_cname']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo PHONE_NUMBER; ?> *</label>
                                    <input type="text" class="form-control" name="cust_b_phone" value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo COUNTRY; ?> *</label>
                                    <select name="cust_b_country" class="form-control select2" style="width:100%;">
                                        <option value=""><?php echo SELECT_COUNTRY; ?></option>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll();
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $_SESSION['customer']['cust_b_country']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo ADDRESS; ?> *</label>
                                    <textarea name="cust_b_address" class="form-control" cols="30" rows="10" style="height:100px;"><?php echo $_SESSION['customer']['cust_b_address']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo CITY; ?> *</label>
                                    <input type="text" class="form-control" name="cust_b_city" value="<?php echo $_SESSION['customer']['cust_b_city']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo STATE; ?> *</label>
                                    <input type="text" class="form-control" name="cust_b_state" value="<?php echo $_SESSION['customer']['cust_b_state']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo ZIP_CODE; ?> *</label>
                                    <input type="text" class="form-control" name="cust_b_zip" value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3><?php echo UPDATE_SHIPPING_ADDRESS; ?></h3>
                                
                                <div class="billing_shipping_checkbox_container">
                                    <input type="hidden" name="cust_shipping_billing_same" value="0">
                                    <input type="checkbox" name="cust_shipping_billing_same" id="checkbox_shipping" value="1" <?php if($_SESSION['customer']['cust_shipping_billing_same'] == 1) {echo 'checked';} ?>> Same as billing address?
                                </div>
                                    
                                <div id="shipping_form_container" style="<?php if($_SESSION['customer']['cust_shipping_billing_same'] == 0) {echo 'display:block';} else {echo 'display:none;';} ?>">

                                <div class="form-group">
                                    <label for=""><?php echo FULL_NAME; ?></label>
                                    <input type="text" class="form-control" name="cust_s_name" value="<?php echo $_SESSION['customer']['cust_s_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo COMPANY_NAME; ?></label>
                                    <input type="text" class="form-control" name="cust_s_cname" value="<?php echo $_SESSION['customer']['cust_s_cname']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo PHONE_NUMBER; ?></label>
                                    <input type="text" class="form-control" name="cust_s_phone" value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo COUNTRY; ?></label>
                                    <select name="cust_s_country" class="form-control select2" style="width:100%;">
                                        <option value=""><?php echo SELECT_COUNTRY; ?></option>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll();
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $_SESSION['customer']['cust_s_country']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo ADDRESS; ?></label>
                                    <textarea name="cust_s_address" class="form-control" cols="30" rows="10" style="height:100px;"><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo CITY; ?></label>
                                    <input type="text" class="form-control" name="cust_s_city" value="<?php echo $_SESSION['customer']['cust_s_city']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo STATE; ?></label>
                                    <input type="text" class="form-control" name="cust_s_state" value="<?php echo $_SESSION['customer']['cust_s_state']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo ZIP_CODE; ?></label>
                                    <input type="text" class="form-control" name="cust_s_zip" value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>">
                                </div>

                                </div><!-- // End of #shipping_form_container -->

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