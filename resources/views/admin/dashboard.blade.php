@extends('layouts.admin')
@section('title')
الرئيسية
@endsection

@section('css')
<style>


.dashboard {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    padding: 20px;
    background-color: #e9f7f6;
    border-radius: 10px;
}

.card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
}

.card h2 {
    font-size: 18px;
    color: #555;
    margin-bottom: 10px;
}

.card p {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

</style>
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.dashboard') }}"> الرئيسية </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')
<div class="dashboard">
    <div class="card">
        <h2>Customers Current Balance</h2>
        <p>9,952.030JD</p>
    </div>
    <div class="card">
        <h2>Dealers Current Balance</h2>
        <p>13,903.200JD</p>
    </div>
    <div class="card">
        <h2>Total Transfer From Dealer To Customer</h2>
        <p>565,446.390JD</p>
    </div>
    <div class="card">
        <h2>Number of mobile cards</h2>
        <p>174</p>
    </div>
    <div class="card">
        <h2>Number of mobile cards sales</h2>
        <p>97673</p>
    </div>
    <div class="card">
        <h2>Total mobile cards sales (JD)</h2>
        <p>543,123.160</p>
    </div>
    <div class="card">
        <h2>Number of game cards</h2>
        <p>42</p>
    </div>
    <div class="card">
        <h2>Number of game cards sales</h2>
        <p>3482</p>
    </div>
    <div class="card">
        <h2>Total game cards sales (JD)</h2>
        <p>12,424.510</p>
    </div>
</div>


@endsection



