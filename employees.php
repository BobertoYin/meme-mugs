<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>Meme Mugs | Employees</title>
        <link href="https://fonts.googleapis.com/css?family=Righteous|Roboto+Mono" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" href="images/mug.ico" type="image/x-icon">
    </head>
        <?php include("essential/header.php");?>
        <body>
            <div class="content">
                <h2>Employees</h2>
                <!-- Search Boxes -->
               <form action="" method="GET" class="searchbox">
                    <input class="searchBox" type ="search" placeholder ="Press Enter to Search..." name="search" size="24">
                </form>
                <button onclick="window.location.href='https://meme-market-bobertoyin.c9users.io/newemployee.php';" class="new-entry">New Employee</button>
                <?php
                    require_once("database.php");
                    
                    // Check connection
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    } 
                    
                    $search = $_GET['search'];
                    
                    if (empty($search) === TRUE) {
                        $sql = "SELECT CONCAT(first_name, ' ', IFNULL(CONCAT(middle_name, ' '),''), last_name) as name, date_format(start_date, '%c/%e/%Y') as date, Employees.occupation, phone_number, email, CONCAT(address, ', ', city, ', ', state, ' ', zip_code) AS home_address, Occupations.description, CONCAT('$', Occupations.salary) AS employee_salary FROM Employees
                                    INNER JOIN Occupations
                                        ON Occupations.occupation = Employees.occupation
                                    ORDER BY salary DESC";
                    } else {
                        $sql = "SELECT CONCAT(first_name, ' ', IFNULL(CONCAT(middle_name, ' '),''), last_name) as name, date_format(start_date, '%c/%e/%Y') as date, Employees.occupation, phone_number, email, CONCAT(address, ', ', city, ', ', state, ' ', zip_code) AS home_address, Occupations.description, CONCAT('$', Occupations.salary) AS employee_salary FROM Employees
                                    INNER JOIN Occupations
                                        ON Occupations.occupation = Employees.occupation
                                    WHERE CONCAT(first_name, ' ', IFNULL(CONCAT(middle_name, ' '),''), last_name) LIKE '%{$search}%' OR
                                    date_format(start_date, '%c/%e/%Y') LIKE '%{$search}%' OR
                                    Employees.occupation LIKE '%{$search}%' OR
                                    phone_number LIKE '%{$search}%' OR
                                    email LIKE '%{$search}%' OR
                                    CONCAT(address, ', ', city, ', ', state, ' ', zip_code) LIKE '%{$search}%' OR
                                    Occupations.description LIKE '%{$search}%' OR
                                    CONCAT('$', Occupations.salary) LIKE '%{$search}%'
                                    ORDER BY salary DESC";
                    }
                    $result = $db->query($sql);
                    
                    if ($result->num_rows > 0) {
                        echo "<table><tr><th></th><th>Name</th><th>Hire Date</th><th>Occupation</th><th>Phone</th><th>Email</th><th>Address</th><th>Job Description</th><th>Salary</th></tr>";
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row["employee_img"]."</td><td>".$row["name"]."</td><td>".$row["date"]."</td><td>".$row["occupation"]."</td><td class='left-text-align'><a href='tel:".$row["phone_number"]."'>".$row["phone_number"]."</a></td><td><a href='mailto:".$row["email"]."'>".$row["email"]."</a></td><td class='left-text-align'>".$row["home_address"]."</td><td class='left-text-align'>".$row["description"]."</td><td>".$row["employee_salary"]."</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<table><tr><th>Name</th><th>Hire Date</th><th>Occupation</th><th>Phone</th><th>Email</th><th>Address</th><th>Job Description</th><th>Salary</th></tr></table>";
                    }
                    $db->close();
                ?>
            </div>
            <script src="js/nav.js"></script>
        </body>
        <?php include("essential/footer.php");?>
</html>