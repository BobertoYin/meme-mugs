<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | New Employee</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>New Employee</h2>
                <?php
                    require_once("database.php");
                    
                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    } 
                    
                    //define variables as empty values
                    $suffixErr = $middlenameErr = $firstnameErr = $lastnameErr = $genderErr = $occupationErr = $deliveryareaErr = $phoneErr = $emailErr = $addressErr = $cityErr = $zipcodeErr = $stateErr = $entry = "";
                    $firstname = $middlename = $lastname = $suffix = $gender = $occupation = $deliveryarea = $phone = $email = $address = $city = $state = $zipcode = "";          
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        
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
                        
                        $occupation = testInput($_POST['occupation']);
                        if (empty(testInput($_POST['occupation']))) {
                            $occupationErr = "<b><small class='asterisk'>*</small>Occupation cannot be blank</b><br>";
                        }
                        
                         $firstname = testInput($_POST['firstname']);
                        if (empty(testInput($_POST['firstname']))) {
                            $firstnameErr = "<b><small class='asterisk'>*</small>First name cannot be blank</b><br>";
                        } elseif(!preg_match("/^[a-zA-Z- ]*$/",$_POST['firstname'])) {
                            $firstnameErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in name</b><br>";
                        }
                        
                        $lastname = testInput($_POST['lastname']);
                        if (empty(testInput($_POST['lastname']))) {
                            $lastnameErr = "<b><small class='asterisk'>*</small>Last name cannot be blank</b><br>";
                        } elseif (!preg_match("/^[a-zA-Z- ]*$/",$_POST['lastname'])) {
                            $lastnameErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in name</b><br>";
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
                        
                        $address = testInput($_POST['address']);
                        if (empty(testInput($_POST['address']))) {
                            $addressErr = "<b><small class='asterisk'>*</small>Address cannot be blank</b><br>";
                        } elseif (!preg_match("/^[0-9a-zA-Z- ]*$/",$_POST['address'])) {
                            $addressErr = "<b><small class='asterisk'>*</small>Invalid character(s) in address</b><br>";
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
                        
                        if (testInput($_POST['occupation']) === "Deliverer") {
                            $deliveryarea = testInput($_POST['deliveryarea']);
                            if (empty(testInput($_POST['deliveryarea']))) {
                                $deliveryareaErr = "<b><small class='asterisk'>*</small>Delivery area cannot be blank for deliverers</b><br>";
                            } elseif (!preg_match("/^[a-zA-Z- ]*$/",$_POST['city'])) {
                                $deliveryareaErr = "<b><small class='asterisk'>*</small>Invalid character(s)/spacing in delivery area</b><br>";
                            }
                            
                            $deliveryBoy = "INSERT INTO Deliverers (first_name, last_name, delivery_area)
                                            VALUES ('$firstname', '$lastname', '$deliveryarea')";
                                            
                            if (empty($deliveryareaErr)) {
                                $db->query($deliveryBoy);
                            }
                        }
                        
                        if (empty($suffixErr . $middlenameErr . $firstnameErr . $lastnameErr . $genderErr . $phoneErr . $emailErr . $addressErr . $cityErr . $stateErr . $zipcodeErr . $deliverareaErr)) {
                            $sql = "INSERT INTO Employees (first_name, middle_name, last_name, suffix, gender, occupation, phone_number, email, address, city, state, zip_code)
                            VALUES ('$firstname', ".$middlename.", '$lastname', ".$suffix.", '$gender', '$occupation', '$phone', '$email', '$address', '$city', '$state', '$zipcode')";
                            
                            $db->query($sql);
                            $entry = "<b>New employee: {$firstname} {$lastname}</b></br>";
                        } else {
                            $entry = "<b>New employee could not be created</b></br>";
                        }
                    }
                    
                ?>
                <!-- New Customer Form -->
                <form class="data-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="firstname">Name<small class="asterisk">*</small></label>
                    <input style="margin-left:-2px;margin-right:-2px" type="text" placeholder="John" name="firstname" id="firstname" size="7 " maxlength="255" value="<?php echo $firstname;?>" required>
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
                    <label for="occupation">Occupation<small class="asterisk">*</small></label>
                    <select class="occupationDropdown" name="occupation" id="occupation" required>
                        <option value="" disabled selected hidden>-------</option>
                        <option value="Manager">Manager</option>
                        <option value="Cashier">Cashier</option>
                        <option value="Stocker">Stocker</option>
                        <option value="Packager">Packager</option>
                        <option value="Deliverer">Deliverer</option>
                    </select>    
                    <label for="deliveryarea">Delivery Area</label>
                    <input type="text" placeholder="Jackson" name="deliveryarea" id="deliveryarea" size="9" maxlength="255" value="<?php echo $deliveryarea;?>">
                    <br>
                    <label for="phone">Phone<small class="asterisk">*</small></label>
                    <input type="tel" placeholder="123-456-7890" name="phone" id="phone" size="11" maxlength="12" value="<?php echo $phone;?>" required>
                    <label for="email">Email<small class="asterisk">*</small></label>
                    <input type="email" placeholder="example@example.com" name="email" id="email" size="21" maxlength="255" value="<?php echo $email;?>" required>
                    <br>
                    <label for="address">Address<small class="asterisk">*</small></label>
                    <input type="text" placeholder="123 Washington Street" name="address" id="address" size="25" maxlength="255" value="<?php echo $address;?>" required>
                    <br>
                    <label for="city">City<small class="asterisk">*</small></label>
                    <input type="text" placeholder="Jackson" name="city" id="city" size="9" maxlength="255" value="<?php echo $city;?>" required>
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
                    <?php echo $firstnameErr;?>
                    <?php echo $middlenameErr;?>
                    <?php echo $lastnameErr;?>
                    <?php echo $suffixErr;?>
                    <?php echo $genderErr;?>
                    <?php echo $occupationErr;?>
                    <?php echo $deliveryareaErr;?>
                    <?php echo $phoneErr;?>
                    <?php echo $emailErr;?>
                    <?php echo $addressErr;?>
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