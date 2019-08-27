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
<div class="content-header">
    <h3>
        <i class="fa fa-home text-success" aria-hidden="true"></i>
        Dashboard
    </h3>
</div>

<hr>

{{-- Short report --}}
<div class="row">
    {{-- Total product count --}}
    <div class="col-sm-4">
        <div class="alert alert-dark">
            <button type="button" class="close">
                <i class="fa fa-barcode fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Products</h4>
            <h2 class="mall">{{count($products)}}</h2>
        </div>
    </div>

    {{-- Total customer count --}}
    <div class="col-sm-4">
        <div class="alert alert-primary">
            <button type="button" class="close">
                <i class="fa fa-users fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Customers</h4>
            <h2 class="mall">{{count($customers)}}</h2>
        </div>
    </div>

    {{-- Total employee count --}}
    <div class="col-sm-4">
        <div class="alert alert-danger">
            <button type="button" class="close">
                <i class="fa fa-users fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Users</h4>
            <h2 class="mall">{{count($users)}}</h2>
        </div>
    </div>                
</div>

@role('super_admin')
<div class="row">
    {{-- Total sale count --}}
    <div class="col-sm-4">
        <div class="alert alert-primary">
            <button type="button" class="close">
                <i class="fa fa-money fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Today's Sale</h4>
            <h2 class="mall">{{$sales}}</h2>
        </div>
    </div>

    {{-- Total Expense count --}}
    <div class="col-sm-4">
        <div class="alert alert-warning">
            <button type="button" class="close">
                <i class="fa fa-usd fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Today's Expense</h4>
            <h2 class="mall">{{$expenses}}</h2>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="alert alert-dark">
            <button type="button" class="close">
                <i class="fa fa-money fa-2x" aria-hidden="true"></i>
            </button>
            <h5>Today's Received Amount</h5>
            <h2 class="mall">{{$incomes}}</h2>
        </div>
    </div>                
</div>
<div class="row">
    {{-- Total sale count --}}
    <div class="col-sm-5">
        <div class="alert alert-secondary">
            <button type="button" class="close">
                <i class="fa fa-money fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Purchase Table</h4>
            <table>
                <tr>
                    <td>Total Purchase</td>
                    <td>{{$totalpurchaseprice}}</td>
                </tr>
                <tr>
                    <td>Total Sold (with damage)</td>
                    <td>{{$solditem}}</td>
                </tr>
                <tr>
                    <td>Remaining Product</td>
                    <td>{{$remainingproduct}}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Total Expense count --}}
    <div class="col-sm-7">
        <div class="alert alert-danger">
            <button type="button" class="close">
                <i class="fa fa-usd fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Income Table</h4>
            <table>
                <tr>
                    <td>Total Sales (Cash + Account Receivable)</td>
                    <td>{{$totalsales}} ({{$totalincomes}} + {{$receivable}})</td>
                </tr>
                <tr>
                    <td>Sales Amount</td>
                    <td>{{$solditem - $damage}}</td>
                </tr>
                <tr>
                    <td>Income</td>
                    <td>{{$incomeamount}}</td>
                </tr>
            </table>
        </div>
    </div>              
</div>
<div class="row">

    {{-- Total Expense count --}}
    <div class="col-sm-6">
        <div class="alert alert-dark">
            <button type="button" class="close">
                <i class="fa fa-usd fa-2x" aria-hidden="true"></i>
            </button>
            <h4>Profit Table</h4>
            <table>
                <tr>
                    <td>Income</td>
                    <td>{{$incomeamount}}</td>
                </tr>
                <tr>
                    <td>Total Expenses</td>
                    <td>{{$totalexpenses}}</td>
                </tr>

                <tr>
                    <td>Damage</td>
                    <td>{{$damage}}</td>
                </tr>

                <tr>
                    @if($netprofit < 0)
                    <td>Net Loss</td>
                    <td>
                        {{abs($netprofit)}}
                    </td>
                    @else
                    <td>Net Profit</td>
                    <td>{{$netprofit}}</td>
                    @endif
                </tr>

                <tr>
                    <td>Receivable Amount From Loan</td>
                    <td>{{$loanReceivable}}</td>
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
