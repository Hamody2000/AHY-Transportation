<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/logo.png') }}" alt="AHY Transportation" class="img-fluid navbar-logo" style="width: 150px;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto custom-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('daily_expenses.index') }}">المصاريف اليومية</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('client_revenues.index') }}">إيرادات العملاء</a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('employees.index') }}">الموظفين</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('vehicles.index') }}">المركبات</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('clients.index') }}">العملاء</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('salaries.index') }}">الرواتب</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('loans.index') }}">السلف</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('individual_transactions.index') }}">معاملات افراد</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('company_transactions.index') }}">معاملات شركات</a>
            </li>
        </ul>
    </div>
</nav>
