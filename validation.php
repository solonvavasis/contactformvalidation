<?php

//Setting default values for variables to avoid "undefined variable" errors
$FnameError ="";
$LnameError ="";
$genderError ="";
$emailError ="";
$phoneError ="";
$adressError ="";

//handling undefined index notice when $_POST isn't set
$first_name = isset($_POST['first_name'])?$_POST['first_name']:'';
$last_name = isset($_POST['last_name'])?$_POST['last_name']:'';
$gender= isset($_POST['gender'])?$_POST['gender']:'';
$email = isset($_POST['email'])?$_POST['email']:'';
$phone = isset($_POST['phone_number'])?$_POST['phone_number']:'';
$adress = isset($_POST['adress'])?$_POST['adress']:'';
$message = isset($_POST['message'])?$_POST['message']:'';
$selection = isset($_POST['selection'])?$_POST['selection']:'';


//if form is submitted then validate
if(isset($_POST['submit'])){
	//use if(empty($_POST["x"])) statement to check for empty fields
	if (empty($_POST["first_name"])) {
		$FnameError = "First name is required";
		$fn_error=true; //error handling: if input fails to validate, error=true, else error=false
		
	} else {
		$first_name = test_input($_POST["first_name"]);
		$first_name_error=false;
		
		// check first name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
			$FnameError = "Only letters allowed";
			$first_name_error=true;
			
		}
	}
	
	if (empty($_POST["last_name"])) {
		$LnameError = "Last Name is required";
		$last_name_error=true;
		
	} else {
		$last_name = test_input($_POST["last_name"]);
		$last_name_error=false;
		
		// check first name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
			$LnameError = "Only letters allowed";
			$last_name_error=true;
			
		}
	}
	
	if (empty($_POST["gender"])) {
		$genderError = "Gender is required";
		$gender_error=true;
		
	} else {
		$gender = test_input($_POST["gender"]);
		$gender_error=false;
		
	}

	
	if (empty($_POST["email"])) {
		$emailError = "Email is required";
		$email_error=true;
		
	} else {
		$email = test_input($_POST["email"]);
		$email_error=false;
		
		// check if e-mail address syntax is valid or not
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
			$emailError = "Invalid email format";
			$email_error=true;
			
		}
	}
	
	if (empty($_POST["phone_number"])) {
		$phoneError = "Phone is required";
		$phone_error=true;
		
	} else {
		$phone = test_input($_POST["phone_number"]);
		$phone_error=false;
		
		// check if phone is numeric or not
		if (!preg_match('/^[0-9]*$/', $phone)) {
			$phoneError = "Invalid phone format";
			$phone_error=true;
			
		}
	}
	
	if (empty($_POST["adress"])) {
		$adressError = "Adress is required";
		$adress_error=true;
		
	} else {
		$adress = test_input($_POST["adress"]);
		$adress_error=false;
		
		// check if phone syntax is numeric or not
		if (!preg_match('/^[A-Za-z0-9\s\-\\,.]*$/', $adress)) {
			$adressError = "Invalid adress format";
			$adress_error=true;
			
		}
	}
	
	if (empty($_POST["message"])) {
		$message = "";
		$message_error = false;
		
	} else {
		$message = test_input($_POST["message"]);
		$message_error=false;
		if (empty($_POST["first_name"])&&empty($_POST["last_name"])&&empty($_POST["gender"])&&empty($_POST["email"])&&empty($_POST["phone_number"])&&empty($_POST["adress"])){
			$message_error=true;
		}
	}
	
	
	// check for errors. if no errors were found, send email
	if(false === $first_name_error && false == $last_name_error && false == $gender_error && false == $email_error && false == $phone_error && false == $adress_error && false == $message_error && !empty($_POST["first_name"])&&!empty($_POST["last_name"])&&!empty($_POST["gender"])&&!empty($_POST["email"])&&!empty($_POST["phone_number"])&&!empty($_POST["adress"]))
	{
		//Validation Success!
		
		//Send Email
		//Mail will be send to the input email adress
		$to = $email;
		$subject = $selection;
		$txt = "First Name: " . $first_name . "\r\n" .
			   "Last Name: " . $last_name . "\r\n" .
			   "Gender: " . $gender . "\r\n" .
			   "Email: " . $email . "\r\n" .
			   "Phone: " . $phone . "\r\n" .
			   "Adress: " . $adress . "\r\n" .
			   "Message: " .$message . "\r\n" .
		$headers = "From: webmaster@example.com" . "\r\n" .
		"CC: somebodyelse@example.com";
		
		mail($to,$subject,$txt,$headers);
		
		//Form success and thank you message!
		header('Location: success.html');
	}
	
}


//function used inside if statements to check for html characters, unneeded spaces and quotes.
function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
}

?>


<!--HTML starts here-->

<!DOCTYPE HTML> 
<html>
	<head>
	<title>PHP Form Validation</title>
	<meta name="wtf" content="noindex, nofollow" />
	<link rel="stylesheet" href="style.css" />
    <link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
        <form method="post" action="validation.php" class="basic-grey">
            <h1>Contact Form 
                <span>Please fill all the texts in the fields. <span class="red_star">(* required field.)</span></span>
            </h1>
            <span class="error"> *<?php echo $FnameError;?></span>
            <label>
                <span>First Name :</span>
                <input id="name" type="text" name="first_name"  value="<?php echo htmlspecialchars($first_name); ?>" placeholder="Your First Name" />
            </label>
            
                <span class="error"> *<?php echo $LnameError;?></span> 
             <label>
                <span>Last Name :</span>
                <input id="name" type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" placeholder="Your Last Name" />
            </label>
            
            <span class="error"> *<?php echo $genderError;?></span>
            <label>
                <span>Gender :</span>
                <input id="gender" type="radio" name="gender" value="man"
				<?php if (isset($_POST[ 'gender']) && $_POST[ 'gender']=='man' ){echo ' checked="checked"';}?>/> Male
                <input id="gender" type="radio" name="gender" value="woman"
				<?php if (isset($_POST[ 'gender']) && $_POST[ 'gender']=='woman' ){echo ' checked="checked"';}?>/> Female
            </label>
            
            <span class="error"> *<?php echo $emailError;?></span>
            <label>
                <span>Email :</span>
                <input id="email" type="email" name="email"  value="<?php echo htmlspecialchars($email); ?>" placeholder="Valid Email Address" />
            </label>
            
            <span class="error"> *<?php echo $phoneError;?></span>
            <label>
                <span>Phone :</span>
                <input id="phone" type="text" name="phone_number" value="<?php echo htmlspecialchars($phone); ?>"placeholder="Your Phone Number" />
            </label>
            
            <span class="error"> *<?php echo $adressError;?></span>
            <label>
                <span>Adress :</span>
                <input id="adress" type="text" name="adress" value="<?php echo htmlspecialchars($adress); ?>"placeholder="Your Adress" />
            </label>
            
            
            <label>
                <span>Message :</span>
                <textarea id="message" name="message" value="<?php echo htmlspecialchars($message); ?>" placeholder="Your Message to Us"></textarea>
            </label> 
             <label>
                <span>Subject :</span><select name="selection">
                <option value="Job Inquiry">Job Inquiry</option>
                <option value="General Question">General Question</option>
                </select>
            </label>    
             <label>
                <span>&nbsp;</span> 
                <input type="submit" class="button"  name="submit" value="Send" /> 
            </label>    
		</form>
    
    </body>
</html>
    