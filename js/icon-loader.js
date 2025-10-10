// Icon loading utilities
function ensureIconsLoaded() {
    // Create a test element to force font loading
    const testElement = document.createElement('div');
    testElement.className = 'material-icons-load-test';
    document.body.appendChild(testElement);

    // Check if font is loaded by measuring text width
    function checkFontLoaded() {
        const testIcon = document.createElement('md-icon');
        testIcon.textContent = 'schedule';
        testIcon.style.position = 'absolute';
        testIcon.style.left = '-9999px';
        testIcon.style.visibility = 'hidden';
        document.body.appendChild(testIcon);

        const width = testIcon.offsetWidth;
        document.body.removeChild(testIcon);

        // If width is greater than 0, font is likely loaded
        return width > 0;
    }

    // Retry logic for font loading
    let retries = 0;
    const maxRetries = 10;

    function retryFontLoad() {
        if (checkFontLoaded() || retries >= maxRetries) {
            document.body.removeChild(testElement);
            document.body.classList.add('icons-loaded');
            return;
        }

        retries++;
        setTimeout(retryFontLoad, 100);
    }

    // Start checking
    setTimeout(retryFontLoad, 50);
}

// Initialize icon loading when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ensureIconsLoaded);
} else {
    ensureIconsLoaded();
}

// Fallback for older browsers or if Material Web Components fail
document.addEventListener('DOMContentLoaded', function () {
    // Check all md-icon elements and ensure they have content
    const icons = document.querySelectorAll('md-icon');

    icons.forEach(icon => {
        if (!icon.textContent.trim()) {
            // If md-icon is empty, try to get icon name from class or data attributes
            const classList = Array.from(icon.classList);
            const iconName = classList.find(cls => cls.includes('icon')) || 'help';

            if (iconName && iconName !== 'icon') {
                icon.textContent = iconName.replace('-icon', '').replace('_', '_');
            }
        }
    });
});
