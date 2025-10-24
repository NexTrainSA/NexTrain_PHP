// Função para confirmar exclusão
function confirmDelete(tremId) {
    if (confirm('Tem certeza que deseja excluir esta rota?')) {
        window.location.href = `./php/excluir_rota.php?codigo=${tremId}`;
    }
}

// Adicionar event listeners quando a página carregar
document.addEventListener('DOMContentLoaded', function () {
    // Selecionar todos os botões de excluir
    const deleteButtons = document.querySelectorAll('.delete-btn');

    // Adicionar evento de clique para cada botão
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.stopPropagation(); // Previne o clique no card
            const tremId = this.getAttribute('data-trem-id');
            confirmDelete(tremId);
        });
    });
});

// Função original mantida para compatibilidade
function viewRouteDetails(routeName) {
    // Sua lógica existente para visualizar detalhes
    console.log('Visualizando rota:', routeName);
}