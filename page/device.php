<?php
$page = $_GET['page'] ?? '';
$insert = false;

// Ensure the database connection is established
if (!isset($konek)) {
  die('Database connection not established.');
}

// Function to display alert messages
function showAlert($message)
{
  echo "<script>alert('$message');</script>";
}

if (isset($_POST['edit_data'])) {
  // Editing existing data
  $idlama = $_POST['edit_data'];
  $iddd = $_POST['idnya'];
  $kontrol = $_POST['kontroler'];
  $namah = $_POST['nama'];
  $status = $_POST['active'];

  // Prepare and bind
  $stmt = $konek->prepare("UPDATE device SET id_device = ?, mcu_type = ?, name_user = ?, active = ? WHERE id_device = ?");
  $stmt->bind_param("sssss", $iddd, $kontrol, $namah, $status, $idlama);
  $stmt->execute();
  $stmt->close();
} else if (isset($_POST['idnya'])) {
  // Adding new data
  $iddd = $_POST['idnya'];
  $kontrol = $_POST['kontroler'];
  $namah = $_POST['nama'];

  // Check for duplicate ID
  $stmt = $konek->prepare("SELECT COUNT(*) as count FROM device WHERE id_device = ?");
  $stmt->bind_param("s", $iddd);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();

  if ($count > 0) {
    showAlert('ID Device already exists. Please use a different ID.');
  } else {
    // Insert new record
    $stmt = $konek->prepare("INSERT INTO device (id_device, mcu_type, name_user) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $iddd, $kontrol, $namah);
    $stmt->execute();
    $stmt->close();
    $insert = true;
  }
}

if (isset($_GET['edit'])) {
  $serial = $_GET['edit'];
  $stmt = $konek->prepare("SELECT * FROM device WHERE id_device = ? LIMIT 1");
  $stmt->bind_param("s", $serial);
  $stmt->execute();
  $result = $stmt->get_result();
  $dataedit = $result->fetch_assoc();
  $stmt->close();
}

$sql = "SELECT * FROM device";
$result = $konek->query($sql);
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Perangkat</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <?php if ($insert) {
        showAlert('Data successfully inserted.');
      } ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Perangkat yang terdaftar</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID Device</th>
                    <th>MCU Type</th>
                    <th>Name User</th>
                    <th>Status</th>
                    <th>Time Connected</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                      <td><?php echo $row['id_device']; ?></td>
                      <td><?php echo $row['mcu_type']; ?></td>
                      <td><?php echo $row['name_user']; ?></td>
                      <td><?php echo $row['active']; ?></td>
                      <td><?php echo $row['time']; ?></td>
                      <td><a href="?page=<?php echo $page ?>&edit=<?php echo $row['id_device']; ?>"><i class="fas fa-user-edit"></i></a></td>
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID Device</th>
                    <th>MCU Type</th>
                    <th>Name User</th>
                    <th>Status</th>
                    <th>Time Connected</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <?php if (!isset($_GET['edit'])) { ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Data</h3>
              </div>
              <form method="post" action="?page=device">
                <div class="card-body">
                  <div class="form-group">
                    <label>ID Device</label>
                    <input type="text" class="form-control" name="idnya" required placeholder="id">
                  </div>
                  <div class="form-group">
                    <label for="mcutype">MCU Type</label>
                    <input type="text" class="form-control" name="kontroler" required placeholder="mcu">
                  </div>
                  <div class="form-group">
                    <label>Name User</label>
                    <input type="text" class="form-control" name="nama" required placeholder="name">
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          <?php } else { ?>
            <div class="col-lg-12">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Ubah Data</h3>
                </div>
                <form method="post" action="?page=device">
                  <div class="card-body">
                    <div class="form-group">
                      <label>ID Device</label>
                      <input type="hidden" name="edit_data" value="<?php echo $dataedit['id_device']; ?>">
                      <input type="text" class="form-control" name="idnya" value="<?php echo $dataedit['id_device']; ?>" required placeholder="id">
                    </div>
                    <div class="form-group">
                      <label for="mcutype">MCU Type</label>
                      <input type="text" class="form-control" name="kontroler" value="<?php echo $dataedit['mcu_type']; ?>" required placeholder="mcu">
                    </div>
                    <div class="form-group">
                      <label>Name User</label>
                      <input type="text" class="form-control" name="nama" value="<?php echo $dataedit['name_user']; ?>" required placeholder="name">
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <div class="col-lg-1">
                        <select class="form-control" name="active">
                          <option value="yes" <?php echo ($dataedit['active'] == 'yes') ? 'selected' : ''; ?>>Aktif</option>
                          <option value="no" <?php echo ($dataedit['active'] == 'no') ? 'selected' : ''; ?>>Tidak Aktif</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info">Change</button>
                    <a href="?page=device" class="btn bg-lightblue">Cancel</a>
                  </div>
                </form>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>