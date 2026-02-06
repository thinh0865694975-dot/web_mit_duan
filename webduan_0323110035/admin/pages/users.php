<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">
<h3>👤 Quản lý Users</h3>
<button class="btn btn-success mb-2" id="btnAdd">➕ Thêm User</button>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Username</th>
<th>Email</th>
<th>Role</th>
<th width="150">Thao tác</th>
</tr>
</thead>
<tbody id="data"></tbody>
</table>
</div>

<!-- MODAL -->
<div class="modal fade" id="modal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5>Thêm / Sửa User</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<input type="hidden" id="user_id">
<input class="form-control mb-2" id="username" placeholder="Username">
<input class="form-control mb-2" id="email" placeholder="Email">
<select class="form-control" id="role_id">
<option value="1">Admin</option>
<option value="2">ThuThu</option>
<option value="3">DocGia</option>
</select>
</div>
<div class="modal-footer">
<button class="btn btn-primary" id="save">Lưu</button>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let modal=new bootstrap.Modal(document.getElementById('modal'));

function loadData(){
 $.post("users_action.php",{action:"fetch"},res=>{
  let html="";
  JSON.parse(res).forEach(r=>{
   html+=`<tr>
    <td>${r.user_id}</td>
    <td>${r.username}</td>
    <td>${r.email}</td>
    <td>${r.role_name}</td>
    <td>
     <button class="btn btn-warning btn-sm edit"
      data-id="${r.user_id}"
      data-username="${r.username}"
      data-email="${r.email}"
      data-role="${r.role_id}">Sửa</button>
     <button class="btn btn-danger btn-sm delete" data-id="${r.user_id}">Xóa</button>
    </td></tr>`;
  });
  $("#data").html(html);
 });
}
loadData();

$("#btnAdd").click(()=>{ $("#user_id").val(""); $("#username").val(""); $("#email").val(""); modal.show(); });

$(document).on("click",".edit",function(){
 $("#user_id").val($(this).data("id"));
 $("#username").val($(this).data("username"));
 $("#email").val($(this).data("email"));
 $("#role_id").val($(this).data("role"));
 modal.show();
});

$("#save").click(()=>{
 $.post("users_action.php",{
  action:"save",
  user_id:$("#user_id").val(),
  username:$("#username").val(),
  email:$("#email").val(),
  role_id:$("#role_id").val()
 },()=>{ modal.hide(); loadData(); });
});

$(document).on("click",".delete",function(){
 if(confirm("Xóa user này?")){
  $.post("users_action.php",{action:"delete",id:$(this).data("id")},loadData);
 }
});
</script>
</body>
</html>
