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
    <table style="width:100%; margin-bottom:20px;">
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Pasien</td>
            <td>:</td>
            <td>{{ $data->patient->name }}</td>
            <td style="font-weight:bold;">Dokter</td>
            <td>:</td>
            <td>{{ $data->doctor->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Permintaan</td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($data->date_of_request)) }}</td>
            <td style="font-weight:bold;">Ref</td>
            <td>:</td>
            <td>{{ $data->ref() }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jam Permintaan</td>
            <td>:</td>
            <td>{{ date('H:i:s', strtotime($data->date_of_request)) }}</td>
            <td style="font-weight:bold;">Pemeriksa</td>
            <td>:</td>
            <td>{{ $data->user->employee->name ?? '-' }}</td>
        </tr>
    </table>
    <table class="table" style="margin-bottom:20px;">
        <thead style="background:#E5E7EB;">
            <tr>
                <th>Grup</th>
                <th>Item</th>
                <th>BHP</th>
                <th>JRS</th>
                <th>JASPEL</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($data->labRequestDetail as $lrd)
                @php
                    $consumables = $lrd->consumables;
                    $hospitalService = $lrd->hospital_service;
                    $service = $lrd->service;
                    $subtotal = $consumables + $hospitalService + $service;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $lrd->labItem->labItemGroup->name }}</td>
                    <td>{{ $lrd->labItem->name }}</td>
                    <td nowrap>{{ Simrs::formatRupiah($consumables) }}</td>
                    <td nowrap>{{ Simrs::formatRupiah($hospitalService) }}</td>
                    <td nowrap>{{ Simrs::formatRupiah($service) }}</td>
                    <td nowrap>{{ Simrs::formatRupiah($subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot style="background:#E5E7EB;">
            <tr>
                <td style="font-weight:bold;" colspan="5">TOTAL KESELURUHAN</td>
                <td style="font-weight:bold;">{{ Simrs::formatRupiah($total) }}</td>
            </tr>
        </tfoot>
    </table>
    <table style="width:100%;">
        <tr style="text-align:center;">
            <td>
                <div style="font-size:14px; margin-bottom:60px;">Petugas Pelaksana</div>
                <div style="font-size:14px; margin-bottom:3px; text-decoration:underline;">{{ $data->user->employee->name }}</div>
                <div style="font-size:12px; letter-spacing:0.5px;">NIP. -</div>
            </td>
            <td>
                <div style="font-size:14px; margin-bottom:60px;">Ka. Ins. Laboratorium</div>
                <div style="font-size:14px; margin-bottom:3px; text-decoration:underline;">dr. Erwin Ichsan</div>
                <div style="font-size:12px; letter-spacing:0.5px;">NIP. 196411151990031011</div>
            </td>
        </tr>
    </table>
</body>
</html>
