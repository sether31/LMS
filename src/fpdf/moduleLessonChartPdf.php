<?php
require('./fpdf186/fpdf.php');

  date_default_timezone_set('Asia/Manila');
  $today = date('Y-m-d H:i:sa');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $course_data_json = $_POST['course-data'] ?? '';
    $course_data = json_decode($course_data_json, true);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Number of Module and Lesson per Course Report', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(90, 10, 'Course Title', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Modules', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Lessons', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 11);

    foreach($course_data as $course){
      $title = $course['course_name'] ?? 'N/A';
      $modules = $course['modules'] ?? '0';
      $lessons = $course['lessons'] ?? '0';

      $startX = $pdf->GetX();
      $startY = $pdf->GetY();

      $pdf->MultiCell(90, 8, $title, 1);

      $newY = $pdf->GetY();
      $rowHeight = $newY - $startY;

      $pdf->SetXY($startX + 90, $startY);
      $pdf->Cell(40, $rowHeight, $modules, 1, 0, 'C');

      $pdf->Cell(40, $rowHeight, $lessons, 1, 1, 'C');
    }
    
    $date = 'Date: ' . $today;
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->cell(171, 25, $date, 0, 1, 'R');
    $pdf->Output('D', 'module_lesson_chart.pdf');
    exit();
  } 
    header("Location: ../../pages/teacher/dashboard.php");
    exit();
?>
