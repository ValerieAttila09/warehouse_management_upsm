document.addEventListener('DOMContentLoaded', () => {
  let selectedDeleteUserId = null;
  let selectedDeleteUserEmail = null;

  function ajaxPost(url, data) {
    return fetch(url, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams(data)
    });
  }

  // Edit buttons: expect data attributes on the row or button
  document.querySelectorAll('[data-modal-target="edit-user-modal"]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const tr = btn.closest('tr');
      if (!tr) return;
      const id = tr.dataset.userId || btn.dataset.userId || '';
      const first = tr.dataset.firstName || btn.dataset.firstName || '';
      const last = tr.dataset.lastName || btn.dataset.lastName || '';
      const email = tr.dataset.email || btn.dataset.email || '';
      const role = tr.dataset.role || btn.dataset.role || '';
      const country = tr.dataset.country || btn.dataset.country || '';
      const city = tr.dataset.city || btn.dataset.city || '';
      const phone = tr.dataset.phoneNumber || tr.dataset.phone || btn.dataset.phone || '';
      const zip = tr.dataset.zipCode || tr.dataset.zip || btn.dataset.zip || '';
      const profile = tr.dataset.profilePicture || btn.dataset.profilePicture || '';

      const form = document.getElementById('edit-user-form');
      if (!form) return;
      const idInput = form.querySelector('input[name="id_user"]');
      if (idInput) idInput.value = id;
      const f1 = form.querySelector('input[name="first_name"]'); if (f1) f1.value = first;
      const f2 = form.querySelector('input[name="last_name"]'); if (f2) f2.value = last;
      const f3 = form.querySelector('input[name="email"]'); if (f3) f3.value = email;
      const roleSelect = form.querySelector('select[name="role"]');
      if (roleSelect) roleSelect.value = role;
      const countryInput = form.querySelector('input[name="country"]'); if (countryInput) countryInput.value = country;
      const cityInput = form.querySelector('input[name="city"]'); if (cityInput) cityInput.value = city;
      const phoneInput = form.querySelector('input[name="phone"]'); if (phoneInput) phoneInput.value = phone;
      const zipInput = form.querySelector('input[name="zip_code"]'); if (zipInput) zipInput.value = zip;
      const profileInput = form.querySelector('input[name="profile_picture"]'); if (profileInput) profileInput.value = profile;
      
      console.log('Edit form populated with id:', id);
    });
  });

  // Delete buttons: mark selected user id/email and open modal (UI library should open modal)
  document.querySelectorAll('[data-modal-target="delete-user-modal"]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const tr = btn.closest('tr');
      selectedDeleteUserId = null;
      selectedDeleteUserEmail = null;
      if (tr) {
        selectedDeleteUserId = tr.dataset.userId ? parseInt(tr.dataset.userId, 10) : null;
        selectedDeleteUserEmail = tr.dataset.email || null;
        if (!selectedDeleteUserEmail) {
          const secondTd = tr.querySelectorAll('td')[1];
          if (secondTd) {
            const m = secondTd.innerText.match(/[\w.+-]+@[\w.-]+\.[A-Za-z]{2,}/);
            if (m) selectedDeleteUserEmail = m[0];
          }
        }
      } else {
        selectedDeleteUserEmail = btn.dataset.email || null;
      }
      // optionally show user info in modal
      const modal = document.getElementById('delete-user-modal');
      if (modal) {
        const info = modal.querySelector('.delete-user-info');
        if (info && tr) {
          const name = tr.querySelector('.text-base.font-semibold');
          info.textContent = name ? name.textContent.trim() : '';
        }
      }
      
      console.log('Delete user selected - id:', selectedDeleteUserId, 'email:', selectedDeleteUserEmail);
    });
  });

  // Confirm delete button in modal
  const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const payload = {};
      if (selectedDeleteUserId) payload.id_user = selectedDeleteUserId;
      else if (selectedDeleteUserEmail) payload.email = selectedDeleteUserEmail;
      else return;

      ajaxPost('../auth/users_delete.php', payload)
        .then(resp => {
          if (resp.status === 403) {
            // admin confirmation required: prompt for password then retry
            const pwd = prompt('Masukkan password admin untuk konfirmasi:');
            if (!pwd) return;
            return ajaxPost('../auth/admin_confirm.php', { admin_password: pwd }).then(r => {
              return r.json().then(json => {
                if (json.success) {
                  return ajaxPost('../auth/users_delete.php', payload);
                } else {
                  alert(json.message || 'Konfirmasi gagal');
                }
              });
            });
          }
          return resp.json();
        })
        .then(data => {
          if (!data) return;
          if (data.success) {
            alert(data.message || 'User deleted');
            // remove row from table if present (match by id or email)
            let tr = null;
            if (selectedDeleteUserId) tr = document.querySelector('tr[data-user-id="' + selectedDeleteUserId + '"]');
            if (!tr && selectedDeleteUserEmail) tr = Array.from(document.querySelectorAll('tr')).find(r => r.dataset.email === selectedDeleteUserEmail);
            if (tr) tr.remove();
            // hide modal if using data-modal-hide attribute
            document.querySelectorAll('[data-modal-hide="delete-user-modal"]').forEach(el => el.click());
          } else {
            alert(data.message || 'Gagal menghapus user');
          }
        }).catch(err => {
          console.error(err);
          alert('Terjadi kesalahan jaringan.');
        });
    });
  }

  // Optional: AJAX submit for add/edit forms to show messages without full page reload
  ['add-user-form', 'edit-user-form'].forEach(id => {
    const f = document.getElementById(id);
    if (!f) return;
    f.addEventListener('submit', (e) => {
      e.preventDefault();
      const url = f.action;
      const data = Object.fromEntries(new FormData(f).entries());
      
      function submitForm() {
        return ajaxPost(url, data);
      }
      
      submitForm()
        .then(r => {
          if (r.status === 403) {
            // admin confirmation required: prompt for password then retry
            const pwd = prompt('Masukkan password admin untuk konfirmasi:');
            if (!pwd) return Promise.resolve(null);
            return ajaxPost('../auth/admin_confirm.php', { admin_password: pwd })
              .then(confirmResp => confirmResp.json())
              .then(confirmJson => {
                if (confirmJson.success) {
                  return submitForm();
                } else {
                  alert(confirmJson.message || 'Konfirmasi gagal');
                  return Promise.resolve(null);
                }
              });
          }
          return r;
        })
        .then(r => {
          if (!r) return;
          return r.json();
        })
        .then(json => {
          if (!json) return;
          if (json.success) {
            alert(json.message || 'Sukses');
            window.location.reload();
          } else {
            alert(json.message || 'Gagal');
          }
        })
        .catch(() => alert('Network error'));
    });
  });

});