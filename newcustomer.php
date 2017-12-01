<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | New Customer</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>New Customer</h2>
                <?php
                    require_once("database.php");
                    
                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    } 
                    
                    //define variables as empty values
                    $titleErr = $suffixErr = $middlenameErr = $firstnameErr = $lastnameErr = $genderErr = $phoneErr = $emailErr = $shippingErr = $billingErr = $cityErr = $zipcodeErr = $stateErr = $entry = "";
                    $title = $firstname = $middlename = $lastname = $suffix = $gender = $phone = $email = $shipping = $billing = $city = $state = $zipcode = "";          
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        
                        $title = !empty($_POST['title']) ? "'".$_POST['title']."'" : "NULL";
                        if (!preg_match("/^[a-zA-Z.]*$/",$_POST['title'])) {
                            $titleErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in title</b><br>";
                        }
                        
                        $middlename = !empty($_POST['middlename']) ? "'".$_POST['middlename']."'" : "NULL";
                        if (!preg_match("/^[a-zA-Z.]*$/",$_POST['middlename'])) {
                            $middlenameErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in middle name</b><br>";
                        }
                        
                        $suffix = !empty($_POST['suffix']) ? "'".$_POST['suffix']."'" : "NULL";
                        if (!preg_match("/^[a-zA-Z.]*$/",$_POST['suffix'])) {
                            $suffixErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in suffix</b><br>";
                        }
                        
                        $state = testInput($_POST['state']);
                        if (empty(testInput($_POST['state']))) {
                            $stateErr = "<b><small class='asterisk'>*</small>State cannot be blank</b><br>";
                        }
                        
                        $gender = testInput($_POST['gender']);
                        if (empty(testInput($_POST['gender']))) {
                            $genderErr = "<b><small class='asterisk'>*</small>Gender cannot be blank</b><br>";
                        }
                        
                        $firstname = testInput($_POST['firstname']);
                        if (empty(testInput($_POST['firstname']))) {
                            $firstnameErr = "<b><small class='asterisk'>*</small>First name cannot be blank</b><br>";
                        } elseif(!preg_match("/^[a-zA-Z- ]*$/",$_POST['firstname'])) {
                            $firstnameErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in first name</b><br>";
                        }
                        
                        $lastname = testInput($_POST['lastname']);
                        if (empty(testInput($_POST['lastname']))) {
                            $lastnameErr = "<b><small class='asterisk'>*</small>Last name cannot be blank</b><br>";
                        } elseif (!preg_match("/^[a-zA-Z- ]*$/",$_POST['lastname'])) {
                            $lastnameErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in last name</b><br>";
                        }
                        
                        $phone = testInput($_POST['phone']);
                        if (empty(testInput($_POST['phone']))) {
                            $phoneErr = "<b><small class='asterisk'>*</small>Phone number cannot be blank</b><br>";
                        } elseif (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/",$_POST['phone'])) {
                            $phoneErr = "<b><small class='asterisk'>*</small>Invalid phone number</b><br>";
                        }
                        
                        $phoneCheck = $db->query("SELECT * FROM Customers WHERE phone_number LIKE '$phone'");
                        if ($phoneCheck->num_rows != 0) {
                            $phoneErr = "<b><small class='asterisk'>*</small>Phone number already in use</b><br>";
                        }
                        
                        $email = testInput($_POST['email']);
                        if (empty(testInput($_POST['email']))) {
                            $emailErr = "<b><small class='asterisk'>*</small>Email cannot be blank</b><br>";
                        }
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $emailErr = "<b><small class='asterisk'>*</small>Invalid email format</b><br>"; 
                        }
                        
                        $emailCheck = $db->query("SELECT * FROM Customers WHERE email LIKE '$email'");
                        if ($emailCheck->num_rows != 0) {
                            $emailErr = "<b><small class='asterisk'>*</small>Email already in use</b><br>";
                        }
                        
                        $shipping = testInput($_POST['shipping']);
                        if (empty(testInput($_POST['shipping']))) {
                            $shippingErr = "<b><small class='asterisk'>*</small>Shipping address cannot be blank</b><br>";
                        } elseif (!preg_match("/^[0-9a-zA-Z- ]*$/",$_POST['shipping'])) {
                            $shippingErr = "<b><small class='asterisk'>*</small>Invalid character(s) in shipping address</b><br>";
                        }
                        
                        $billing = testInput($_POST['billing']);
                        if (empty(testInput($_POST['billing']))) {
                            $billingErr = "<b><small class='asterisk'>*</small>Billing address cannot be blank</b><br>";
                        } elseif (!preg_match("/^[0-9a-zA-Z- ]*$/",$_POST['billing'])) {
                            $billingErr = "<b><small class='asterisk'>*</small>Invalid character(s) in billing address</b><br>";
                        }
                        
                        $city = testInput($_POST['city']);
                        if (empty(testInput($_POST['city']))) {
                            $cityErr = "<b><small class='asterisk'>*</small>City cannot be blank</b><br>";
                        } elseif (!preg_match("/^[a-zA-Z- ]*$/",$_POST['city'])) {
                            $cityErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in city</b><br>";
                        }
                        
                        $zipcode = testInput($_POST['zipcode']);
                        if (empty(testInput($_POST['zipcode']))) {
                            $zipcodeErr = "<b><small class='asterisk'>*</small>Zipcode cannot be blank</b><br>";
                        } elseif (!preg_match("/^[0-9]{5}$/",$_POST['zipcode'])) {
                            $zipcodeErr = "<b><small class='asterisk'>*</small>Invalid zipcode</b><br>";
                        }
                        
                        $sql = "INSERT INTO Customers (first_name, middle_name, last_name, title, suffix, gender, phone_number, email, shipping_address, billing_address, city, state, zip_code)
                            VALUES ('$firstname', ".$middlename.", '$lastname', ".$title.", ".$suffix.", '$gender', '$phone', '$email', '$shipping', '$billing', '$city', '$state', '$zipcode')";
                    
                        if (empty($titleErr . $suffixErr . $middlenameErr . $firstnameErr . $lastnameErr . $genderErr . $phoneErr . $emailErr . $shippingErr . $billingErr . $cityErr . $stateErr . $zipcodeErr)) {
                            $db->query($sql);
                            $entry = "<b>New customer: {$firstname} {$lastname}</b></br>";
                        } else {
                            $entry = "<b>New customer could not be created</b><br>";
                        }
                    }
                ?>
                <!-- New Customer Form -->
                <form class="data-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="title">Name<small class="asterisk">*</small></label>
                    <input style="margin-left:-2px;margin-right:-2px" type="text" placeholder="Mr." name="title" id="title" size="2" maxlength="255" value="<?php if($title != 'NULL') {echo $_POST['title'];}?>">
                    <input style="margin-left:-2px;margin-right:-2px" type="text" placeholder="John" name="firstname" size="7" maxlength="255" value="<?php echo $firstname;?>" required>
                    <input style="margin-left:-2px;margin-right:-2px" type="text" placeholder="R." name="middlename" size="1" maxlength="2" value="<?php if($middlename != 'NULL') {echo $_POST['middlename'];}?>">
                    <input style="margin-left:-2px;margin-right:-2px" type="text" placeholder="Doe" name="lastname" size="9" maxlength="255" value="<?php echo $lastname;?>" required>
                    <input style="margin-left:-2px" type="text" placeholder="Jr." name="suffix" size="2" maxlength="20" value="<?php if($suffix != 'NULL') {echo $_POST['suffix'];}?>">
                    <br>
                    <label for="gender">Gender<small class="asterisk">*</small></label>
                    <select class="genderDropdown" name="gender" id="gender" required>
                        <option value="" disabled selected hidden>-----</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                        </select>
                    <br>
                    <label for="phone">Phone<small class="asterisk">*</small></label>
                    <input type="tel" placeholder="123-456-7890" name="phone" id="phone" size="11" maxlength="12" value="<?php echo $phone;?>" required>
                    <label for="email">Email<small class="asterisk">*</small></label>
                    <input type="email" placeholder="example@example.com" name="email" id="email" size="21" maxlength="255" value="<?php echo $email;?>" required>
                    <br>
                    <label for="shipping">Shipping Address<small class="asterisk">*</small></label>
                    <input type="text" placeholder="123 Washington Street" name="shipping" id="shipping" size="25" maxlength="255" value="<?php echo $shipping;?>" required>
                    <br>
                    <label for="billing">Billing Address<small class="asterisk">*</small></label>
                    <input type="text" placeholder="456 MLK Drive" name="billing" id="billing" size="25" maxlength="255" maxlength="255" value="<?php echo $billing;?>" required>
                    <br>
                    <label for="city">City<small class="asterisk">*</small></label>
                    <input type="text" placeholder="Jackson" name="city" id="city" size="9" value="<?php echo $city;?>" required>
                    <label for="state">State<small class="asterisk">*</small></label>
                    <select name="state" id="state" required>
                        <option value="" disabled selected hidden>--</option>
                        <option value="Tennessee">TN</option>
                    </select>
                    <label for="zipcode">Zip Code<small class="asterisk">*</small></label>
                    <input type="text" placeholder="38305" name="zipcode" id="zipcode" size="4" maxlength="5" value="<?php echo $zipcode;?>" required>
                    <br>
                    <input style="margin-bottom:0.25em" type="submit" name="Submit" value="Submit"><br>
                    <input style="margin-top:0.25em" type="reset" name="Reset"><br><br>
                    <?php echo $titleErr;?>
                    <?php echo $firstnameErr;?>
                    <?php echo $middlenameErr;?>
                    <?php echo $lastnameErr;?>
                    <?php echo $suffixErr;?>
                    <?php echo $genderErr;?>
                    <?php echo $phoneErr;?>
                    <?php echo $emailErr;?>
                    <?php echo $shippingErr;?>
                    <?php echo $billingErr;?>
                    <?php echo $cityErr;?>
                    <?php echo $stateErr;?>
                    <?php echo $zipcodeErr;?>
                    <?php echo $entry;?><br>
                    <b style="font-size:0.8em;cursor:default"><small class="asterisk">*</small>Required Fields</b>
                </form>
                <?php $db->close();?>
            </div>
            <script src="js/nav.js"></script>
            <script src="js/formreset.js"></script>
        </body>
        <?php include("essential/footer.php");?>
</html>