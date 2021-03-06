
$(document).ready(function () {
    var nik = $('#getnik').val();
    $('#rekognisi').DataTable({
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
        },
        'serverSide': 'true',
        'processing': 'true',
        'paging': 'true',
        'order': [],
        'ajax': {
            'url': 'pages/data_rekognisi.php?nik='+nik,
            'type': 'post',
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [4]
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
            "targets": [3, 4],
            "className": "text-left",
            "width": "10d%"
        }
        ]
    });
});
$(document).on('submit', '#addrekog', function (e) {
    e.preventDefault();
    var nik = $('#nik').val();
    var bidangah = $('#bidangah').val();
    var rekognisi = $('#rekognisis').val();
    var tingkat = $('#tingkat').val();
    var tahunaka = $('#tahunaka').val();
    if (rekognisi != '' && tingkat != '' && nik != '' && tahunaka != '' && bidangah != '') {
        $.ajax({
            url: "pages/add_rekog.php",
            type: "post",
            data: {
                nik: nik,
                rekognisi: rekognisi,
                tingkat: tingkat,
                tahunaka: tahunaka,
                bidangah: bidangah,
            },
            success: function (data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'true') {
                    mytable = $('#rekognisi').DataTable();
                    mytable.draw();
                    $('#modalRekognisi').modal('hide');
                } else {
                    alert('failed');
                }
            }
        });
    } else {
        alert('Fill all the required fields');
    }
});
$(document).on('submit', '#updaterekognisi', function (e) {
    e.preventDefault();
    //var tr = $(this).closest('tr');
    var nik = $('#nik_').val();
    var rekognisi = $('#rekognisis_').val();
    var tingkat = $('#tingkat_').val();
    var tahunaka = $('#tahunaka_').val();
    var bidangah = $('#bidangah_').val();
    var trid = $('#trid').val();
    var id = $('#id_').val();
    if (nik != '' && rekognisi != '' && tingkat != '' && tahunaka != '' && bidangah != '') {
        $.ajax({
            url: "pages/update_rekog.php",
            type: "post",
            data: {
                nik: nik,
                rekognisi: rekognisi,
                tingkat: tingkat,
                tahunaka: tahunaka,
                bidangah: bidangah,
                id: id
            },
            success: function (data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'true') {
                    table = $('#rekognisi').DataTable();
                    var button = '<td><div class="d-flex"><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtn">Delete</a></div></td>';
                    var row = table.row("[id='" + trid + "']");
                    row.row("[id='" + trid + "']").data([bidangah, rekognisi, tingkat, tahunaka, button]);
                    $('#editModalRekog').modal('hide');
                } else {
                    alert('failed');
                }
            }
        });
    } else {
        alert('Fill all the required fields');
    }
});
$('#rekognisi').on('click', '.editbtn ', function (event) {
    var table = $('#rekognisi').DataTable();
    var trid = $(this).closest('tr').attr('id');
    // console.log(selectedRow);
    var id = $(this).data('id');
    $('#editModalRekog').modal('show');

    $.ajax({
        url: "pages/get_single_rekognisi.php",
        data: {
            id: id
        },
        type: 'post',
        success: function (data) {
            var json = JSON.parse(data);
            $('#nik_').val(json.nik);
            $('#bidangah_').val(json.bidang_ahli);
            $('#rekognisis_').val(json.rekognisi);
            $('#tingkat_').val(json.tingkat);
            $('#tahunaka_').val(json.tahunaka);
            $('#id_').val(id);
            $('#trid').val(trid);
        }
    })
});
$(document).on('click', '.deleteBtn', function (event) {
    var table = $('#rekognisi').DataTable();
    event.preventDefault();
    var id = $(this).data('id');
    var nik = $(this).data('nik');
    if (confirm("Are you sure want to delete this User ? ")) {
        $.ajax({
            url: "pages/hapus_rekognisi.php",
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