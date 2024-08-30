<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4;
            margin: 10mm; /* Adjust the margin as needed */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px; /* Adjust font size for better fit */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Force columns to fit within page */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px; /* Reduced padding for better fit */
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis; /* Add ellipsis if text overflows */
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        h1 {
            font-size: 12px; /* Reduced font size for heading */
            text-align: center;
            margin-bottom: 10px;
        }
        /* Optional: Use this rule to rotate table headers if necessary */
        th {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <h1>Merchants Report</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Id</th>
                <th style="width: 15%;">Account No</th>
                <th style="width: 20%;">Name</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 25%;">Address</th>
                <th style="width: 15%;">Phone</th>
                <th style="width: 15%;">TID</th>
                <th style="width: 15%;">Status Agen</th>
                <th style="width: 15%;">Activate Date</th>
                <th style="width: 15%;">Resign Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($merchants as $index => $merchant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $merchant->id }}</td>
                    <td>{{ $merchant->account_no ?? 'N/A' }}</td>
                    <td>{{ $merchant->name ?? 'N/A' }}</td>
                    <td>{{ $merchant->email ?? 'N/A' }}</td>
                    <td>{{ $merchant->address ?? 'N/A' }}</td>
                    <td>{{ $merchant->phone ?? 'N/A' }}</td>
                    <td>{{ $merchant->tid ?? 'N/A' }}</td>
                    <td>{{ $merchant->status_agen ?? 'N/A' }}</td>
                    <td>{{ $merchant->activate_date ? $merchant->activate_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $merchant->resign_date ? $merchant->resign_date->format('Y-m-d') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
