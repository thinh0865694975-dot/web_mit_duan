<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Roles</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">
<h3>🔐 Quản lý Roles</h3>
<button class="btn btn-success mb-2" id="add">➕ Thêm</button>

<table class="table table-bordered">
<thead class="table-dark">
<tr><th>ID</th><th>Tên Role</th><th width="120">Thao tác</th></tr>
</thead>
<tbody id="data"></tbody>
</table>
</div>

<div class="modal fade" id="modal">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5>Role</h5></div>
<div class="modal-body">
<input type="hidden" id="id">
<input class="form-control" id="role_name" placeholder="Tên role">
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
 $.post("roles_action.php",{action:"fetch"},r=>{
  let h="";
  JSON.parse(r).forEach(x=>{
   h+=`<tr>
    <td>${x.role_id}</td>
    <td>${x.role_name}</td>
    <td>
     <button class="btn btn-warning btn-sm edit" data-id="${x.role_id}" data-name="${x.role_name}">Sửa</button>
     <button class="btn btn-danger btn-sm delete" data-id="${x.role_id}">Xóa</button>
    </td></tr>`;
  });
  $("#data").html(h);
 });
}
load();

$("#add").click(()=>{ $("#id").val(""); $("#role_name").val(""); modal.show(); });

$(document).on("click",".edit",function(){
 $("#id").val($(this).data("id"));
 $("#role_name").val($(this).data("name"));
 modal.show();
});

$("#save").click(()=>{
 $.post("roles_action.php",{
  action:"save",
  role_id:$("#id").val(),
  role_name:$("#role_name").val()
 },()=>{ modal.hide(); load(); });
});

$(document).on("click",".delete",function(){
 if(confirm("Xóa role?")){
  $.post("roles_action.php",{action:"delete",id:$(this).data("id")},load);
 }
});
</script>
</body>
</html>
