<!DOCTYPE html>
<html>
<head>
    <style>
        /* Styles for table, th, td, etc. */
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
        /* Additional styles can be added as needed */
        .invoice-header {
            margin-bottom: 20px;
        }
        .invoice-header img {
            max-width: 150px;
        }
        .logo-container {
            background-image: url('{{ asset('icon.png') }}');
            background-size: contain; /* Adjust size as needed */
            width: 200px; /* Example width */
            height: 100px; /* Example height */
        }
    </style>
</head>
<body>
    <h2>Invoice</h2>

    @if ($order->status === 'Confirmed')
        <h3>Order Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit_price }}</td>
                    <td>{{ $item->quantity * $item->unit_price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Order Summary</h3>
        <table>
            <tbody>
                <tr>
                    <td><strong>Order ID:</strong></td>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <td><strong>Total Price:</strong></td>
                    <td>{{ $order->total_price }}</td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td>{{ $order->status }}</td>
                </tr>
                <tr>
                    <td><strong>Date:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>This order is not confirmed. Invoice cannot be generated.</p>
    @endif
</body>
</html>
