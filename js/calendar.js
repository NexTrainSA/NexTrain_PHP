const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const previousMonthElement = document.getElementById('previousMonth');
const nextMonthElement = document.getElementById('nextMonth');

let currentDate = new Date();

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();

    const monthYearString = currentDate.toLocaleString('default', {
        month: 'long',
        year: 'numeric'
    });
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';

    // Dias do mês anterior (inativos)
    for (let i = firstDayIndex; i > 0; i--) {
        const prevDate = new Date(currentYear, currentMonth, 1 - i);
        datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
    }

    // Dias do mês atual
    for (let i = 1; i <= totalDays; i++) {
        const date = new Date(currentYear, currentMonth, i);
        const isToday = date.toDateString() === new Date().toDateString();
        const activeClass = isToday ? 'active' : '';
        datesHTML += `<div class="date ${activeClass}">${i}</div>`;
    }

    datesElement.innerHTML = datesHTML;
};

previousMonthElement.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
});

nextMonthElement.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
});

updateCalendar();
