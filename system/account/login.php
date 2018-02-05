<?php include('functions.php') ?>

<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<title>Donut World</title>
	<script src='https://code.jquery.com/jquery-3.2.1.min.js'></script> <!--link jquery -->
	<!-- Links bootstrap -->
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>

	<link rel='stylesheet' type='text/css' href='../../style.css' media='screen'>
	<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>


<body>
<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-3">
		<div class="loginformular">
			<div class='accountheader'>
				<div class="row">
					<div class="col-sm-4">
					</div>
					<div class="col-sm-4">
						<a href='../../index.php'>
							<img class='img-responsive' src="../../bilder/logo.png" width="75%" title="Donut World Startseite" alt="Logo Donut World">
						</a>
					</div>
					<div class="col-sm-4">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4">
					</div>
					<div class="col-sm-4">
						<h2>Login</h2>
					</div>
					<div class="col-sm-4">
					</div>
				</div>
			</div>
			<br>

			<form method='post' action='login.php'>


				<div class="row">
					<div class='input-group'>
						<div class="col-sm-4">
						</div>
						<div class="col-sm-4">
							<label>E-Mail</label> <br>
							<input type='text' name='email' placeholder="E-Mail" style="width: 200px" maxlength="50">
						</div>
						<div class="col-sm-4">
						</div>
					</div>
				</div>

                <br>

				<div class="row">
					<div class='input-group'>
						<div class="col-sm-4">
						</div>
						<div class="col-sm-4">
							<label>Passwort</label> <br>
							<input type='password' name='passwort' placeholder="Passwort" style="width: 200px" maxlength="50">
						</div>
						<div class="col-sm-4">
						</div>
					</div>
				</div>

				<br>

				<?php echo display_error(); ?>


				<div class="row">
					<div class='input-group'>
						<div class="col-sm-4">
						</div>
						<div class="col-sm-4">
						</div>
						<div class="col-sm-4">
							<button type='submit' class='rosabutton' name='login_btn' title='Einloggen' >Einloggen</button>
						</div>
					</div>
				</div>

				<br>
				<br>

				<div class="row">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<p>
						Noch kein Kunde? <a href='register.php' style='color: grey;'>Hier registrieren</a><br><br>
							Zurück zur <a style='color: grey;' href='../../index.php'>Startseite</a>
						</p>
					</div>
				</div>
		</div>
	</div>
	<div class="col-sm-5">
	</div>

</div>
</form>
</body>
</html>