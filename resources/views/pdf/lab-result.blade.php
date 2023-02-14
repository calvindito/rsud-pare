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
                <th>Hasil</th>
                <th>Normal</th>
                <th>Kondisi</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->labRequestDetail as $lrd)
                <tr>
                    <td>{{ $lrd->labItem->labItemGroup->name }}</td>
                    <td>{{ $lrd->labItem->name }}</td>
                    <td>{{ $lrd->result }}</td>
                    <td class="align-middle" nowrap>
                        @isset($lrd->labItemParent)
                            @if($lrd->labItemParent->limit_lower && $lrd->labItemParent->limit_upper)
                                {{ $lrd->labItemParent->limit_lower . ' - ' . $lrd->labItemParent->limit_upper }}
                            @elseif($lrd->labItemParent->limit_upper)
                                {{ $lrd->labItemParent->limit_upper }}
                            @elseif($lrd->labItemParent->limit_lower)
                                {{ $lrd->labItemParent->limit_lower }}
                            @else
                                -
                            @endif
                        @else
                            -
                        @endif
                        <span style="float:right;">
                            {{ $lrd->labItemParent->unit ?? '' }}
                        </span>
                    </td>
                    <td class="align-middle">{{ $lrd->labItemCondition->name ?? 'Tidak Ada' }}</td>
                    <td class="align-middle" nowrap>{{ $lrd->labItemParent->method ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
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
