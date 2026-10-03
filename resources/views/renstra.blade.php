<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renstra Universitas Samudra 2025-2026</title>

    <!-- DearFlip CSS (Lite Version) -->
    <link href="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.8.6/dflip/css/dflip.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.8.6/dflip/css/themify-icons.min.css" rel="stylesheet">
    
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            background-color: #2b2b2b; /* Background gelap agar elegan */
        }
        
        #flipbook-container {
            height: 100vh;
            width: 100vw;
        }

        /* Menyembunyikan sedikit watermark atau elemen tidak perlu (opsional) */
        .df-ui-btn.df-ui-logo {
            display: none !important;
        }
    </style>
</head>
<body>

    <!-- Container untuk Flipbook -->
    <div id="flipbook-container"></div>

    <!-- jQuery (Wajib untuk DearFlip) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DearFlip JS (Lite Version) -->
    <script src="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.8.6/dflip/js/dflip.min.js"></script>

    <script>
        jQuery(document).ready(function () {
            // Path langsung ke file PDF Anda
            var pdfPath = "{{ asset('build/assets/Renstra Universitas Samudra 2025-2026 Revisi.pdf') }}";

            // Konfigurasi DearFlip
            var options = {
                webgl: true, // Mengaktifkan efek 3D (Jika didukung browser)
                height: '100%',
                duration: 800, // Kecepatan membalik halaman (ms)
                backgroundColor: "#2b2b2b", // Sesuaikan dengan warna background body
                
                // Menonaktifkan fitur yang mungkin tidak diperlukan
                enableDownload: true,
                autoEnableOutline: true,
                autoEnableThumbnail: true
            };

            // Inisialisasi Flipbook
            var flipbook = $("#flipbook-container").flipBook(pdfPath, options);
        });
    </script>
</body>
</html>
