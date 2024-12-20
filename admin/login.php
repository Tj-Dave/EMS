<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Event Management System</title>
 	

<?php include('./header.php'); ?>
<?php
if(isset($_SESSION['login_id'])) {
	if($_SESSION['login_type'] == 1) {
		header("location:index.php?page=home"); // Admin
	} elseif ($_SESSION['login_type'] == 2) {
		header("location:../host/index.php?page=home"); // Host
	}
}
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		display: flex;
		align-items: center;
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>);*/
		background:#28a745;
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	#login-right .card{
		margin: auto;
		z-index: 1
	}
	#login-form, .card-body, .w-100{
		animation: fadeInUp 1s ease;
	}
	/*#login-form input {
		border-left: 0px;
		border-right: 0px;
		border-top: 0px;
	}*/
	.logo {
		margin: auto;
		font-size: 8rem;
		padding: .5em 0.8em;
		color: #000000b3;
		animation: fadeInUp 1s ease;
}

	.logo img {
		width: 600px;
		height: 600px;
		transition: width 0.5s ease-out, height 0.5s ease-out;
		animation: fadeInUp 1s ease;
	}
	.logo img:hover {
		width: 610px;
		height: 610px;
	}
	.register_here {
			color: #007bff;
			text-decoration: none;
		}
	.new_user_text {
		font-size: 1rem;
		font-style: italic;
		font-family: Verdana, Geneva, Tahoma, sans-serif;
	}
	.register_text {
		margin-top: 1rem;
	}
	.eye_icon {
		position: absolute;
		background-color: rgba(0, 0, 0, 0);
		border: 0px;
		top: 72%; /* Center the icon vertically within the input field */
		right: 4px; /* Adjust distance from the right side of the input field */
		transform: translateY(-50%); /* Perfect vertical centering */
		color: #28a745; /* Matches the text-success color */
		font-size: 18px; /* Adjust icon size */
		z-index: 2;
	}
	input.form-control {
		padding-right: 40px; /* Add padding to the input field so the text doesn't overlap the icon */
	}
	@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<body>


  <main id="main" class=" bg-black">
  		<div id="login-left">
  			<div class="logo">
				<a href="../">
  					<img src="assets/uploads/admin-logo/EMS.png" alt="EMS Logo">
				</a>
			</div>
  		</div>

  		<div id="login-right">
  			<div class="w-100">
  				<h4 class="text-success text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
  				<br>

  			<div class="card col-md-8">
  				<div class="card-body">
  						
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label text-success">Username</label>
  							<input type="text" id="username" name="username" class="form-control" placeholder="Enter Username">
  						</div>
  						<div class="form-group" style="position:relative">
  							<label for="password" class="control-label text-success">Password</label>
  							<input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
							  <span class="eye_icon input-group-text" id="togglePassword" style="cursor: pointer;">
								<i class="fa fa-eye"></i>
							</span>
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-success">Login</button></center>
						<div class="register_text">
							<a class="new_user_text">Want to register as host?
								
							</a><a class="register_here" href="mailto:<?php echo $_SESSION['system']['email']?>"> Click Here </a> <a class="new_user_text">to contact Admin.</a>
						</div>
  					</form>
  				</div>
  			</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	document.getElementById('togglePassword').addEventListener('click', function () {
		const passwordInput = document.getElementById('password');
		const icon = this.querySelector('i');
		
		// Toggle the type attribute
		if (passwordInput.type === 'password') {
			passwordInput.type = 'text';
			icon.classList.remove('fa-eye');
			icon.classList.add('fa-eye-slash');
		} else {
			passwordInput.type = 'password';
			icon.classList.remove('fa-eye-slash');
			icon.classList.add('fa-eye');
		}
		});

	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
			},
			success:function(resp){
				console.log(resp);
				if(resp == 1){
					location.href ='index.php?page=home';
				}else if(resp == 2){
					location.href ='../host/';

				}else if(resp == 3){
					$('#login-form').prepend('<div class="alert alert-danger">Missing Username.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>