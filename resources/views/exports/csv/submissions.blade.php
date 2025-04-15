<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Laporan Pengajuan - SMKN 11 Bandung</title> --}}
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>UNIT</th>
                <th>STATUS</th>
                <th>BARANG</th>
                <th>Jumlah</th>
                <th>Jumlah DISETUJUI</th>
                <th>TANGGAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($submissions as $submission)
                @php
                    $username = trim(explode('@', $submission->unit)[0]);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $username }}</td>
                    <td>{{ $submission->status }}</td>
                    <td>{{ $submission->name }}</td>
                    <td>{{ $submission->qty }}</td>
                    <td>{{ $submission->qty_accepted }}</td>
                    <td>{{ $submission->created_at->format('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
