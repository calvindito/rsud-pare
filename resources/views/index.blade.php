<div class="content">
    <div class="alert alert-success">
        <b>Selamat @if($time >= 4 && $time < 11) Pagi @elseif($time >= 11 && $time < 15) Siang @elseif($time >= 15 && $time <= 18) Sore @else Malam @endif {{ auth()->user()->employee->name }}</b>, silahkan menggunakan <b>SIMRS</b> Kabupaten Kediri dengan baik :)
    </div>
</div>
