<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1
        style="text-align: center; margin-bottom: 20px; margin-top: 20px; font-weight: bold; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; color: #333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3)">
        {{ $title }}</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Saldo Barang</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($semua_barang as $barang)
                <tr>
                    <td>{{ $barang['nama_barang'] }}</td>
                    <td>{{ $barang['kategori']['nama_kategori'] }}</td>
                    <td style="text-align: right">{{ number_format($barang['saldo_barang'], 2, ',', '.') }}</td>
                    <td>{{ $barang['satuan']['nama_satuan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
