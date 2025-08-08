<script src="{{ asset('assets/admin/js/plugins/chartjs.min.js') }}" async></script>
<script src="{{ asset('assets/admin/js/plugins/perfect-scrollbar.min.js') }}" async></script>

<script src="{{ asset('assets/admin/js/argon-dashboard-tailwind.js') }}?v=1.0.1" async></script>

<!-- Flash Messages Auto Hide -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto hide flash messages after 5 seconds
    const flashMessages = document.querySelectorAll('#flash-message');
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            message.style.transform = 'translateY(-100%)';
            setTimeout(function() {
                message.remove();
            }, 300);
        }, 5000);
    });
});
</script>
