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
            <td>{{ $data->doctorOperation->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Operasi</td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($data->date_of_entry)) }}</td>
            <td style="font-weight:bold;">Ref</td>
            <td>:</td>
            <td>{{ $data->ref() }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Selesai</td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($data->date_of_out)) }}</td>
            <td style="font-weight:bold;">Kelas</td>
            <td>:</td>
            <td>{{ $data->operatingRoomAction->classType->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Golongan Operasi</td>
            <td>:</td>
            <td>{{ $data->operatingRoomAction->operatingRoomGroup->name ?? '-' }}</td>
            <td style="font-weight:bold;">Jenis Tindakan</td>
            <td>:</td>
            <td>{{ $data->operatingRoomAction->operatingRoomActionType->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Unit</td>
            <td>:</td>
            <td>{{ $data->unit->name ?? '-' }}</td>
            <td style="font-weight:bold;">UPF</td>
            <td>:</td>
            <td>{{ $data->functionalService->name ?? '-' }}</td>
        </tr>
    </table>
    <table class="table" style="margin-bottom:20px;">
        <tr style="background:#E5E7EB;">
            <th colspan="2" style="text-align:left;">INFORMASI</th>
        </tr>
        <tr>
            <th style="text-align:left;">Diagnosa</th>
            <td>{{ $data->diagnosis }}</td>
        </tr>
        <tr>
            <th style="text-align:left;">Status</th>
            <td>{{ $data->status_format_result }}</td>
        </tr>
        <tr style="background:#E5E7EB;">
            <th colspan="2" style="text-align:left;">RINGKASAN BIAYA</th>
        </tr>
        <tr>
            <th style="text-align:left;">Biaya Rumah Sakit</th>
            <td style="text-align:right;">{{ Simrs::formatRupiah($data->hospital_service) }}</td>
        </tr>
        <tr>
            <th style="text-align:left;">Biaya Dokter Operasi</th>
            <td style="text-align:right;">{{ Simrs::formatRupiah($data->doctor_operating_room) }}</td>
        </tr>
        <tr>
            <th style="text-align:left;">Biaya Dokter Anestesi</th>
            <td style="text-align:right;">{{ Simrs::formatRupiah($data->doctor_anesthetist) }}</td>
        </tr>
        <tr>
            <th style="text-align:left;">Biaya Perawat Operasi</th>
            <td style="text-align:right;">{{ Simrs::formatRupiah($data->nurse_operating_room) }}</td>
        </tr>
        <tr>
            <th style="text-align:left;">Biaya Perawat Anestesi</th>
            <td style="text-align:right;">{{ Simrs::formatRupiah($data->nurse_anesthetist) }}</td>
        </tr>
        <tr>
            <th style="text-align:left;">Biaya Bahan</th>
            <td style="text-align:right;">{{ Simrs::formatRupiah($data->totalMaterial()) }}</td>
        </tr>
        <tr>
            <th style="text-align:left;">Biaya RR Monitoring</th>
            <td style="text-align:right;">{{ Simrs::formatRupiah($data->monitoring) }}</td>
        </tr>
        <tr>
            <th style="text-align:left;">Biaya RR Askep</th>
            <td style="text-align:right;">{{ Simrs::formatRupiah($data->nursing_care) }}</td>
        </tr>
    </table>
    <table class="table">
        <tbody>
            <tr>
                <td>
                    <div style="text-align:center; margin-bottom:10px;">TOTAL BIAYA KESELURUHAN</div>
                    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->total()) }}</div>
                    <div style="text-align:center; font-weight:400; font-style:italic; margin-top:10px; font-size:14px;">
                        Terbilang : {{ Simrs::numerator($data->total()) }}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
