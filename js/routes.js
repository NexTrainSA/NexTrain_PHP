// Routes page functionality

// Toggle filters panel
function toggleFilters() {
    const filtersPanel = document.getElementById('filters-panel');
    const filterBtn = document.getElementById('filter-btn');

    if (filtersPanel.style.display === 'none' || filtersPanel.style.display === '') {
        filtersPanel.style.display = 'block';
        filterBtn.innerHTML = '<md-icon slot="icon">filter_list_off</md-icon>Ocultar Filtros';
    } else {
        filtersPanel.style.display = 'none';
        filterBtn.innerHTML = '<md-icon slot="icon">filter_list</md-icon>Filtros';
    }
}

// Clear all filters
function clearFilters() {
    const selects = document.querySelectorAll('md-outlined-select');
    selects.forEach(select => {
        select.value = 'all';
    });

    const searchField = document.getElementById('route-search');
    searchField.value = '';

    // Reset all route cards visibility
    const routeCards = document.querySelectorAll('.route-detail-card');
    routeCards.forEach(card => {
        card.style.display = 'block';
    });
}

// Apply filters
function applyFilters() {
    const statusFilter = document.querySelector('md-outlined-select[label="Status"]')?.value || 'all';
    const lineFilter = document.querySelector('md-outlined-select[label="Linha"]')?.value || 'all';
    const searchTerm = document.getElementById('route-search')?.value?.toLowerCase() || '';

    const routeCards = document.querySelectorAll('.route-detail-card');

    routeCards.forEach(card => {
        let shouldShow = true;

        // Get card data
        const routeName = card.querySelector('.route-name')?.textContent?.toLowerCase() || '';
        const routeLine = card.querySelector('.route-line')?.textContent?.toLowerCase() || '';
        const statusChip = card.querySelector('.status-chip');
        const status = getStatusFromChip(statusChip);

        // Apply search filter
        if (searchTerm && !routeName.includes(searchTerm) && !routeLine.includes(searchTerm)) {
            shouldShow = false;
        }

        // Apply status filter
        if (statusFilter !== 'all' && status !== statusFilter) {
            shouldShow = false;
        }

        // Apply line filter
        if (lineFilter !== 'all') {
            const lineMatch = routeLine.includes(lineFilter.replace('line', 'linha'));
            if (!lineMatch) {
                shouldShow = false;
            }
        }

        card.style.display = shouldShow ? 'block' : 'none';
    });

    // Close filters panel after applying
    toggleFilters();
}

// Helper function to get status from chip
function getStatusFromChip(chip) {
    if (!chip) return 'unknown';

    const label = chip.getAttribute('label')?.toLowerCase() || '';

    if (label.includes('horário')) return 'active';
    if (label.includes('atraso')) return 'delayed';
    if (label.includes('manutenção')) return 'maintenance';

    return 'unknown';
}

// View route details
function viewRouteDetails(routeId) {
    // This would typically navigate to a detailed view or open a modal
    console.log(`Viewing details for route: ${routeId}`);

    // For now, just show an alert - this can be replaced with actual navigation
    // or modal functionality later
    alert(`Visualizando detalhes da rota ${routeId}`);
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
                this.innerHTML = '<md-icon slot="icon">expand_more</md-icon>Carregar Mais Rotas';
                this.disabled = false;
                alert('Novas rotas foram carregadas!');
            }, 2000);
        });
    }
});
