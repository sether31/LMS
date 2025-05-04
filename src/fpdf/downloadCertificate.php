<?php
  require('./fpdf186/fpdf.php');

  if($_SERVER["REQUEST_METHOD"] == "POST"){  
    $user_name = trim($_POST['user-name']);    
    $course_title = trim($_POST['course-title']);
    $course_id = trim($_POST['course-id']);

    $pdf = new FPDF('L', 'mm', 'A4');
      
    $upName = strtoupper($user_name);
    $upCourse = strtoupper($course_title);
    
    $courseLength = strlen($course_title);
    if($courseLength <= 10){
      $courseFontSize = 20;
    } else if($courseLength <= 20){
      $courseFontSize = 16;
    } else if($courseLength <= 30){
      $courseFontSize = 12;
    } else{
      $courseFontSize = 10;
    };
      
    $pdf->AddPage();
    $pdf->Image('../../assets/images/certificate-template.png', 0, 0, 297, 210);
    $pdf->SetFont('Arial', 'B', 28);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY(0, 120);
    $pdf->Cell(297, -15, $upCourse, 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(405, 51, $upCourse, 0, 1, 'C');
    
    $pdf->Output('D', $user_name . ' Certificate.pdf');

    header("Location: ../../pages/student/viewCourse.php?courseId=$course_id");
    exit();
  } else{
    $_SESSION['failed-to-download-cert'] = 'Failed tom download certificate. please try again.';
    header("Location: ../../pages/student/viewCourse.php?courseId=$course_id");
    exit();
  }
?>