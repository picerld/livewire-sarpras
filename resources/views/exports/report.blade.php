<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Barang - SMKN 11 Bandung</title>
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

    <h4 style="text-align: center; margin-top: 10px;">LAPORAN DATA BARANG</h4>

    <table style="width: 100%; outline: none;">
        <tbody>
            <tr>
                <td style="width: 50%;">
                    <p>Kepada Yth</p>
                </td>
                <td style="width: 50%;">: Kepala Sekolah</td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <p>Dari</p>
                </td>
                <td style="width: 50%;">: Sarana</td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <p>Tanggal</p>
                </td>
                <td style="width: 50%;">: {{ Date::now()->format('d F Y') }}</td>
            </tr>
        </tbody>
    </table>

    <p>Disampaikan dengan hormat, kami dari Unit Kerja Sarana SMKN 11 Bandung sampaikan laporan barang untuk periode
        {{ Date::now()->format('F Y') }}.</p>
    <p>Dengan ini kami sampaikan laporan barang sebagai berikut:</p>

    <table class="table">
        <thead>
            <tr>
                <td style="font-size: 13px; text-align: center">No</td>
                <td style="font-size: 13px; text-align: center">BARANG</td>
                <td style="font-size: 13px; text-align: center">TANGGAL MASUK</td>
                <td style="font-size: 13px; text-align: center">TANGGAL KELUAR</td>
                <td style="font-size: 13px; text-align: center">MASUK</td>
                <td style="font-size: 13px; text-align: center">KELUAR</td>
                <td style="font-size: 13px; text-align: center">SISA</td>
                <td style="font-size: 13px; text-align: center">KETERANGAN</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr>
                    <td style="font-size: 13px; text-align: center">{{ $index + 1 }}</td>
                    <td style="font-size: 13px; text-align: center">{{ $item->name }}</td>
                    <td style="font-size: 13px; text-align: center">{{ $item->incoming_date ?? '' }}</td>
                    <td style="font-size: 13px; text-align: center">{{ $item->outgoing_date ?? '' }}</td>
                    <td style="font-size: 13px; text-align: center">
                        {{ $item->incoming_qty ?? '' }} {{ $item->unit }}
                    </td>
                    <td style="font-size: 13px; text-align: center">
                        {{ $item->outgoing_qty ?? '' }} {{ $item->unit }}
                    </td>
                    <td style="font-size: 13px; text-align: center"></td>
                    <td style="font-size: 13px; text-align: center"></td>
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
