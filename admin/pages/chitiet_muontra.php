<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi tiết mượn</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">
<h3>📑 Chi tiết mượn</h3>
<button class="btn btn-success mb-2" id="add">➕ Thêm chi tiết</button>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>Mã mượn</th>
<th>Tên sách</th>
<th>Ngày trả</th>
<th>Tình trạng</th>
<th width="140">Thao tác</th>
</tr>
</thead>
<tbody id="data"></tbody>
</table>
</div>

<!-- MODAL -->
<div class="modal fade" id="modal">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5>Chi tiết mượn</h5></div>
<div class="modal-body">
<input type="hidden" id="old_muontra">
<input type="hidden" id="old_sach">

<div class="mb-2">
<label>Mã mượn</label>
<input class="form-control" id="muontra_id" placeholder="muontra_id (vd: 1)">
</div>
<div class="mb-2">
<label>Mã sách</label>
<input class="form-control" id="sach_id" placeholder="sach_id (vd: 2)">
</div>
<div class="mb-2">
<label>Ngày trả</label>
<input type="date" class="form-control" id="ngaytra">
</div>
<div class="mb-2">
<label>Tình trạng</label>
<input class="form-control" id="tinhtrang" placeholder="Tốt / Chưa trả / Hỏng">
</div>
</div>
<div class="modal-footer">
<button class="btn btn-primary" id="save">Lưu</button>
</div>
</div></div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let modal=new bootstrap.Modal(document.getElementById('modal'));

function load(){
 $.post("chitiet_muontra_action.php",{action:"fetch"},r=>{
  let h="";
  JSON.parse(r).forEach(x=>{
   h+=`<tr>
    <td>${x.muontra_id}</td>
    <td>${x.tensach}</td>
    <td>${x.ngaytra ?? ''}</td>
    <td>${x.tinhtrang ?? ''}</td>
    <td>
      <button class="btn btn-warning btn-sm edit"
        data-m="${x.muontra_id}"
        data-s="${x.sach_id}"
        data-ngaytra="${x.ngaytra ?? ''}"
        data-tinhtrang="${x.tinhtrang ?? ''}">Sửa</button>
      <button class="btn btn-danger btn-sm delete"
        data-m="${x.muontra_id}"
        data-s="${x.sach_id}">Xóa</button>
    </td>
   </tr>`;
  });
  $("#data").html(h);
 });
}
load();

$("#add").click(()=>{
 $("#old_muontra").val(""); $("#old_sach").val("");
 $("#muontra_id").val(""); $("#sach_id").val("");
 modal.show();
});

$(document).on("click",".edit",function(){
 $("#old_muontra").val($(this).data("m"));
 $("#old_sach").val($(this).data("s"));
 $("#muontra_id").val($(this).data("m"));
 $("#sach_id").val($(this).data("s"));
 $("#ngaytra").val($(this).data("ngaytra"));
 $("#tinhtrang").val($(this).data("tinhtrang"));
 modal.show();
});

$("#save").click(()=>{
 $.post("chitiet_muontra_action.php",{
  action:"save",
  old_muontra:$("#old_muontra").val(),
  old_sach:$("#old_sach").val(),
  muontra_id:$("#muontra_id").val(),
  sach_id:$("#sach_id").val(),
  ngaytra:$("#ngaytra").val(),
  tinhtrang:$("#tinhtrang").val()
 },()=>{ modal.hide(); load(); });
});

$(document).on("click",".delete",function(){
 if(confirm("Xóa chi tiết mượn?")){
  $.post("chitiet_muontra_action.php",{
    action:"delete",
    muontra_id:$(this).data("m"),
    sach_id:$(this).data("s")
  },load);
 }
});
</script>
</body>
</html>
