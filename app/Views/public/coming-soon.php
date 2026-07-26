<?php
/** @var string $pageName */
$pageName = $pageName ?? 'Bu sayfa';
?>
<div class="coming-soon">
    <div class="coming-box">
        <div class="coming-icon">🚧</div>
        <h1><?= e($pageName) ?> — çok yakında</h1>
        <p>Bu sayfa şu anda hazırlanıyor. Anasayfaya dönüp diğer bölümleri inceleyebilir, ya da bize doğrudan ulaşabilirsiniz.</p>
        <a href="<?= url('/') ?>" class="btn btn-indigo btn-lg">← Anasayfaya dön</a>
    </div>
</div>
