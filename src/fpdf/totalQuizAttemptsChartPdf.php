<?php
  require('./fpdf186/fpdf.php');

  date_default_timezone_set('Asia/Manila');
  $today = date('Y-m-d H:i:sa');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $quiz_attempt_data_json = $_POST['quiz-data'] ?? '';
    $quiz_attempt_data = json_decode($quiz_attempt_data_json, true);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Quiz Attempt Report', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(140, 10, 'Course', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Total Quiz Attempts', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 11);

    foreach($quiz_attempt_data as $quiz_attempt){
      $title = $quiz_attempt['title'] ?? 'N/A';
      $attempts = $quiz_attempt['total_attempts'] ?? '0';

      $startX = $pdf->GetX();
      $startY = $pdf->GetY();

      $pdf->MultiCell(140, 8, $title, 1);

      $newY = $pdf->GetY();
      $rowHeight = $newY - $startY;

      $pdf->SetXY($startX + 140, $startY);
      $pdf->Cell(50, $rowHeight, $attempts, 1, 1, 'C');
    }

    $date = 'Date: ' . $today;
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->cell(190, 25, $date, 0, 1, 'R') ;
    $pdf->Output('D', 'All_Reports.pdf');
    $pdf->Output('D', 'quiz_attemps_report.pdf');
  }

  header("Location: ../../pages/teacher/dashboard.php");
  exit();
?>
