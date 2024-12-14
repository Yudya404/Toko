<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kode_cus'])) {
	
    $kodeCustomer = mysqli_real_escape_string($conn, $_POST['kode_cus']);

    // Lakukan operasi penghapusan data dari database
    $query = "DELETE FROM customer WHERE kode_cus = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $kodeCustomer);

    $response = array();

    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }

    mysqli_stmt_close($stmt);
    $conn->close();

    echo json_encode($response);
}
?>
