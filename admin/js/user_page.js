const modal = document.getElementById('userModal');
const closeModal = document.getElementById('closeModal');
const openModalButtons = document.querySelectorAll('#openModal');

openModalButtons.forEach((button) => {
  button.addEventListener('click', function() {
    modal.classList.remove('hidden');

    const userId = this.getAttribute('data-userID');
    const username = this.getAttribute('data-username');
    const name = this.getAttribute('data-name');
    const email = this.getAttribute('data-email');
    const phone = this.getAttribute('data-phone');
    const credit = this.getAttribute('data-credit');
    const role = this.getAttribute('data-role');

    modal.querySelector('input[name="ID"]').value = userId;
    modal.querySelector('input[name="username"]').value = username;
    modal.querySelector('input[name="name"]').value = name;
    modal.querySelector('input[name="email"]').value = email;
    modal.querySelector('input[name="phone"]').value = phone;
    modal.querySelector('input[name="credit"]').value = credit;
    modal.querySelector('select[name="role"]').value = role;
    modal.querySelector('#deleteBtn').href = `user/delete.php?id=${userId}`;
  });
});


modal.addEventListener('click', function(e) {
  if (e.target === modal) {
    modal.classList.add('hidden');
  }
});

closeModal.addEventListener('click', function() {
  modal.classList.add('hidden');
});

document.addEventListener("DOMContentLoaded", function() {
  const params = new URLSearchParams(window.location.search);

  const messagesEdit = {
    success: {
      title: "Successfully edited!",
      html: "You have successfully edited the user account!",
      icon: "success",
    },
    failed: {
      title: "Edit failed!",
      html: "Failed to edit the user account! Please try again later.",
      icon: "error",
    },
  };

  const messagesDelete = {
    success: {
      title: "Successfully deleted!",
      html: "You have successfully deleted the user account!",
      icon: "success",
    },
    failed: {
      title: "Delete failed!",
      html: "Failed to delete the user account! Please try again later.",
      icon: "error",
    },
  };

  const statusEdit = params.get("edit");
  const statusDelete = params.get("delete");

  if (statusEdit && messagesEdit[statusEdit]) {
    Swal.fire({
      timer: 4000,
      ...messagesEdit[statusEdit],
      showConfirmButton: false,
    });
  }

  if (statusDelete && messagesDelete[statusDelete]) {
    Swal.fire({
      timer: 4000,
      ...messagesDelete[statusDelete],
      showConfirmButton: false,
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const editButton = document.querySelector('input[type="submit"][name="edit"]');

  form.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      editButton.click();
    }
  });
});
