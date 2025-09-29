// Máscara para CPF: 000.000.000-00
document.getElementById('cpf').addEventListener('input', function () {
  let cpf = this.value.replace(/\D/g, '');
  if (cpf.length > 11) cpf = cpf.slice(0, 11);

  cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
  cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
  cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

  this.value = cpf;
});

// Máscara para telefone:
document.getElementById('telefone').addEventListener('input', function () {
  let tel = this.value.replace(/\D/g, '');
  if (tel.length > 11) tel = tel.slice(0, 11);

  if (tel.length <= 10) {
    tel = tel.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
  } else {
    tel = tel.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
  }

  this.value = tel;
});

// Validação de CPF:
function validateCPF(cpf) {
  cpf = cpf.replace(/[^\d]/g, '');
  return cpf.length === 11;
}

// Validação de telefone:
function validateTelefone(telefone) {
  telefone = telefone.replace(/[^\d]/g, '');
  return telefone.length >= 10 && telefone.length <= 11;
}

// Validação do formulário todinho:
function validateForm(event) {
  event.preventDefault();

  const cpf = document.getElementById('cpf').value;
  const telefone = document.getElementById('telefone').value;
  const tipo = document.getElementById('trem').value;

  let isValid = true;

  if (!validateCPF(cpf)) {
    alert('CPF inválido! Deve conter 11 dígitos numéricos.');
    isValid = false;
  }

  if (!validateTelefone(telefone)) {
    alert('Telefone inválido! Deve conter DDD + número.');
    isValid = false;
  }

  if (tipo === "") {
    alert("Por favor, selecione um trem.");
    isValid = false;
  }

  if (isValid) {
    include(insert_requests.php);
    alert("Seu chamado foi recebido! Torça para não sermos como a TI da escola e demorarmos mais de 6 meses para resolver um probleminha ;)");
    document.getElementById('formOS').reset(); // Isso faz resetar todo o formulário
  }

  return false;
}

// Validar o formulário:
function validateForm(event) {
  event.preventDefault(); // Tem que ter!!!

  const ordemServico = document.getElementById('ordem_servico').value;
  const nomeFuncionario = document.getElementById('nome_funcionario').value;
  const cpf = document.getElementById('cpf').value;
  const idFuncionario = document.getElementById('id_funcionario').value;
  const telefoneFuncionario = document.getElementById('telefone_funcionario').value;
  const idTrem = document.getElementById('id_trem').value;
  const descricaoProblema = document.getElementById('descricao_problema').value;
  const tecnicoResponsavel = document.getElementById('tecnico_responsavel').value;
  const dataEntrada = document.getElementById('data_entrada').value;
  const dataSaida = document.getElementById('data_saida').value;

  if (!ordemServico || !nomeFuncionario || !cpf || !idFuncionario || !telefoneFuncionario || !idTrem || !descricaoProblema || !tecnicoResponsavel || !dataEntrada || !dataSaida) {
    alert('Preencha todos os campos obrigatórios!');
    return false;
  }

  include(insert_requests.php);
  alert("Seu chamado foi recebido! Torça para não sermos como a TI da escola e demorarmos mais de 6 meses para resolver um probleminha ;)");
  event.target.submit(); // Envia o formulário
  document.getElementById('formOS').reset(); // Isso faz resetar todo o formulário

  return true;
}