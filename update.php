<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
        $durasi = isset($_POST['durasi']) ? $_POST['durasi'] : '';
        $materi = isset($_POST['materi']) ? $_POST['materi'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE kursus SET id = ?, nama = ?, deskripsi = ?, durasi = ?, materi = ? WHERE id = ?');
        $stmt->execute([$id, $nama, $deskripsi, $durasi, $materi, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM kursus WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$course) {
        exit('Course doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Course #<?=$course['id']?></h2>
    <form action="update.php?id=<?=$course['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama</label>
        <input type="text" name="id" value="<?=$course['id']?>" id="id">
        <input type="text" name="nama" value="<?=$course['nama']?>" id="nama">
        <label for="email">Deskripsi</label>
        <label for="notelp">Durasi</label>
        <input type="text" name="deskripsi" value="<?=$course['deskripsi']?>" id="deskripsi">
        <input type="text" name="durasi" value="<?=$course['durasi']?>" id="durasi">
        <label for="pekerjaan">Materi</label>
        <input type="text" name="materi" value="<?=$course['materi']?>" id="materi">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>