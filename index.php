<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | Orders</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>Orders</h2>
                <!-- Search Boxes -->
                <form action="" method="GET" class="searchbox">
                    <input class="searchBox" type ="search" placeholder ="Press Enter to Search..." name="search" size="24">
                </form>
                <button onclick="window.location.href='https://meme-market-bobertoyin.c9users.io/neworder.php';" class="new-entry">New Order</button>
                <?php
                    require_once("database.php");

                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    }
                    
                    $search = testInput($_GET['search']);
                    
                    if (empty($search) === TRUE) {
                        $sql = "SELECT date_format(order_date, '%l:%i %p %M %e, %Y') AS date, CONCAT(Customers.first_name,' ', IFNULL(CONCAT(Customers.middle_name, ' '),''), Customers.last_name) AS customer, Inventory.name, Inventory.size, Orders.quantity, CONCAT('$', Orders.quantity*Inventory.unit_price) AS total_price FROM Orders
                                INNER JOIN Inventory
                                    ON Inventory.product_id = Orders.product_id
                                INNER JOIN Customers
                                    ON Customers.customer_id = Orders.customer_id
                                ORDER BY order_date, Customers.last_name";
                    } else {
                        $sql = "SELECT date_format(order_date, '%l:%i %p %M %e, %Y') AS date, CONCAT(Customers.first_name, ' ', IFNULL(CONCAT(Customers.middle_name, ' '),''), Customers.last_name) AS customer, Inventory.name, Inventory.size, Orders.quantity, CONCAT('$', Orders.quantity*Inventory.unit_price) AS total_price FROM Orders
                                    INNER JOIN Inventory
                                        ON Inventory.product_id = Orders.product_id
                                    INNER JOIN Customers
                                        ON Customers.customer_id = Orders.customer_id
                                    WHERE date_format(order_date, '%l:%i %p %M %e, %Y') LIKE '%{$search}%' OR
                                    CONCAT(Customers.first_name, ' ', IFNULL(CONCAT(Customers.middle_name, ' '),''), Customers.last_name) LIKE '%{$search}%' OR
                                    name LIKE '%{$search}%' OR
                                    size LIKE '%{$search}%' OR
                                    quantity LIKE '%{$search}%' OR
                                    CONCAT('$', Orders.quantity*Inventory.unit_price) LIKE '%{$search}%'
                                    ORDER BY order_date, Customers.last_name";
                    }
                    $result = $db->query($sql);
                    
                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>Date</th><th>Name</th><th>Product</th><th>Size</th><th>Quantity</th><th>Total Price</th></tr>";
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row['date']."</td><td>".$row["customer"]."</td><td>".$row["name"]."</td><td>".$row["size"]."</td><td>".$row["quantity"]."</td><td>".$row["total_price"]."</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<table><tr><th>Date</th><th>Name</th><th>Product</th><th>Size</th><th>Quantity</th><th>Total Price</th></tr></table>";
                    }
                    $db->close();
                ?>
            </div>
            <script src="js/nav.js"></script>
        </body>
        <?php include("essential/footer.php");?>
</html>

<!-- 









-->