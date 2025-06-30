// Busca os elementos HTML com os IDs correspondentes
const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const previousMonthElement = document.getElementById('previousMonth');
const nextMonthElement = document.getElementById('nextMonth');

let currentDate = new Date(); // Data de hoje

const updateCalendar = () => {  // Função principal que atualiza o calendário:
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0); // Dia 0 do mês seguinte é o último do mês atual
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay(); // Qual dia da semana (domingo=0)
    const isSmallScreen = window.innerWidth <= 380;

    // Tela mobile: 
    if (isSmallScreen) {
        const dayNumber = currentDate.getDate();
        const weekdayName = currentDate.toLocaleDateString('pt-BR', {
            weekday: 'long'
        });

        monthYearElement.textContent = weekdayName.charAt(0).toUpperCase() + weekdayName.slice(1); // Mostra o nome do dia da semana com letra maiúscula

        datesElement.innerHTML = `<div class="date active">${dayNumber}</div>`; // Mostra só o número do dia

        const daysElement = document.querySelector('.days'); // Oculta os nomes dos dias da semana
        if (daysElement) {
            daysElement.style.display = 'none';
        }

        return; // Encerra aqui para não mostrar o calendário todinho
    }
    // Fim da tela mobile


    // Telas maiores:
    const daysElement = document.querySelector('.days'); // Dias da semana aparecem!
    if (daysElement) {
        daysElement.style.display = 'grid';
    }

    const monthYearString = currentDate.toLocaleString('default', {
        month: 'long',
        year: 'numeric'
    });

    const formattedMonthYearString = monthYearString.charAt(0).toUpperCase() + monthYearString.slice(1); // Monta o mês todinho (mês com letra maiúscula)
    monthYearElement.textContent = formattedMonthYearString;

    let datesHTML = '';

    for (let i = firstDayIndex; i > 0; i--) { // Completa com os dias do mês anterior
        const prevDate = new Date(currentYear, currentMonth, 1 - i);
        datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
    }

    for (let i = 1; i <= totalDays; i++) { // Preenche os dias do mês atual
        const date = new Date(currentYear, currentMonth, i);
        const isToday = date.toDateString() === new Date().toDateString();
        const activeClass = isToday ? 'active' : '';

        // Textos do tooltip:
        const dayOfWeek = date.getDay(); // Verifica o dia para mudar o texto do tooltip
        let tooltipText = 'Aproveite enquanto não tem trabalho.'; // Texto padrão
        if (dayOfWeek === 0 || dayOfWeek === 6) { // Sábado é (6) e domingo é (0)
            tooltipText = 'Vai dormir!'; // Texto especial para fim de semana
        }

        // Coloca cada dia dentro do "date-container" e inclui um tooltip oculto com o texto correto
        datesHTML += `
            <div class="date-container">
                <div class="date ${activeClass}" data-day="${i}">${i}</div>
                <div class="tooltip">${tooltipText}</div>
            </div>
        `;
    }
        // Fim dos Textos do tooltip

    // Insere os dias dentro do HTML:
    datesElement.innerHTML = datesHTML;

    // Ativa os tooltips
    setupTooltips();
};

// Função que adiciona tooltips clicáveis aos elementos com a classe "date"
function setupTooltips() {
    const allDates = document.querySelectorAll('.date');

    allDates.forEach(date => {
        date.addEventListener('click', function (e) {
            // Esconde qualquer tooltip já visível
            document.querySelectorAll('.date').forEach(d => d.classList.remove('show-tooltip'));

            // Mostra o tooltip do dia clicado
            this.classList.add('show-tooltip');

            e.stopPropagation(); // Impede que o clique feche o tooltip imediatamente
        });
    });

    // Se o usuário clicar fora de qualquer dia, o tooltip desaparece
    document.addEventListener('click', () => {
        document.querySelectorAll('.date').forEach(d => d.classList.remove('show-tooltip'));
    });
}

// Botão de voltar: 
previousMonthElement.addEventListener('click', () => {
    if (window.innerWidth <= 360) { // Em telas pequenas, volta um dia
        currentDate.setDate(currentDate.getDate() - 1);
    } else {
        currentDate.setMonth(currentDate.getMonth() - 1);  // Em telas grandes, volta um mês
    }
    updateCalendar(); // Atualiza a exibição
});

// Event listener para o botão "próximo mês" ou "próximo dia"
nextMonthElement.addEventListener('click', () => {
    if (window.innerWidth <= 360) {
        currentDate.setDate(currentDate.getDate() + 1);  // Em telas pequenas, avança um dia
    } else {
        currentDate.setMonth(currentDate.getMonth() + 1); // Em telas grandes, avança um mês
    }
    updateCalendar();
});

window.addEventListener('resize', updateCalendar); // Atualiza o calendário com o resize da tela

updateCalendar(); // Atualiza o calendário quando a página é carregada