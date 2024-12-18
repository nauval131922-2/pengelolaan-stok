<!DOCTYPE html>
<html>

<head>
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
    <h1 style="text-decoration: underline">{{ $title }}</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Saldo Barang</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($semua_barang as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang['nama_barang'] }}</td>
                        <td>{{ $barang['kategori']['nama_kategori'] }}</td>
                        <td style="text-align: right">{{ number_format($barang['saldo_barang'], 2, ',', '.') }}</td>
                        <td>{{ $barang['satuan']['nama_satuan'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
