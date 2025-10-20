const traj = document.getElementById("trajectory");

traj.addEventListener('change',function(){
    alert('changed - new value: ' + traj.innerText);
});