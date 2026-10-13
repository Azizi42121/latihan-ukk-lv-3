<?php
require_once 'config/kuis_db.php';
require_once 'middleware/auth_check.php';
check_login();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_project = trim($_POST['nama_project']);
    $deskripsi = trim($_POST['deskripsi']);
    $link_project = trim($_POST['link_project']);
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $new_name = uniqid('project_', true) . '.' . $ext;
        
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $new_name)) {
            $stmt = $pdo->prepare("INSERT INTO projects (user_id, nama_project, deskripsi, gambar, link_project) VALUES (:user_id, :nama, :desk, :img, :link)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':nama' => $nama_project,
                ':desk' => $deskripsi,
                ':img' => $new_name,
                ':link' => $link_project
            ]);
            header('Location: index.php');
            exit();
        } else {
            $error = "Gagal mengunggah gambar.";
        }
    } else {
        $error = "Gambar wajib diunggah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Karya - Etalase Digital Stella</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/form.css">
</head>
<body>
<div class="form-container">
    <h2>Tambah Karya Digital</h2>
    <?php if($error): ?><div class="alert-danger"><?= $error ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Karya</label>
            <input type="text" name="nama_project" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" required></textarea>
        </div>
        <div class="form-group">
            <label>Link Project</label>
            <input type="url" name="link_project" placeholder="https://" required>
        </div>
        <div class="form-group">
            <label>Gambar Karya</label>
            <input type="file" name="gambar" accept="image/*" id="inputGambar" required>
            <div class="preview-box" id="previewBox">
                <img id="imgPreview" src="#" alt="Preview">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Karya</button>
    </form>
    <p style="margin-top:15px; text-align:center;"><a href="index.php">&larr; Kembali</a></p>
</div>

<script>
document.getElementById('inputGambar').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('imgPreview').src = URL.createObjectURL(file);
        document.getElementById('previewBox').style.display = 'block';
    }
});
</script>
</body>
</html>