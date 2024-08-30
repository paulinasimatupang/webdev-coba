<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Transactions Report</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Transaction Code</th>
                <th>Amount</th>
                <th>Fee</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction[0] }}</td>
                    <td>{{ $transaction[1] }}</td>
                    <td>{{ $transaction[2] }}</td>
                    <td>{{ $transaction[3] }}</td>
                    <td>{{ $transaction[4] }}</td>
                    <td>{{ $transaction[5] }}</td>
                    <td>{{ $transaction[6] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
