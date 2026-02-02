<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function() {

        var table = $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
        });

        getData();

        $('.btn-get-data').click(function() {
            getData();
        });

        function getData() {

            $('#loading-filter').show();

            table.clear().draw();

            var filter_kode      = $('#filter-kode').val();
            var filter_nama      = $('#filter-nama').val();
            var filter_harga_min = $('#filter-harga-min').val();
            var filter_harga_max = $('#filter-harga-max').val();

            $.ajax({
                url: '{{ url("master-items/search") }}',
                dataType: 'json',
                data: {
                    kode: filter_kode,
                    nama: filter_nama,
                    hargamin: filter_harga_min,
                    hargamax: filter_harga_max
                },
                success: function(results) {

                    var data = results.data;

                    $.each(data, function(index, item) {

                        var harga_jual = Math.round(
                            item.harga_beli + (item.harga_beli * item.laba / 100)
                        );

                        var viewBtn = `
                            <a href="{{ url('master-items/view') }}/${item.kode}"
                               class="btn btn-primary btn-sm">
                               View
                            </a>
                        `;

                        var foto = '-';
                        if (item.foto) {
                            foto = `
                                <img src="/storage/${item.foto}"
                                     width="60"
                                     class="img-thumbnail">
                            `;
                        }

                        table.row.add([
                            item.kode,        // Kode
                            item.nama,        // Nama
                            item.jenis,       // Jenis
                            item.harga_beli,  // Harga Beli
                            harga_jual,       // Harga Jual
                            item.supplier,    // Supplier
                            viewBtn,          // View
                            foto              // Foto
                        ]).draw(false);
                    });

                    $('#loading-filter').hide();
                },
                error: function() {
                    alert('Terjadi kesalahan server, tidak dapat mengambil data');
                    $('#loading-filter').hide();
                }
            });
        }
    });
</script>
    