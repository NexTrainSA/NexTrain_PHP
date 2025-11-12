<?php
require_once("db.php");
$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT username_usuario, nome_completo_usuario, email_usuario FROM usuario WHERE id_usuario = '$id_usuario'";
$resultado = mysqli_query($con, $sql);
$usuario = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!--  Fontes e Estilos:  -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script type="importmap">
    {
            "imports": {
            "@material/web/": "https://esm.run/@material/web/"
            }
        }
        </script>
  <script type="module">
    import '@material/web/all.js';
    import {
      styles as typescaleStyles
    } from '@material/web/typography/md-typescale-styles.js';
    document.adoptedStyleSheets.push(typescaleStyles.styleSheet);

    // Ensure icons are loaded properly
    document.addEventListener('DOMContentLoaded', function() {
      // Force icon font load
      const testIcon = document.createElement('md-icon');
      testIcon.textContent = 'schedule';
      testIcon.style.position = 'absolute';
      testIcon.style.left = '-9999px';
      document.body.appendChild(testIcon);

      setTimeout(() => {
        document.body.removeChild(testIcon);
      }, 100);
    });
  </script>
  <style>
    .user-info-card {
      width: 100%;
      max-width: 800px;
      margin: 40px auto;
      border-radius: 16px;
      background: var(--card, #ffffff);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: background 0.3s, color 0.3s;
      font-family: 'Roboto', sans-serif;
    }

    .dark-mode .user-info-card {
      background-color: rgb(53, 72, 90);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .user-card-content {
      padding: 30px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .user-card-header {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
    }

    .user-field {
      display: flex;
      flex-direction: column;
      background: var(--bg-secondary, rgba(0, 0, 0, 0.02));
      padding: 16px;
      border-radius: 10px;
      transition: background 0.3s;
    }

    .user-label {
      font-size: 0.85rem;
      color: var(--muted, #6b7280);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 6px;
      font-weight: 600;
    }

    .dark-mode .user-label {
      color: white;
    }

    .dark-mode .user-value {
      color: white;
    }
    .user-value {
      font-size: 1rem;
      color: var(--text, #111827);
      font-weight: 500;
      word-break: break-word;
    }

    /* Responsividade */
    @media (max-width: 600px) {
      .user-card-content {
        padding: 20px;
      }

      .user-card-header {
        grid-template-columns: 1fr;
      }
    }

    /* Dark Mode */
    :root.dark-mode .user-info-card {
      background: var(--card, #334155);
      box-shadow: 0 4px 15px rgba(255, 255, 255, 0.05);
    }

    :root.dark-mode .user-field {
      background: rgba(255, 255, 255, 0.05);
    }

    :root.dark-mode .user-label {
      color: #a1a1aa;
    }

    :root.dark-mode .user-value {
      color: #f1f5f9;
    }
  </style>
</head>


<body>
  <main class="dashboard-container">
    <!-- Welcome Section -->
    <section class="welcome-section">
      <div class="welcome-content">
        <h1 class="dashboard-title">Olá,
          <?php echo $_SESSION['nome_completo_usuario']; ?>.
        </h1>
        <p class="dashboard-subtitle">Visualize suas informações.</p>
      </div>
    </section>


    <md-card class="user-info-card">
      <div class="user-card-content">
        <div class="user-card-header">
          <div class="user-field">
            <span class="user-label">Nome completo</span>
            <span class="user-value"><?php echo $usuario['nome_completo_usuario']; ?></span>
          </div>
          <div class="user-field">
            <span class="user-label">Usuário</span>
            <span class="user-value"><?php echo $usuario['username_usuario']; ?></span>
          </div>
          <div class="user-field">
            <span class="user-label">Email</span>
            <span class="user-value"><?php echo $usuario['email_usuario']; ?></span>
          </div>
        </div>
      </div>
    </md-card>
  </main>

  <!--  Scripts:  -->
  <script src="./js/icon-loader.js"></script>
  <script src="./js/dark_mode.js"></script>
  <script src="./js/sidebar.js"></script>
  <!--  Fim dos Scripts  -->

</body>

</html>