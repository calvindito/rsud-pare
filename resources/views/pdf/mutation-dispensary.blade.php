<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table td, .table th {
            border: solid thin;
            padding: 0.5rem;
            font-size: 12px;
        }

        .table th {
            font-weight: bold;
        }

        .table td {
            vertical-align: middle;
        }

        .table tbody td:first-child::after {
            content: leader(". ");
        }
    </style>
</head>
<body>
    @include('pdf.header')
    <hr style="margin-top:20px; margin-bottom:20px;">
    <div style="text-align:center;">{{ $dispensaryItem->item->name }}</div>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <table style="width:100%; margin-bottom:20px;">
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Kode</td>
            <td>:</td>
            <td>{{ $item->code }}</td>
            <td style="font-weight:bold;">Berdasarkan</td>
            <td>:</td>
            <td>{{ $columnDate }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Cetak</td>
            <td>:</td>
            <td>{{ date('Y-m-d') }}</td>
            <td style="font-weight:bold;">Dari Tanggal</td>
            <td>:</td>
            <td>{{ $startDate }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Lama Hari</td>
            <td>:</td>
            <td>{{ $diff + 1 }} Hari</td>
            <td style="font-weight:bold;">Sampai Tanggal</td>
            <td>:</td>
            <td>{{ $endDate }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Apotek</td>
            <td>:</td>
            <td>{{ $dispensaryItem->dispensary->name ?? '-' }}</td>
            <td style="font-weight:bold;">Lokasi</td>
            <td>:</td>
            <td>{{ $dispensaryItem->dispensary->dispensaryLocation->name ?? '-' }}</td>
        </tr>
    </table>
    <table class="table">
        <thead>
            <tr style="text-align:center; background:#E5E7EB;">
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
                <tr>
                    <td style="text-align:center;">{{ $d['date'] }}</td>
                    <td>
                        <span style="text-align:left;">{{ $d['stock_in'] }}</span>
                        <span style="float:right;">Stok</span>
                    </td>
                    <td>
                        <span style="text-align:left;">{{ $d['stock_out'] }}</span>
                        <span style="float:right;">Stok</span>
                    </td>
                    <td>
                        <span style="text-align:left;">{{ $d['remaining'] }}</span>
                        <span style="float:right;">Stok</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
