🔥 Firewall Rule Simulator
  A web-based Firewall Simulator built from scratch using PHP, HTML, CSS, and MySQL.
  It’s designed to help visualize how packet-filtering firewalls work and how rule changes affect network traffic.

🚀 Features
  Add, Edit, and Manage Rules:
  Supports creating, updating, and viewing firewall rules (ALLOW / DENY) from the browser.

  Real-Time Packet Simulation:
  Simulate how packets move through your firewall rules, shown in a live terminal-style console (inspired by NS2 trace files).

  Live Activity Logging:
  All packet actions (allowed/blocked) are instantly logged, complete with timestamps—data is persisted in a MySQL database.

  Modern Cyber-Themed Interface:
  UI features a bold red/orange color scheme, with terminal-style animations for packet tracing.

🗂️ Project Structure

  frontend/   # HTML/CSS/JS for UI, rule tables, simulation console
  backend/    # PHP for rule management, simulation, and DB operations
  database/   # MySQL: rules table, logs table
  assets/     # Icons, images, theme files

Why I Built This
  I wanted to understand firewalls in a hands-on way and create a tool for experimenting with packet filtering rules visually. This project helped me learn about networking fundamentals, database logging, and real-world interface design.

firewall-simulator/
│
├── index.php # Dashboard
├── rules.php # Add/View Rules
├── simulate.php # Packet Simulation
├── logs.php # View Logs
├── db_connect.php # Database connection
├── style.css # Styling
└── firewall.jpeg # Background image


---

## ⚙️ How to Run Locally
1. Install [XAMPP](https://www.apachefriends.org/)
2. Place the folder in:  
   `C:\xampp\htdocs\firewall-simulator`
3. Start **Apache** and **MySQL**
4. Create a database `firewall_db` in phpMyAdmin
5. Create tables:
   ```sql
   CREATE TABLE rules (
     id INT AUTO_INCREMENT PRIMARY KEY,
     action VARCHAR(10),
     protocol VARCHAR(10),
     src_ip VARCHAR(30),
     dst_ip VARCHAR(30),
     port VARCHAR(10)
   );

   CREATE TABLE logs (
     id INT AUTO_INCREMENT PRIMARY KEY,
     packet_protocol VARCHAR(10),
     packet_src_ip VARCHAR(30),
     packet_dst_ip VARCHAR(30),
     packet_port VARCHAR(10),
     action_taken VARCHAR(10),
     matched_rule_id INT,
     ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
