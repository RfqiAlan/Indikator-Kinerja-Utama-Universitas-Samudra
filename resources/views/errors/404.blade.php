<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 antialiased h-screen flex flex-col items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 text-center border border-slate-100">
        <div class="relative w-20 h-20 mx-auto mb-8 flex items-center justify-center">
            <!-- Efek Animasi Gelombang Indigo -->
            <div class="absolute inset-0 bg-indigo-200 rounded-full animate-ping opacity-60 duration-1000"></div>
            <div class="absolute inset-0 bg-indigo-100 rounded-full animate-pulse"></div>
            
            <!-- Lingkaran Utama -->
            <div class="relative w-full h-full bg-white border border-indigo-100 rounded-full flex items-center justify-center shadow-xl shadow-indigo-200/50">
                <!-- Icon Kompas Nyasar -->
                <svg class="w-9 h-9 text-indigo-500 animate-[bounce_2s_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                </svg>
            </div>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Halaman Tidak Ditemukan</h1>
        <p class="text-slate-500 text-sm leading-relaxed mb-8">
            Maaf, halaman atau rute yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia. Silakan periksa kembali tautan yang Anda masukkan.
        </p>
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg shadow-blue-600/30">
            Kembali ke Beranda
        </a>
        <p class="mt-6 text-xs text-slate-400 font-medium">
            Error Code: 404 (Not Found)
        </p>
    </div>
</body>
</html>
