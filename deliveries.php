<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | Deliveries</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>Deliveries</h2>
                <!-- Search Boxes -->
                <form action="" method="GET" class="searchbox">
                    <input class="searchBox" type ="search" placeholder ="Press Enter to Search..." name="search" size="24">
                </form>
                <?php
                    require_once("database.php");
                    
                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    } 
                    
                    $search = $_GET['search'];
                    
                    if (empty($search) === TRUE) {
                        $sql = "SELECT CONCAT('7:30 AM ', date_format(Orders.order_date + INTERVAL '3' DAY, '%m/%d/%Y')) AS date, CONCAT(IFNULL(CONCAT(Customers.title, ' '), ''),Customers.first_name, ' ', IFNULL(CONCAT(Customers.middle_name, ' '),''), Customers.last_name, IFNULL(CONCAT(' ',Customers.suffix, ' '), '')) AS customer, CONCAT(Customers.shipping_address, ', ', Customers.city, ', ', Customers.state, ' ', Customers.zip_code) AS address, CONCAT(Deliverers.first_name, ' ', Deliverers.last_name) AS deliverer, Inventory.name, Orders.quantity, CONCAT(Orders.quantity*Inventory.unit_weight_lb, ' Lbs') AS total_weight FROM Orders
                                INNER JOIN Inventory
                                    ON Inventory.product_id = Orders.product_id
                                INNER JOIN Customers
                                    ON Customers.customer_id = Orders.customer_id
                                INNER JOIN Deliverers
                                    ON Deliverers.delivery_area = Customers.city
                                ORDER BY order_date + INTERVAL '3' DAY, Customers.last_name";
                    } else {
                        $sql = "SELECT CONCAT('7:30 AM ', date_format(Orders.order_date + INTERVAL '3' DAY, '%m/%d/%Y')) AS date, CONCAT(IFNULL(CONCAT(Customers.title, ' '), ''),Customers.first_name, ' ', IFNULL(CONCAT(Customers.middle_name, ' '),''), Customers.last_name, IFNULL(CONCAT(' ',Customers.suffix, ' '), '')) AS customer, CONCAT(Customers.shipping_address, ', ', Customers.city, ', ', Customers.state, ' ', Customers.zip_code) AS address, CONCAT(Deliverers.first_name, ' ', Deliverers.last_name) AS deliverer, Inventory.name, Orders.quantity, CONCAT(Orders.quantity*Inventory.unit_weight_lb, ' Lbs') AS total_weight FROM Orders
                                INNER JOIN Inventory
                                    ON Inventory.product_id = Orders.product_id
                                INNER JOIN Customers
                                    ON Customers.customer_id = Orders.customer_id
                                INNER JOIN Deliverers
                                    ON Deliverers.delivery_area = Customers.city
                                WHERE 
                                CONCAT('7:30 AM ', date_format(Orders.order_date + INTERVAL '3' DAY, '%m/%d/%Y')) LIKE '%{$search}%' OR
                                CONCAT(IFNULL(CONCAT(Customers.title, ' '), ''),Customers.first_name,' ' , IFNULL(CONCAT(Customers.middle_name, ' '),''), Customers.last_name, IFNULL(CONCAT(' ',Customers.suffix, ' '), '')) LIKE '%{$search}%' OR
                               CONCAT(Customers.shipping_address, ', ', Customers.city, ', ', Customers.state, ' ', Customers.zip_code) LIKE '%{$search}%' OR
                                CONCAT(Deliverers.first_name, ' ', Deliverers.last_name) LIKE '%{$search}%' OR
                                name LIKE '%{$search}%' OR
                                quantity LIKE '%{$search}%' OR
                                CONCAT(Orders.quantity*Inventory.unit_weight_lb, ' Lbs') LIKE '%{$search}%'
                                ORDER BY order_date + INTERVAL '3' DAY, Customers.last_name";
                    }
                    $result = $db->query($sql);
                    
                    if ($result->num_rows > 0) {
                        echo <<<HERE
<table>
    <tr>
        <th>Delivery Time</th>
        <th>Customer</th>
        <th>Address</th>
        <th>Deliverer</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Total Weight</th>
    </tr>
HERE;
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row["date"]."</td><td>".$row["customer"]."</td><td class='left-text-align'>".$row["address"]."</td><td>".$row["deliverer"]."</td><td>".$row["name"]."</td><td>".$row["quantity"]."</td><td>".$row["total_weight"]."</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<table><tr><th>Delivery Time</th><th>Customer</th><th>Address</th><th>Deliverer</th><th>Product</th><th>Quantity</th><th>Total Weight</th></tr></table>";
                    }
                    $db->close();
                ?>
            </div>
            <script src="js/nav.js"></script>
        </body>
        <?php include("essential/footer.php");?>
</html>