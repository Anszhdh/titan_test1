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

    @if ($subscription->payments->isEmpty() || $subscription->payments->where('status', 'Confirmed')->isEmpty())
        <p>This order is not confirmed. Invoice cannot be generated.</p>
    @else

    <h2>Product Details</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Unit Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $subscription->recommendation->product->name }}</td>
                <td>{{ $subscription->recommendation->product->base_price }}</td>
            </tr>
        </tbody>
    </table>
    
        <h3>Subscription Details</h3>
        <table>
            <tbody>
                <tr>
                    <td><strong>Order ID:</strong></td>
                    <td>{{ $subscription->id }}</td>
                </tr>
                <tr>
                    <td><strong>Type:</strong></td>
                    <td>{{ $subscription->type }}</td>
                </tr>
                <tr>
                    <td><strong>Shipping:</strong></td>
                    <td>RM8</td>
                </tr>
                <tr>
                    <td><strong>Payment Method:</strong></td>
                    <td>{{ formatPaymentMethod($subscription->payments->first()->type) }}</td>
                </tr>
                <tr>
                    <td><strong>Total Price:</strong></td>
                    <td>{{ $subscription->price }}</td>
                </tr>
                <tr>
                    <td><strong>Date:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($subscription->created_at)->format('d-m-Y') }}</td>
                </tr>
            </tbody>
        </table>

 
    @endif
</body>
</html>
@php
    function formatPaymentMethod($method) {
        $methods = [
            'bank_transfer' => 'Bank Transfer',
            'qr_code' => 'QR Code',
            // Add other payment methods here if needed
        ];
        return $methods[$method] ?? $method;
    }
@endphp
