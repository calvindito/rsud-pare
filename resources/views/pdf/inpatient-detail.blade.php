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
            <td style="font-weight:bold;">Kode</td>
            <td>:</td>
            <td>{{ $data->code() }}</td>
            <td style="font-weight:bold;">Status</td>
            <td>:</td>
            <td>{{ $data->status_format_result ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Pasien</td>
            <td>:</td>
            <td>{{ $data->patient->name ?? '-' }}</td>
            <td style="font-weight:bold;">Kamar</td>
            <td>:</td>
            <td>{{ $data->roomType->room->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">No RM</td>
            <td>:</td>
            <td>{{ $data->patient->id ?? '-' }}</td>
            <td style="font-weight:bold;">Kelas</td>
            <td>:</td>
            <td>{{ $data->roomType->classType->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->patient->gender_format_result ?? '-' }}</td>
            <td style="font-weight:bold;">Dokter</td>
            <td>:</td>
            <td>{{ $data->doctor->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">UPF</td>
            <td>:</td>
            <td>{{ $data->functionalService->name ?? '-' }}</td>
            <td style="font-weight:bold;">Tanggal Cetak</td>
            <td>:</td>
            <td>{{ now() }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Golongan</td>
            <td>:</td>
            <td>{{ $data->type_format_result }}</td>
            <td style="font-weight:bold;">Tanggal Masuk</td>
            <td>:</td>
            <td>{{ $data->date_of_entry }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Hasil</td>
            <td>:</td>
            <td>{{ $data->ending_format_result }}</td>
            <td style="font-weight:bold;">Tanggal Keluar</td>
            <td>:</td>
            <td>{{ !empty($data->date_of_out) ? $data->date_of_out : '-' }}</td>
        </tr>
    </table>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <table class="table">
        <tr>
            <td style="font-size:14px; text-align:left;" colspan="2">
                Tindakan
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                <div style="margin-left:50px;">
                    Pelayanan
                </div>
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->actionService) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                <div style="margin-left:50px;">
                    Operatif
                </div>
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->actionOperative) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                <div style="margin-left:50px;">
                    Non Operatif
                </div>
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->actionNonOperative) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                <div style="margin-left:50px;">
                    Penunjang
                </div>
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->actionSupporting) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                <div style="margin-left:50px;">
                    Obat & Alkes
                </div>
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->actionHealth) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                <div style="margin-left:50px;">
                    Lain - Lain
                </div>
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->actionOther) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                <div style="margin-left:50px;">
                    Paket
                </div>
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->actionPackage) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                Permintaan Obat
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->recipe) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                Laboratorium
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->lab) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                Radiologi
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->radiology) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:14px; text-align:left;">
                Kamar Operasi
            </td>
            <td style="font-size:14px; text-align:right;">
                {{ Simrs::formatRupiah($data->costBreakdown()->operation) }}
            </td>
        </tr>
    </table>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <div style="text-align:center; margin-bottom:10px;">TOTAL KESELURUHAN</div>
    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->total()) }}</div>
    <div style="text-align:center; font-weight:400; font-style:italic; margin-top:10px; font-size:14px;">
        Terbilang : {{ Simrs::numerator($data->total()) }}
    </div>
</body>
</html>
