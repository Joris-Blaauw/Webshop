function TogglePopup(PopupId) {
    event.preventDefault()
    document.getElementById(PopupId).classList.toggle("hidden")
}