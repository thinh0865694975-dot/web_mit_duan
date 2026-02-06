<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sách</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">
<h3>📘 Quản lý Sách</h3>
<button class="btn btn-success mb-2" id="add">➕ Thêm</button>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>ID</th><th>Tên sách</th><th>Năm XB</th><th>Số lượng</th><th>Thao tác</th>
</tr>
</thead>
<tbody id="data"></tbody>
</table>
</div>

<div class="modal fade" id="modal">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5>Sách</h5></div>
<div class="modal-body">
<input type="hidden" id="id">
<input class="form-control mb-2" id="tensach" placeholder="Tên sách">
<input class="form-control mb-2" id="namxuatban" placeholder="Năm xuất bản">
<input class="form-control mb-2" id="soluong" placeholder="Số lượng">
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
 $.post("sach_action.php",{action:"fetch"},r=>{
  let h="";
  JSON.parse(r).forEach(x=>{
   h+=`<tr>
    <td>${x.sach_id}</td>
    <td>${x.tensach}</td>
    <td>${x.namxuatban}</td>
    <td>${x.soluong}</td>
    <td>
     <button class="btn btn-warning btn-sm edit"
      data-id="${x.sach_id}"
      data-name="${x.tensach}"
      data-nam="${x.namxuatban}"
      data-sl="${x.soluong}">Sửa</button>
     <button class="btn btn-danger btn-sm delete" data-id="${x.sach_id}">Xóa</button>
    </td></tr>`;
  });
  $("#data").html(h);
 });
}
load();

$("#add").click(()=>{ $("#id").val(""); modal.show(); });

$(document).on("click",".edit",function(){
 $("#id").val($(this).data("id"));
 $("#tensach").val($(this).data("name"));
 $("#namxuatban").val($(this).data("nam"));
 $("#soluong").val($(this).data("sl"));
 modal.show();
});

$("#save").click(()=>{
 $.post("sach_action.php",{
  action:"save",
  sach_id:$("#id").val(),
  tensach:$("#tensach").val(),
  namxuatban:$("#namxuatban").val(),
  soluong:$("#soluong").val(),
  theloai_id:1
 },()=>{ modal.hide(); load(); });
});

$(document).on("click",".delete",function(){
 if(confirm("Xóa sách?")){
  $.post("sach_action.php",{action:"delete",id:$(this).data("id")},load);
 }
});
</script>
</body>
</html>
