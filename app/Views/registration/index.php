<h2>Qeydiyyat</h2>
<form id="regForm" class="mt-3">
    <div class="mb-3">
        <label class="form-label">Ad Soyad*</label>
        <input type="text" name="full_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email*</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Şirkət (opsional)</label>
        <input type="text" name="company" class="form-control">
    </div>
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
    <button class="btn btn-primary">Göndər</button>
</form>
<div id="res" class="mt-3"></div>
<script>
    window.baseUrl = <?= json_encode(BASE_URL) ?>;

    $('#regForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: window.baseUrl + '/register', method: 'POST', data: $(this).serialize(),
            success: function (r) {
                if (r.status === 'success') {
                    $('#res').html('<div class="alert alert-success">' + r.message + '</div>');
                    $('#regForm')[0].reset();
                } else {
                    $('#res').html('<div class="alert alert-danger">' + r.message + '</div > '); }
                }
            ,
                error: function () {
                    $('#res').html('<div class="alert alert-danger">Server error </div>'); }
                }
            )
                ;
            });
</script>