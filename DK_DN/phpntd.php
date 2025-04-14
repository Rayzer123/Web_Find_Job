<?php
// Dữ liệu mẫu
$dsTinhThanh = [
    'Việt Nam' => ['Hà Nội', 'TP. Hồ Chí Minh'],
];

$dsQuanHuyen = [
    'Hà Nội' => ['Ba Đình', 'Hoàn Kiếm'],
    'TP. Hồ Chí Minh' => ['Quận 1', 'Quận 3']
];

// Xử lý dữ liệu được chọn
$quocGia = $_POST['quoc-gia'] ?? '';
$tinhThanh = $_POST['tinh-thanh'] ?? '';
$quanHuyen = $_POST['quan-huyen'] ?? '';
?>

<form method="post">
    <label>Địa Chỉ</label><br>

    <!-- Quốc gia -->
    <select name="quoc-gia" onchange="this.form.submit()">
        <option value="">Chọn quốc gia</option>
        <option value="Việt Nam" <?= $quocGia == 'Việt Nam' ? 'selected' : '' ?>>Việt Nam</option>
    </select>

    <!-- Tỉnh / Thành -->
    <select name="tinh-thanh" onchange="this.form.submit()">
        <option value="">Chọn tỉnh / thành</option>
        <?php
        if ($quocGia && isset($dsTinhThanh[$quocGia])) {
            foreach ($dsTinhThanh[$quocGia] as $tinh) {
                $selected = $tinh == $tinhThanh ? 'selected' : '';
                echo "<option value=\"$tinh\" $selected>$tinh</option>";
            }
        }
        ?>
    </select>

    <!-- Quận / Huyện -->
    <select name="quan-huyen">
        <option value="">Chọn quận / huyện</option>
        <?php
        if ($tinhThanh && isset($dsQuanHuyen[$tinhThanh])) {
            foreach ($dsQuanHuyen[$tinhThanh] as $qh) {
                $selected = $qh == $quanHuyen ? 'selected' : '';
                echo "<option value=\"$qh\" $selected>$qh</option>";
            }
        }
        ?>
    </select>
</form>

<?php
if ($quocGia && $tinhThanh && $quanHuyen) {
    echo "<p>Bạn đã chọn: $quocGia → $tinhThanh → $quanHuyen</p>";
}
?>
