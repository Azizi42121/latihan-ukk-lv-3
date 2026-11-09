<?php
require_once 'config/kuis_db.php';
require_once 'middleware/auth_check.php';

check_login();

// 1. Logika Pencarian Karya
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($keyword !== '') {
    // Cari berdasarkan nama_project atau deskripsi dengan JOIN ke tabel users
    $stmt = $pdo->prepare("SELECT projects.*, users.nama AS pembuat 
                           FROM projects 
                           JOIN users ON projects.user_id = users.id 
                           WHERE projects.nama_project LIKE :keyword 
                              OR projects.deskripsi LIKE :keyword
                              OR users.nama LIKE :keyword 
                           ORDER BY projects.created_at DESC");
    $stmt->execute([':keyword' => "%$keyword%"]);
    $projects = $stmt->fetchAll();
} else {
    // Tampilkan semua data jika tidak ada kata kunci pencarian
    $stmt = $pdo->query("SELECT projects.*, users.nama AS pembuat 
                         FROM projects 
                         JOIN users ON projects.user_id = users.id 
                         ORDER BY projects.created_at DESC");
    $projects = $stmt->fetchAll();
}

// 2. Logika Modal Detail (Tanpa JS, dikontrol PHP lewat parameter ?detail=ID)
$id_detail = isset($_GET['detail']) ? $_GET['detail'] : null;
$project_terpilih = null;

if ($id_detail) {
    $stmt_detail = $pdo->prepare("SELECT projects.*, users.nama AS pembuat 
                                  FROM projects 
                                  JOIN users ON projects.user_id = users.id 
                                  WHERE projects.id = :id");
    $stmt_detail->execute([':id' => $id_detail]);
    $project_terpilih = $stmt_detail->fetch();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etalase Digital Stella</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <link rel="icon" type="image/jpeg" href="icon/stella_icon.jpg" />
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f8f9fa; 
            margin: 0; 
            padding: 20px; 
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            border-bottom: 2px solid #ddd; 
            padding-bottom: 10px; 
        }
        .grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 20px; 
            margin-top: 20px; 
        }
        .card { 
            background: white; 
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-4px);
        }
        .card img { width: 100%; height: 180px; object-fit: cover; }
        .card-body { padding: 15px; }
        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .btn { 
            text-decoration: none; 
            padding: 8px 12px; 
            border-radius: 4px; 
            color: white;
            display: inline-block; 
            font-size: 12px; 
            margin-right: 5px; 
        }

        .searchbar {
            display: flex;
            width: 450px;
            justify-content: center;
            align-items: center;
            gap: 15px;
            padding: 15px;
            margin: 30px auto;
            border: 1px solid grey;
            border-radius: 10px;
            background: #fff;
        }

        .btn-blue { background: #007bff; } 
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; }

        /* Styling Modal Overlay tanpa JS */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .btn-close {
            position: absolute;
            top: 10px;
            right: 15px;
            text-decoration: none;
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        <h2>Etalase Digital Stella</h2>
        <div>
            Halo, <b><?= htmlspecialchars($_SESSION['nama']) ?></b> (<?=$_SESSION['role']?>) |
            <a href="project_tambah.php" class="btn btn-blue">+ Tambah Karya</a>
            <?php if ($_SESSION['role'] === 'super_admin'): ?>
                <a href="admin/users.php" class="btn btn-warning">Kelola Users</a>
            <?php endif; ?>
            <a href="auth/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Searchbar Section -->
    <div class="searchbar">
        <span>Katalog Karya Siswa</span>
        <form method="GET" action="">
            <input type="text" id="search-input" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari Project...">
            <button type="submit" id="btn-cari">Cari</button>
        </form>
    </div>

    <!-- Grid List Karya -->
    <div class="grid">
        <?php foreach($projects as $p): ?>
            <div class="card">
                <!-- Tautan card mengarah ke index.php dengan parameter ?detail=ID -->
                <a href="index.php?detail=<?= $p['id'] ?>" class="card-link">
                    <img src="uploads/<?= htmlspecialchars($p['gambar']) ?>" alt="Karya">
                    <div class="card-body">
                        <h3><?= htmlspecialchars($p['nama_project']) ?></h3>
                        <p><small>Oleh: <b><?= htmlspecialchars($p['pembuat']) ?></b></small></p>
                        <p><?= htmlspecialchars(substr($p['deskripsi'], 0, 100)) ?><?= strlen($p['deskripsi']) > 100 ? '...' : '' ?></p>
                    </div>
                </a>
                <div class="card-body" style="padding-top: 0;">
                    <?php if($_SESSION['role'] === 'super_admin' || $_SESSION['role'] === 'admin' || $_SESSION['user_id'] === $p['user_id']): ?>
                        <a href="project_edit.php?id=<?= $p['id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="project_hapus.php?id=<?= $p['id'] ?>" onclick="return confirm('Hapus karya ini?')" class="btn btn-danger">Hapus</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal Overlay Detail Karya (Murni PHP, tampil jika $project_terpilih tidak null) -->
    <?php if ($project_terpilih): ?>
        <div class="modal-overlay">
            <div class="modal-box">
                <!-- Tombol Tutup (X) menghapus parameter ?detail di URL -->
                <a href="index.php<?= $keyword !== '' ? '?keyword=' . urlencode($keyword) : '' ?>" class="btn-close">&times;</a>
                
                <h2><?= htmlspecialchars($project_terpilih['nama_project']) ?></h2>
                <img src="uploads/<?= htmlspecialchars($project_terpilih['gambar']) ?>" alt="Karya" style="width: 100%; height: 220px; object-fit: cover; border-radius: 6px; margin: 10px 0;">
                
                <p><small>Dibuat oleh: <b><?= htmlspecialchars($project_terpilih['pembuat']) ?></b></small></p>
                <p><?= htmlspecialchars($project_terpilih['deskripsi']) ?></p>
                
                <?php if (!empty($project_terpilih['link_project'])): ?>
                    <p style="margin-top: 15px;">
                        <a href="<?= htmlspecialchars($project_terpilih['link_project']) ?>" target="_blank" class="btn btn-blue">Lihat Project Tautan &rarr;</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>