<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th>Sl</th>
                <th>Date</th>                    
                <th>Purpose</th>
                <th>Payment Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomes as $income)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $income->income_date }}</td>
                <td>{{ $income->purpose }}</td>
                <td >{{$income->payment_type =='1' ? 'Cash' : "Cheque (".$income->cheque_number.")"}}</td>
                <td>{{ -$income->amount }}</td>
            </tr>
            @endforeach
            @for($i=0;$i<count($sales);$i++)
            <tr>
                <td>{{$i + 1}}</td>
                <td>{{ $sales[$i]->sale_date }}</td>
                <td>Sale</td>
                <td></td>
                <td>
                    {{$sum[$i]}}
                </td>
            </tr>
            @endfor
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align:right">Remaining:</th>
                <th>{{$remaining}}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>