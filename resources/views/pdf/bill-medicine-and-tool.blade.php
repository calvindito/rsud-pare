<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
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
    <table style="width:100%;">
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Pasien</td>
            <td>:</td>
            <td>{{ $data->patient->name }}</td>
            <td style="font-weight:bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->patient->gender_format_result }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">No RM</td>
            <td>:</td>
            <td>{{ $data->patient->no_medical_record }}</td>
            <td style="font-weight:bold;">Alamat</td>
            <td>:</td>
            <td>{{ $data->patient->address ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Status</td>
            <td>:</td>
            <td>{!! $data->statusable(true) !!}</td>
            <td style="font-weight:bold;">Ref</td>
            <td>:</td>
            <td>{{ $data->ref() }}</td>
        </tr>
    </table>
    <hr style="margin-top:20px; margin-bottom:20px;">
        <table class="table">
            <thead style="background:#E5E7EB;">
                <tr>
                    <th>Item</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->dispensaryRequestItem() as $d)
                    <tr>
                        <td>{{ $d->dispensaryItemStock->dispensaryItem->item->name }}</td>
                        <td>{{ $d->qty }}</td>
                        <td>{{ $d->dispensaryItemStock->dispensaryItem->item->itemUnit->name ?? '-' }}</td>
                        <td>
                            @if($d->discount > 0)
                                @php
                                    $discount = $d->discount;
                                    $priceSell = $d->price_sell;
                                    $price = $priceSell - (($discount / 100) * $priceSell);
                                @endphp
                                {{ Simrs::formatRupiah($price) }}
                                <small class="ms-1">
                                    <strike>{{ Simrs::formatRupiah($priceSell) }}</strike>
                                </small>
                            @else
                                {{ Simrs::formatRupiah($d->price_sell) }}
                            @endif
                        </td>
                        <td>{{ $d->discount }} %</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <div style="text-align:center; margin-bottom:10px;">NOMINAL YANG TERBAYAR</div>
    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->total()) }}</div>
    <div style="text-align:center; font-weight:400; font-style:italic; margin-top:10px; font-size:14px;">
        Terbilang : {{ Simrs::numerator($data->total()) }}
    </div>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <table style="width:100%;">
        <tr style="text-align:center;">
            <td width="50%">
                <div style="font-size:14px; margin-bottom:60px;">Penyetor</div>
                <div style="font-size:14px; margin-bottom:3px; text-decoration:underline;">(.............................)</div>
            </td>
            <td width="50%">
                <div style="font-size:14px; margin-bottom:60px;">Kasir</div>
                <div style="font-size:14px; margin-bottom:3px; text-decoration:underline;">({{ auth()->user()->employee->name }})</div>
            </td>
        </tr>
    </table>
</body>
</html>
