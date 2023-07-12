<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
    $durasi = isset($_POST['durasi']) ? $_POST['durasi'] : '';
    $materi = isset($_POST['materi']) ? $_POST['materi'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO kursus VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$id, $nama, $deskripsi, $durasi, $materi]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Course</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama</label>
        <input type="text" name="id" value="auto" id="id">
        <input type="text" name="nama" id="nama">
        <label for="email">Deskripsi</label>
        <label for="notelp">Durasi</label>
        <input type="text" name="deskripsi" id="deskripsi">
        <input type="text" name="durasi" id="durasi">
        <label for="pekerjaan">Materi</label>
        <input type="text" name="materi" id="materi">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>