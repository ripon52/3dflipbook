<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Realistic PDF Flipbook - wowBook.js</title>

    <!-- wowBook CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/wowbook/2.0.2/wowbook.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        #flipbook {
            width: 800px;
            height: 500px;
            margin: 40px auto;
        }
        .page img {
            width: 100%;
            height: auto;
        }
        .controls {
            text-align: center;
            margin-bottom: 20px;
        }
        .controls button {
            padding: 10px 15px;
            margin: 0 5px;
            background: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .controls button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="controls">
    <button id="prev">⬅ Prev</button>
    <button id="next">Next ➡</button>
    <button id="zoomIn">Zoom In 🔍</button>
    <button id="zoomOut">Zoom Out 🔎</button>
</div>

<div id="flipbook"></div>

<!-- ✅ jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ✅ wowBook.js -->
<script src="{{ asset('assets/js/wow_book.min.js') }}"></script>

<!-- ✅ PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<script>
    // Set PDF.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

    const pdfUrl = "{{ asset('books/laravelbeyond.pdf') }}"; // Update this to your actual Laravel PDF path

    async function renderPDF() {
        const pdf = await pdfjsLib.getDocument(pdfUrl).promise;
        const flipbook = $('#flipbook');

        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            const viewport = page.getViewport({ scale: 1.5 });
            const canvas = document.createElement('canvas');
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;

            const pageDiv = $('<div class="page"></div>');
            const img = $('<img>').attr('src', canvas.toDataURL());
            pageDiv.append(img);
            flipbook.append(pageDiv);
        }

        // Initialize wowBook
        flipbook.wowBook({
            height: 500,
            width: 800,
            centeredWhenClosed: true,
            hardcovers: true,
            toolbar: "back, next, first, last",
            toolbarPosition: "bottom",
            share: "twitter, facebook, reddit",
            turnPageDuration: 1000,
            pageNumbers: true,
            controls: {
                zoomIn: "#zoomIn",
                zoomOut: "#zoomOut",
                next: "#next",
                back: "#prev"
            },
            curl: true
        });
    }

    $(document).ready(function () {
        renderPDF();

        // Keyboard navigation
        $(document).keydown(function (e) {
            if (e.key === 'ArrowRight') {
                $('#flipbook').wowBook('advance');
            } else if (e.key === 'ArrowLeft') {
                $('#flipbook').wowBook('back');
            }
        });
    });
</script>

</body>
</html>
