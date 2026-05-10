<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Anggota</title>
    <style>
        @page { margin: 0; }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .kartu {
            width: 9cm;
            height: 5.4cm;
            border: 1px solid #333;
            border-radius: 6px;
            background: linear-gradient(to right, #e0f7fa 30%, #ffffff 70%);
            padding: 6px 10px;
            box-sizing: border-box;
            position: relative;
            margin: 0 auto;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #aaa;
            padding-bottom: 2px;
            margin-bottom: 5px;
        }
        .header img {
            width: 28px;
            height: 28px;
            margin-right: 6px;
        }
        .header h1 {
            font-size: 10px;
            font-weight: bold;
            line-height: 1.1;
            margin: 0;
        }

        /* Isi kartu */
        .isi {
            position: relative;
        }

        /* Info kiri */
        .info {
            font-size: 10px;
            line-height: 1.3;
            width: 65%;
        }
        .info strong {
            display: block;
            font-size: 11px;
            margin-bottom: 3px;
        }
        .info p {
            margin: 1px 0;
        }
        .info span {
            display: inline-block;
            width: 35px;
        }

        /* Foto kanan atas */
        .foto {
            position: absolute;
            top: 0;
            right: 0;
            text-align: center;
        }
        .foto img {
            width: 100px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #555;
            border-radius: 4px;
        }
        .foto p {
            font-size: 8px;
            font-style: italic;
            margin: 2px 0 0 0;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 4px;
            left: 10px;
            font-size: 8px;
            font-style: italic;
            color: #444;
        }
    </style>
</head>
<body>
    <div class="kartu">
        <div class="header">
            <img src="{{ public_path('img/logosmp.jpg') }}" alt="Logo">
            <h1>KARTU ANGGOTA PERPUSTAKAAN<br>SMP N 1 KLAMBU</h1>
        </div>

        <div class="isi">
            <div class="info">
                <strong>{{ $user->nama_lengkap ?? 'Nama Anggota' }}</strong>
                <p><span>NIS</span> : {{ $user->nis ?? '-' }}</p>
                <p><span>Email</span> : {{ $user->email ?? '-' }}</p>
                <p><span>Alamat</span> : {{ $user->alamat ?? '-' }}</p>
            </div>

            <div class="foto">
                <img src="{{ $user->foto_profil ? public_path('storage/'.$user->foto_profil) : public_path('img/foto-default.png') }}" alt="Foto Profil">
            </div>
        </div>

        <div class="footer">Anggota Aktif</div>
    </div>
</body>
</html>
