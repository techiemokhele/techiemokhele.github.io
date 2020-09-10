<?php 

	/*Including header page*/
	require_once "./includes/header.php";

 ?>

<!--Start Main page content-->

<?php 

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail() {

	// Load Composer's autoloader
	require 'vendor/autoload.php';

	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = 0;
	    
	    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
	    
	    $mail->isSMTP();                                            // Send using SMTP
	    
	    $mail->Host       = 'smtp.gmail.com';                    	// Set the SMTP server to send through
	    
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    
	    $mail->Username   = 'info.videosnap@gmail.com';             // SMTP username
	    
	    $mail->Password   = 'not-this-password';                            // SMTP password
	    
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    
	    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom('info.videosnap@gmail.com', 'Videosnap Support Team');
	    $mail->addAddress($_POST["email"]);     			// Add a recipient 
	    $mail->addReplyTo('info.videosnap@gmail.com', 'Videosnap Support Team');

	    // Attachments
	    $mail->addAttachment('media/img/favicon/android-chrome-192x192.png');         	// Add attachments
	    //$mail->addAttachment('media/img/favicon/android-chrome-192x192.png', 'videosnap.jpg');    		// Optional name*/

	    $body = 'Dear user 😊, <br><br>
					Thank you for contacting our support team. We are sorry for any inconvenience caused while using Videosnap.<br><br>

					We understand your concern and we will be in touch with you as soon as one of our agents are available. <br><br>

					Please don\'t hesitate to contact us again if you need any further assistance.<br><br>

					Have a wonderful day and enjoy using Videosnap! <br><br>

					<small>
						📇 Support Team: <b style="color:red;">Videosnap</b> <br>
						📲 Contact Number: <b style="color:#34b7f1;"><a href="https://api.whatsapp.com/send?phone=27617307564">Whatsapp Us</a></b>

					</small>
					';

	    // Content
	    $mail->isHTML(true);                                  		// Set email format to HTML
	    $mail->Subject = 'Query about Videosnap';
	    $mail->Body    = $body;
	    $mail->AltBody = strip_tags($body);

	    $mail->send();
	    $message = "<div class='alert alert-success'>
						<i class='fas fa-info'></i> Your email was sent successfully! We will be in touch soon. 
					</div>";
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

if (!isset($_POST["btnSubmit"])) {
	
} else {
	sendMail();
}
	
	echo '<div class="container contact-form">
	            <div class="contact-image">
	                <img src="media/img/icons/rocket_contact.png" alt="rocket_contact"/>
	            </div>
	            <form method="post">
	                <h3>Drop Us a Message</h3>
	               <div class="row">
	                    <div class="col-md-6">
	                        <div class="form-group">
	                            <input type="text" name="name" class="form-control" placeholder="Name *" value="" required/>
	                        </div>
	                        <div class="form-group">
	                            <input type="text" name="email" class="form-control" placeholder="Email *" value="" required/>
	                        </div>
	                        <div class="form-group">
	                            <input type="phone" name="mobile" class="form-control" placeholder="Mobile Number *" value=""required />
	                        </div>
	                        <div class="form-group">
	                            <input type="submit" name="btnSubmit" class="btnContact" value="Send" />
	                        </div>
	                    </div>
	                    <div class="col-md-6">
	                        <div class="form-group">
	                            <textarea name="message" class="form-control" placeholder="Your Message *" style="width: 100%; height: 150px; resize:none;" required></textarea>
	                        </div>
	                    </div>
	                </div>
	            </form>
			</div>';

 ?>

<!--End Main page content-->

 <?php 

	/*Including footer page*/
	require_once "./includes/footer.php";

 ?>			
