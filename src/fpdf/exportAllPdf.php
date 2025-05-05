<?php
  require('./fpdf186/fpdf.php');

  date_default_timezone_set('Asia/Manila');
  $today = date('Y-m-d H:i:sa');

  $course_data = json_decode($_POST['course-data'], true);
  $quiz_data = json_decode($_POST['quiz-data'], true);

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

  // Create PDF
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 10, 'Complete Learning Report', 0, 1, 'C');
  $pdf->Ln(5);

  // modules
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(0, 10, 'Modules and Lessons', 0, 1);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Cell(90, 10, 'Course Title', 1);
  $pdf->Cell(40, 10, 'Total Modules', 1);
  $pdf->Cell(50, 10, 'Total Lessons', 1);
  $pdf->Ln();

  $pdf->SetFont('Arial', '', 12);
  
  foreach($course_data as $course){
    $title = $course['course_name'] ?? 'N/A';
    $modules = $course['modules'] ?? 0;
    $lessons = $course['lessons'] ?? 0;

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(90, 10, $title, 1);
    $lines = ceil($pdf->GetStringWidth($title) / 90);
    $pdf->SetXY($x + 90, $y);
    $pdf->Cell(40, 10 * $lines, $modules, 1, 0, 'C');
    $pdf->Cell(50, 10 * $lines, $lessons, 1);
    $pdf->Ln();
  }

  $pdf->Ln(10);

  // stats
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(0, 10, 'Statistics Summary', 0, 1);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Cell(120, 10, 'Statistics Title', 1);
  $pdf->Cell(60, 10, 'Value', 1);
  $pdf->Ln();

  $pdf->SetFont('Arial', '', 12);

  foreach($stats as $label => $value){
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(120, 10, $label, 1);
    $lines = ceil($pdf->GetStringWidth($label) / 120);
    $pdf->SetXY($x + 120, $y);
    $pdf->Cell(60, 10 * $lines, $value, 1);
    $pdf->Ln();
  }

  $pdf->Ln(10);

  //  quiz 
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(0, 10, 'Quiz Attempts', 0, 1);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Cell(120, 10, 'Course Title', 1);
  $pdf->Cell(60, 10, 'Quiz Attempts', 1);
  $pdf->Ln();

  $pdf->SetFont('Arial', '', 12);

  foreach($quiz_data as $quiz){
    $title = $quiz['course_name'] ?? 'N/A';
    $attempts = $quiz['quiz_attempts'] ?? 0;

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(120, 10, $title, 1);
    $lines = ceil($pdf->GetStringWidth($title) / 120);
    $pdf->SetXY($x + 120, $y);
    $pdf->Cell(60, 10 * $lines, $attempts, 1);
    $pdf->Ln();
  }


  $date = 'Date: ' . $today;
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->cell(181, 25, $date, 0, 1, 'R') ;
  $pdf->Output('D', 'All_Reports.pdf');
?>