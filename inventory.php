<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | Inventory</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>Inventory</h2>
                <!-- Search Boxes -->
                <form action="" method="GET" class="searchbox">
                    <input class="searchBox" type ="search" placeholder ="Press Enter to Search..." name="search" size="24">
                </form>
                <button style="border-right: 1px solid black" onclick="window.location.href='https://meme-market-bobertoyin.c9users.io/newinventory.php';" class="new-entry">New Item</button>
                <button style="border-right: 1px solid black" onclick="window.location.href='https://meme-market-bobertoyin.c9users.io/updatestock.php';" class="new-entry">Update Stock</button>
                <button onclick="window.open('https://meme-market-bobertoyin.c9users.io/essential/productcodes.pdf');" class="new-entry">Item Code Key</button>
                
                <?php
                    require_once("database.php");

                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    } 
                    
                    $search = $_GET['search'];
                    
                    if (empty($search) === TRUE) {
                        $sql = "SELECT product_code, name, description, category, size, CONCAT('$', unit_price) AS price, CONCAT(unit_weight_lb, ' Lbs') AS weight, in_stock FROM Inventory
                                    ORDER BY category";
                    } else {
                        $sql = "SELECT product_code, name, description, category, size, CONCAT('$', unit_price) AS price, CONCAT(unit_weight_lb, ' Lbs') AS weight, in_stock FROM Inventory
                                    WHERE name LIKE '%{$search}%' OR
                                    product_code LIKE '%{$search}%' OR
                                    description LIKE '%{$search}%' OR
                                    category LIKE '%{$search}%' OR
                                    size LIKE '%{$search}%' OR
                                    CONCAT('$', unit_price) LIKE '%{$search}%' OR
                                    CONCAT(unit_weight_lb, ' Lbs') LIKE '%{$search}%' OR
                                    in_stock LIKE '%{$search}%' 
                                    ORDER BY category";
                    }
                    $result = $db->query($sql);
                    
                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>Product</th><th>Product Code</th><th>Description</th><th>Category</th><th>Size</th><th>Unit Price</th><th>Unit Weight</th><th>Units In Stock</th></tr>";
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row["name"]."</td><td>".$row["product_code"]."</td><td class='left-text-align'>".$row["description"]."</td><td>".$row["category"]."</td><td>".$row["size"]."</td><td>".$row["price"]."</td><td>".$row["weight"]."</td><td>".$row["in_stock"]."</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<table><tr><th>Product</th><th>Product Code</th><th>Description</th><th>Category</th><th>Size</th><th>Unit Price</th><th>Unit Weight</th><th>Units In Stock</th></tr></table>";
                    }
                    $db->close();
                ?>
            </div>
            <script src="js/nav.js"></script>
            <script src="js/stock.js"></script>
        </body>
        <?php include("essential/footer.php");?>
</html>