const traj = document.getElementById("trajectory");

traj.addEventListener('change',function(){
    alert('changed - new value: ' + traj.value);

    $.get( "php/listar_arestas_estacao?id_estacao=" + traj.value, function( data ) {
        $( ".result" ).html( data );
        alert( "Load was performed." );
    });
});