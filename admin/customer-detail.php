<?php require_once('header.php'); ?>

<?php 
if(!isset($_REQUEST['id']))
{
	header('location: customer.php');
	exit;
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Customer Details</h1>
	</div>
</section>

<?php
$i=0;
$statement = $pdo->prepare("SELECT * 
							FROM tbl_customer t1
							JOIN tbl_country t2
							ON t1.cust_country = t2.country_id
							WHERE cust_id=?
						");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);						
foreach ($result as $row) {
	$cust_name = $row['cust_name'];
	$cust_cname = $row['cust_cname'];
	$cust_email = $row['cust_email'];
	$cust_phone = $row['cust_phone'];
	$cust_country = $row['cust_country'];
	$cust_address = $row['cust_address'];
	$cust_city = $row['cust_city'];
	$cust_state = $row['cust_state'];
	$cust_zip = $row['cust_zip'];

	$cust_b_name = $row['cust_b_name'];
	$cust_b_cname = $row['cust_b_cname'];
	$cust_b_phone = $row['cust_b_phone'];
	$cust_b_country = $row['cust_b_country'];
	$cust_b_address = $row['cust_b_address'];
	$cust_b_city = $row['cust_b_city'];
	$cust_b_state = $row['cust_b_state'];
	$cust_b_zip = $row['cust_b_zip'];

	$cust_s_name = $row['cust_s_name'];
	$cust_s_cname = $row['cust_s_cname'];
	$cust_s_phone = $row['cust_s_phone'];
	$cust_s_country = $row['cust_s_country'];
	$cust_s_address = $row['cust_s_address'];
	$cust_s_city = $row['cust_s_city'];
	$cust_s_state = $row['cust_s_state'];
	$cust_s_zip = $row['cust_s_zip'];

	$cust_status = $row['cust_status'];
}
?>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">

					<h4 style="color:blue;">General Information</h4 style="color:blue;">
					<table class="table table-bordered table-striped">
						<tbody>
							<tr>
								<th style="width: 270px;">Customer Name</th>
								<td><?php echo $cust_name; ?></td>
							</tr>
							<tr>
								<th>Customer Company Name</th>
								<td><?php echo $cust_cname; ?></td>
							</tr>
							<tr>
								<th>Customer Email</th>
								<td><?php echo $cust_email; ?></td>
							</tr>
							<tr>
								<th>Customer Phone</th>
								<td><?php echo $cust_phone; ?></td>
							</tr>
							<tr>
								<th>Customer Country</th>
								<td><?php echo $cust_country; ?></td>
							</tr>
							<tr>
								<th>Customer Address</th>
								<td><?php echo $cust_address; ?></td>
							</tr>
							<tr>
								<th>Customer City</th>
								<td><?php echo $cust_city; ?></td>
							</tr>
							<tr>
								<th>Customer State</th>
								<td><?php echo $cust_state; ?></td>
							</tr>
							<tr>
								<th>Customer Zip Code</th>
								<td><?php echo $cust_zip; ?></td>
							</tr>
						</tbody>
					</table>

					<h4 style="color:blue;margin-top:50px;">Billing Information</h4 style="color:blue;">
					<table class="table table-bordered table-striped">
						<tbody>
							<tr>
								<th style="width: 270px;">Customer Name</th>
								<td><?php echo $cust_b_name; ?></td>
							</tr>
							<tr>
								<th>Customer Company Name</th>
								<td><?php echo $cust_b_cname; ?></td>
							</tr>
							<tr>
								<th>Customer Phone</th>
								<td><?php echo $cust_b_phone; ?></td>
							</tr>
							<tr>
								<th>Customer Country</th>
								<td><?php echo $cust_b_country; ?></td>
							</tr>
							<tr>
								<th>Customer Address</th>
								<td><?php echo $cust_b_address; ?></td>
							</tr>
							<tr>
								<th>Customer City</th>
								<td><?php echo $cust_b_city; ?></td>
							</tr>
							<tr>
								<th>Customer State</th>
								<td><?php echo $cust_b_state; ?></td>
							</tr>
							<tr>
								<th>Customer Zip Code</th>
								<td><?php echo $cust_b_zip; ?></td>
							</tr>
						</tbody>
					</table>



					<h4 style="color:blue;margin-top:50px;">Shipping Information</h4 style="color:blue;">
					<table class="table table-bordered table-striped">
						<tbody>
							<tr>
								<th style="width: 270px;">Customer Name</th>
								<td><?php echo $cust_s_name; ?></td>
							</tr>
							<tr>
								<th>Customer Company Name</th>
								<td><?php echo $cust_s_cname; ?></td>
							</tr>
							<tr>
								<th>Customer Phone</th>
								<td><?php echo $cust_s_phone; ?></td>
							</tr>
							<tr>
								<th>Customer Country</th>
								<td><?php echo $cust_s_country; ?></td>
							</tr>
							<tr>
								<th>Customer Address</th>
								<td><?php echo $cust_s_address; ?></td>
							</tr>
							<tr>
								<th>Customer City</th>
								<td><?php echo $cust_s_city; ?></td>
							</tr>
							<tr>
								<th>Customer State</th>
								<td><?php echo $cust_s_state; ?></td>
							</tr>
							<tr>
								<th>Customer Zip Code</th>
								<td><?php echo $cust_s_zip; ?></td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>


</section>


<?php require_once('footer.php'); ?>