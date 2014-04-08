<?php
$conn = mysqli_connect("127.0.0.1", "root", "") or die(mysqli_error($conn));
$db = mysqli_select_db($conn,"ecom") or die(mysqli_error($conn)); 
?>
