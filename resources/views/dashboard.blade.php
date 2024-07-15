@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- ALL Transactions Card -->
        <div class="col-md-3 mb-4">
            <a href="{{ route('transactions.search') }}" class="card-link">
                <div class="card text-white text-center p-3" style="background-color: #6A9468; cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title">التعاملات اليومية</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Employees Card -->
        <div class="col-md-3 mb-4">
            <a href="{{ route('employees.index') }}" class="card-link">
                <div class="card text-white text-center p-3" style="background-color: #7b719d; cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title">الموظفين</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Vehicles Card -->
        <div class="col-md-3 mb-4">
            <a href="{{ route('vehicles.index') }}" class="card-link">
                <div class="card text-white text-center p-3" style="background-color: #9d9d78; cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title">المركبات</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Clients Card -->
        <div class="col-md-3 mb-4">
            <a href="{{ route('clients.index') }}" class="card-link">
                <div class="card text-white text-center p-3" style="background-color: #689487; cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title">العملاء</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Individuals Transactions Card -->
        <div class="col-md-3 mb-4">
            <a href="{{ route('individual_transactions.index') }}" class="card-link">
                <div class="card text-white text-center p-3" style="background-color: #E1BB84; cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title">معاملات أفراد</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Company Transactions Card -->
        <div class="col-md-3 mb-4">
            <a href="{{ route('company_transactions.index') }}" class="card-link">
                <div class="card text-white text-center p-3" style="background-color: #E18484; cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title">معاملات شركات</h5>
                    </div>
                </div>
            </a>
        </div>
           <!-- Total loans Card -->
           <div class="col-md-3 mb-4">
            <a href="{{ route('loans.index') }}" class="card-link">
                <div class="card text-white text-center p-3" style="background-color: #c787bc; cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title">السلف</h5>
                    </div>
                </div>
            </a>
        </div>
            <!-- Total transactions Card -->
            <div class="col-md-3 mb-4">
                <a href="{{ route('loans.index') }}" class="card-link">
                    <div class="card text-white text-center p-3" style="background-color: #453d57; cursor: pointer;">
                        <div class="card-body">
                            <h5 class="card-title">المصاريف</h5>
                        </div>
                    </div>
                </a>
            </div>

        <!-- Recent Transactions Card (Optional) -->
        {{-- <div class="col-md-3 mb-4">
            <a href="{{ route('financial-transactions.index') }}" class="card-link">
                <div class="card text-white bg-info text-center p-3" style="cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title">Recent Transactions</h5>
                        <ul class="list-unstyled">
                            @foreach($recentTransactions as $transaction)
                            <li>
                                <p class="mb-1">{{ $transaction->description }}</p>
                                <p class="mb-0">${{ number_format($transaction->amount, 2) }} - {{ $transaction->created_at->format('Y-m-d') }}</p>
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('financial-transactions.index') }}" class="btn btn-light">View All Transactions</a>
                    </div>
                </div>
            </a>
        </div> --}}
    </div>
</div>
@endsection
