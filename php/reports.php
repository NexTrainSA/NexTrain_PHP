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

<canvas id="chartAlertas" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

