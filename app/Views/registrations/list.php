<div class="d-flex justify-content-between align-items-center">
    <h2>Qeydiyyatlar</h2>
    <form method="post" action="logout">
        <button class="btn btn-outline-secondary btn-sm">Çıxış</button>
    </form>
</div>
<table id="regTable" class="display mt-3" style="width:100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Ad Soyad</th>
        <th>Email</th>
        <th>Şirkət</th>
        <th>Qeydiyyatdan Keçdiyi Tarix</th>
    </tr>
    </thead>
</table>
<div class="mt-3">
    <a id="expX" class="btn btn-success me-2">Export XLSX</a>
    <a id="expP" class="btn btn-danger">Export PDF</a>
</div>
<script>
    window.baseUrl = <?= json_encode(BASE_URL) ?>;

    $(function () {
        let dt = $('#regTable').DataTable({
            serverSide: true,
            processing: true,
            ajax: function (data, cb) {
                $.get(window.baseUrl + '/api/registrations', data, function (json) {
                    cb(json);
                });
            },
            columns: [
                {data: 'id'}, {data: 'full_name'}, {data: 'email'}, {data: 'company'},
                {data: 'created_at'}
            ]
        });

        function currentFilters() {
            const o = dt.order();
            const s = dt.search();
            return {
                'order[0][column]': o[0][0],
                'order[0][dir]': o[0][1],
                'search[value]': s
            };
        }

        function buildUrl(path) {
            const p = new URLSearchParams(currentFilters());
            return window.baseUrl + path + '?' + p.toString();
        }

        $('#expX').on('click', function (e) {
            e.preventDefault();
            window.location = buildUrl('/export/xlsx');
        });
        $('#expP').on('click', function (e) {
            e.preventDefault();
            window.location = buildUrl('/export/pdf');
        });
    });
</script>
