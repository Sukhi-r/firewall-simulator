<?php
// include database connection
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Firewall Rule Manager</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 20px;
    }
    h2 {
      color: #cc3a00;
      text-align: center;
    }
    form {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 400px;
      margin: 20px auto;
    }
    form input, form select, form button {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    form button {
      background: #cc3a00;
      color: white;
      border: none;
      cursor: pointer;
      transition: 0.2s ease;
    }
    form button:hover {
      background: #b23300;
    }
    table {
      width: 80%;
      margin: 30px auto;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background: #cc3a00;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f6f6f6;
    }
    /* readable cells on light pages */
    td {
      color: #111;
    }
    .message {
      text-align: center;
      color: green;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <h2>🧱 Firewall Rule Manager</h2>

  <form method="POST">
    <select name="action" required>
      <option value="ALLOW">ALLOW</option>
      <option value="DENY">DENY</option>
    </select>
    <input type="text" name="protocol" placeholder="Protocol (TCP/UDP)" required>
    <input type="text" name="src_ip" placeholder="Source IP or ANY" required>
    <input type="text" name="dst_ip" placeholder="Destination IP or ANY" required>
    <input type="text" name="port" placeholder="Port or ANY" required>
    <button type="submit" name="add">Add Rule</button>
  </form>

<?php
// when form is submitted
if (isset($_POST['add'])) {
  $action   = $_POST['action'];
  $protocol = $_POST['protocol'];
  $src_ip   = $_POST['src_ip'];
  $dst_ip   = $_POST['dst_ip'];
  $port     = $_POST['port'];

  // insert into DB
  $sql = "INSERT INTO rules (action, protocol, src_ip, dst_ip, port)
          VALUES ('$action', '$protocol', '$src_ip', '$dst_ip', '$port')";

  if ($conn->query($sql) === TRUE) {
    echo "<p class='message'>✅ Rule added successfully!</p>";
  } else {
    echo "<p class='message' style='color:red;'>❌ Error adding rule: " . $conn->error . "</p>";
  }
}

// fetch all rules
$result = $conn->query("SELECT * FROM rules ORDER BY id DESC");

if ($result->num_rows > 0) {
  echo "<table><tr>
        <th>ID</th>
        <th>Action</th>
        <th>Protocol</th>
        <th>Source IP</th>
        <th>Destination IP</th>
        <th>Port</th>
      </tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['action']}</td>
            <td>{$row['protocol']}</td>
            <td>{$row['src_ip']}</td>
            <td>{$row['dst_ip']}</td>
            <td>{$row['port']}</td>
          </tr>";
  }
  echo "</table>";
} else {
  echo "<p style='text-align:center;'>No rules added yet.</p>";
}
?>
</body>
 <div class="topnav">
  <a href="index.php" class="home-btn">🏠 Home</a>
 </div>

</html>
