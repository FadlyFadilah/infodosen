$(document).ready(function() {
    var nik = $('#getnik').val();
    $('#kom').DataTable({
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
        },
        'serverSide': 'true',
        'processing': 'true',
        'paging': 'true',
        'order': [],
        'ajax': {
            'url': 'pages/data_kom.php?nik='+nik,
            'type': 'post',
        },
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [6]
            },

        ],
        'columnDefs': [{
                "targets": [0, 1],
                "className": "text-center",
                "width": "1%"
            }, {
                "targets": [4, 5],
                "className": "text-left",
                "width": "5%"
            },
            {
                "targets": [2, 3, 6],
                "className": "text-left",
                "width": "10d%"
            }
        ]
    });
});
$(document).on('submit', '#addKom', function(e) {
    e.preventDefault();
    var nik = $('#nikK').val();
    var kegiatan = $('#kegiatan').val();
    var tempat = $('#tempatK').val();
    var waktu = $('#waktuK').val();
    var sebagai = $('#sebagai').val();
    var tingkat = $('#tingkatK').val();
    var tahunaka = $('#tahunakaK').val();
    if (kegiatan != '' && tempat != '' && nik != '' && waktu != '' && sebagai != '' && tingkat != '' && tahunaka != '') {
        $.ajax({
            url: "pages/add_kom.php",
            type: "post",
            data: {
                nik: nik,
                kegiatan: kegiatan,
                tempat: tempat,
                waktu: waktu,
                sebagai: sebagai,
                tingkat: tingkat,
                tahunaka: tahunaka,
            },
            success: function(data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'true') {
                    mytable = $('#kom').DataTable();
                    mytable.draw();
                    $('#modalKom').modal('hide');
                } else {
                    alert('failed');
                }
            }
        });
    } else {
        alert('Fill all the required fields');
    }
});
$(document).on('submit', '#updateKom', function(e) {
    e.preventDefault();
    //var tr = $(this).closest('tr');
    var nik = $('#nikK_').val();
    var kegiatan = $('#kegiatan_').val();
    var tempat = $('#tempatK_').val();
    var waktu = $('#waktuK_').val();
    var sebagai = $('#sebagai_').val();
    var tingkat = $('#tingkatK_').val();
    var tahunaka = $('#tahunakaK_').val();
    var trid = $('#tridK').val();
    var id = $('#idK_').val();
    if (nik != '' && kegiatan != '' && tempat != '' && waktu != '' && sebagai != '' && tingkat != '' && tahunaka != '') {
        $.ajax({
            url: "pages/update_kom.php",
            type: "post",
            data: {
                nik: nik,
                kegiatan: kegiatan,
                tempat: tempat,
                waktu: waktu,
                sebagai: sebagai,
                tingkat: tingkat,
                tahunaka: tahunaka,
                id: id
            },
            success: function(data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'true') {
                    table = $('#kom').DataTable();
                    var button = '<td><div class="d-flex"><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtnK">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtnK">Delete</a></div></td>';
                    var row = table.row("[id='" + trid + "']");
                    row.row("[id='" + trid + "']").data([kegiatan, tempat, waktu, sebagai, tingkat, tahunaka, button]);
                    $('#editKom').modal('hide');
                } else {
                    alert('failed');
                }
            }
        });
    } else {
        alert('Fill all the required fields');
    }
});
$('#kom').on('click', '.editbtnK ', function(event) {
    var table = $('#kom').DataTable();
    var trid = $(this).closest('tr').attr('id');
    // console.log(selectedRow);
    var id = $(this).data('id');
    $('#editKom').modal('show');

    $.ajax({
        url: "pages/get_single_kom.php",
        data: {
            id: id
        },
        type: 'post',
        success: function(data) {
            var json = JSON.parse(data);
            $('#nikK_').val(json.nik);
            $('#kegiatan_').val(json.kegiatan);
            $('#tempatK_').val(json.tempat);
            $('#waktuK_').val(json.waktu);
            $('#sebagai_').val(json.sebagai);
            $('#tingkatK_').val(json.tingkat);
            $('#tahunakaK_').val(json.tahunaka);
            $('#idK_').val(id);
            $('#tridK').val(trid);
        }
    })
});
$(document).on('click', '.deleteBtnK', function(event) {
    var table = $('#kom').DataTable();
    event.preventDefault();
    var id = $(this).data('id');
    var nik = $(this).data('nik');
    if (confirm("Are you sure want to delete this User ? ")) {
        $.ajax({
            url: "pages/hapus_kom.php",
            data: {
                id: id,
                nik: nik
            },
            type: "post",
            success: function(data) {
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