// Busca os elementos HTML com os IDs correspondentes
const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const previousMonthElement = document.getElementById('previousMonth');
const nextMonthElement = document.getElementById('nextMonth');

let currentDate = new Date(); // Data de hoje

const updateCalendar = () => { // Função principal: atualiza o calendário
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0); // Dia 0 do mês seguinte é o último do mês atual

    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay(); // Qual dia da semana (domingo=0)

    // Tela de mobile:
    const isSmallScreen = window.innerWidth <= 500;

    if (isSmallScreen) {
        const today = new Date();

        // Verifica se o mês e o ano mostrados no calendário são do mês atual
        const isSameMonth =
            today.getFullYear() === currentYear &&
            today.getMonth() === currentMonth;

        if (isSameMonth) { // Se for o mesmo mês, mostra só o dia de hoje
            const dayNumber = today.getDate(); // Mostra o número do dia
            const weekdayName = today.toLocaleDateString('pt-BR', {
                weekday: 'long'
            }); // Nome do dia da semana

            monthYearElement.textContent = weekdayName.charAt(0).toUpperCase() + weekdayName.slice(1); // Nome do dia da semana com letra maiúscula

            datesElement.innerHTML = `<div class="date active">${dayNumber}</div>`; // Mostra só o número do dia
        }

        // Esconde os outros nomes dos dias da semana
        document.querySelector('.days').style.display = 'none';
        return; // Encerra aqui para não continuar com o calendário completo
    }

    // Fim tela de mobile

    // Calendário completo das telas grandes:

    document.querySelector('.days').style.display = 'grid';

    const monthYearString = currentDate.toLocaleString('default', {
        month: 'long',
        year: 'numeric'
    });

    const formattedMonthYearString = monthYearString.charAt(0).toUpperCase() + monthYearString.slice(1); // Faz o nome do mês ficar com letra maiúscula
    monthYearElement.textContent = formattedMonthYearString; // Insere o nome do mês na div com o ID monthYear

    let datesHTML = ''; // Monta HTML dos dias do mês

    for (let i = firstDayIndex; i > 0; i--) { // Preenche os espaços vazios com os dias do mês anterior
        const prevDate = new Date(currentYear, currentMonth, 1 - i);
        datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
    }

    for (let i = 1; i <= totalDays; i++) { // Monta o calendário com os dias do mês atual
        const date = new Date(currentYear, currentMonth, i);

        // Verificamos se é o dia de hoje
        const isToday = date.toDateString() === new Date().toDateString();
        const activeClass = isToday ? 'active' : '';

        // Criamos o quadradinho do dia, com destaque se for hoje
        datesHTML += `<div class="date ${activeClass}">${i}</div>`;
    }

    // Insere os dias dentro do HTML:
    datesElement.innerHTML = datesHTML;
};

// Botão do mês anterior:
previousMonthElement.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1); // Volta um mês
    updateCalendar(); // Atualiza o calendário
});

// Botão do próximo mês:
nextMonthElement.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1); // Avança um mês
    updateCalendar(); // Atualiza o calendário
});

// Atualiza o calendário com o resize da tela
window.addEventListener('resize', updateCalendar);

// Atualiza o calendário quando a página é carregada (claramente)
updateCalendar();
