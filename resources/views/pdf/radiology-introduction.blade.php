<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
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
    <table style="width:100%;">
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Pasien</td>
            <td>:</td>
            <td>{{ $data->patient->name }}</td>
            <td style="font-weight:bold;">Dokter</td>
            <td>:</td>
            <td>{{ $data->doctor->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->patient->gender_format_result }}</td>
            <td style="font-weight:bold;">Golongan</td>
            <td>:</td>
            <td>{{ $data->radiologyRequestable->type_format_result ?? '-' }}</td>
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
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tangal Lahir</td>
            <td>:</td>
            <td>{{ $data->patient->date_of_birth }}</td>
            <td style="font-weight:bold;">Tindakan</td>
            <td>:</td>
            <td>{{ $data->radiology->type . ' - ' . $data->radiology->object . ' - ' . $data->radiology->projection }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Klinis</td>
            <td>:</td>
            <td>{{ $data->clinical }}</td>
            <td style="font-weight:bold;">Kritis</td>
            <td>:</td>
            <td>{{ $data->critical ? 'Ya' : 'Tidak' }}</td>
        </tr>
    </table>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <div style="text-align:center; margin-bottom:10px;">NOMINAL YANG HARUS DIBAYAR</div>
    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->total()) }}</div>
    <div style="text-align:center; font-weight:400; font-style:italic; margin-top:10px; font-size:14px;">
        Terbilang : {{ Simrs::numerator($data->total()) }}
    </div>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <table style="width:100%;">
        <tr style="text-align:center;">
            <td style="text-align:right;">
                <div style="font-size:14px;">Pare, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
                <div style="font-size:14px; margin-bottom:60px;">Petugas Radiologi</div>
                <div style="font-size:14px; text-decoration:underline;">(.............................)</div>
            </td>
        </tr>
    </table>
</body>
</html>
