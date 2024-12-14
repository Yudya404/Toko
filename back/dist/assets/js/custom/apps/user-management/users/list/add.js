"use strict";

// Class definition
var KTUsersAddUser = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_user');
    const form = element.querySelector('#kt_modal_add_user_form');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initAddUser = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'user_name': {
                        validators: {
                            notEmpty: {
                                message: 'Nama diperlukan'
                            }
                        }
                    },
                    'user_telp': {
                        validators: {
                            notEmpty: {
                                message: 'No. Telp diperlukan'
                            }
                        }
                    },
                    'user_email': {
                        validators: {
                            notEmpty: {
                                message: 'Email diperlukan'
                            }
                        }
                    },
                    'user_alamat': {
                        validators: {
                            notEmpty: {
                                message: 'Alamat diperlukan'
                            }
                        }
                    },
                    'user_role': {
                        validators: {
                            notEmpty: {
                                message: 'Tipe Pengguna diperlukan'
                            }
                        }
                    },
                    'avatar': {
                        validators: {
                            notEmpty: {
                                message: 'Foto Pengguna diperlukan'
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Submit button handler
        const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
        submitButton.addEventListener('click', e => {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        // Prepare form data
                        const formData = new FormData(form);

                        // Send data to backend using fetch
                        fetch('proses/user_add.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json()) // You might need to adjust this based on your backend response
                        .then(data => {
                            // Handle the response data here

                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;

                            // Rest of your code...
                            var tanggallengkap = new String();
                            var jamlengkap = new String();
                            var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
                            namahari = namahari.split(" ");
                            var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
                            namabulan = namabulan.split(" ");
                            var tgl = new Date();
                            var hari = tgl.getDay();
                            var tanggal = tgl.getDate();
                            var bulan = tgl.getMonth();
                            var tahun = tgl.getFullYear();
                            var jam = new Date().getHours();
                            var menit = new Date().getMinutes();
                            var detik = new Date().getSeconds();

                            tanggallengkap = tanggal + " " + namabulan[bulan] + " " + tahun;
                            jamlengkap = " " + jam + ":" + menit + ":" + detik;

                            // Show popup confirmation with formatted date and time
                            Swal.fire({
                                text: "Data Anda dengan ID U001 telah sukses tersimpan pada " + tanggallengkap + jamlengkap + "!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Selesai",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    modal.hide();
                                }
                            });

                            // Reset form
                            form.reset();
                        })
                        .catch(error => {
                            // Handle error
                            console.error(error);
                            Swal.fire({
                                text: "Maaf, terjadi kesalahan saat mengirim data. Silakan coba lagi.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Selesai",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        });
                    } else {
                        // Show popup warning
                        Swal.fire({
                            text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Selesai",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });

        // ... (Cancel and Close button handlers)
    }

    return {
        // Public functions
        init: function () {
            initAddUser();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddUser.init();
});
