import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

// Global SweetAlert functions
window.showSuccess = (message) => {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: message,
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        customClass: {
            popup: 'rounded-2xl',
            title: 'text-lg font-semibold'
        }
    });
};

window.showError = (message) => {
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: message,
        confirmButtonColor: '#ef4444',
        customClass: {
            popup: 'rounded-2xl',
            title: 'text-lg font-semibold'
        }
    });
};

window.showWarning = (message) => {
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian!',
        text: message,
        confirmButtonColor: '#10b981',
        customClass: {
            popup: 'rounded-2xl',
            title: 'text-lg font-semibold'
        }
    });
};

// Intercept delete actions globally
window.confirmDelete = (event, message = "Data yang dihapus tidak dapat dikembalikan!") => {
    event.preventDefault();
    const form = event.target.closest('form');

    Swal.fire({
        title: 'Hapus Data?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl shadow-xl border border-slate-100',
            title: 'text-xl font-bold text-slate-800',
            htmlContainer: 'text-slate-500 font-medium',
            confirmButton: 'font-semibold px-6 py-2.5 rounded-lg shadow-sm',
            cancelButton: 'font-semibold px-6 py-2.5 rounded-lg border border-slate-200'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
};

// Global Submit Confirmation
window.confirmSubmit = (event, message = "Apakah Anda yakin ingin menyimpan data ini?") => {
    event.preventDefault();
    const form = event.target.closest('form');

    // Check form validity before showing SweetAlert
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    Swal.fire({
        title: 'Simpan Data?',
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl shadow-xl border border-slate-100',
            title: 'text-xl font-bold text-slate-800',
            htmlContainer: 'text-slate-500 font-medium',
            confirmButton: 'font-semibold px-6 py-2.5 rounded-lg shadow-sm',
            cancelButton: 'font-semibold px-6 py-2.5 rounded-lg border border-slate-200'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    title: 'text-lg font-bold text-slate-800',
                }
            });
            form.submit();
        }
    });
};

Alpine.start();
