<!-- references the database in the page -->
<?php
$db = new mysqli(getenv("IP"), getenv("C9_USER"), "", "Meme Mugs", 3306);


function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>