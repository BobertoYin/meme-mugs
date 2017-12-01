<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | Customers</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>Customers</h2>
                <!-- Search Boxes -->
                <form action="" method="GET" class="searchbox">
                    <input class="searchBox" type ="search" placeholder ="Press Enter to Search..." name="search" size="24">
                </form>
                <button onclick="window.location.href='https://meme-market-bobertoyin.c9users.io/newcustomer.php';" class="new-entry">New Customer</button>
                <?php
                    require_once("database.php");
                    
                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    } 
                    
                    $search = $_GET['search'];
                    
                    if (empty($search) === TRUE) {
                        $sql = "SELECT CONCAT(IFNULL(CONCAT(title, ' '), ''), first_name, ' ', IFNULL(CONCAT(middle_name, ' '),''), last_name, ' ', IFNULL(suffix, '')) as name, gender, phone_number, email, CONCAT(shipping_address, ', ', city, ', ', state, ' ', zip_code) AS shipping, CONCAT(billing_address, ', ', city, ', ', state, ' ', zip_code) AS billing FROM Customers
                                    ORDER BY last_name";
                    } else {
                        $sql = "SELECT CONCAT(IFNULL(CONCAT(title, ' '), ''), first_name, ' ', IFNULL(CONCAT(middle_name, ' '),''), last_name, ' ', IFNULL(suffix, '')) as name, gender, phone_number, email, CONCAT(shipping_address, ', ', city, ', ', state, ' ', zip_code) AS shipping, CONCAT(billing_address, ', ', city, ', ', state, ' ', zip_code) AS billing FROM Customers
                                    WHERE CONCAT(IFNULL(CONCAT(title, ' '), ''), first_name, ' ', IFNULL(CONCAT(middle_name, ' '),''), last_name, ' ', IFNULL(suffix, '')) LIKE '%{$search}%' OR
                                    gender LIKE '{$search}' OR
                                    phone_number LIKE '%{$search}%' OR
                                    email LIKE '%{$search}%' OR
                                    CONCAT(shipping_address, ', ', city, ', ', state, ' ', zip_code) LIKE '%{$search}%' OR
                                    CONCAT(billing_address, ', ', city, ', ', state, ' ', zip_code) LIKE '%{$search}%'
                                    ORDER BY last_name";
                    }
                    $result = $db->query($sql);
                    
                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>Name</th><th>Gender</th><th>Phone</th><th>Email</th><th>Billing Address</th><th>Shipping Address</th></tr>";
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row["name"]."</td><td>".$row["gender"]."</td><td class='left-text-align'><a href='tel:".$row["phone_number"]."'>".$row["phone_number"]."</a></td><td><a href='mailto:".$row["email"]."'>".$row["email"]."</a></td><td class='left-text-align'>".$row["billing"]."</td><td class='left-text-align'>".$row["shipping"]."</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<table><tr><th>Name</th><th>Phone</th><th>Email</th><th>Billing Address</th><th>Shipping Address</th></tr></table>";
                    }
                    $db->close();
                ?>
            </div>
            <script src="js/nav.js"></script>
        </body>
        <?php include("essential/footer.php");?>
</html>