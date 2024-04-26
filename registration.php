<?php

require('fpdf.php');

// Step 1: Retrieve form data
$Name = $_POST["Name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$dob = $_POST["dob"];
$gender = $_POST["gender"];
$department = $_POST["department"];
$appointment = $_POST["appointment"];

// Step 2: Establish a connection to the database
$db = mysqli_connect("localhost:4306", "root", "", "patient") or die("unable to connect");

// Step 3: Insert form data into the database
$sql = "INSERT INTO patientregistration (Name, email, phone, dob, gender, department, appointment)
        VALUES ('$Name', '$email', '$phone', '$dob', '$gender', '$department', '$appointment')";

if (mysqli_query($db, $sql)) {
    echo "Your Registration is successful. Download your receipt from below:\n\n";

    // Step 4: Generate a random registration number
    $registrationNumber = generateRandomString();

    // Step 5: Get doctor's name based on department
    $doctor = getDoctorName($department);

    // Step 6: Initialize PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Step 7: Add content to PDF
    // Hospital name
    $pdf->Cell(0, 10, 'Serienty Health Care Center Doctor appointment ', 0, 1, 'C');
    $pdf->Ln(10);

    // Registration details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(60, 10, 'Registration Number:', 1, 0, 'L');
    $pdf->Cell(0, 10, $registrationNumber, 1, 1, 'L');
    $pdf->Cell(60, 10, 'Name:', 1, 0, 'L');
    $pdf->Cell(0, 10, $Name, 1, 1, 'L');
    $pdf->Cell(60, 10, 'Email:', 1, 0, 'L');
    $pdf->Cell(0, 10, $email, 1, 1, 'L');
    $pdf->Cell(60, 10, 'Phone:', 1, 0, 'L');
    $pdf->Cell(0, 10, $phone, 1, 1, 'L');
    $pdf->Cell(60, 10, 'Date of Birth:', 1, 0, 'L');
    $pdf->Cell(0, 10, $dob, 1, 1, 'L');
    $pdf->Cell(60, 10, 'Gender:', 1, 0, 'L');
    $pdf->Cell(0, 10, $gender, 1, 1, 'L');
    $pdf->Cell(60, 10, 'Department:', 1, 0, 'L');
    $pdf->Cell(0, 10, $department, 1, 1, 'L');
    $pdf->Cell(60, 10, 'Appointment Date & Time:', 1, 0, 'L');
    $pdf->Cell(0, 10, $appointment, 1, 1, 'L');

    // Doctor's name
    $pdf->Cell(60, 10, 'Doctor:', 1, 0, 'L');
    $pdf->Cell(0, 10, $doctor, 1, 1, 'L');

    // QR Code
    $pdf->Cell(0, 10, 'QR Code Here', 0, 1, 'C');
    $pdf->Ln(10);

    // Contact details
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Thanks for using our health care center', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Contact us:', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Email: s2vhealthcare@gmail.com', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Phone: 011-2338780', 0, 1, 'C');

    // Step 8: Save PDF to a file
    $pdf->Output('registration_invoice.pdf', 'F');

    // Provide download link to the user
    echo '<a href="registration_invoice.pdf" download>Download Invoice</a>';
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}

// Step 9: Close the database connection
mysqli_close($db);

// Function to generate a random string for registration number
function generateRandomString($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Function to get doctor's name based on department
function getDoctorName($department) {
    switch($department) {
        case "Cardiology":
            return "Dr. Varun Kaushik"; // Replace with the corresponding Cardiology doctor's name
        case "General":
            return "Dr. Ella Lopez";
        case "Neurology":
            return "Dr. Chloe Decker";
        case "Psychiatrist":
            return "Dr. Lucifer Morningstar";
        case "Ophthalmology":
            return "Dr. Radha Krishna";
        case "Ayurvedic":
            return "Dr. D.D Basu";
        case "Orthopedics":
            return "Dr. Vikas Thakur"; // Replace with the corresponding Orthopedics doctor's name
        case "Pediatrics":
            return "Dr. Sourav"; // Replace with the corresponding Pediatrics doctor's name
        default:
            return "";
    }
}

?>
