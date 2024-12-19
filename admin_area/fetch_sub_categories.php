<?php
require_once './includes/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$categoryId = $data['categoryId'];

$get_sub_cats = "SELECT cat_id, cat_title FROM categories WHERE parent_cat_id = ?";
$stmt = $con->prepare($get_sub_cats);
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$result = $stmt->get_result();

$subCategories = [];
while ($row = $result->fetch_assoc()) {
    $subCategories[] = $row;
}

echo json_encode($subCategories);
