<?php
class Animal {
    private $animals = [];

    public function index() {
        return $this->animals;
    }

    public function store($new_animal) {
        $this->animals[] = $new_animal;
    }

    public function update($old_animal, $new_animal) {
        $index = array_search($old_animal, $this->animals);
        if ($index !== false) {
            $this->animals[$index] = $new_animal;
        }
    }

    public function destroy($animal) {
        $index = array_search($animal, $this->animals);
        if ($index !== false) {
            unset($this->animals[$index]);
        }
    }
}

$animal_manager = new Animal();

// Menambahkan beberapa hewan awal
$animal_manager->store("Kucing");
$animal_manager->store("Anjing");
$animal_manager->store("Kelinci");

// Memproses form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $animal_manager->store($_POST['new_animal']);
    } elseif (isset($_POST['update'])) {
        $animal_manager->update($_POST['old_animal'], $_POST['new_animal']);
    }
}

// Menghapus hewan
if (isset($_GET['delete'])) {
    $animal_manager->destroy($_GET['delete']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hewan</title>
</head>
<body>
    <h1>List Hewan</h1>
    
    <h2>Daftar Hewan:</h2>
    <ul>
    <?php foreach ($animal_manager->index() as $animal): ?>
        <li><?php echo htmlspecialchars($animal); ?> 
            <a href="?delete=<?php echo urlencode($animal); ?>">Hapus</a>
        </li>
    <?php endforeach; ?>
    </ul>

    <h2>Tambah Hewan:</h2>
    <form method="post">
        <input type="text" name="new_animal" required>
        <input type="submit" name="add" value="Tambah">
    </form>

    <h2>Update Hewan:</h2>
    <form method="post">
        <input type="text" name="old_animal" placeholder="Nama hewan lama" required>
        <input type="text" name="new_animal" placeholder="Nama hewan baru" required>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html> 