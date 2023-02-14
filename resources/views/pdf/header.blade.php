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
