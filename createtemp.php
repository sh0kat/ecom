<?php
//connect to the database - either include a connection variable file
//or type the following lines:
require_once 'conn.inc.php';
//Define the temp table
$query = "CREATE TABLE carttemp(
carttemp_hidden INT(10) NOT NULL AUTO_INCREMENT,
carttemp_sess CHAR(50) NOT NULL,
carttemp_prodnum CHAR(5) NOT NULL,
carttemp_quan INT(3) NOT NULL,
PRIMARY KEY (carttemp_hidden),
KEY(carttemp_sess))";
$temp = mysql_query($query)
or die(mysql_error());
echo "Temporary cart table created successfully!";
?>