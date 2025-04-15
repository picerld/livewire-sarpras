<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Keluar - SMKN 11 Bandung</title>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .header img {
            width: 80px;
            position: absolute;
            left: 20px;
            top: 50px;
        }

        .header p {
            font-size: 11px;
        }

        .header h5,
        .header h3,
        .header p {
            margin: 2px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- USE THIS IF U WANT DOWNLOAD -->
        {{-- <img src="{{ public_path('/img/jabar-logo.png') }}" alt="Logo Jawa Barat"> --}}

        <!-- USE THIS IF U WANT PREVIEW FIRST -->
        <img src="{{ asset('img/jabar-logo.png') }}" alt="Logo Jawa Barat">
        <h5>PEMERINTAH DAERAH PROVINSI JAWA BARAT</h5>
        <h5>DINAS PENDIDIKAN</h5>
        <h5>CABANG DINAS PENDIDIKAN WILAYAH VII</h5>
        <h3>SMK NEGERI 11 KOTA BANDUNG</h3>
        <p>Jl. Budhi Cilember No. 23 Bandung, 40175 Telp/Fax: (022) 6653424</p>
        <p>http://smkn11bdg.sch.id | Email: smkn11bdg@gmail.com</p>
    </div>

    <h4 style="text-align: center; margin-top: 10px;">LAPORAN DATA BARANG KELUAR</h4>

    <table style="width: 100%; outline: none;">
        <tbody>
            <tr>
                <td style="width: 50%;">Kepada Yth</td>
                <td>: Kepala Sekolah</td>
            </tr>
            <tr>
                <td>Dari</td>
                <td>: Sarana</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                @php
                    $date = new DateTime($fromDate);
                @endphp
                <td>: {{ str(date_format($date, 'd F Y')) ?? Date::now()->format('d F Y') }}</td>
            </tr>
        </tbody>
    </table>

    <p>Disampaikan dengan hormat, kami dari Unit Kerja Sarana SMKN 11 Bandung menyampaikan laporan barang untuk periode
        {{ str(date_format($date, 'd F Y')) ?? Date::now()->format('d F Y') }}.</p>
    <p>Dengan ini kami sampaikan laporan data barang keluar sebagai berikut:</p>

    <table class="table">
        <thead>
            <tr>
                <td style="font-size: 13px; text-align: center">No</td>
                <td style="font-size: 13px; text-align: center">JENIS BARANG</td>
                <td style="font-size: 13px; text-align: center">JUMLAH</td>
                <td style="font-size: 13px; text-align: center">KETERANGAN</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($outItems as $index => $outItem)
                <tr>
                    <td style="font-size: 13px; text-align: center">{{ $index + 1 }}</td>
                    <td style="font-size: 13px; text-align: center">{{ $outItem->item->name }}</td>
                    <td style="font-size: 13px; text-align: center">{{ $outItem->qty }} {{ $outItem->item->unit }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- OPTIONAL FOOTER -->

    {{-- <div class="footer">
        <p>&copy; {{ date('Y') }} SMKN 11 Bandung. All rights reserved.</p>
    </div> --}}
</body>

</html>
