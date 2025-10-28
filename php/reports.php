<?php
require_once('db.php');

$query = "SELECT u.username_usuario AS funcionario, COUNT(a.id_alerta) AS total_alertas
          FROM alertas a
          JOIN usuario u ON u.id_usuario = a.id_funcionario_recebe
          GROUP BY u.username_usuario
          ORDER BY total_alertas DESC";

$result = $con->query($query);

$funcionarios = [];
$totalAlertas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $funcionarios[] = $row['funcionario'];
        $totalAlertas[] = $row['total_alertas'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Fontes e Estilos -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-pie.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-bar.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/themes/dark_blue.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #FAFAFA;
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
    }

    .page-header {
      text-align: center;
      margin-top: 60px;
      margin-bottom: 40px;
    }

    .page-title {
      font-size: 2rem;
      font-weight: 700;
      color: #1e1e1e;
    }

    .dashboard {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 40px;
      justify-items: center;
      padding: 0 20px 60px;
    }

    .column {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 30px;
    }

    h2 {
      color: #1e1e1e;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .chart-box {
      width: 320px;
      height: 320px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }

    @media (max-width: 1000px) {
      .dashboard {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

<canvas id="chartAlertas" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <section class="page-header">
    <h1 class="page-title">Relatórios</h1>
  </section>

  <section class="content">
    <div class="dashboard">



    </div>


      
  </section>



</body>

<script>
    <script>
const ctxAlertas = document.getElementById('chartAlertas').getContext('2d');
const chartAlertas = new Chart(ctxAlertas, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($funcionarios); ?>,
        datasets: [{
            label: 'Alertas recebidos',
            data: <?php echo json_encode($totalAlertas); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Quantidade de Alertas' } },
            x: { title: { display: true, text: 'Funcionários' } }
        }
    }
});
</script>

</html>


