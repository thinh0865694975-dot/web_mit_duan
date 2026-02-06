<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Độc giả</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">
<h3>🧑‍🎓 Quản lý Độc giả</h3>
<button class="btn btn-success mb-2" id="btnAdd">➕ Thêm</button>

<table class="table table-bordered">
<thead class="table-dark">
<tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Điện thoại</th><th>Thao tác</th></tr>
</thead>
<tbody id="data"></tbody>
</table>
</div>

<div class="modal fade" id="modal">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5>Độc giả</h5></div>
<div class="modal-body">
<input type="hidden" id="id">
<input class="form-control mb-2" id="hoten" placeholder="Họ tên">
<input class="form-control mb-2" id="email" placeholder="Email">
<input class="form-control mb-2" id="dienthoai" placeholder="Điện thoại">
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
 $.post("docgia_action.php",{action:"fetch"},r=>{
  let h="";
  JSON.parse(r).forEach(x=>{
   h+=`<tr>
    <td>${x.docgia_id}</td>
    <td>${x.hoten}</td>
    <td>${x.email}</td>
    <td>${x.dienthoai}</td>
    <td>
     <button class="btn btn-warning btn-sm edit" data-id="${x.docgia_id}"
      data-hoten="${x.hoten}" data-email="${x.email}" data-dt="${x.dienthoai}">Sửa</button>
     <button class="btn btn-danger btn-sm delete" data-id="${x.docgia_id}">Xóa</button>
    </td></tr>`;
  });
  $("#data").html(h);
 });
}
load();

$("#btnAdd").click(()=>{ $("#id").val(""); modal.show(); });

$(document).on("click",".edit",function(){
 $("#id").val($(this).data("id"));
 $("#hoten").val($(this).data("hoten"));
 $("#email").val($(this).data("email"));
 $("#dienthoai").val($(this).data("dt"));
 modal.show();
});

$("#save").click(()=>{
 $.post("docgia_action.php",{
  action:"save",
  docgia_id:$("#id").val(),
  hoten:$("#hoten").val(),
  email:$("#email").val(),
  dienthoai:$("#dienthoai").val()
 },()=>{ modal.hide(); load(); });
});

$(document).on("click",".delete",function(){
 if(confirm("Xóa độc giả?")){
  $.post("docgia_action.php",{action:"delete",id:$(this).data("id")},load);
 }
});
</script>
</body>
</html>
