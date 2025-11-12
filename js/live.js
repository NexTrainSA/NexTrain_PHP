window.onload = function() {
    const ws = new WebSocket('ws://179.155.211.130:6777');

    ws.onmessage = function(event) {
        if(!event.data.startsWith('{')) return;
        const data = JSON.parse(event.data);
        console.log(data);

        if(data.STATION === 'S1') {
            d2 = JSON.parse(data.data);
            document.getElementById('temp-s1').innerText = d2.TEMPERATURE;
            document.getElementById('humidity-s1').innerText = d2.HUMIDITY;
            document.getElementById('luminosity-s1').innerText = d2.LUMINOSITY;
            document.getElementById('presence-s1').innerText = d2.PRESENCE;
            document.getElementById('led-state-s1').innerText = d2.LED_STATE;
            document.getElementById('led-rgb-s1').innerText = d2.LED_RGB;
        }

        if(data.STATION === 'S2') {
            d2 = JSON.parse(data.data);
            document.getElementById('presence2-s2').innerText = d2.PRESENCE2;
            document.getElementById('presence4-s2').innerText = d2.PRESENCE4;
            document.getElementById('led-state-s2').innerText = d2.LED_STATE;
            document.getElementById('led-rgb-s2').innerText = d2.LED_RGB;
            document.getElementById('servo-s2').innerText = d2.SERVO_STATE;
        }

        if(data.STATION === 'S3') {
            d2 = JSON.parse(data.data);
            document.getElementById('presence3-s3').innerText = d2.PRESENCE3;
            document.getElementById('led-state-s3').innerText = d2.LED_STATE;
            document.getElementById('led-rgb-s3').innerText = d2.LED_RGB;
        }

        if(data.STATION === 'S4') {
            d2 = JSON.parse(data.data);
            document.getElementById('led-rgb-s4').innerText = d2.LED_RGB;
            document.getElementById('speed-s4').innerText = d2.SPEED * 100;
            document.getElementById('direction-s4').innerText = d2.SPEED > 0 ? "Frente" : (d2.SPEED < 0 ? "Ré" : "Parado");
        }
    };
    document.getElementById('toggle-led-s1').onclick = function() {
        ws.send(JSON.stringify({ STATION: 'S1', DATA: "TOGGLE_LED" }));
    };
    document.getElementById('toggle-led-s2').onclick = function() {
        ws.send(JSON.stringify({ STATION: 'S2', DATA: "TOGGLE_LED" }));
    };
    document.getElementById('toggle-led-s3').onclick = function() {
        ws.send(JSON.stringify({ STATION: 'S3', DATA: "TOGGLE_LED" }));
    };

    document.getElementById('toggle-servo-s2').onclick = function() {
        ws.send(JSON.stringify({ STATION: 'S2', DATA: "TOGGLE_SERVO" }));
    };
    document.getElementById('set-speed-s4').onclick = function() {
        const speed = parseFloat(document.getElementById('speed-slider-s4').value);
        ws.send(JSON.stringify({ STATION: 'S4', DATA: "speed/" + speed }));
    };
    document.getElementById('speed-slider-s4').oninput = function() {
        const speed = parseFloat(document.getElementById('speed-slider-s4').value);
        document.getElementById('speed-slider-s4-value').innerText = (speed * 100).toFixed(0);
    };

}
