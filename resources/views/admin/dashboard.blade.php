
@extends('layouts.admin')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@section('content')

<style>
    /* .bg-primary {
        background-color: #02fd41 !important;
    } */
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-6" id="1">
                <div class="card-body">Recyclable</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="card-contain card-body">
                        <ol>
                            <li>Plastic</li>
                            <li>Plastic</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Biodegradable</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="card-contain card-body">
                        <ol>
                            <li>Leaf</li>
                            <li>Paper</li>
                            <li>Paper towels</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Residual</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="card-contain card-body">
                        <ol>
                            <li>diapers</li>
                            <li>Styrofoam</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Hazardous</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="card-contain card-body">
                        <ol>
                            <li>Batteries</li>
                            <li>Broken gadgets</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Bar Chart Example
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div> --}}
@endsection
