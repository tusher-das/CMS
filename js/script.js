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

const shareBtn = document.querySelector('.share-btn');
const shareOptions = document.querySelector('.share-options');

shareBtn.addEventListener('click', () => {
    shareOptions.classList.toggle('active');
})

function copyToClipboard(text) {

    console.log(text);
  // Create a temporary element to hold the text
  var tempElement = document.createElement('textarea');
  tempElement.value = text;
  document.body.appendChild(tempElement);
  
  // Copy the text to the clipboard
  tempElement.select();
  document.execCommand('copy');
    document.body.removeChild(tempElement);
    window.alert("Link copied to clipboard!")
}