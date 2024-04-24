const Swal = require('sweetalert2');

window.addEventListener('swal:confirm', event => {
    Swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.type,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('delete', event.detail.id);
        }
    });
});

window.addEventListener('scrollToTop', event => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
