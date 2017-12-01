<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | Update Stock</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>Update Stock</h2>
                <?php
                    require_once("database.php");
                    
                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    } 
                    
                    //define variables as empty values
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $product = $quantity = $entry = "";
                        
                        $product = $_POST['product'];
                        $quantity = $_POST['quantity'];
                        
                        $sql = "SELECT name, size FROM Inventory
                            where product_id = {$product}";
                        
                        $sql2 = "UPDATE Inventory
                                SET in_stock = '$quantity'
                                WHERE product_id = '$product'";
                        
                        $productname = $db->query($sql);
                        while($row = $productname->fetch_assoc()) {
                            $productNameEcho = $row["name"];
                            $productSizeEcho = $row["size"];
                        }
                        
                         $db->query($sql2);
                        $entry = "<b>Updated: {$quantity} of {$productNameEcho} ({$productSizeEcho})</b></br>";
                        
                    }
                ?>
                <!-- New Customer Form -->
                <form class="data-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="product">Product<small class="asterisk">*</small></label>
                    <select class="productDropdown" name="product" id="product" required>
                        <option value="" disabled selected hidden>--------------------------------</option>
                        <?php
                            $query = "SELECT product_id, name, size FROM Inventory
                                ORDER BY name";
                             $res = $db->query($query); 
                        
                           while ($row = $res->fetch_assoc()) 
                           {
                             echo '<option value=" '.$row['product_id'].' "> '.$row['name'].' ('.$row['size'].') </option>';
                           }
                        ?>
                    </select>
                    <br>
                    <label for="quantity">Quantity<small class="asterisk">*</small></label>
                    <input type="number" name="quantity" id="quantity" min="0" step="1" oninput="validity.valid||(value='');" required>
                    <br>
                    <input style="margin-bottom:0.25em" type="submit" name="Submit" value="Submit"><br>
                    <input style="margin-top:0.25em" type="reset" name="Reset"><br><br>
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