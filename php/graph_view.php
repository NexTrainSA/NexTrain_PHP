<?php
  echo '    <script src="https://cdnjs.cloudflare.com/ajax/libs/sigma.js/2.4.0/sigma.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/graphology/0.25.4/graphology.umd.min.js"></script>
    <div id="container2" style="width: 1000px; height: 600px; background: #fafafa"></div>
    <script>
      const graph = new graphology.Graph();


    ';
        include_once('db.php');
        include_once('listar_estacao.php');
        include_once('listar_arestas_estacao.php');

        $x = 0;
        $y = 0;

        foreach($estacoes as $estacao) {
            $x += rand(-100, 100);
            $y += rand(-100, 100);
            echo('graph.addNode("'.$estacao["id_estacao"].'", { label: "'.$estacao["nome_estacao"].'", x: '.$x.', y: '.$y.', size: 10, color: "'.parseStationStatusToColor($estacao["status_estacao"]).'" });');
        }

        $edges = list_all_edges();
        foreach($edges as $edge) {
            echo('graph.addEdge("'.$edge["id_estacao1"].'", "'.$edge["id_estacao2"].'", { size: 2, color: "gray" });');
        }
      echo '

      const sigmaInstance = new Sigma(graph, document.getElementById("container2"));

    </script>
  ';
?>

