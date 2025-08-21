<h2>Admin Login</h2>

<?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['flash_error']) ?>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<form method="post" action="login" class="mt-3">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
    <div class="mb-2">
        <input class="form-control" type="email" name="email" placeholder="Email"></div>
    <div class="mb-2">
        <input class="form-control" type="password" name="password"
               placeholder="Şifrə">
    </div>
    <button class="btn btn-primary">Giriş</button>
</form>