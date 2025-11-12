<?php
include_once 'db.php'; // conexão com o banco

// === GRÁFICO 1: ALERTAS POR USUÁRIO ===
$queryAlertas = "
    SELECT 
        u.username_usuario AS usuario,
        COALESCE(SUM(a.id_funcionario_recebe = u.id_usuario), 0) AS recebidos,
        COALESCE(SUM(a.id_funcionario = u.id_usuario), 0) AS enviados
    FROM usuario u
    LEFT JOIN alertas a 
        ON a.id_funcionario_recebe = u.id_usuario 
        OR a.id_funcionario = u.id_usuario
    GROUP BY u.id_usuario
";
$resultAlertas = $con->query($queryAlertas);

$usuarios = [];
$recebidos = [];
$enviados = [];

while ($row = $resultAlertas->fetch_assoc()) {
    $usuarios[] = $row['usuario'];
    $recebidos[] = $row['recebidos'];
    $enviados[] = $row['enviados'];
}

// === GRÁFICO 2: TRENS EM MANUTENÇÃO ===
$queryTrens = "
    SELECT 
        t.nome_trem AS trem,
        COUNT(cm.id_trem) AS total_chamados
    FROM trens t
    LEFT JOIN chamados_manutencao cm ON t.id_trem = cm.id_trem
    GROUP BY t.id_trem
";
$resultTrens = $con->query($queryTrens);

$nomesTrens = [];
$chamados = [];

while ($row = $resultTrens->fetch_assoc()) {
    $nomesTrens[] = $row['trem'];
    $chamados[] = $row['total_chamados'];
}

$con->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f8fa;
            margin: 0 auto;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .grafico-container {
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        canvas {
            width: 100%;
            height: 400px;
        }

        @media (max-width: 600px) {
            .reports-container {
                padding-top: 68px;
            }
        }
    </style>
</head>

<body>

    <section class="reports-container">
        <main class="routes-container">
            <section class="page-header">
                <div class="header-content">
                    <h1 class="page-title">Relatórios</h1>
                    <p class="page-subtitle">Visualize os relatórios</p>
                </div>


                <div class="grafico-container">
                    <h3>Alertas por Usuário</h3>
                    <canvas id="graficoAlertas"></canvas>
                </div>

                <div class="grafico-container">
                    <h3>Trens com Chamados de Manutenção</h3>
                    <canvas id="graficoTrens"></canvas>
                </div>
            </section>
        </main>
    </section>

    <script>
        // --- ALERTAS ---
        const ctx1 = document.getElementById('graficoAlertas');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($usuarios); ?>,
                datasets: [{
                        label: 'Recebidos',
                        data: <?php echo json_encode($recebidos); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Enviados',
                        data: <?php echo json_encode($enviados); ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // --- TRENS ---
        const ctx2 = document.getElementById('graficoTrens');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($nomesTrens); ?>,
                datasets: [{
                    label: 'Chamados de Manutenção',
                    data: <?php echo json_encode($chamados); ?>,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(201, 203, 207, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
    </main>
    </main>
</body>

</html>