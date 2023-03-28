<?php
session_start();

$_SESSION['page'] = 1;

require 'database.php';

createTables();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Checkout Form </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>



   <div class="jumbotron align-items-center bg-primary" style="text-align: center;color: white;" > <h1>Checkout</h1> </div>
   <div class="container" >

<form id="myForm" class="row" style="padding: 10px;">
  <div style="" class="col-sm-12" id="page" ><?php echo $_SESSION['page']; ?> </div>

  <div class="form-group col-sm-6 ">
	<label for="fn">First Name</label>
	<input required type="text" class="form-control" id="fn" placeholder="First Name">
  </div>

  <div class="form-group col-sm-6 ">
	<label for="ln">Last Name</label>
	<input required type="text" class="form-control" id="ln" placeholder="Last Name">
  </div>
 
 <div class="form-group col-sm-12 ">
	<label for="Address">Address</label>
	<textarea required class="form-control" id="Address" rows="3"></textarea>
 </div>

   <div class="form-group col-sm-6 ">
	<label for="city">City</label>
	<input type="text" required class="form-control" id="city" placeholder="City">
  </div>
   <div class="form-group col-sm-6 ">
	<label for="state">State</label>
	<input type="text" required class="form-control" id="state" placeholder="State">
  </div>

  <div class="form-group col-sm-6 ">
	<label for="Phone">Phone</label>
	<input type="tel" required  pattern="[0-9]{10}" class="form-control" id="Phone" placeholder="Phone Number">
  </div>

  <div class="form-group col-sm-6 ">
	<label for="email">Email</label>
	<input type="email" required  class="form-control" id="email" placeholder="Your Email">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</body>

<script type="text/javascript" src="luhn.js" ></script>
<script type="text/javascript">
 
//sconsole.log(form);
  document.getElementById('myForm').addEventListener('submit',   function (event){
	console.log('11');
	event.preventDefault();

var page = document.getElementById('page').innerHTML;

var send = true;

console.log(page);

if(page == 1){

var params = {
"fn":document.getElementById('fn').value,
"ln":document.getElementById('ln').value,
"add":document.getElementById('Address').value,
"city":document.getElementById('city').value,
"state":document.getElementById('state').value,
"phone":document.getElementById('Phone').value,
"email":document.getElementById('email').value
}  
}
else if(page == 2){

  var length = document.getElementById('cn').value;

var result = luhn(length)
console.log(result);
  var params = {    
"ct":document.getElementById('ct').value,
"cn":document.getElementById('cn').value,
"exp":document.getElementById('exp').value,
"cvv":document.getElementById('cvv').value,
'luhn':result
  }

  if(length.length !== 16 ){
	
   var send = false;
   document.getElementById('status').style.display = 'block';
  }

}
console.log('dd');

var xmlhttp = new XMLHttpRequest();

 console.log(params);
var json = JSON.stringify(params);



xmlhttp.onreadystatechange = function(){
   if (this.readyState == 4 && this.status == 200) {
		document.getElementById("myForm").innerHTML = this.responseText;
		page.innerHTML = <?php echo $_SESSION['page']; ?>
	  }
}

xmlhttp.open("POST", "process.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
if (send == true) {
xmlhttp.send("x=" + json);


} 
	


  })


</script>
</html>
