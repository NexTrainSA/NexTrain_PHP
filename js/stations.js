// Helper function to get status from chip
function getStatusFromChip(chip) {
    if (!chip) return 'unknown';

    const label = chip.getAttribute('label')?.toLowerCase() || '';

    if (label.includes('OPEN')) return 'active';
    if (label.includes('MAINTENANCE')) return 'maintenance';
    if (label.includes('PERMANENTLY_CLOSED')) return 'inactive';
    if (label.includes('UNKNOWN')) return 'warning';

    return 'unknown';
}

// View route details
function viewRouteDetails(routeId) {
    // This would typically navigate to a detailed view or open a modal
    console.log(`Viewing details for route: ${routeId}`);

    // For now, just show an alert - this can be replaced with actual navigation
    // or modal functionality later
    alert(`Visualizando detalhes da estação ${routeId}`);
}

// Real-time search functionality
document.addEventListener('DOMContentLoaded', function () {
    const searchField = document.getElementById('route-search');

    if (searchField) {
        searchField.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const routeCards = document.querySelectorAll('.route-detail-card');

            routeCards.forEach(card => {
                const routeName = card.querySelector('.route-name')?.textContent?.toLowerCase() || '';
                const routeLine = card.querySelector('.route-line')?.textContent?.toLowerCase() || '';
                const stations = Array.from(card.querySelectorAll('.station')).map(s => s.textContent.toLowerCase());

                const matches = routeName.includes(searchTerm) ||
                    routeLine.includes(searchTerm) ||
                    stations.some(station => station.includes(searchTerm));

                card.style.display = matches ? 'block' : 'none';
            });
        });
    }
});

// Load more routes functionality
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.querySelector('.load-more-btn');

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            // This would typically load more data from the server
            console.log('Loading more routes...');

            // For now, just show a message
            this.innerHTML = '<md-icon slot="icon">hourglass_empty</md-icon>Carregando...';
            this.disabled = true;

            setTimeout(() => {
                this.innerHTML = '<md-icon slot="icon">expand_more</md-icon>Carregar Mais Estações';
                this.disabled = false;
                alert('Novas estações foram carregadas!');
            }, 2000);
        });
    }
});

window.onload = function() {
    for(let i = 0; i<document.getElementsByClassName("route-info").length; i++) {
        let stationName = document.getElementsByClassName("route-info")[i].getElementsByClassName("route-name")[0].innerText
        pingStatus = pingStation(stationName).then((status) => {
            console.log(i + " - " + stationName + ": " + status);
            let child = document.getElementsByClassName("route-info")[i].parentElement.appendChild(document.createElement("md-suggestion-chip"));
            child.label = status.toUpperCase();
            if(status == "online") {
                child.style = "background-color: #5BB65F; --_label-text-color:: #FAFAFA;";
            }   else {
                child.style = "background-color: #B45555; --_label-text-color: #FAFAFA;";
            }
        });
    }
};

function pingStation(stationName) {
    return fetch(`php/mqtt/ping_station.php?station=${encodeURIComponent(stationName)}`)
    .then(response => response.json())
    .then(data => {
        return data.status;
    })
    .catch(error => {
        console.error('Error pinging station:', error);
    });
}