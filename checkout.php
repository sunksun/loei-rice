<?php require_once('header.php'); ?>

<?php
unset($_SESSION['from_page']);
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_setting_banner WHERE id=1");
$statement->execute();
$result = $statement->fetchAll();                            
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_setting_payment WHERE id=1");
$statement->execute();
$result = $statement->fetchAll();                            
foreach ($result as $row) {
    $paypal_status = $row['paypal_status'];
    $stripe_status = $row['stripe_status'];
    $bank_status = $row['bank_status'];
    $cash_on_delivery_status = $row['cash_on_delivery_status'];
}
?>

<?php
if(!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo CHECKOUT; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <?php if(!isset($_SESSION['customer'])): ?>
                    <form action="login.php" method="post">
                        <input type="hidden" name="from_page" value="checkout">
                    <p>
                        <button type="submit" class="btn btn-md btn-danger" name="form_from_page"><?php echo PLEASE_LOGIN_AS_CUSTOMER_TO_CHECKOUT; ?></button>
                    </p>
                    </form>
                <?php else: ?>

                <h3 class="special"><?php echo ORDER_DETAILS; ?></h3>
                <div class="cart">
                    <table class="table table-responsive">
                        <tr>
                            <th><?php echo SERIAL; ?></th>
                            <th><?php echo PHOTO; ?></th>
                            <th><?php echo PRODUCT_NAME; ?></th>
                            <th><?php echo SIZE; ?></th>
                            <th><?php echo COLOR; ?></th>
                            <th><?php echo PRICE; ?></th>
                            <th><?php echo QUANTITY; ?></th>
                            <th class="text-right"><?php echo TOTAL; ?></th>
                        </tr>
                         <?php
                        $table_total_price = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                            </td>
                            <td><?php echo $arr_cart_p_name[$i]; ?></td>
                            <td><?php echo $arr_cart_size_name[$i]; ?></td>
                            <td><?php echo $arr_cart_color_name[$i]; ?></td>
                            <td>
                                <?php
                                if(CURRENCY_POSITION == 'Before') {
                                    echo CURRENCY_SYMBOL;
                                    echo $arr_cart_p_current_price[$i];
                                } else {
                                    echo $arr_cart_p_current_price[$i];
                                    echo CURRENCY_SYMBOL;
                                }
                                ?>
                            </td>
                            <td><?php echo $arr_cart_p_qty[$i]; ?></td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                <?php
                                if(CURRENCY_POSITION == 'Before') {
                                    echo CURRENCY_SYMBOL;
                                    echo $row_total_price;
                                } else {
                                    echo $row_total_price;
                                    echo CURRENCY_SYMBOL;
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endfor; ?>           
                        <tr>
                            <th colspan="7" class="total-text"><?php echo SUBTOTAL; ?></th>
                            <th class="total-amount">
                                <?php
                                if(CURRENCY_POSITION == 'Before') {
                                    echo CURRENCY_SYMBOL;
                                    echo $table_total_price;
                                } else {
                                    echo $table_total_price;
                                    echo CURRENCY_SYMBOL;
                                }
                                ?>
                            </th>
                        </tr>
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                        $statement->execute(array($_SESSION['customer']['cust_country']));
                        $total = $statement->rowCount();
                        if($total) {
                            $result = $statement->fetchAll();
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        } else {
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                            $statement->execute();
                            $result = $statement->fetchAll();
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        }                        
                        ?>
                        <tr>
                            <td colspan="7" class="total-text"><?php echo SHIPPING_COST; ?></td>
                            <td class="total-amount">
                                <?php
                                if(CURRENCY_POSITION == 'Before') {
                                    echo CURRENCY_SYMBOL;
                                    echo $shipping_cost;
                                } else {
                                    echo $shipping_cost;
                                    echo CURRENCY_SYMBOL;
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="7" class="total-text"><?php echo TOTAL; ?></th>
                            <th class="total-amount">
                                <?php
                                $final_total = $table_total_price+$shipping_cost;
                                ?>
                                <?php
                                if(CURRENCY_POSITION == 'Before') {
                                    echo CURRENCY_SYMBOL;
                                    echo $final_total;
                                } else {
                                    echo $final_total;
                                    echo CURRENCY_SYMBOL;
                                }
                                ?>
                            </th>
                        </tr>
                    </table> 
                </div>

                

                <div class="billing-address">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="special"><?php echo BILLING_ADDRESS; ?></h3>
                            <table class="table table-responsive table-bordered bill-address">
                                <tr>
                                    <td><?php echo FULL_NAME; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td><?php echo COMPANY_NAME; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo PHONE_NUMBER; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo COUNTRY; ?></td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_b_country']));
                                        $result = $statement->fetchAll();
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo ADDRESS; ?></td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_b_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo CITY; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo STATE; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_state']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo ZIP_CODE; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_zip']; ?></td>
                                </tr>                                
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3 class="special"><?php echo SHIPPING_ADDRESS; ?></h3>
                            <table class="table table-responsive table-bordered bill-address">
                                <tr>
                                    <td><?php echo FULL_NAME; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td><?php echo COMPANY_NAME; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo PHONE_NUMBER; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo COUNTRY; ?></td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_s_country']));
                                        $result = $statement->fetchAll();
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo ADDRESS; ?></td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo CITY; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo STATE; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_state']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo ZIP_CODE; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_zip']; ?></td>
                                </tr> 
                            </table>
                        </div>
                    </div>                    
                </div>

                

                <div class="cart-buttons">
                    <ul>
                        <li><a href="cart.php" class="btn btn-primary"><?php echo BACK_TO_CART; ?></a></li>
                    </ul>
                </div>

				<div class="clear"></div>
                <h3 class="special"><?php echo PAYMENT_SECTION; ?></h3>
                <div class="row">
                    
                    	<?php
		                $checkout_access = 1;
		                if(
		                    ($_SESSION['customer']['cust_b_name']=='') ||
		                    ($_SESSION['customer']['cust_b_cname']=='') ||
		                    ($_SESSION['customer']['cust_b_phone']=='') ||
		                    ($_SESSION['customer']['cust_b_country']=='') ||
		                    ($_SESSION['customer']['cust_b_address']=='') ||
		                    ($_SESSION['customer']['cust_b_city']=='') ||
		                    ($_SESSION['customer']['cust_b_state']=='') ||
		                    ($_SESSION['customer']['cust_b_zip']=='') ||
		                    ($_SESSION['customer']['cust_s_name']=='') ||
		                    ($_SESSION['customer']['cust_s_cname']=='') ||
		                    ($_SESSION['customer']['cust_s_phone']=='') ||
		                    ($_SESSION['customer']['cust_s_country']=='') ||
		                    ($_SESSION['customer']['cust_s_address']=='') ||
		                    ($_SESSION['customer']['cust_s_city']=='') ||
		                    ($_SESSION['customer']['cust_s_state']=='') ||
		                    ($_SESSION['customer']['cust_s_zip']=='')
		                ) {
		                    $checkout_access = 0;
		                }
		                ?>
		                <?php if($checkout_access == 0): ?>
		                	<div class="col-md-12">
				                <div style="color:red;font-size:22px;margin-bottom:50px;">
			                        You must have to fill up all the billing and shipping information from your dashboard panel in order to checkout the order. Please fill up the information going to <a href="customer-billing-shipping-update.php" style="color:red;text-decoration:underline;">this link</a>.
			                    </div>
	                    	</div>
	                	<?php else: ?>
		                	<div class="col-md-4">
		                		
	                            <div class="row">

	                                <div class="col-md-12 form-group">
	                                    <label for=""><?php echo SELECT_PAYMENT_METHOD; ?> *</label>
	                                    <select name="payment_method" class="form-control select2" id="advFieldsStatus">
	                                        <option value=""><?php echo SELECT_A_METHOD; ?></option>
                                            <?php if($paypal_status == 'Active'): ?>
	                                        <option value="PayPal"><?php echo PAYPAL; ?></option>
                                            <?php endif; ?>

                                            <?php if($stripe_status == 'Active'): ?>
	                                        <option value="Stripe"><?php echo STRIPE; ?></option>
                                            <?php endif; ?>

                                            <?php if($bank_status == 'Active'): ?>
	                                        <option value="Bank Deposit"><?php echo BANK_DEPOSIT; ?></option>
                                            <?php endif; ?>

                                            <?php if($cash_on_delivery_status == 'Active'): ?>
                                            <option value="Cash On Delivery"><?php echo CASH_ON_DELIVERY; ?></option>
                                            <?php endif; ?>

	                                    </select>
	                                </div>
                                    
                                    <?php if($paypal_status == 'Active'): ?>
                                    <form class="paypal" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php" method="post" id="paypal_form" target="_blank">
                                        <input type="hidden" name="cmd" value="_xclick">
                                        <input type="hidden" name="no_note" value="1">
                                        <input type="hidden" name="lc" value="US">
                                        <input type="hidden" name="currency_code" value="USD">
                                        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_setting_currency WHERE id=1");
                                        $statement->execute();
                                        $result = $statement->fetchAll();
                                        foreach ($result as $row) {
                                            $currency_code = $row['currency_code'];
                                            if($currency_code == 'USD' || $currency_code == 'usd')
                                            {
                                                $currency_value_per_usd = 1;
                                            }
                                            else
                                            {
                                                $currency_value_per_usd = $row['currency_value_per_usd'];
                                            }
                                            $final_total = number_format(($final_total/$currency_value_per_usd),2);
                                        }
                                        ?>

                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo PAY_NOW; ?>" name="form1">
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                    

                                    <?php if($stripe_status == 'Active'): ?>
                                    <form action="payment/stripe/init.php" method="post" id="stripe_form">
                                        <input type="hidden" name="payment" value="posted">
                                        <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo CARD_NUMBER; ?> *</label>
                                            <input type="text" name="card_number" class="form-control card-number">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo CVV; ?> *</label>
                                            <input type="text" name="card_cvv" class="form-control card-cvc">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo MONTH; ?> *</label>
                                            <input type="text" name="card_month" class="form-control card-expiry-month">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo YEAR; ?> *</label>
                                            <input type="text" name="card_year" class="form-control card-expiry-year">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo PAY_NOW; ?>" name="form2" id="submit-button">
                                            <div id="msg-container"></div>
                                        </div>
                                    </form>
                                    <?php endif; ?>


                                    <?php if($bank_status == 'Active'): ?>
                                    <form action="payment/bank/init.php" method="post" id="bank_form">
                                        <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo SEND_TO_THIS_DETAILS; ?></span></label><br>
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_setting_payment WHERE id=1");
                                            $statement->execute();
                                            $result = $statement->fetchAll();
                                            foreach ($result as $row) {
                                                echo nl2br($row['bank_detail']);
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo TRANSACTION_INFORMATION; ?> <br><span style="font-size:12px;font-weight:normal;">(<?php echo INCLUDE_TXN_ID_AND_OTHER_INFORMATION_CORRECTLY; ?>)</span></label>
                                            <textarea name="transaction_info" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo PAY_NOW; ?>" name="form3">
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                    

                                    <?php if($cash_on_delivery_status == 'Active'): ?>
                                    <form action="payment/cash_on_delivery/init.php" method="post" id="cash_on_delivery_form">
                                        <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo SUBMIT; ?>" name="form4">
                                        </div>
                                    </form>
                                    <?php endif; ?>



	                                
	                            </div>
		                            
		                        
		                    </div>
		                <?php endif; ?>
                        
                </div>
                

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>