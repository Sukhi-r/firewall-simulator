<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Firewall Logs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #cc3a00;
    }
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
    td {
      color: #111;
    }
    .allow {
      color: green;
      font-weight: bold;
    }
    .deny {
      color: red;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <h2>📊 Firewall Simulation Logs</h2>

<?php
// Fetch all logs in reverse order (latest first)
$result = $conn->query("SELECT * FROM logs ORDER BY ts DESC");

if ($result->num_rows > 0) {
  echo "<table>
          <tr>
            <th>ID</th>
            <th>Protocol</th>
            <th>Source IP</th>
            <th>Destination IP</th>
            <th>Port</th>
            <th>Action Taken</th>
            <th>Matched Rule</th>
            <th>Timestamp</th>
          </tr>";

  while($row = $result->fetch_assoc()) {
    $class = ($row['action_taken'] == 'ALLOW') ? 'allow' : 'deny';
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['packet_protocol']}</td>
            <td>{$row['packet_src_ip']}</td>
            <td>{$row['packet_dst_ip']}</td>
            <td>{$row['packet_port']}</td>
            <td class='{$class}'>{$row['action_taken']}</td>
            <td>{$row['matched_rule_id']}</td>
            <td>{$row['ts']}</td>
          </tr>";
  }

  echo "</table>";
} else {
  echo "<p style='text-align:center;'>No logs found yet. Try simulating a few packets first.</p>";
}
?>
</body>
  <div class="topnav">
   <a href="index.php" class="home-btn">🏠 Home</a>
  </div>
</html>
