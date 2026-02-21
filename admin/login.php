<?php

// oturum sorgusu yapıyorum
session_start();

if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenith Login</title>
    <link rel="stylesheet" href="../assets/css/admin_login.css">
</head>
<body>
    <div class="bg-shape"></div>
    
        <div class="card-3d-wrapper" id="cardWrapper">
            
            <div class="card-face card-front">
                <div class="brand-logo"><i class="fas fa-play-circle me-2"></i>Zenith</div>
                <h4 class="mb-4 text-center">Hoş Geldiniz</h4>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center small mb-3">
                        Kullanıcı adı veya şifre hatalı!
                    </div>
                <?php endif; ?>
                
                <form action="auth.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="kullanıcı adınızı girin..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Şifre</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label small" for="remember">Beni Hatırla</label>
                        </div>
                        <a href="#" class="small text-decoration-none">Şifremi Unuttum</a>
                    </div>

                    <button type="submit" name="login" id="login_submit_button" class="btn btn-primary">Giriş Yap</button>
                </form>
            </div>
        </div>
</body>
</html>