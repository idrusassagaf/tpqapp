<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $judul ?? 'Laporan' }}</title>

    <style>
        @page {
            margin: 160px 60px 120px 60px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
        }

        /* ===== HEADER ===== */

        header {
            position: fixed;
            top: -130px;
            left: 0;
            right: 0;
            text-align: center;
        }

        header img {
            height: 70px;
        }

        header h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
        }

        header p {
            margin: 3px 0;
            font-size: 12px;
        }

        header hr {
            margin-top: 10px;
            border: 1px solid black;
        }

        /* ===== TABLE ===== */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #071b40;
            color: white;
            padding: 6px;
            border: 1px solid #fefefe;
        }

        td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .text-left {
            text-align: left !important;
        }

        /* ===== FOOTER ===== */

        footer {
            position: fixed;
            bottom: -95px;
            left: 0;
            right: 0;
            font-size: 10px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none;
            padding: 0;
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ public_path('images/logo-tpq.png') }}">
        <h2>{{ $judul }}</h2>
        <p>TPQ Khairunnissa Ternate</p>
        <hr>
    </header>

    <main>

        @yield('content')

        <br><br><br>

        <table width="100%" style="border:none; border-collapse:collapse;">
            <tr>
                <td width="60%" style="border:none;"></td>
                <td width="40%" align="center" style="border:none;">
                    Ternate, {{ date('d-m-Y') }}<br>
                    Ketua TPQ Khairunnissa<br><br><br><br>
                    <strong>( FULAN Bin FULAN )</strong>
                </td>
            </tr>
        </table>

    </main>

    <script type="text/php">
        if (isset($pdf)) {

    $pdf->page_script(function ($pageNumber, $pageCount, $pdf, $fontMetrics) {

        $font = $fontMetrics->get_font("DejaVu Sans", "normal");
        $size = 9;

        // ===== POSISI VERTIKAL (SAMAKAN KEDUANYA)
        $y = 790;

        // ===== TEXT KIRI
        $textLeft = "Dicetak : {{ date('d-m-Y H:i') }}";
        $pdf->text(60, $y, $textLeft, $font, $size);

        // ===== TEXT KANAN
        $textRight = "Halaman " . $pageNumber;
        $width = $fontMetrics->get_text_width($textRight, $font, $size);

        $pdf->text(535 - $width, $y, $textRight, $font, $size);

    });

}
</script>

</body>

</html>