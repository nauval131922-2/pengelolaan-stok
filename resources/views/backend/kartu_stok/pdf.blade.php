<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #444;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #f7f7f7;
            text-align: left;
            font-weight: bold;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .table-container {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 20px;
            }

            table,
            th,
            td {
                font-size: 14px;
            }
        }

        h3 {
            font-size: 18px;
            font-weight: bold;
            color: #555;
            text-align: center;
            text-transform: capitalize;
            line-height: 0.5;
        }

        p {
            font-size: 16px;
            text-align: center;
            color: #666;
            line-height: 0.5;
        }
    </style>
</head>

<body>
    <h1 style="text-decoration: underline">{{ $title2 }}</h1>
    <h3>{{ $namaBarang }}</h3>
    <p>{{ $tanggalAwal }} - {{ $tanggalAkhir }}</p>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td></td>
                    <td>Saldo awal</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right">{{ number_format($saldoAwal, 2, ',', '.') }}</td>
                    <td>{{ $namaSatuan }}</td>
                </tr>
                @foreach ($kartuStok as $item)
                    <tr>
                        {{-- loop nomor mulai dari 2 --}}
                        <td>{{ $loop->iteration + 1 }}</td>
                        <td>{{ $item['tanggal'] }}</td>
                        <td>{{ $item['nama_barang'] }}</td>
                        <td>{{ $item['kategori'] }}</td>
                        <td style="text-align: right">{{ number_format($item['debit'], 2, ',', '.') }}</td>
                        <td style="text-align: right">{{ number_format($item['kredit'], 2, ',', '.') }}</td>
                        <td style="text-align: right">{{ number_format($item['saldo'], 2, ',', '.') }}</td>
                        <td>{{ $item['satuan'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
