<?php
session_start();

	$servername = 'localhost';
	$username   = 'root';
	$password   = '';
	$dbname     = 'reliable';
	 $conn      = new PDO( "mysql:host=$servername;dbname=$dbname", $username, $password );



header( 'Content-Type: application/json; charset=UTF-8' );
$obj = json_decode( $_POST['x'], false );

$li = 0;

if ( $_SESSION['page'] == 1 ) {
	$_SESSION['page']++;
	try {


		$stmt = $conn->prepare(
			'INSERT INTO customer_details (first_name, last_name, address, city, state, phone, email) VALUES (
	:fn,
    :ln,
    :add,
    :city,
    :state,
    :phone,
    :email)'
		);
		$stmt->bindParam( ':fn', $obj->fn );
		$stmt->bindParam( ':ln', $obj->ln );
		$stmt->bindParam( ':add', $obj->add );
		$stmt->bindParam( ':city', $obj->city );
		$stmt->bindParam( ':state', $obj->state );
		$stmt->bindParam( ':phone', $obj->phone );
		$stmt->bindParam( ':email', $obj->email );

		$stmt->execute();

		$li = $conn->lastInsertId();

		$_SESSION['id'] = $conn->lastInsertId();

	} catch ( PDOException $e ) {

		echo $e->getMessage();

	}



	echo '<div style="" id="page" class="col-sm-12" >' . $_SESSION['page'] . ' </div>
<div style="display:none;" id="status" class="alert alert alert-danger col-sm-12 " >The card length should be 16 digits</div>
<div class="form-group col-sm-6 ">
    <label for="ct">Card Type</label>
    <input required type="text" class="form-control" id="ct" placeholder="Card Type">
  </div>

  <div class="form-group col-sm-6 ">
    <label for="cn">Card Number</label>
    <input required type="number" pattern="[0-9]{16}" minlength="16" class="form-control" id="cn" placeholder="Card Number">
  </div>
 
 <div class="form-group col-sm-6 ">
    <label for="exp">Expiration Date</label>
    <input required type="date" class="form-control" id="exp" >
 </div>

   <div class="form-group col-sm-6 ">
    <label for="CVV">Verification Code</label>
    <input required type="number" class="form-control" id="cvv" placeholder="CVV2">
  </div>

  
  
  <button type="submit" class="btn btn-primary">Submit</button>';


} elseif ( $_SESSION['page'] == 2 ) {


		$stmt2 = $conn->prepare(
			'INSERT INTO payment_details (card_type, customer_id, card_number,card_exp_date) VALUES (
	:ct,
    :cid,
    :cn,
    :exp)'
		);

	$li = $conn->lastInsertId();

	$stmt2->bindParam( ':ct', $obj->ct );
	$stmt2->bindParam( ':cid', $_SESSION['id'] );
	$stmt2->bindParam( ':cn', $obj->cn );
	$stmt2->bindParam( ':exp', $obj->exp );
	$stmt2->execute();

	$third = 'SELECT * FROM customer_details
WHERE customer_id = ' . $_SESSION['id'] . '';

	$q = $conn->query( $third );
	$q->setFetchMode( PDO::FETCH_ASSOC );
	// echo $row;
	while ( $row = $q->fetch() ) {
		echo '
<ul class="list-group col-sm-6 ">
  <li class="list-group-item">FirstName:' . $row['first_name'] . '</li>
  <li class="list-group-item">LastName:' . $row['last_name'] . '</li>
  <li class="list-group-item">Address:' . $row['address'] . '</li>
  <li class="list-group-item">City:' . $row['city'] . '</li>
  <li class="list-group-item">ID:' . $row['customer_id'] . '</li>
  <li class="list-group-item">State:' . $row['state'] . '</li>
  <li class="list-group-item">Phone:' . $row['phone'] . '</li>
  <li class="list-group-item">Email:' . $row['email'] . '</li>
</ul>
';
	}

	$credit = 'SELECT * FROM payment_details
WHERE customer_id = ' . $_SESSION['id'] . '';

	$passed = $obj->luhn ? 'PASSED' : 'FAILED';

	$c = $conn->query( $credit );
	$c->setFetchMode( PDO::FETCH_ASSOC );
	while ( $row = $c->fetch() ) {
		echo '
<ul class="list-group col-sm-6">
  <li class="list-group-item">Card Type:' . $row['card_type'] . '</li>
  <li class="list-group-item">Card Number:' . $row['card_number'] . '</li>
  <li class="list-group-item">Exp Date:' . $row['card_exp_date'] . '</li>
  <li class="list-group-item">ID:' . $row['customer_id'] . '</li>

  <li class="list-group-item">Luhn ALgorithm Check:' . $passed . '</li>
</ul>
';
	}
}

