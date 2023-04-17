function showModal() {
    const element = document.getElementById("modal-content");
    element.classList.remove("modal-close");
    element.classList.add("modal-show");
}
function closeModal() {
    const element = document.getElementById("modal-content");
    element.classList.remove("modal-show");
    element.classList.add("modal-close");
}