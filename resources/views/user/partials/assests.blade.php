<style>
    body, h1, h2, h3, h4, h5, h6, input, button, select, textarea {
        font-family: 'Open Sans', Arial, Helvetica, Tahoma, Verdana, sans-serif !important;
    }
    .tagline, #topnav, .logo, .navigation-menu, .submenu, .megamenu-head, .dropdown-menu, .buy-button, .menu-extras, .navbar-toggle, .menu-arrow, .submenu-arrow, .sub-menu-item {
        font-family: 'Open Sans', Arial, Helvetica, Tahoma, Verdana, sans-serif !important;
    }
    .navigation-menu > li > a {
        font-family: 'Open Sans', Arial, Helvetica, Tahoma, Verdana, sans-serif !important;
    }
    
    /* Logo styling */
    .logo {
        text-decoration: none !important;
    }
    
    .logo:hover {
        text-decoration: none !important;
    }
    
    /* Responsive logo */
    @media (max-width: 768px) {
        .logo .text-2xl {
            font-size: 1.25rem !important;
        }
        .logo .text-xs {
            font-size: 0.625rem !important;
        }
        .logo .gap-3 {
            gap: 0.5rem !important;
        }
    }
    
    @media (max-width: 480px) {
        .logo .text-2xl {
            font-size: 1rem !important;
        }
        .logo .text-xs {
            font-size: 0.5rem !important;
        }
        .logo .gap-3 {
            gap: 0.25rem !important;
        }
    }
</style>

<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Css -->
    <link href="{{ asset('assets/user/libs/tobii/css/tobii.min.css') }}" rel="stylesheet">

    <!-- Main Css -->
     <link href="{{ asset('assets/user/libs/%40mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets/user/css/tailwind.css') }}" rel="stylesheet" type="text/css">