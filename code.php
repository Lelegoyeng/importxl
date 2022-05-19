<?php
session_start();
include('dbconfig.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['save_excel_data']))
{
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach($data as $row)
        {
            if($count > 0)
            {   
                $no= $row['0'];
                $nama= $row['1'];
                $posisi= $row['2'];
                $gapok= $row['3'];
                $evaluasi = $row['4'];
                $bonus = $row['5'];
                $late = $row['6'];
                $premi = $row['7'];
                $tidak_masuk = $row['8'];
                $potongan = $row['9'];
                $total = $row['10'];
                $tahun = $row['11'];
                $bulan = $row['12'];          
                $sqlpegawai = "INSERT INTO `slip_gaji`(`no`, `nama`, `posisi`, `gapok`, `evaluasi`, `bonus`, `late`, `premi`, `tidak_masuk`, `potongan`, `total`, `tahun`, `bulan`) VALUES ('$no','$nama','$posisi','$gapok','$evaluasi','$bonus','$late','$premi','$tidak_masuk','$potongan','$total','$tahun','$bulan')";
               $result = mysqli_query($conn, $sqlpegawai);
                $msg = true;
            }
            else
            {
                $count = "1";
            }
        }

        if(isset($msg))
        {
            $_SESSION['message'] = "Successfully Imported";
            header('Location: index.php');
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Not Imported";
            header('Location: index.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "Invalid File";
        header('Location: index.php');
        exit(0);
    }
}
?>
