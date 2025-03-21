@extends('layouts.app')

@section('content')
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-red-600">404</h1>
            <p class="text-2xl mt-4">Page Not Found</p>
            <p class="mt-2">Sorry, the page you are looking for could not be found.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-4">Go back to Home</a>
        </div>
    </div>
</body>
</html>
@endsection 