// public/js/regency-handler.js

document.addEventListener('DOMContentLoaded', function () {
    const regencySelect = document.getElementById('regency_select');
    const otherRegencyWrapper = document.getElementById('other_regency_wrapper');
    const otherRegencyInput = document.getElementById('other_regency');

    function toggleOtherRegency() {
        if (regencySelect.value === 'Lain-lain') {
            otherRegencyWrapper.classList.remove('hidden');
            otherRegencyInput.setAttribute('required', 'required');
        } else {
            otherRegencyWrapper.classList.add('hidden');
            otherRegencyInput.removeAttribute('required');
            otherRegencyInput.value = '';
        }
    }

    // Jalankan saat halaman pertama kali dimuat
    toggleOtherRegency(); 
    
    // Jalankan setiap kali pilihan dropdown berubah
    regencySelect.addEventListener('change', toggleOtherRegency);
});