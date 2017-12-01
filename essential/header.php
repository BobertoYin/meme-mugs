<header>
            <div class="logo">
                <?php include("images/logo.svg");?>
                <h1 id="header-text">Meme Mugs</h1>
                <h4 class="open-hours">Hours of Operation: 7:00 AM to 9:00 PM</h4>
            </div>
            <nav>
                <div class="container dropbtn" onclick="openNav()">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <div class="nav-content" id="nav-links">
                        <a style="font-size:2em;margin:0;text-align:left" href="javascript:void(0)"><b onclick="closeNav();">&times;</b></a>
                        <a style="margin-top:0.25em" href="index.php">Orders</a>
                        <a href="deliveries.php">Deliveries</a>
                        <a href="inventory.php">Inventory</a>
                        <a href="customers.php">Customers</a>
                        <a href="employees.php">Employees</a>
                    </div>
            </nav>
        </header>