<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Packet Simulation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      
      margin: 0;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #cc3a00;
    }
    form {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 400px;
      margin: 20px auto;
    }
    

    input, button {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      background: #cc3a00;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background: #b23300;
    }
    .result {
      width: 400px;
      margin: 20px auto;
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      font-weight: bold;
    }
    .allow {
      background-color: #d4edda;
      color: #155724;
      border: 2px solid #c3e6cb;
    }
    .deny {
      background-color: #f8d7da;
      color: #721c24;
      border: 2px solid #f5c6cb;
    }
  </style>
</head>
<body>
  <h2>🛰️ Firewall Packet Simulator</h2>

  <form method="POST">
    <input type="text" name="protocol" placeholder="Protocol (TCP/UDP)" required>
    <input type="text" name="src_ip" placeholder="Source IP" required>
    <input type="text" name="dst_ip" placeholder="Destination IP" required>
    <input type="text" name="port" placeholder="Port" required>
    <button type="submit" name="simulate">Simulate Packet</button>

  </form>
  <div id="live-console" style="
    width: 80%; 
    margin: 30px auto; 
    background: rgba(0,0,0,0.7); 
    color: #00ff6a; 
    padding: 15px; 
    font-family: monospace;
    height: 200px;
    overflow-y: auto;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(255,69,0,0.5);">
    <strong>Live Simulation Log:</strong><br>
  </div>

  <!-- Visual simulation area (packet movement) -->
  <div id="simulation-container" class="simulation-box" style="display:none;">
    <div class="packet">📦</div>
    <div class="firewall">🧱</div>
    <div class="src-label"></div>
    <div class="dst-label"></div>
    <div class="result-text"></div>
  </div>


<?php
if (isset($_POST['simulate'])) {
  $protocol = strtoupper(trim($_POST['protocol']));
  $src_ip   = trim($_POST['src_ip']);
  $dst_ip   = trim($_POST['dst_ip']);
  $port     = trim($_POST['port']);
  $action   = "DENY";
  $matched_rule_id = "None";

  // fetch all rules from DB
  $rules = $conn->query("SELECT * FROM rules ORDER BY id ASC");

  while ($rule = $rules->fetch_assoc()) {
    if (
      ($rule['protocol'] == $protocol) &&
      ($rule['src_ip'] == "ANY" || $rule['src_ip'] == $src_ip) &&
      ($rule['dst_ip'] == "ANY" || $rule['dst_ip'] == $dst_ip) &&
      ($rule['port'] == "ANY" || $rule['port'] == $port)
    ) {
      $action = $rule['action'];
      $matched_rule_id = $rule['id'];
      break;
    }
  }

  // insert into logs table
  $conn->query("INSERT INTO logs (packet_protocol, packet_src_ip, packet_dst_ip, packet_port, action_taken, matched_rule_id)
                VALUES ('$protocol', '$src_ip', '$dst_ip', '$port', '$action', " . ($matched_rule_id === 'None' ? 'NULL' : "'$matched_rule_id'") . ")");

  // show result box
  $class = ($action == "ALLOW") ? "allow" : "deny";
  echo "<div class='result $class'>
          Packet: $protocol | $src_ip ➜ $dst_ip:$port<br>
          Result: <b>$action</b><br>
          Matched Rule: <b>$matched_rule_id</b>
        </div>";
  // call JS simulator with safe-encoded values (defer slightly so functions are defined)
  echo "<script>setTimeout(function(){ if (typeof simulatePackets === 'function') simulatePackets(" . json_encode($src_ip) . "," . json_encode($dst_ip) . "," . json_encode($port) . "," . json_encode($action) . "); else console.warn('simulatePackets not ready'); }, 150);</script>";

}
?>
<script>
function runSimulation(result, src, dst) {
  const simBox = document.getElementById('simulation-container');
  const resultText = document.querySelector('.result-text');
  const packet = document.querySelector('.packet');
  const firewall = document.querySelector('.firewall');

  // labels (create if not present)
  let srcLabel = document.querySelector('.src-label');
  let dstLabel = document.querySelector('.dst-label');
  if (!srcLabel) {
    srcLabel = document.createElement('div');
    srcLabel.className = 'src-label';
    simBox.insertBefore(srcLabel, simBox.firstChild);
  }
  if (!dstLabel) {
    dstLabel = document.createElement('div');
    dstLabel.className = 'dst-label';
    simBox.appendChild(dstLabel);
  }
  srcLabel.textContent = src;
  dstLabel.textContent = dst;

  // reset styles
  simBox.style.display = 'flex';
  resultText.textContent = '';
  resultText.className = 'result-text';
  firewall.classList.remove('blocked','allowed');
  packet.classList.remove('blocked');
  packet.style.animation = 'none';
  packet.style.transform = 'translateX(0)';
  void packet.offsetWidth;

  // move to firewall first
  packet.style.animation = 'moveToFirewall 1000ms linear forwards';

  setTimeout(() => {
    if (result === 'ALLOW') {
      // firewall allows — flash green and move through
      firewall.classList.add('allowed');
      packet.style.animation = 'moveThrough 900ms linear forwards';
      setTimeout(() => {
        resultText.textContent = '✅ ALLOWED';
        resultText.classList.add('allow-glow');
      }, 900);
    } else {
      // firewall blocks — shake packet and show denied
      firewall.classList.add('blocked');
      packet.classList.add('blocked');
      setTimeout(() => {
        resultText.textContent = '❌ DENIED';
        resultText.classList.add('deny-glow');
      }, 400);
    }
  }, 1000);
}
</script>
<script>
function simulatePackets(src, dst, port, result) {
  const consoleBox = document.getElementById('live-console');
  consoleBox.innerHTML += `<br>Packet from ${src} → ${dst}:${port} <br>Sending...`;
  let step = 0;
  const steps = [
    "Packet queued...",
    "Transmitting...",
    "Passing through firewall...",
    result === "ALLOW" ? "✅ Packet ALLOWED by rule" : "❌ Packet BLOCKED by rule"
  ];
  const interval = setInterval(() => {
    consoleBox.innerHTML += `<br>${steps[step]}`;
    consoleBox.scrollTop = consoleBox.scrollHeight;
    step++;
    if (step === steps.length) {
      clearInterval(interval);
      // after log steps finish, run the visual simulation
      setTimeout(() => {
        // ensure runSimulation exists, then call it
        if (typeof runSimulation === 'function') {
          runSimulation(result, src, dst);
        } else {
          consoleBox.innerHTML += `<br>Visual simulator not available.`;
        }
      }, 300);
    }
  }, 700);
}
</script>


</body>
  <div class="topnav">
   <a href="index.php" class="home-btn">🏠 Home</a>
  </div>
</html>
