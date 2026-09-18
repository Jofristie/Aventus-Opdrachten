<?php
include 'db_connect1.php';

for ($i = 0; $i < count($_POST['id']); $i++) {

    $stmt = $conn->prepare("UPDATE producten SET naam=?, prijs=?, voorraad=? WHERE product_id=?");
    $stmt->bind_param("sdii",
        $_POST['naam'][$i],
        $_POST['prijs'][$i],
        $_POST['voorraad'][$i],
        $_POST['id'][$i]
    );

    $stmt->execute();
}

header("Location: productBeheer.php");
?>