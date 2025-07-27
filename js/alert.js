function showAlert(id) {
    const alertElement = document.getElementById(id);
    alertElement.classList.add('show');

    setTimeout(() => {
        alertElement.classList.remove('show');
    }, 3000);
}