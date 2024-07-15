<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAY Transportation</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo.png') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            direction: rtl;
            text-align: right;
        }

        .navbar-logo {
            max-height: 100%;
            max-width: 100%;
            height: auto;
            width: auto;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            max-height: 100px;
            /* Adjust this value based on your navbar height */
        }

        .custom-nav .nav-item {
            /* text-align: center !important ;
            height: 100px !important ; */
            /* border: 1px solid #ffffff; */
            margin: 8px;
            border-radius: 5px;
        }

        .custom-nav .nav-item:hover {
            background-color: #ffc107;
            /* Darker shade for hover effect */
        }

        .custom-nav .nav-item .nav-link {
            color: #ffffff;
            transition: color 0.3s ease;
        }

        .custom-nav .nav-item .nav-link:hover {
            color: #ffc107;
            /* Bootstrap's warning color for hover effect */
        }

        .card-link:hover .card {
            /* Optional: Add hover effects if needed */
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .form-group {
                margin-bottom: 1rem;
            }

            .form-control {
                width: 100%;
            }

            button:not(.navbar-toggler) {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('layouts.navbar')
    <div class="container mt-5">
        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display error message -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')


    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</body>

</html>
