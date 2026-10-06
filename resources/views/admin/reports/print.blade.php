<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan — Pamulang Fish Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #1e293b;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #0f172a;
        }
        .header p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 11px;
        }
        .summary-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background: #f8fafc;
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #64748b;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #0284c7; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            Cetak Dokumen Laporan (Print / PDF)
        </button>
    </div>

    <div class="header">
        <h1>PAMULANG FISH STORE</h1>
        <p>Toko Online 100% Khusus Ikan Cupang Hias (Betta Fish Only) &mdash; Rekapitulasi Laporan Penjualan</p>
        <p>Jl. Surya Kencana No. 88, Pamulang Barat, Tangerang Selatan &bull; Dicetak: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <div class="summary-box">
        <div>
            <strong>Total Transaksi Lunas:</strong> {{ $totalPaidOrders }} Pesanan
        </div>
        <div>
            <strong>Total Omzet Penjualan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>No. Pesanan</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Kota Pengiriman</th>
                <th>Status Bayar</th>
                <th class="text-right">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $idx => $ord)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $ord->order_number }}</strong></td>
                    <td>{{ $ord->created_at->format('d/m/Y') }}</td>
                    <td>{{ $ord->customer_name }}</td>
                    <td>{{ $ord->shipping_city }}</td>
                    <td>{{ strtoupper($ord->payment_status) }}</td>
                    <td class="text-right">Rp {{ number_format($ord->total_amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #f8fafc; font-weight: bold;">
                <td colspan="6" class="text-right">TOTAL OMZET KESELURUHAN:</td>
                <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div>Dicetak oleh: {{ auth()->user()->name ?? 'Administrator Pamulang Fish' }}</div>
        <div>Halaman Resmi Sistem Informasi Pamulang Fish Store</div>
    </div>
</body>
</html>
