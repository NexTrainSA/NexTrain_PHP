function validateForm(event) {
    event.preventDefault(); // Tem que ter!!!

    const funcionario = document.getElementById('funcionario').value;
    const descricao = document.getElementById('descricao').value;

    if (!funcionario || !descricao) {
        alert('Preencha todos os campos obrigatórios!');
        return false;
    }

    include(insert_task.php);
    alert("Seu chamado foi recebido! Torça para não sermos como a TI da escola e demorarmos mais de 6 meses para resolver um probleminha ;)");
    event.target.submit(); // Envia o formulário
    document.getElementById('formOS').reset(); // Isso faz resetar todo o formulário

    return true;
}