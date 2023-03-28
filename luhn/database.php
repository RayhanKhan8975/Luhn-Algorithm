<?php

function createTables() {
	$servername = 'localhost';
	$username   = 'root';
	$password   = '';
	$dbname     = 'reliable';
	 $conn      = new PDO( "mysql:host=$servername;dbname=$dbname", $username, $password );

	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	$customer_details =
	'CREATE TABLE IF NOT EXISTS `customer_details` (
`customer_id` mediumint(10) NOT NULL AUTO_INCREMENT,
`first_name` char(25) NOT NULL,
`last_name` char(25) NOT NULL,
`address` char(100) NOT NULL,
`city` char(50) NOT NULL,
`state` char(2) NOT NULL,
`phone` BIGINT(10) UNSIGNED NOT NULL,
`email` varchar(100) NOT NULL,
PRIMARY KEY (`customer_id`)
);';

	$conn->exec( $customer_details );

	$credit_card =
	'CREATE TABLE IF NOT EXISTS `payment_details` (
`payment_id` mediumint(10) NOT NULL AUTO_INCREMENT,
`card_type` varchar(50) NOT NULL,
`customer_id` mediumint(10) NOT NULL,
`card_number` varchar(50) NOT NULL,
`card_exp_date` varchar(50) NOT NULL,      
PRIMARY KEY (`payment_id`),

FOREIGN KEY (`customer_id`) REFERENCES `customer_details`(`customer_id`) 
 ON DELETE CASCADE ON UPDATE CASCADE
);';

	$conn->exec( $credit_card );

}
