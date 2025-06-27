<?php
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

header('Content-Type: application/json');

// Step 1: Check file uploads
if (!isset($_FILES['csvFile'], $_FILES['pdfFile'])) {
    echo json_encode(['success' => false, 'error' => 'Files not uploaded']);
    exit;
}

$csvFile = $_FILES['csvFile']['tmp_name'];
$pdfFile = $_FILES['pdfFile']['tmp_name'];

if (!file_exists($csvFile) || !file_exists($pdfFile)) {
    echo json_encode(['success' => false, 'error' => 'Files not found']);
    exit;
}

// Step 2: Read case numbers from CSV (assumes 'case_number' in Column A)
$csvNumbers = [];
if (($handle = fopen($csvFile, 'r')) !== false) {
    $header = fgetcsv($handle);
    $caseIndex = array_search('case_number', array_map('strtolower', $header));

    if ($caseIndex === false) {
        echo json_encode(['success' => false, 'error' => 'Missing "case_number" column']);
        exit;
    }

    while (($row = fgetcsv($handle)) !== false) {
        $value = strtoupper(trim($row[$caseIndex]));
        if (preg_match('/\d+\/\d{4}/', $value, $match)) {
            $csvNumbers[] = $match[0];  // Only numeric part
        }
    }
    fclose($handle);
}
$csvNumbers = array_unique($csvNumbers);

// Step 3: Extract all numeric case numbers from PDF
$parser = new Parser();
$pdfText = strtoupper($parser->parseFile($pdfFile)->getText());

preg_match_all('/\d{1,6}\/\d{4}/', $pdfText, $pdfMatches);
$pdfNumbers = array_unique($pdfMatches[0]);

// Step 4: Match
$matched = array_intersect($csvNumbers, $pdfNumbers);

// Step 5: Return result
if (!empty($matched)) {
    ob_start();
    echo "<table border='1' style='width:100%;margin-top:20px;border-collapse:collapse;'>";
    echo "<tr><th>Matched Case Numbers</th></tr>";
    foreach ($matched as $m) {
        echo "<tr><td>" . htmlspecialchars($m) . "</td></tr>";
    }
    echo "</table>";
    $html = ob_get_clean();

    echo json_encode([
        'success' => true,
        'recordsCount' => count($matched),
        'html' => $html
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'No matching records found.']);
}
