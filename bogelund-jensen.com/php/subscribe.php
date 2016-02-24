<?php


/* === Subscription Settings === */
// Choose a method for the subscribed email addresses to be saved or sent. You can choose both options to be used at the same time, i.e. store in MySQL and email you.

// To save email addresses into MySQL Server, set the following variable to 'true' and add in your MySQL connection settings below. Settings this to 'false' will disable all usage of MySQL, such as checking if addresses is already subscribed.
$saveToMySQL = 'false';

// To receive an email notification containing subscribed address (i.e. Joe Bloggs has subscribed, email address: joe@bloggs.net), set the following variable to 'true' and add in your email notification settings below
$sendToEmail = 'true';
	
// To subscribe the given email address to your MailChimp list, set the following variable to 'true' and update your MailChimp settings belowl
$mailChimpList = 'false';

	
	

/* === MySQL Connection Settings === */
// Change these details with the correct information for your server

// Host name, domain or IP Address for MySQL Database location
$mysql_host = "mysql8.gigahost.dk";

// Username for MySQL Access
$mysql_username = "signe";

// Password for MySQL Access
$mysql_password = "jensen";

// Name of MySQL Database to use
$mysql_database = "signe_bogelundjensen";

// Name of MySQL table where email information will be stored
$mysql_table = "signups";



/* === Email Notification Settings === */
// Change these details so notification emails can be sent to you

// Email address to send notifications to
$myEmail = "adam@wearecrunch.dk";

// Where email is 'from', i.e. when you read email it will say From: (whatever you say). Add a name then email address you have setup inbetween the < and >
$emailFrom = "Bogelund-Jensen.com <adam@wearecrunch.dk>";



/* === MailChimp Configuration and Settings === */
// Change these details according to information available from your MailChimp account - see documentation for more help

// Enter your MailChimp API Key - see http://admin.mailchimp.com/account/api
$apikey = 'API KEY HERE';

// List ID is required in order to decide which of your lists to subscribe users to. This can be found by loggin into your MailChimp account and by going to Lists --> List Tools, and List ID entry at bottom of page. See Documentation for more info
$listId = 'LIST ID HERE';



/* === Error / Success Messages === */
// Change these details with your own custom messages if you wish

// Error message if no email is entered
$emailempty_errormsg = "Please enter an address.";

// Error message if email is invalid
$invalidemail_errormsg = "That's not a valid email address.";

// Error message if another error occurred (such as could not insert data into database)
$insertfailure_errormsg = "Error. Try again.";

// Error message if email address already exists in the database
$emailexists_errormsg = "That address is already subscribed.";

// Success message once email address is successfully stored in database
$subscriptionsuccess_msg = "Thanks for subscribing! You'll hear from us soon.";








/* === BEGIN PHP SCRIPT === */

if(isset($_GET['action'])) {
	if($_GET['action'] == 'signup'){
		
		if($saveToMySQL == 'true') {
			mysql_connect($mysql_host,$mysql_username,$mysql_password);  
			mysql_select_db($mysql_database);
		}
		
		// Sanitize Email Address (for security)
		$email = $_POST['signup-email'];
		if($saveToMySQL == 'true') { $email = mysql_real_escape_string($email); }
		$email = strip_tags($email);
		
		// Check / store emails
			if(empty($email)){
				$status = "error";
				$returnmessage = $emailempty_errormsg;
			}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // Validate Email Address (If browser does not support HTML5 auto email validation)
				$status = "error";
				$returnmessage = $invalidemail_errormsg;
			}
			else {
				$date = date('Y-m-d'); // Get the current date to store with email in database
				$time = date('H:i:s'); // Get the current time to store with email in database
						
				if($saveToMySQL == 'true') {
					$emailexist = mysql_query("SELECT * FROM $mysql_table WHERE signup_email_address='$email'"); // Check if entered email already exists in the database 
					if(mysql_num_rows($emailexist) < 1) {
						$date = date('Y-m-d'); // Get the current date to store with email in database
						$time = date('H:i:s'); // Get the current time to store with email in database
						
						$insertEmail = mysql_query("INSERT INTO $mysql_table (signup_email_address, signup_date, signup_time) VALUES ('$email','$date','$time')"); // Insert email address into MySQL table, or remove this for a custom way to save addresses
						if($insertEmail){
							$status = "success";
							$returnmessage = $subscriptionsuccess_msg;
						}
						else {
							$status = "error";
							$returnmessage = $insertfailure_errormsg;
						}
					}
					else { // if already signed up
						$status = "error";
						$returnmessage = $emailexists_errormsg;
					}
				}
				
				if($sendToEmail == 'true') {
					$date = date('Y-m-d'); // Get the current date to store with email in database
					$time = date('H:i:s'); // Get the current time to store with email in database
					
					$to = $myEmail;
					$subject = "A new user has subscribed!";
					$message = "A new user has subscribed. <br />Email address: ". $email ."<br />Time: ". $time ."<br />Date: ". $date;
					$from = $emailFrom;
					$headers = "From:" . $from ."\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					mail($to,$subject,$message,$headers);

							$status = "success";
							$returnmessage = $subscriptionsuccess_msg;
				}
				
				if($mailChimpList == 'true') {
					require_once 'mailchimp/MCAPI.class.php';
					
					$api = new MCAPI($apikey);
					
					// By default this sends a confirmation email - you will not see new members
					// until the link contained in it is clicked!
					$retval = $api->listSubscribe( $listId, $email );
					
					if ($api->errorCode){
						$status = "error";
						$returnmessage = $emailexists_errormsg;
					}
					else {
						$status = "success";
						$returnmessage = $subscriptionsuccess_msg;
					}
				}
			}
			
	// JSON response
	$data = array(
		'status' => $status,
		'returnmessage' => $returnmessage
	);
	
	echo json_encode($data);
	exit;
	}
}
?>