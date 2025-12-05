@extends('layouts.admin.app')

@section('title', 'Bank Soal')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Bank Soal</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Bank Soal</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.bank-soal.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Bank Soal
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="bank-soal-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Bank Soal</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Batch</th>
                                    <th>Tentor</th>
                                    <th>Tanggal Upload</th>
                                    <th>File</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#bank-soal-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.bank-soal.data') }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nama_banksoal', name: 'nama_banksoal'},
            {data: 'mapel', name: 'mapel'},
            {data: 'batch_nama', name: 'batch_nama'},
            {data: 'tentor_nama', name: 'tentor_nama'},
            {data: 'tanggal_upload', name: 'tanggal_upload'},
            {data: 'file', name: 'file', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Delete handler
    $('#bank-soal-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        
        if (confirm('Yakin ingin menghapus bank soal ini?')) {
            $.ajax({
                url: '{{ url('admin/bank-soal') }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#bank-soal-table').DataTable().ajax.reload();
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    toastr.error('Gagal menghapus bank soal');
                }
            });
        }
    });
});
</script>
@endpush