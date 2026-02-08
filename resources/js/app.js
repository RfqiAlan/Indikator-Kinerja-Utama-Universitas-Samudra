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

window.confirmDelete = (formId) => {
    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl',
            title: 'text-lg font-semibold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
};

Alpine.start();
