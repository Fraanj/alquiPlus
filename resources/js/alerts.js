// Gestión de alertas de la aplicación
document.addEventListener('DOMContentLoaded', function() {

    // Función para auto-cerrar alertas
    function autoCloseAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            setTimeout(function() {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }, 4000);
        }
    }

    // Auto-cerrar alertas de éxito y error después de 4 segundos
    autoCloseAlert('success-alert');
    autoCloseAlert('error-alert');

    // Función global para cerrar alertas manualmente
    window.closeAlert = function(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.remove();
        }
    }
});
