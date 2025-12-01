# NexTrain

## Objetivo do projeto 
O principal objetivo é desenvolver um aplicativo móvel inteligente para gestão e monitoramento do transporte ferroviário em cidades inteligentes, com o intuito de otimizar o controle de rotas, acompanhar em tempo real o deslocamento dos trens, prever a necessidade de manutenção e reforçar a segurança operacional, promovendo assim a eficiência, sustentabilidade e tomadas de decisão com uma maior agilidade no sistema de transporte urbano. O aplicativo visa melhorar a eficiência dos serviços de transporte ferroviário, contribuindo para a redução de falhas, e no aumento da sustentabilidade e agilidade.

## Qual o contexto?
As cidades inteligentes (Smart Cities) utilizam tecnologia para melhorar a qualidade de vida, otimizar recursos e tornar os serviços mais eficientes. No setor de transportes, a digitalização tem um papel crucial na automação e monitoramento de sistemas como metrôs e ferrovias, garantindo maior segurança, eficiência e sustentabilidade. Um dos desafios das Smart Cities é a gestão inteligente do transporte ferroviário, que exige sistemas eficientes para controle de rotas, monitoramento de trens, manutenção preditiva e segurança operacional. Aplicativos móveis desempenham um papel essencial nesse contexto, permitindo que operadores e gestores acessem informações em tempo real e tomem decisões estratégicas de forma ágil.

**Funcionalidades principais** 
- Dashboard (início): a página de início mostra as notificações e alertas recentes do usuário, os trens que estão partindo e um mapa das estações e rotas dos trens.
- Área do Usuário: dentro dessa página, o usuario pode ver os seus dados informados no cadastro.
- Alertas: os administradores podem criar alertas que podem ser emitidos para os usuários ou outros administradores e ver os alertas que recebeu.
- Chamados de Manutenção: os administradores podem abrir chamados de manutenção de trens que podem ser emitidos para outros administradores e ver os chamados em aberto.
- Estações: os administradores podem adicionar estações da cidade que podem ser vistos pelos usuários.
- Itinerário: os administradores podem criar o caminho que os trens percorrem (de estação para estação), que vai ser disponibilizado para os usuários.
- Relatórios: os administradores podem ver a quantidade de alertas que cada usuário recebeu e os trens com a quantidade de chamados abertos pelo mesmo.
- Rotas: os administradores criar rotas a partir dos itinerários, e essas rotas vão ser disponibilizadas para os usuários.
- Sobre: essa página fala sobre o propósito do projeto, as funções de seus criadores e o link da documentação do projeto.
- Trens: os administradores podem adicionar um novo trem, que vai ser disponibilizado para os usuários.

**Tecnologias utilizadas:** PHP, HTML, CSS, JavaScript

**Equipe de desenvolvimento:** Fernanda Ribeiro Sant’Anna, Gabriela Vitória Maes, João Rodrigo Heinzelmann Luckow, Mariana Lopes Carvalho Pita e Yasmin Victhoria da Silva.

**Licença:** Boost Software License 1.0

**Estrutura do repositório (Listagem dos Arquivos):**
.ideia - .gitignore -, css - admin.css, maintenance.css, style.css -, html - admin, templates, about_us.html, index.html, login.html, maps.html, reports.html, schedule.html, trains.html -, imagens - Nextrain.png -, js - add_task.js, admin-icon-loader.js, calendar.js, confirm_delete.js, dark_mode.js, graph_relations_updater.js, graph_view.js, icon-loader.js, login.js, maintenance-requests.js, reports.js, routes.js, sidebar.js, stations.js -, php - mqtt              , ping_sation.php -, add_itinerary.php -, add_route.php -, add_routes.php-, add_station.php-, add_task.php-, add_trains.php-, alerts-requests.php-, alerts.php-, changepassword.php-, db.php-, edit_alert.php-, edit_itinerary.php-, edit_route.php-, edit_station.php-, excluir_alerta.php-, excluir_chamados.php-, excluir_estacao.php-, excluir_itinerario.php-, excluir_rota.php-, excluir_trem.php-, gerenciamento.php-, get_dest_itinerario.php-, get_orig_itinerario.php-, graph_view.php-, insert_alerts_requests.php-, insert_itinerary.php-, insert_requests.php-, insert_route.php-, insert_station.php-, insert_task.php-, insert_train.php-, itinerary.php-, listar_alerts.php-, listar_arestas_estacao.php-, listar_chamados_manutencao.php-, listar_estacao.php-, listar_funcionarios.php-, listar_itinerario.php-, listar_rotas.php-, listar_trem.php-, login.php-, logout.php-, maintenance-requests.php-, maintenance.php-, notification.php-, permission_handler.php-, process_edit_alert.php-, process_edit_itinerary.php-, process_edit_route.php, process_edit_station.php-, register.php-, reports.php-, routes.php-, sair.php-, station.php-, trains.php-, user.php-, usermod_handler.php.  vendor - composer, myclabs/php-enum, php-mqtt/client, psr/log, autoload.php -, .DS_Store, .gitignore, LICENSE, README.md, composer.json, composer.lock, composer.phar, debug_db_structure.php, favicon.ico, index.php.


