<?

//on spboms.ru


$mpdf = new mPDF();

$mpdf->SetAuthor("ТФОМС Санкт-Петербурга");

if (isset($confPdf['title'])) {
    $mpdf->SetTitle($confPdf['title']);
}

if (isset($confPdf['useCss']) && $confPdf['useCss']) {
    $stylesheet = file_get_contents($pdfReportDir . 'pdf_'.$idPrint.'.css');
    $mpdf->WriteHTML($stylesheet, 1); # The parameter 1 tells that this is css/style only and no body/html/text
}

if (isset($confPdf['useTpl']) && $confPdf['useTpl']) {
    ob_start();
    include($pdfReportDir . 'pdf_'.$idPrint.'.tpl.php');
    $html = ob_get_clean();

    $mpdf->WriteHTML($html);
}

$filename = $idPrint.'('.date('d-m-Y H-i-s', time()).')';
if (isset($confPdf['filename'])) {
    $filename = $confPdf['filename'];
}


if ($idPrint == 'report') {
    $contentPdf = $mpdf->Output('', 'S');
    $dataOp = lk('logOperation', 'createHistoryReport');
    $b64Pdf = base64_encode($contentPdf);
    $successReg = lk('regPdf', $dataReport, $b64Pdf, $dataOp);
}




$mpdf->Output($filename.'.pdf', 'I'); //I S D F

_log('pdf', array('$filename' => $filename, '$successReg' => $successReg));
