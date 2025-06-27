<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Court Cases Locator</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Court Cases Locator</h1>
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="file-upload">
                <label for="csvFile">Upload CSV File:</label>
                <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
            </div>
            <div class="file-upload">
                <label for="pdfFile">Upload PDF File:</label>
                <input type="file" id="pdfFile" name="pdfFile" accept=".pdf" required>
            </div>
            <button type="submit" id="fetchReportBtn">Fetch Report</button>
        </form>
        <div id="message"></div>
        <div id="downloadSection" style="display: none;">
            <a href="#" id="downloadLink" download="report.xlsx">Download Excel Report</a>
        </div>
        <div id="links">
            <a href="https://judiciary.karnataka.gov.in/entire_causelist.php" target="_blank">High Court Cause List</a>
            <a href="https://cis.cgat.gov.in/catlive/home1.php?no=MTAz" target="_blank">CAT Cause List</a>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
