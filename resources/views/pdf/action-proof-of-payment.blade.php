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
    <table style="width:100%;">
        <tr>
            <td style="vertical-align:middle; text-align:center;" width="10%">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/logo-kab.png'))) }}" style="max-width:80px;">
            </td>
            <td style="vertical-align:middle; text-align:center;" width="80%;">
                <div style="font-size:18px; font-weight:400; letter-spacing:1px; text-transform:uppercase;">Pemerintahan Kabupaten Kediri</div>
                <div style="font-size:18px; font-weight:400; letter-spacing:1px; text-transform:uppercase; margin-bottom:10px;">Rumah Sakit Umum Daerah Kabupaten Kediri</div>
                <div style="font-size:13px;">Jl. Pahlawan Kusuma Bangsa no 1 | telp : (0354) 391718, 394956 | Fax : 391833</div>
                <div style="font-size:13px;">Faksimile (0354) 391833 | email : rsud_pare@kedirikab.go.id</div>
            </td>
            <td style="vertical-align:middle; text-align:center;" width="10%">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/icon.png'))) }}" style="max-width:100px;">
            </td>
        </tr>
    </table>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <div style="text-align:center; text-transform:uppercase; font-weight:bold; font-size:16px; letter-spacing:0.5px; margin-bottom:20px; background:#E5E7EB; padding:5px;">{{ $title }}</div>
    <table style="width:100%; margin-bottom:20px;">
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Pasien</td>
            <td>:</td>
            <td>{{ $data->outpatient->patient->name }}</td>
            <td style="font-weight:bold;">Dokter</td>
            <td>:</td>
            <td>{{ $data->doctor->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->outpatient->patient->gender_format_result }}</td>
            <td style="font-weight:bold;">Golongan</td>
            <td>:</td>
            <td>{{ $data->outpatient->type_format_result ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Masuk</td>
            <td>:</td>
            <td>{{ $data->outpatient->date_of_entry }}</td>
            <td style="font-weight:bold;">Kehadiran</td>
            <td>:</td>
            <td>{{ $data->outpatient->presence_format_result }}</td>
        </tr>
    </table>
    <table class="table" style="margin-bottom:20px;">
        <tbody>
            <tr>
                <td colspan="3">
                    <div style="text-align:center; margin-bottom:10px;">NOMINAL YANG SUDAH DIBAYAR</div>
                    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->total()) }}</div>
                </td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td width="1%">:</td>
                <td>{{ Simrs::numerator($data->total()) }}</td>
            </tr>
            <tr>
                <td>Tindakan</td>
                <td width="1%">:</td>
                <td>{{ $data->unitAction->action->name }}</td>
            </tr>
            <tr>
                <td>Poli</td>
                <td width="1%">:</td>
                <td>{{ $data->outpatient->unit->name }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td width="1%">:</td>
                <td>{{ now() }}</td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%;">
        <tr style="text-align:center;">
            <td>
                <div style="font-size:14px; margin-bottom:60px;">Penyetor</div>
                <div style="font-size:14px; text-decoration:underline;">(.............................)</div>
            </td>
            <td>
                <div style="font-size:14px; margin-bottom:60px;">Petugas Poli</div>
                <div style="font-size:14px; text-decoration:underline;">(.............................)</div>
            </td>
        </tr>
    </table>
</body>
</html>
