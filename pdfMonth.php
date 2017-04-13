<?php
    //koneksi ke database
	session_start();
    include"koneksi.php";
    //akhir koneksi
      
    #ambil data di tabel dan masukkan ke array
    $uid = $_SESSION['uid'];
    $result = $con->prepare('SELECT id, fullname, phone_number, operator, kode, harga, transaction_date FROM transaction WHERE YEAR(transaction_date) = YEAR(NOW()) AND MONTH(transaction_date)=MONTH(NOW()) AND uid = "'.$uid.'"');
    $result->execute();
    $data = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
     array_push($data, $row);
    }
      
    #setting judul laporan dan header tabel
    $judul = "TRANSACTION";
    $header = array(
      array("label"=>"ID", "length"=>10, "align"=>"C"),
      array("label"=>"Name", "length"=>50, "align"=>"C"),
      array("label"=>"Phone Number", "length"=>35, "align"=>"C"),
      array("label"=>"Operator", "length"=>25, "align"=>"C"),
      array("label"=>"Code", "length"=>15, "align"=>"C"),
      array("label"=>"Price", "length"=>25, "align"=>"C"),
      array("label"=>"Transaction Date", "length"=>30, "align"=>"C")
     );
      
    #sertakan library FPDF dan bentuk objek
    require_once ("fpdf/fpdf.php");
    $pdf = new FPDF();
    $pdf->AddPage();
      
    #tampilkan judul laporan
    $pdf->SetFont('Arial','B','16');
    $pdf->Cell(0,20, $judul, '0', 1, 'C');
      
    #buat header tabel
    $pdf->SetFont('Arial','','10');
    $pdf->SetFillColor(41,128,185);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(41,128,185);
    foreach ($header as $kolom) {
     $pdf->Cell($kolom['length'], 5, $kolom['label'], 1, '0', $kolom['align'], true);
    }
    $pdf->Ln();
      
    #tampilkan data tabelnya
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    $fill=false;
    foreach ($data as $baris) {
     $i = 0;
     foreach ($baris as $cell) {
      $pdf->Cell($header[$i]['length'], 5,$cell, 1, '0', 'C', $fill);
      $i++;
     }
     $fill = !$fill;
     $pdf->Ln();
    }
      
    #output file PDF
    $pdf->Output();
    ?>