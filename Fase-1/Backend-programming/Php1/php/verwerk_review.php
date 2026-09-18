<?php
session_start();
include 'db_connect1.php';

// Nieuwe review toevoegen
if (isset($_POST["rating_data"])) {

    $user_name = mysqli_real_escape_string($conn, $_POST["user_name"]);
    $user_rating = (int)$_POST["rating_data"];
    $user_review = mysqli_real_escape_string($conn, $_POST["user_review"]);
    $datetime = time();

    $query = "
    INSERT INTO review_table (user_name, user_rating, user_review, datetime)
    VALUES ('$user_name', '$user_rating', '$user_review', '$datetime')
    ";

    if (mysqli_query($conn, $query)) {
        echo "Your Review & Rating Successfully Submitted";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Data laden voor review overzicht
if (isset($_POST["action"])) {

    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;
    $review_content = array();

    $query = "SELECT * FROM review_table ORDER BY review_id DESC";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $review_content[] = array(
            'user_name'  => $row["user_name"],
            'user_review'=> $row["user_review"],
            'rating'     => $row["user_rating"],
            'datetime'   => date('l jS, F Y h:i:s A', $row["datetime"])
        );

        switch ($row["user_rating"]) {
            case 5: $five_star_review++; break;
            case 4: $four_star_review++; break;
            case 3: $three_star_review++; break;
            case 2: $two_star_review++; break;
            case 1: $one_star_review++; break;
        }

        $total_review++;
        $total_user_rating += $row["user_rating"];
    }

    if ($total_review > 0) {
        $average_rating = $total_user_rating / $total_review;
    }

    $output = array(
        'average_rating'   => number_format($average_rating, 1),
        'total_review'     => $total_review,
        'five_star_review' => $five_star_review,
        'four_star_review' => $four_star_review,
        'three_star_review'=> $three_star_review,
        'two_star_review'  => $two_star_review,
        'one_star_review'  => $one_star_review,
        'review_data'      => $review_content
    );

    echo json_encode($output);
}

mysqli_close($conn);
?>