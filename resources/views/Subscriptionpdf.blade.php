<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Subscriptions Report</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
            <tr>
                <td>{{ $subscription->user->name }}</td>
                <td>{{ $subscription->type }}</td>
                <td>{{ Carbon::parse($subscription->start_date)->format('d-m-Y') }}</td>
                <td>{{ Carbon::parse($subscription->end_date)->format('d-m-Y') }}</td>
                <td>{{ $subscription->price }}</td>
                <td>{{ $subscription->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
