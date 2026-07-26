<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>404 - Sayfa Bulunamadi</title>
    <style>
        body{margin:0;font-family:'Plus Jakarta Sans',sans-serif;background:#f1f5f9;color:#0f172a;display:flex;align-items:center;justify-content:center;min-height:100vh}
        .box{background:#fff;padding:48px 64px;border-radius:24px;box-shadow:0 20px 40px rgba(15,23,42,.08);text-align:center;max-width:480px}
        h1{font-size:96px;margin:0;color:#4f46e5}
        p{color:#64748b;margin:8px 0 24px}
        a{background:#4f46e5;color:#fff;padding:12px 24px;border-radius:12px;text-decoration:none;font-weight:600}
    </style>
</head>
<body>
    <div class="box">
        <h1>404</h1>
        <p>Aradiginiz sayfa bulunamadi.</p>
        <a href="<?= url('/') ?>">Ana Sayfaya Don</a>
    </div>
</body>
</html>
