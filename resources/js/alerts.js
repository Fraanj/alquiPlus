// Gestión de alertas de la aplicación
document.addEventListener('DOMContentLoaded', function() {

    // Auto-cerrar alertas de éxito después de 4 segundos
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.opacity = '0';
            successAlert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => successAlert.remove(), 500);
        }, 4000);
    }

    // Función global para cerrar alertas manualmente
    window.closeAlert = function(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.remove();
        }
    }
});
