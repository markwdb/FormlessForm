<?php //ini_set("display_errors",true);
	/*
session_start();
	require_once("class/contactUsForm.class.php");			
	$contact_us_form = new ContactUsForm();
	if ($contact_us_form->submitted) {
		header ("Location: " . $contact_us_form->redirect);
	}
*/
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formless Form</title>
		<meta name="description" content=""/>
		<meta name="keywords" content=""/>
		<link rel="stylesheet" type="text/css" href="formless.css" />
		<script type="text/javascript" src="scripts/jquery.js"></script>
		<script type="text/javascript" src="scripts/formless.js"></script>
	</head>
	<body>
		<header>
			<div class="row">
				<div class="twelvecol">
					<h1>Formless</h1>
				</div>
			</div>
		</header>
		<section id="pagebody" class="main">		
			<section class="row">
				<div class="form sevencol last">
					<form action="" method="post" name="contact-form" id="contact-form">
						<input type="hidden" name="submitted" value="submitted" />
						<fieldset>
							<label for="name">Contact Name*</label>
							<p id="name" contenteditable>Mark Woodward</p>
<!-- 							<input type="text" id="name" name="name" value=""/> -->
				
							<label for="email">Email*</label>
							<input type="text" id="email" name="email" value="" class="email"/>		
						</fieldset>

						<label for="comments">Comments</label>
						<textarea  id="comments" name="comments"></textarea>
						<!--<fieldset class="captchacontainer">
							<label for="captcha_code">Enter Code *</label>
							<a name="captcha"></a>
							<img id="captcha" src="securimage/securimage_show.php?sid=aa097d8c309bb984dc146d2e9d67dcfa" alt="CAPTCHA Image" />
							<input id="captcha_code" class="" name="captcha_code" type="text" />
							<?php if ($contact_us_form->error_message) { ?>
								<p id="captcha_code_error" class="error"><?=$contact_us_form->error_message?></p>
							<?php } ?>
						</fieldset>-->
						<a href="#" id="submit">SUBMIT</a>
						<fieldset class="buttons">
							<p class="req">All fields marked '*' are required.</p>
							<button type="submit">Send Enquiry</button>
						</fieldset>
					</form>
				</div>
				
			</section>


		</section>


		<footer>
		</footer>
	</body>
</html>