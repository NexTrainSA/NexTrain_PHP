const traj = document.getElementById("trajectory");

traj.addEventListener('change',function(){
    alert('changed - new value: ' + traj.value);

    $.get( "php/listar_arestas_estacao?id_estacao=" + traj.value, function( data ) {
        var json = $.parseJSON(data);
        alert(json);
        console.log(json);
    });
});