document.addEventListener('DOMContentLoaded', function () {
    const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
    const btnSave = document.getElementById('btnSave');
    const userForm = document.getElementById('userForm');

    btnSave.addEventListener('click', function () {
        // Ambil data dari form
        const user_name = document.getElementById('user_name').value;
		const user_telp = document.getElementById('user_telp').value;
        const user_email = document.getElementById('user_email').value;
        const user_alamat = document.getElementById('user_alamat').value;
		const user_role = document.getElementById('user_role').value;
        const avatar = document.getElementById('avatar').value;

        // Kirim data ke server (contoh: tampilkan alert)
        alert(`Nama: ${user_name}\nEmail: ${user_telp}\nEmail: ${user_email}\nAlamat: ${user_alamat}\nHak Akses: ${user_role}\nFoto: ${avatar}`);

        // Tutup modal
        addUserModal.hide();

        // Reset form
        userForm.reset();
    });

    const btnAddUser = document.getElementById('btnAddUser');
    btnAddUser.addEventListener('click', function () {
        addUserModal.show();
    });
});
