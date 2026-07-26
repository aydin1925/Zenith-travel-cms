<?php
/** @var string|null $error */
$error = $error ?? null;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenith Login</title>
    <link rel="stylesheet" href="<?= asset('css/admin_login.css') ?>">
</head>
<body>
    <div class="bg-shape"></div>

    <div class="card-3d-wrapper" id="cardWrapper">

        <div class="card-face card-front">
            <div class="brand-logo"><i class="fas fa-play-circle me-2"></i>Zenith</div>
            <h4 class="mb-4 text-center">Hos Geldiniz</h4>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center small mb-3">
                    Kullanici adi veya sifre hatali!
                </div>
            <?php endif; ?>

            <form action="<?= url('/login') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label small text-muted">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="kullanici adinizi girin..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Sifre</label>
                    <input type="password" name="password" class="form-control" placeholder="********" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Beni Hatirla</label>
                    </div>
                    <a href="#" class="small text-decoration-none">Sifremi Unuttum</a>
                </div>

                <button type="submit" name="login" id="login_submit_button" class="btn btn-primary">Giris Yap</button>
            </form>
        </div>
    </div>
</body>
</html>
