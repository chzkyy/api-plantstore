{{--  image preview  --}}
<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';
        const OFReader = new FileReader();
        OFReader.readAsDataURL(image.files[0]);

        OFReader.onload = function(OFREvent) {
            imgPreview.src = OFREvent.target.result;
        }
    }

    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    })
</script>

{{--  <!-- Bootstrap core JavaScript-->  --}}
<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

{{--  <!-- Core plugin JavaScript-->  --}}
<script src="{{ url('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

{{--  <!-- Custom scripts for all pages-->  --}}
<script src="{{ url('backend/js/sb-admin-2.min.js') }}"></script>

{{--  <!-- DataTables JavaScript -->  --}}
<script src="{{ url('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '/api/getProject',
            method: 'GET',
            success: function(response) {
                // Handle the response data here
                $('#tableProject').DataTable(
                    {
                        data: response.data,
                        dom: 'Bfrtip',
                        responsive: true,

                        columns: [
                            {
                                data: 'id'
                            },
                            {
                                data: 'image',
                                render: function(data, type, full, meta) {
                                    return "<img src=\"" + data + "\" height=\"50\"/>";
                                }
                            },
                            {
                                data: 'name'
                            },
                            {
                                data: 'short_description'
                            },
                            {
                                data: 'role'
                            },
                            {
                                data: 'id',
                                render: function(data, type, full, meta) {
                                    // view modal editProject
                                    var btn_edit = "<button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editProject' data-id='" + data + "'><i class='fas fa-edit'></i></button>";
                                    return btn_edit;
                                }
                            }
                        ],
                    }
                );
            },
            error: function(xhr, status, error) {
                // Handle the error here
            }
        })
    });
</script>
