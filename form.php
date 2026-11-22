<?php 
$name = $phone = $email = $comments = '';
$nameErr = $phoneErr = $emailErr = '';

function form_input ($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}   

if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
    if (empty($_POST['name'])) {
        $nameErr = "This is a required field!";
    } else {
        $name = form_input ($_POST['name']);

        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Only letters and whitespace allowed!";
        }
    }

    if (empty($_POST['phone'])) {
        $phoneErr = "This is a required field!";
    } else {
        $phone = form_input ($_POST['phone']);

        if (!preg_match($phone, '/^[0-9]{10}+$/')) {
            $phoneErr = "Please enter a valid phone number!";
        }
    }
    
    if (empty($_POST['email'])) {
        $emailErr = "This is a required field!";
    } else {
        $email = form_input ($_POST['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Please enter a valid email";
        }
    }
    
    if (empty($_POST['comments'])) {
        $comments = "";
    } else {
        $comments = form_input ($_POST['comments']);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation Form</title>
    <link rel="stylesheet" href="./styles.css">
    <script src="./ijquery.js"></script>
    <script src="./ivalidate.js"></script>

    <script>
        $(document).ready(function() {
            jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
			    phone_number = phone_number.replace(/\s+/g, ""); 
				return this.optional(element) || phone_number.length > 9 &&
					phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
			}, "Please specify a valid phone number");

            $('#form').validate();
        });
    </script>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="form">
        <fieldset>
            <label for="name">Name: <em>*</em></label>
            <input type="text" name="name" class="required" id="name" > <span><?php echo $nameErr; ?></span>

            <label for="phone">Phone (000-000-0000): <em>*</em></label>
			<input type="text" name="phone" id="phone" class="required phoneUS" > <span><?php echo $phoneErr; ?></span>

            <label for="email">Email: <em>*</em></label>
			<input type="text" name="email" id="email" class="required email" > <span><?php echo $emailErr; ?></span>
				
			<label for="comments">Comments:</label>
			<textarea name="comments" id="comments" rows="3" cols="40"></textarea> 
        
            <p class="required_msg">* required fields</p>
				
			<input type="submit" name="submit" id="submit">
        </fieldset>
    </form>
    
    <h1>Form verification on Form Page</h1>
   
    </body>
</body>
</html>