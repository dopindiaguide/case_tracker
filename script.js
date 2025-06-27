document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const csvFile = document.getElementById('csvFile').files[0];
    const pdfFile = document.getElementById('pdfFile').files[0];

    if (!csvFile || !pdfFile) {
        alert('Please upload both CSV and PDF files.');
        return;
    }

    const formData = new FormData();
    formData.append('csvFile', csvFile);
    formData.append('pdfFile', pdfFile);

    fetch('process_files.php', {
        method: 'POST',
        body: formData
    })
    .then(data => {
        const messageElem = document.getElementById('message');
        if (data.success) {
            messageElem.innerHTML = `${data.recordsCount} matching records found.<br>${data.html}`;
        } else {
            messageElem.textContent = data.error || 'No matching records found.';
        }
    })
    
    
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the files.');
    });
});
