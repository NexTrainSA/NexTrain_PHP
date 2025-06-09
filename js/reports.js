// Values do gráfico de pontinhos:
const xyValues1 = [
    { x: 50, y: 7 },
    { x: 60, y: 8 },
    { x: 70, y: 8 },
    { x: 80, y: 9 },
    { x: 90, y: 9 },
    { x: 100, y: 9 },
    { x: 110, y: 10 },
    { x: 120, y: 11 },
    { x: 130, y: 14 },
    { x: 140, y: 14 },
    { x: 150, y: 15 },
    { x: 30, y: 15 }
];

const xyValues2 = [
    { x: 18, y: 43 },
    { x: 21, y: 78 },
    { x: 54, y: 8 },
    { x: 12, y: 9 },
    { x: 10, y: 99 },
    { x: 100, y: 65 },
];

// Gráfico de pontinhos:
new Chart("myChart", {
    type: "scatter",
    data: {
        datasets: [
            {
                label: "A",
                pointRadius: 4, // Tamanho dos pontinhos
                pointBackgroundColor: "#778da9",
                data: xyValues1 // Usa os dados definidos no começo
            },
            {
                label: "B",
                pointRadius: 4,
                pointBackgroundColor: "#f28482",
                data: xyValues2
            }
        ]
    }
});

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