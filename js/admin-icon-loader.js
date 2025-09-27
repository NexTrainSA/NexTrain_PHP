// Admin Icon Loading Script
// Ensures Material Icons load properly in admin pages

document.addEventListener('DOMContentLoaded', function() {
    // Force load Material Icons font
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap';
    document.head.appendChild(link);
    
    // Backup font loading
    const linkBackup = document.createElement('link');
    linkBackup.rel = 'stylesheet';
    linkBackup.href = 'https://fonts.googleapis.com/icon?family=Material+Icons';
    document.head.appendChild(linkBackup);
    
    // Wait for fonts to load, then fix any broken icons
    setTimeout(function() {
        fixIconDisplay();
    }, 1000);
    
    // Fix icon display on window load as well
    window.addEventListener('load', function() {
        setTimeout(fixIconDisplay, 500);
    });
});

function fixIconDisplay() {
    // Find all md-icon elements and ensure they render properly
    const icons = document.querySelectorAll('md-icon');
    
    icons.forEach(function(icon) {
        // Force font family
        icon.style.fontFamily = "'Material Symbols Outlined', 'Material Icons', sans-serif";
        icon.style.fontWeight = 'normal';
        icon.style.fontStyle = 'normal';
        icon.style.fontSize = icon.style.fontSize || '24px';
        icon.style.lineHeight = '1';
        icon.style.letterSpacing = 'normal';
        icon.style.textTransform = 'none';
        icon.style.display = 'inline-block';
        icon.style.whiteSpace = 'nowrap';
        icon.style.wordWrap = 'normal';
        icon.style.direction = 'ltr';
        icon.style.fontFeatureSettings = "'liga'";
        icon.style.WebkitFontSmoothing = 'antialiased';
        icon.style.fontVariationSettings = "'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24";
        
        // Ensure icon content is properly displayed
        if (icon.textContent && icon.textContent.trim()) {
            // Icon has text content, make sure it's displayed as an icon
            icon.setAttribute('aria-hidden', 'true');
        }
        
        // Force a repaint
        icon.style.transform = 'translateZ(0)';
    });
    
    console.log('Admin icons fixed:', icons.length, 'icons processed');
}

// Export for use in other scripts
window.fixAdminIcons = fixIconDisplay;
