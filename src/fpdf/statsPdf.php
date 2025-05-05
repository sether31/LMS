<?php
  require('./fpdf186/fpdf.php');

  date_default_timezone_set('Asia/Manila');
  $today = date('Y-m-d H:i:sa');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $total_students = $_POST['total-students'] ?? 0;
    $total_publish_courses = $_POST['total-publish-courses'] ?? 0;
    $total_unpublish_courses = $_POST['total-unpublish-courses'] ?? 0;
    $total_active_modules = $_POST['total-active-modules'] ?? 0;
    $total_inactive_modules = $_POST['total-inactive-modules'] ?? 0;
    $total_active_lessons = $_POST['total-active-lessons'] ?? 0;
    $total_inactive_lessons = $_POST['total-inactive-lessons'] ?? 0;

    $stats = [
      'Total Number of Enrolled' => $total_students,
      'Total Number of Published' => $total_publish_courses,
      'Total Number of Unpublished Courses' => $total_unpublish_courses,
      'Total Number of Actice Modules' => $total_active_modules,
      'Total Number of Inactive Modules' => $total_inactive_modules,
      'Total Number of Active Lessons' => $total_active_lessons,
      'Total Number of Inactive Lessons' => $total_inactive_lessons
    ];

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Dashbord Statistics Report', 0, 1, 'C');
    $pdf->Ln(10);

    $labelWidth = 120;
    $valueWidth = 60;
    $lineHeight = 10;

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell($labelWidth, $lineHeight, 'Statistics', 1, 0, 'C');
    $pdf->Cell($valueWidth, $lineHeight, 'Data', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 12);

    foreach($stats as $label => $value){
      $x = $pdf->GetX();
      $y = $pdf->GetY();
      $pdf->MultiCell($labelWidth, $lineHeight, $label, 1);
      $pdf->SetXY($x + $labelWidth, $y);
      $lines = ceil($pdf->GetStringWidth($label) / $labelWidth);
      $pdf->Cell($valueWidth, $lineHeight * $lines, $value, 1, 1, 'C');
    }

    $date = 'Date: ' . $today;
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->cell(181, 25, $date, 0, 1, 'R') ;
    $pdf->Output('D', 'All_Reports.pdf');
    $pdf->Output('D', 'Dashboard_Statistics_Report.pdf');
    
    header("Location: ../../pages/teacher/dashboard.php");
    exit();
  }
?>
