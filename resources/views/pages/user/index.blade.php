@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <a href="{{ route('user.create') }}" class="btn btn-success btn-sm modal-show my-3  float-right" title="Create User"><i class="icon-plus"></i> Create</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table id="datatable" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('table.user') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false},
            ]
        });

        // Show modal
        $('body').on('click', '.modal-show', function(e) {
            e.preventDefault();

            let me = $(this);
            let url = me.attr('href');
            let title = me.attr('title');

            $('#modal-title').text(title);
            $('#modal-btn-save')
                .removeClass('hidden bs collapse')
                .text(me.hasClass('edit') ? 'Update' : 'Create');

            $.ajax({
                url: url,
                dataType: 'html',
                success: function(response) {
                    $('#modal-body').html(response);
                }
            });

            $('#modal').modal('show');
        });

        // Insert / update data
        $('#modal-btn-save').click(function(e) {
            e.preventDefault();

            let form = $('#modal-body form');
            let url = form.attr('action');
            let method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
            console.log(form, url, method)

            // Clear error message
            form.find('.help-block').remove();
            form.find('.form-control').removeClass('is-invalid');

            $.ajax({
                url: url,
                method: method,
                data: form.serialize(),
                success: function() {
                    form.trigger('reset');
                    $('#modal').modal('hide');
                    $('#datatable').DataTable().ajax.reload();

                    Swal.fire(
                        'Good job!',
                        'Data has been saved',
                        'success'
                    );
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    // console.log(res);
                    if($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(key, value) {
                            $('#' + key)
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .append('<small class="help-block form-text text-danger">' + value + '</small>');
                        });
                    }
                }
            });
        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();

            let me = $(this),
                url = me.attr('href'),
                title = me.attr('title'),
                csrf_token = $('meta[name="csrf-token"]').attr('content');

            Swal.fire({
                title: 'Are you sure want to delete ' + title +  '?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': csrf_token
                        },
                        success: function() {
                            $('#datatable').DataTable().ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        },
                        error: function() {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    });



                }
            });
        })

        // Detail
        $('body').on('click', '.btn-show', function(e){
            e.preventDefault();

            let me = $(this),
                url = me.attr('href'),
                title = me.attr('title');

            $('#modal-title').text(title);
            $('#modal-btn-save').addClass('hidden bs collapse');

            $.ajax({
                url: url,
                dataType: 'html',
                success: function(res) {
                    $('#modal-body').html(res);
                }
            });

            $('#modal').modal('show');
        });
    </script>
@endpush


