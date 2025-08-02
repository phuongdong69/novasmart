<script src="{{ asset('assets/user/libs/tobii/js/tobii.min.js') }}"></script>
<script src="{{ asset('assets/user/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/user/js/plugins.init.js') }}"></script>
<script src="{{ asset('assets/user/js/app.js') }}"></script>

<!-- JS xử lý popup login -->
<script src="{{ asset('assets/user/js/popup-cart.js') }}"></script>

<!-- Header Scroll Fix -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('topnav');
    
    function handleScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('scroll');
        } else {
            navbar.classList.remove('scroll');
        }
    }
    
    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Check initial state
});
</script>
