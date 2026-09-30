<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Dalam Pemeliharaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* Animasi Pinggir Card (Elegant Animated Border) */
        .card-wrapper {
            position: relative;
            padding: 2px; /* Ketebalan border animasi */
            border-radius: 10px;
            overflow: hidden;
            max-width: 550px;
            width: 90%;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        }

        .card-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(
                from 0deg,
                #e2e8f0 0%,
                #e2e8f0 75%,
                #1e3a8a 95%, /* Warna biru akademik yang berjalan */
                #e2e8f0 100%
            );
            animation: border-spin 4s linear infinite;
        }

        @keyframes border-spin {
            100% { transform: rotate(360deg); }
        }

        .container {
            background-color: #ffffff;
            padding: 60px 50px;
            border-radius: 8px; /* Disesuaikan agar border pinggir melengkung rapi */
            position: relative;
            z-index: 1;
        }

        .icon {
            margin-bottom: 24px;
            color: #1e3a8a;
            display: flex;
            justify-content: center;
        }

        .icon svg {
            width: 56px;
            height: 56px;
            /* Animasi Berjalan (Gigi Roda Berputar Halus) */
            animation: spin 6s linear infinite; /* Diperlambat sedikit agar lebih elegan */
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 16px 0;
            color: #0f172a;
            letter-spacing: -0.025em;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #64748b;
            margin: 0 0 32px 0;
            font-weight: 300;
        }

        strong {
            font-weight: 600;
            color: #334155;
        }

        .divider {
            height: 1px;
            background-color: #e2e8f0;
            width: 100%;
            margin: 0 auto 24px auto;
        }

        .footer {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        @media (max-width: 600px) {
            .container { padding: 40px 30px; }
            h1 { font-size: 22px; }
            p { font-size: 15px; }
        }
    </style>
</head>
<body>
    <div class="card-wrapper">
        <div class="container">
            <div class="icon">
                <!-- SVG Icon Gear dengan animasi berputar -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            
            <h1>Sistem Dalam Pemeliharaan</h1>
            
            <p>
                Mohon maaf atas ketidaknyamanan yang terjadi. Sistem <strong>Indikator Kinerja Utama (IKU)</strong> saat ini sedang dalam pemeliharaan rutin untuk meningkatkan kualitas layanan. Silakan akses kembali beberapa saat lagi.
            </p>

            <div class="divider"></div>

            <div class="footer">
                PEMELIHARAAN SISTEM &nbsp;|&nbsp; &copy; <script>document.write(new Date().getFullYear());</script> Universitas Samudra
            </div>
        </div>
    </div>
</body>
</html>
