@extends('layouts.master')
@section('title', 'Home')

@section('content')
<!-- Content Header (Page header) -->
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session('success')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<hr>

@role('super_admin')
<div class="row">

    {{-- Total Expense count --}}
    <div class="col-sm-6">
        <div class="alert alert-dark">
            <button type="button" class="close">
                <i class="fa fa-usd fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Report From {{$start_date}} To {{$end_date}}</h4>
            <table>
                <tr>
                    <td>Total Purchase</td>
                    <td>{{$totalpurchaseprice}}</td>
                </tr>

                <tr>
                    <td>Total Sales</td>
                    <td>{{$totalsales}}</td>
                </tr>
                <tr>
                    <td>Total Income</td>
                    <td>{{$totalincomes}}</td>
                </tr>
                <tr>
                    <td>Total Expenses</td>
                    <td>{{$totalexpenses}}</td>
                </tr>

                <tr>
                    <td>Damage</td>
                    <td>{{$damage}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="alert alert-success">
            <button type="button" class="close">
                <i class="fa fa-line-chart fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Date to Date Report</h4>
            <form id="particularexpense" method="GET" action="{{url('allreport')}}">
                {{ csrf_field() }}
                <div class="form-group col-sm-6">
                    <label for="inlineFormCustomSelect">Start Date</label>
                    <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
                </div>
                <div class="form-group col-sm-6">
                    <label for="inlineFormCustomSelect">End Date</label>
                    <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date">
                </div>
                <button type="submit" class="btn btn-info"><i class="fa fa-line-chart" aria-hidden="true"></i> Report</button>
            </form>
        </div>
    </div>                
</div>
@endrole
@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
    $( function() {
        $( "#start_date" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
        });
    } );
</script>

<script>
    $( function() {
        $( "#end_date" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
        });
    } );
</script>
@endsection
