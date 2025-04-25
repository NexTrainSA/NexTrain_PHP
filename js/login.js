function validateForm() {
    if(document.forms["loginForm"]["user"].value.length <= 1) {
        alert("Insira um nome de usuário.")
        return false;
    }
    if(document.forms["loginForm"]["pass"].value.length <= 1) {
        alert("Insira uma senha.")
        return false;
    }
    return true;
}