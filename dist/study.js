$(document).ready(function() {
    $('#study').DataTable({
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
        },
        'serverSide': 'true',
        'processing': 'true',
        'paging': 'true',
        'order': [],
        'ajax': {
            'url': 'pages/data_study.php',
            'type': 'post',
        },
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [5]
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
                "targets": [2, 3],
                "className": "text-left",
                "width": "10d%"
            }
        ]
    });
});
$(document).on('submit', '#addStudy', function(e) {
    e.preventDefault();
    var nik = $('#nikS').val();
    var pendiklanjut = $('#pendiklanjut').val();
    var bidstudy = $('#bidstudy').val();
    var univ = $('#univ').val();
    var negara = $('#negara').val();
    var tahunS = $('#tahunS').val();
    if (pendiklanjut != '' && bidstudy != '' && nik != '' && univ != '' && negara != '' && negara != '') {
        $.ajax({
            url: "pages/add_study.php",
            type: "post",
            data: {
                nik: nik,
                pendiklanjut: pendiklanjut,
                bidstudy: bidstudy,
                univ: univ,
                negara: negara,
                tahunS: tahunS,
            },
            success: function(data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'true') {
                    mytable = $('#study').DataTable();
                    mytable.draw();
                    $('#modalStudy').modal('hide');
                } else {
                    alert('failed');
                }
            }
        });
    } else {
        alert('Fill all the required fields');
    }
});
$(document).on('submit', '#updateStudy', function(e) {
    e.preventDefault();
    //var tr = $(this).closest('tr');
    var nik = $('#nikS_').val();
    var pendiklanjut = $('#pendiklanjut_').val();
    var bidstudy = $('#bidstudy_').val();
    var univ = $('#univ_').val();
    var negara = $('#negara_').val();
    var tahun = $('#tahunS_').val();
    var trid = $('#tridS').val();
    var id = $('#idS_').val();
    if (nik != '' && pendiklanjut != '' && bidstudy != '' && univ != '' && negara != '' && tahun != '') {
        $.ajax({
            url: "pages/update_study.php",
            type: "post",
            data: {
                nik: nik,
                pendiklanjut: pendiklanjut,
                bidstudy: bidstudy,
                univ: univ,
                negara: negara,
                tahun: tahun,
                id: id
            },
            success: function(data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'true') {
                    table = $('#study').DataTable();
                    var button = '<td><div class="d-flex"><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtnS">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtnS">Delete</a></div></td>';
                    var row = table.row("[id='" + trid + "']");
                    row.row("[id='" + trid + "']").data([pendiklanjut, bidstudy, univ, negara, tahun, button]);
                    $('#editModalStudy').modal('hide');
                } else {
                    alert('failed');
                }
            }
        });
    } else {
        alert('Fill all the required fields');
    }
});
$('#study').on('click', '.editbtnS ', function(event) {
    var table = $('#study').DataTable();
    var trid = $(this).closest('tr').attr('id');
    // console.log(selectedRow);
    var id = $(this).data('id');
    $('#editModalStudy').modal('show');

    $.ajax({
        url: "pages/get_single_study.php",
        data: {
            id: id
        },
        type: 'post',
        success: function(data) {
            var json = JSON.parse(data);
            $('#nikS_').val(json.nik);
            $('#pendiklanjut_').val(json.pendiklanjut);
            $('#bidstudy_').val(json.bidangstudy);
            $('#univ_').val(json.univ);
            $('#negara_').val(json.negara);
            $('#tahunS_').val(json.tahunmulaistudi);
            $('#idS_').val(id);
            $('#tridS').val(trid);
        }
    })
});
$(document).on('click', '.deleteBtnS', function(event) {
    var table = $('#study').DataTable();
    event.preventDefault();
    var id = $(this).data('id');
    var nik = $(this).data('nik');
    if (confirm("Are you sure want to delete this User ? ")) {
        $.ajax({
            url: "pages/hapus_study.php",
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