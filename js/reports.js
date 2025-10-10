
// Values do gráfico de pizza
const xValues = ["Trem1", "Trem2", "Trem3", "Trem3", "Trem4"];
const yValues = [23, 44, 9, 6, 20];
const barColors = ["#e76f51", "#f4a261", "#e9c46a", "#2a9d8f", "#264653"];

// Gráfico de pizza
new Chart("myPieChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Olha os trens..."
    }
  }
});