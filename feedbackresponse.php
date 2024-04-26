<?php

require('fpdf.php');

// Step 1: Retrieve form data
$name = $_POST["name"];
$email = $_POST["email"];
$service = $_POST["service"];
$satisfaction = $_POST["satisfaction"];
$comments = $_POST["comments"];

// Step 2: Establish a connection to the database
$db = mysqli_connect("localhost:4306", "root", "", "feedback") or die("unable to connect");

// Step 3: Insert form data into the database
$sql = "INSERT INTO response (name, email, service, satisfaction, comments)
        VALUES ('$name', '$email', '$service', '$satisfaction', '$comments')";

if (mysqli_query($db, $sql)) {
    echo "Your Registration is successful. Download your receipt from below:\n\n";
    // Step 4: Generate PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Title with border
    $pdf->SetFillColor(61, 67, 239);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 10, 'Serienty Health Care Center Feedback Form', 1, 1, 'C', true);

    // Feedback details
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0);
    $pdf->Cell(40, 10, 'Name:', 1, 0);
    $pdf->Cell(0, 10, $name, 1, 1);
    $pdf->Cell(40, 10, 'Email:', 1, 0);
    $pdf->Cell(0, 10, $email, 1, 1);
    $pdf->Cell(40, 10, 'Service/Product:', 1, 0);
    $pdf->Cell(0, 10, $service, 1, 1);
    $pdf->Cell(40, 10, 'Satisfaction:', 1, 0);
    $pdf->Cell(0, 10, $satisfaction, 1, 1);
    $pdf->Cell(40, 10, 'Your feedback:', 1, 0);
    $pdf->MultiCell(0, 10, $comments, 1, 1);
    
    // Contact details with border
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Contact us:', 1, 1, 'C');
    $pdf->Cell(0, 10, 'Email: v2hhealthcare@gmail.com', 1, 1, 'C');
    $pdf->Cell(0, 10, 'Phone: 011-2338780', 1, 1, 'C');

    // Step 5: Save PDF to a file
    $pdf->Output('feedback_form.pdf', 'F');

    // Provide download link to the user
    echo '<a href="feedback_form.pdf" download>Download Feedback Form</a>';
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}

// Step 6: Close the database connection
mysqli_close($db);

?>
