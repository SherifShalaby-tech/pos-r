<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML to PDF with jsPDF</title>
</head>
<body>
    <div id="content">
        <!-- Your HTML content goes here -->
        <h1>Hello, world!</h1>
        <p>This is a sample content for the PDF.</p>
    </div>

    <!-- Include the jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <!-- Your custom JavaScript code goes here -->
    <script>
        // Create a new instance of jsPDF
        var pdf = new jsPDF();

        // Select the element or the entire window
        var element = document.getElementById('content');

        // Check if the element is found
        if (element) {
            // Generate the PDF
            pdf.fromHTML(element, 10, 10);

            // Save or print the PDF
            pdf.save('output.pdf');
        } else {
            console.error('Element not found.');
        }

    </script>
</body>
</html>
