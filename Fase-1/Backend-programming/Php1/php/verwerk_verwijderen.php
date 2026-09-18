<?php
include 'db_connect1.php';

if (isset($_POST['verwijder'])) {

    foreach ($_POST['verwijder'] as $id) {

        $stmt = $conn->prepare("DELETE FROM producten WHERE product_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

header("Location: productBeheer.php");