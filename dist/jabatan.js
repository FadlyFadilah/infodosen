$(document).ready(function () {
    var nik = $('#getnik').val();
    $('#jabatan').DataTable({
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
        },
        'serverSide': 'true',
        'processing': 'true',
        'paging': 'true',
        'order': [],
        'ajax': {
            'url': 'pages/data_jabatan.php?nik='+nik,
            'type': 'post',
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [3]
        },

        ],
        'columnDefs': [{
            "targets": [0, 1],
            "className": "text-center",
            "width": "1%"
        },
        {
            "targets": [2],
            "className": "text-left",
            "width": "10d%"
        },
        {
            "targets": [3],
            "className": "text-left",
            "width": "10d%"
        }
        ]
    });
});
$(document).on('submit', '#addJ', function (e) {
    e.preventDefault();
    var nik = $('#nikJ').val();
    var prodi = $('#prodi').val();
    var sebelum = $('#sebelum').val();
    var sesudah = $('#sesudah').val();
    var tahunaka = $('#tahunakaJ').val();
    if (sebelum != '' && sesudah != '' && nik != '' && tahunaka != '' && prodi != '') {
        $.ajax({
            url: "pages/add_jabatan.php",
            type: "post",
            data: {
                nik: nik,
                sebelum: sebelum,
                sesudah: sesudah,
                tahunaka: tahunaka,
                prodi: prodi,
            },
            success: function (data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'true') {
                    mytable = $('#jabatan').DataTable();
                    mytable.draw();
                    $('#modalj').modal('hide');
                } else {
                    alert('failed');
                }
            }
        });
    } else {
        alert('Fill all the required fields');
    }
});
$(document).on('submit', '#updatej', function (e) {
    e.preventDefault();
    //var tr = $(this).closest('tr');
    var nik = $('#nikJ_').val();
    var prodi = $('#prodi_').val();
    var sebelum = $('#sebelum_').val();
    var tahunaka = $('#tahunakaJ_').val();
    var sesudah = $('#sesudah_').val();
    var trid = $('#tridJ').val();
    var id = $('#idJ_').val();
    if (nik != '' && prodi != '' && sebelum != '' && tahunaka != '' && sesudah != '') {
        $.ajax({
            url: "pages/update_jabatan.php",
            type: "post",
            data: {
                nik: nik,
                prodi: prodi,
                sebelum: sebelum,
                tahunaka: tahunaka,
                sesudah: sesudah,
                id: id
            },
            success: function (data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'true') {
                    table = $('#jabatan').DataTable();
                    var button = '<td><div class="d-flex"><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtnJ">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtnJ">Delete</a></div></td>';
                    var row = table.row("[id='" + trid + "']");
                    row.row("[id='" + trid + "']").data([prodi, sebelum, sesudah, tahunaka, button]);
                    $('#modaluj').modal('hide');
                } else {
                    alert('failed');
                }
            }
        });
    } else {
        alert('Fill all the required fields');
    }
});
$('#jabatan').on('click', '.editbtnJ', function (event) {
    var table = $('#jabatan').DataTable();
    var trid = $(this).closest('tr').attr('id');
    // console.log(selectedRow);
    var id = $(this).data('id');
    $('#modaluj').modal('show');

    $.ajax({
        url: "pages/get_single_jabatan.php",
        data: {
            id: id
        },
        type: 'post',
        success: function (data) {
            var json = JSON.parse(data);
            $('#nikJ_').val(json.nik);
            $('#prodi_').val(json.prodi);
            $('#sebelum_').val(json.sebelum);
            $('#sesudah_').val(json.sesudah);
            $('#tahunakaJ_').val(json.tahunaka);
            $('#idJ_').val(id);
            $('#tridJ').val(trid);
        }
    })
});
$(document).on('click', '.deleteBtnJ', function (event) {
    var table = $('#jabatan').DataTable();
    event.preventDefault();
    var id = $(this).data('id');
    var nik = $(this).data('nik');
    if (confirm("Are you sure want to delete this User ? ")) {
        $.ajax({
            url: "pages/hapus_jabatan.php",
            data: {
                id: id,
                nik: nik
            },
            type: "post",
            success: function (data) {
                var json = JSON.parse(data);
                status = json.status;
                if (status == 'success') {
                    location.reload();
                } else {
                    alert('Failed');
                    return;
                }
            }
        });
    } else {
        return null;
    }
});