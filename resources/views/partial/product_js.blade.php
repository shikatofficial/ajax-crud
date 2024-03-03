    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    document.querySelectorAll('.btnDelete').forEach(function(btn) {
        btn.addEventListener('click', function() {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn btn-dark" 
                    },
                    confirm: {
                        text: "Delete",
                        value: true,
                        visible: true,
                        className: "btn btn-danger" 
                    }
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    btn.closest('.deleteForm').submit();
                }
            });
            
            document.querySelector('.swal-modal').classList.add('alert', 'alert-light'); 
        });
    });
</script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            // add product

            $(document).on('click', '.add_product', function (e) {
                e.preventDefault();

                let name = $('#name').val();
                let price = $('#price').val();
                let description = $('#description').val();

                // console.log(name+price+description);

                $.ajax({
                    url:"{{ route('products.store')}}",
                    method:'post',
                    data:{name:name,price:price,description:description},
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#addModal form').trigger('reset');

                            $('#addModal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            $('.table').load(location.href+' .table');
                        }
                    },error:function (err) {
                        let error = err.responseJSON;

                        $.each(error.errors, function (index, value) {
                            $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'<br>');
                        });
                    }
                });
            });

            // Edit Product

            $(document).on('click', '.update-product-form', function (e) {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let price = $(this).data('price');
                let description = $(this).data('description');

                $('#up_id').val(id);
                $('#up_name').val(name);
                $('#up_price').val(price);
                $('#up_description').val(description);
            });


            // Update Product
            $(document).on('click', '.update_product', function (e) {
                e.preventDefault();

                let up_id = $('#up_id').val();
                let up_name = $('#up_name').val();
                let up_price = $('#up_price').val();
                let up_description = $('#up_description').val();

                let action = $('#updateProductForm').attr('action');
                $.ajax({
                    url: "{{ url('products') }}/" + up_id,
                    method: 'put',
                    data: {name: up_name, price: up_price, description: up_description},
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#updateModal form').trigger('reset');
                            $('#updateModal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            $('.table').load(location.href + ' .table');
                        }
                    },
                    error: function(err) {
                        let error = err.responseJSON;

                        $.each(error.errors, function (index, value) {
                            $('.errMsgContainer').append('<span class="text-danger">' + value + '</span>' + '<br>');
                        });
                    }
                });
            });

            // Delete Product
            $(document).on('click', '.delete-product', function (e) {
                e.preventDefault();

                let productId = $(this).data('id');

                $.ajax({
                    url: "{{ url('products') }}/" + productId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (res) {
                        if (res.status == 'success') {
                            $('.table').load(location.href + ' .table');
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });


        });
    </script>