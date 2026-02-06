<?php
include "../../db.php";
$rs=$conn->query("
    SELECT c.muontra_id,s.tensach,c.tinhtrang
    FROM chitietmuontra c JOIN sach s ON c.sach_id=s.sach_id
");
while($c=$rs->fetch_assoc()){
    echo "<tr>
        <td>{$c['muontra_id']}</td>
        <td>{$c['tensach']}</td>
        <td>{$c['tinhtrang']}</td>
    </tr>";
}
