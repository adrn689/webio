<?php

if ($_SESSION['role'] != "Adm") {

    echo "<script> location.href='index.php' </script>";
}

// Initialize variables
$insert = false;
$update = false;

// Add new user
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $fullName = $_POST['full_name'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check for duplicate username
    $stmt = $konek->prepare("SELECT COUNT(*) as count FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<script>alert('Username already exists. Please use a different username.');</script>";
    } else {
        // Insert new user
        $stmt = $konek->prepare("INSERT INTO user (username, Full_Name, role, Statusactive, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $fullName, $role, $status, $password);
        $stmt->execute();
        $stmt->close();
        $insert = true;
    }
}

// Update existing user
if (isset($_POST['edit_user'])) {
    $oldUsername = $_POST['old_username'];
    $username = $_POST['username'];
    $fullName = $_POST['full_name'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $newPassword = $_POST['password'];

    if (!empty($newPassword)) {
        $password = password_hash($newPassword, PASSWORD_DEFAULT);
        // Update user details and password
        $stmt = $konek->prepare("UPDATE user SET username = ?, full_Name = ?, role = ?, Statusactive = ?, password = ? WHERE username = ?");
        $stmt->bind_param("ssssss", $username, $fullName, $role, $status, $password, $oldUsername);
    } else {
        // Update user details without changing the password
        $stmt = $konek->prepare("UPDATE user SET username = ?, full_Name = ?, role = ?, Statusactive = ? WHERE username = ?");
        $stmt->bind_param("sssss", $username, $fullName, $role, $status, $oldUsername);
    }

    $stmt->execute();
    $stmt->close();
    $update = true;
}

// Fetch user details for editing
if (isset($_GET['edit'])) {
    $editUsername = $_GET['edit'];
    $stmt = $konek->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $editUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $editData = $result->fetch_assoc();
    $stmt->close();
}

// Execute the query and handle potential errors
$sql = "SELECT * FROM user";
$result = mysqli_query($konek, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($konek));
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengguna Website</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
            if ($insert) {
                echo "<script>alert('User successfully added.');</script>";
            }
            if ($update) {
                echo "<script>alert('User successfully updated.');</script>";
            }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pengguna</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama Lengkap</th>
                                        <th>Hak Akses</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['Full_Name']; ?></td>
                                            <td><?php echo $row['role']; ?></td>
                                            <td><?php echo $row['Statusactive']; ?></td>
                                            <td><a href="?page=user&edit=<?php echo $row['username']; ?>"><i class="fas fa-user-edit"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama Lengkap</th>
                                        <th>Hak Akses</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <?php if (!isset($_GET['edit'])) { ?>
                    <!-- Form to Add New User -->
                    <div class="col-lg-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tambah Pengguna</h3>
                            </div>
                            <form method="post" action="?page=user">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" required placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" required placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" name="full_name" required placeholder="Nama Lengkap">
                                    </div>
                                    <div class="form-group">
                                        <label>Hak Akses</label>
                                        <select class="form-control" name="role">
                                            <option value="Adm">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="yes">Aktif</option>
                                            <option value="no">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="add_user">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } else { ?>
                    <!-- Form to Edit Existing User -->
                    <div class="col-lg-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Ubah Pengguna</h3>
                            </div>
                            <form method="post" action="?page=user">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="hidden" name="old_username" value="<?php echo $editData['username']; ?>">
                                        <input type="text" class="form-control" name="username" value="<?php echo $editData['username']; ?>" required placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <label>Password </label>
                                        <input type="password" class="form-control" name="password" placeholder="Password (Kosongkan jika tidak diubah)">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" name="full_name" value="<?php echo $editData['Full_Name']; ?>" required placeholder="Nama Lengkap">
                                    </div>
                                    <div class="form-group">
                                        <label>Hak Akses</label>
                                        <select class="form-control" name="role">
                                            <option value="Adm" <?php echo ($editData['role'] == 'Adm') ? 'selected' : ''; ?>>Admin</option>
                                            <option value="user" <?php echo ($editData['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="yes" <?php echo ($editData['Statusactive'] == 'yes') ? 'selected' : ''; ?>>Aktif</option>
                                            <option value="no" <?php echo ($editData['Statusactive'] == 'no') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info" name="edit_user">Change</button>
                                    <a href="?page=user" class="btn bg-lightblue">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>