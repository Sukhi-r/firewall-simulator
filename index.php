<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Firewall Simulator Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #cc3a00;
      color: white;
      padding: 15px 0;
      text-align: center;
      font-size: 24px;
      font-weight: 700;
    }
    nav {
      text-align: center;
      background-color: #343a40;
      padding: 10px;
    }
    nav a {
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      margin: 0 5px;
      background: #495057;
      border-radius: 5px;
      transition: 0.3s;
    }
    nav a:hover {
      background: #cc3a00;
    }
    .content {
      padding: 40px;
      text-align: center;
      padding-bottom: 100px; /* reserve space for fixed footer */
    }
    .content h2 {
      color: #cc3a00;
    }
    .box-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 30px;
    }
    .box {
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 20px;
      width: 250px;
      transition: 0.3s;
    }
    .box:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .box h3 {
      color: #cc3a00;
      margin-bottom: 10px;
    }
    .box p {
      color: #555;
    }
    footer {
      text-align: center;
      background: #343a40;
      color: white;
      padding: 12px 10px;
      margin-top: 0;
      position: fixed;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 1000;
      box-shadow: 0 -2px 8px rgba(0,0,0,0.2);
    }
  </style>
</head>

<body>
  <header>🔥 Firewall Rule Simulator</header>

  <nav>
    <a href="rules.php">Rules</a>
    <a href="simulate.php">Simulate</a>
    <a href="logs.php">Logs</a>
  </nav>
  
  <div class="content">
    <h2>Welcome to Firewall Simulator</h2>
    <p>This web app simulates how a firewall filters packets based on custom rules.</p>

    <div class="box-container">
      <div class="box">
        <h3>➕ Add Rules</h3>
        <p>Create and view firewall rules (ALLOW/DENY).</p>
        <a href="rules.php">Open Rules Page →</a>
      </div>
      <div class="box">
        <h3>🛰️ Simulate Packets</h3>
        <p>Test packets and see if they're allowed or denied.</p>
        <a href="simulate.php">Open Simulator →</a>
      </div>
      <div class="box">
        <h3>📊 View Logs</h3>
        <p>See all past simulation results and actions taken.</p>
        <a href="logs.php">Open Logs Page →</a>
      </div>
    </div>
  </div>

  <footer>© <?php echo date('Y'); ?> Firewall Simulator Project | Built by Sukhi J</footer>
</body>
</html>
