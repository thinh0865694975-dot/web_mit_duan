<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Mượn – Trả</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.badge-overdue{background:#dc3545}
.badge-borrow{background:#0d6efd}
.badge-return{background:#198754}
</style>
</head>
<body>

<div class="container mt-3">
<h3>🔄 Quản lý Mượn – Trả</h3>
<button class="btn btn-success mb-2" id="add">➕ Thêm phiếu mượn</button>

<table class="table table-bordered align-middle">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Độc giả</th>
<th>Ngày mượn</th>
<th>Hạn trả</th>
<th>Trạng thái</th>
<th width="140">Thao tác</th>
</tr>
</thead>
<tbody id="data"></tbody>
</table>
</div>

<!-- MODAL -->
<div class="modal fade" id="modal">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5>Phiếu mượn</h5></div>
<div class="modal-body">
<input type="hidden" id="muontra_id">
<div class="mb-2">
<label>ID Độc giả</label>
<input class="form-control" id="docgia_id" placeholder="docgia_id (vd: 1)">
</div>
<div class="mb-2">
<label>Ngày mượn</label>
<input type="date" class="form-control" id="ngaymuon">
</div>
<div class="mb-2">
<label>Hạn trả</label>
<input type="date" class="form-control" id="hantra">
</div>
<div class="mb-2">
<label>Trạng thái</label>
<select class="form-control" id="trangthai">
<option>Dang muon</option>
<option>Da tra</option>
</select>
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

function badge(trangthai, hantra){
 const today=new Date().toISOString().slice(0,10);
 if(trangthai==="Da tra") return `<span class="badge badge-return">Đã trả</span>`;
 if(hantra < today) return `<span class="badge badge-overdue">Quá hạn</span>`;
 return `<span class="badge badge-borrow">Đang mượn</span>`;
}

function load(){
 $.post("muontra_action.php",{action:"fetch"},r=>{
  let h="";
  JSON.parse(r).forEach(x=>{
   h+=`<tr>
    <td>${x.muontra_id}</td>
    <td>${x.hoten}</td>
    <td>${x.ngaymuon}</td>
    <td>${x.hantra}</td>
    <td>${badge(x.trangthai, x.hantra)}</td>
    <td>
      <button class="btn btn-warning btn-sm edit"
        data-id="${x.muontra_id}"
        data-docgia="${x.docgia_id}"
        data-ngaymuon="${x.ngaymuon}"
        data-hantra="${x.hantra}"
        data-trangthai="${x.trangthai}">Sửa</button>
      <button class="btn btn-danger btn-sm delete" data-id="${x.muontra_id}">Xóa</button>
    </td>
   </tr>`;
  });
  $("#data").html(h);
 });
}
load();

$("#add").click(()=>{ $("#muontra_id").val(""); $("#docgia_id").val(""); modal.show(); });

$(document).on("click",".edit",function(){
 $("#muontra_id").val($(this).data("id"));
 $("#docgia_id").val($(this).data("docgia"));
 $("#ngaymuon").val($(this).data("ngaymuon"));
 $("#hantra").val($(this).data("hantra"));
 $("#trangthai").val($(this).data("trangthai"));
 modal.show();
});

$("#save").click(()=>{
 $.post("muontra_action.php",{
  action:"save",
  muontra_id:$("#muontra_id").val(),
  docgia_id:$("#docgia_id").val(),
  ngaymuon:$("#ngaymuon").val(),
  hantra:$("#hantra").val(),
  trangthai:$("#trangthai").val()
 },()=>{ modal.hide(); load(); });
});

$(document).on("click",".delete",function(){
 if(confirm("Xóa phiếu mượn?")){
  $.post("muontra_action.php",{action:"delete",id:$(this).data("id")},load);
 }
});
</script>
</body>
</html>
