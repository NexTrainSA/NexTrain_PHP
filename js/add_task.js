function validateForm(event) {
    event.preventDefault(); // Tem que ter!!!

    const funcionario = document.getElementById('id_funcionario').value;
    const descricao = document.getElementById('descricao').value;

    if (!funcionario || !descricao) {
        alert('Preencha todos os campos obrigatórios!');
        return false;
    }

    include('insert_task.php');
    alert("Tarefa adicionada ;)");
    event.target.submit(); // Envia o formulário
    document.getElementById('formOS').reset(); // Isso faz resetar todo o formulário

    return true;
}