<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | New Inventory</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>New Inventory</h2>
                <?php
                    require_once("database.php");
                    
                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    } 
                    
                    //define variables as empty values
                    $memeErr = $categoryErr = $sizeErr = $descErr = $codeErr = $entry = "";
                    $meme = $category = $size = $desc = $quantity = $subcode1 = $subcode2 = $subcode3 = $code = $unitprice = $unitweight = "";          
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        
                        $meme = testInput($_POST['meme']);
                        if (empty(testInput($_POST['meme']))) {
                            $memeErr = "<b><small class='asterisk'>*</small>Meme is required</b><br>";
                        }
                        
                        $category = testInput($_POST['category']);
                        if (empty(testInput($_POST['category']))) {
                            $categoryErr = "<b><small class='asterisk'>*</small>Category is required</b><br>";
                        }
                        
                        $size = testInput($_POST['size']);
                        if (empty(testInput($_POST['size']))) {
                            $sizeErr = "<b><small class='asterisk'>*</small>Size is required</b><br>";
                        }
                        
                        $desc = testInput($_POST['description']);
                        if (empty(testInput($_POST['description']))) {
                            $descErr = "<b><small class='asterisk'>*</small>Description cannot be blank</b><br>";
                        } elseif (!preg_match("/^[a-zA-Z0-9-. ]*$/",$_POST['firstname'])) {
                            $descErr = "<b><small class='asterisk'>*</small>Invalid character(s) in description</b><br>";
                        }
                        
                        switch ($meme) {
                            case "Pepe":
                                $subcode1 = "000";
                                break;
                            case "Jake Paul":
                                $subcode1 = "001";
                                break;
                            case "Sanic":
                                $subcode1 = "002";
                                break;
                            case "Big Shaq":
                                $subcode1 = "003";
                                break;
                            case "Boneless Pizza":
                                $subcode1 = "004";
                                break;
                            default:
                                $subcode1 = "";
                        }
                        
                        switch ($category) {
                            case "Mug":
                                $subcode2 = "0";
                                break;
                            case "Thermos":
                                $subcode2 = "1";
                                break;
                            case "Canteen":
                                $subcode2 = "2";
                                break;
                            case "Wine Glass":
                                $subcode2 = "3";
                                break;
                            case "Glass Bottle":
                                $subcode2 = "4";
                                break;
                            default:
                                $subcode2 = "";
                        }
                        
                        switch ($size) {
                            case "Regular":
                                $subcode3 = "0";
                                break;
                            case "Small":
                                $subcode3 = "1";
                                break;
                            case "Medium":
                                $subcode3 = "2";
                                break;
                            case "Large":
                                $subcode3 = "3";
                                break;
                            default:
                                $subcode3 = "";
                        }

                        $code = $subcode1 . "-" . $subcode2 . "-" . $subcode3;
                        $quantity = testInput($_POST['quantity']);
                        $unitprice = testInput($_POST['unitprice']);
                        $unitweight = testInput($_POST['unitweight']);
                        
                        $codeCheck = $db->query("SELECT * FROM Inventory WHERE product_code LIKE '$code'");
                        if ($codeCheck->num_rows != 0) {
                            $codeErr = "<b><small class='asterisk'>*</small>Product already exists</b><br>";
                        }
                        
                        $productname = $meme . " " . $category;
                        
                        $sql = "INSERT INTO Inventory (product_code, name, description, category, size, unit_price, unit_weight_lb, in_stock)
                            VALUES ('$code', '$productname', '$desc', '$category', '$size', '$unitprice', '$unitweight', '$quantity')";
                    
                        if (empty($memeErr . $categoryErr . $sizeErr . $descErr . $codeErr)) {
                            $db->query($sql);
                            $entry = "<b>New item: {$productname} ({$size})</b></br>";
                        } else {
                            $entry = "<b>New item could not be created</b><br>";
                        }
                    }
                ?>
                <!-- New Customer Form -->
                <form class="data-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="meme">Meme<small class="asterisk">*</small></label>
                    <select class="memeDropdown" name="meme" id="meme" required>
                        <option value="" disabled selected hidden>--------------</option>
                        <option value="Pepe">Pepe</option>
                        <option value="Jake Paul">Jake Paul</option>
                        <option value="Sanic">Sanic</option>
                        <option value="Big Shaq">Big Shaq</option>
                        <option value="Boneless Pizza">Boneless Pizza</option>
                    </select>
                    <label for="category">Category<small class="asterisk">*</small></label>
                    <select class="categoryDropdown" name="category" id="category" required>
                        <option value="" disabled selected hidden>------------</option>
                        <option value="Mug">Mug</option>
                        <option value="Thermos">Thermos</option>
                        <option value="Canteen">Canteen</option>
                        <option value="Wine Glass">Wine Glass</option>
                        <option value="Glass Bottle">Glass Bottle</option>
                    </select>
                    <label for="size">Size<small class="asterisk">*</small></label>
                    <select class="sizeDropdown" name="size" id="size" required>
                        <option value="" disabled selected hidden>--------</option>
                        <option value="Regular">Regular</option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                    </select>
                    <br>
                    <br>
                    <label for="description">Description<small class="asterisk">*</small></label>
                    <br>
                    <div style="width:100%;text-align:center">
                        <textarea name="description" id="description" class="descBox" rows="10" maxlength="500" placeholder="Type the item's description here. Maximum of 500 characters." value="<?php echo $desc?>" required></textarea>
                    </div>
                    <br>
                    <label for="quantity">Quantity<small class="asterisk">*</small></label>
                    <input type="number" name="quantity" id="quantity" min="0" step="1" oninput="validity.valid||(value='');" required>
                    <label for="unitprice">Unit Price<small class="asterisk">*</small></label>
                    <input type="number" name="unitprice" id="unitprice" min="0" step=".01" oninput="validity.valid||(value='');" required>
                    <label for="unitweight">Unit Weight<small class="asterisk">*</small></label>
                    <input type="number" name="unitweight" id="unitweight" min="0" step=".01"  oninput="validity.valid||(value='');" required>
                    <br>
                    <input style="margin-bottom:0.25em" type="submit" name="Submit" value="Submit"><br>
                    <input style="margin-top:0.25em" type="reset" name="Reset"><br><br>
                    <?php echo $memeErr;?>
                    <?php echo $categoryErr;?>
                    <?php echo $sizeErr;?>
                    <?php echo $descErr;?>
                    <?php echo $codeErr;?>
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