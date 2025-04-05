<?php 

require "../backend/database/connectDB.php";
$appointment_id = $_POST['appointment_id'] ?? null;

if (empty($appointment_id)) {
    echo json_encode(["success" => false, "message" => "Appointment ID is required."]);
    exit();
}

if (!filter_var($appointment_id, FILTER_VALIDATE_INT)) {
    echo json_encode(["success" => false, "message" => "Invalid appointment ID. It must be an integer."]);
    exit();
}

$query = "UPDATE appointments SET STATUS ='rejected' WHERE id=?";
$stmt = $conn->prepare($query);

$stmt->bind_param("i", $appointment_id);


if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Error in appointment rejection"]);
    die();
}

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Appointment rejected"]);
} else {
    echo json_encode(["success" => false, "message" => "Error in appointment rejection"]);
}

$stmt->close();
$conn->close();

?>