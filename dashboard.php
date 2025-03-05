<?php
session_start();
include 'db.php'; // Ensure database connection is included

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not authenticated
    exit();
}

// Fetch user details (optional)
$user_id = $_SESSION['user_id'];
$query = "SELECT full_name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
</head>
<body>
  
        <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blinki Mining App</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #00b4d8;
      --secondary: #90e0ef;
      --accent: #ffd60a;
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
      color: white;
      text-align: center;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
    .screen {
      display: none;
      padding: 20px;
      animation: fadeIn 0.5s ease-out;
      max-width: 500px;
      width: 90%;
    }

    .screen.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .distribution-container {
      background: rgba(255, 255, 255, 0.2);
      padding: 15px;
      border-radius: 10px;
      max-width: 600px;
      margin: 20px auto;
      text-align: left;
    }
    .distribution-container h2 {
      text-align: center;
    }
    h1 {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
      text-shadow: 0 3px 10px rgba(0, 180, 216, 0.4);
    }

    .balance-container {
      background: linear-gradient(45deg, #1a2a6c,  #b21f1f);
      padding: 1.5rem;
      border-radius: 15px;
      margin: 2rem 0;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .faq {
      text-align: left;
      max-width: 600px;
      margin: 20px auto;
      background: rgba(255, 255, 255, 0.2);
      padding: 15px;
      border-radius: 10px;
    }
    .faq h2 {
      text-align: center;
    }
    #balance {
      font-size: 3rem;
      font-weight: 700;
      color: var(--accent);
      text-shadow: 0 0 20px rgba(255, 214, 10, 0.5);
    }

    button {
      background:  #ff8c00;
      border: none;
      padding: 1rem 2rem;
      color: white;
      font-weight: 600;
      border-radius: 50px;
      margin: 0.5rem;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
      max-width: 300px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      box-shadow: 0 4px 15px rgba(0, 180, 216, 0.3);
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 180, 216, 0.5);
      background: linear-gradient(45deg, var(--secondary), var(--primary));
    }

    button:active {
      transform: translateY(0);
    }

    .history-list {
      background:#1a2a6c
      padding: 1.5rem;
      border-radius: 15px;
      margin: 2rem 0;
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
    }

    .history-item {
      background: linear-gradient(45deg, rgba(0, 53, 102, 0.5), rgba(0, 29, 61, 0.5));
      padding: 1rem;
      margin: 1rem 0;
      border-radius: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      animation: slideIn 0.3s ease-out;
      border-left: 4px solid var(--primary);
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .history-icon {
      color:#fdbb2d
      font-size: 1.5rem;
    }

    #splash-screen {
      animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .nav-button {
      background: 0 4px 15px rgba(0, 180, 216, 0.3);
      padding: 0.8rem 1.5rem;
      border-radius: 10px;
      margin: 0.5rem;
      transition: all 0.3s ease;
    }

    .nav-button:hover {
      background: 0 4px 15px rgba(0, 180, 216, 0.3);
    }

    .mining-animation {
      font-size: 4rem;
      margin: 2rem 0;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div id="splash-screen" class="screen active">
    <div class="mining-animation">⛏️</div>
    <h1 style="font-size: 3em; text-shadow: 0 0 20px var(--primary)">BLINKI</h1>
    <p>Future millionaire Blinkies...</p>
  </div>

  <div id="home-screen" class="screen">
    <div class="balance-container">
      <p style="margin: 0">Total Balance</p>
      <div id="balance">0</div>
      <small>Blinki Coins</small>
    </div>
    
    <button onclick="startMining()">
      <span>🎥</span> Watch Ad to Mine (Earn 10 Blinki)
    </button>
    <button onclick="navigateTo('settings-screen')">
      <span>☰</span> Menu
    </button>
  </div>
</div>

<div id="referral-screen" class="screen">
  <h1>👥Invite & Earn</h1>
  <p>Your Referral Code: <strong id="referral-code"></strong></p>
  <p>Your Referral Link: <a id="referral-link" href="#" target="_blank"></a></p>
  <p>Friends Joined: <strong id="referral-count">0</strong></p>
  <p>Bonus Earned: <strong id="referral-bonus">0</strong> Blinki</p>
  <button onclick="copyReferralCode()">Copy Referral Link</button>
  <button onclick="navigateTo('settings-screen')">Back to Menu</button>
</div>



<div id="faq-screen" class="screen">
  <h1>Support & FAQs</h1>
  <div class="faq">
    <h2>How does mining work?</h2>
    <p>You watch an ad to mine Blinki tokens. Each ad gives you 10 Blinki.</p>
    <h2>How can I withdraw my Blinki?</h2>
    <p>Withdrawals are coming soon! Stay tuned for updates.</p>
    <h2>How do referrals work?</h2>
    <p>Share your referral code with friends. When they join, you earn bonus Blinki!</p>
  </div>
  <button onclick="navigateTo('settings-screen')">Back to Menu</button>
</div> <div id="wallet-screen" class="screen">
  <h1>Wallet</h1>
  <p>Total Mined: <strong id="total-mined">0</strong> Blinki</p>
  <button disabled>Withdraw (Coming Soon)</button>
  <button disabled>Convert to Crypto (Coming Soon)</button>
  <button onclick="navigateTo('settings-screen')">Back to Menu</button>
</div>
  
  <div id="settings-screen" class="screen">
    <h1>☰ Menu</h1>
    <button class="nav-button" onclick="navigateTo('history-screen')">
      📜 Mining History
      <button onclick="navigateTo('referral-screen')">👥invite & Earn</button>
<button onclick="navigateTo('wallet-screen')">👛Wallet</button>
    </button> <button onclick="navigateTo('faq-screen')">❓Support & FAQ</button>
    <button onclick="resetData()"> 🔄Reset Progress</button>
    <button onclick="navigateTo('token-distribution-screen')">💰 Token Distribution</button>
    <button class="nav-button" onclick="navigateTo('home-screen')">
      🏠 Back to Home
    </button>
  </div>
  <div id="token-distribution-screen" class="screen">
    <h1>💰 Token Distribution</h1>
    <div class="distribution-container">
      <h2>Total Supply: <span id="total-supply">1,000,000,000 BLINKI</span></h2>
      <p><strong>Total Distributed:</strong> <span id="distributed-coins">500,000,000 BLINKI</span></p>
      <p><strong>Mining Rewards:</strong> 70% of coins</p>
      <p><strong>Referral Rewards:</strong> 10% of coins</p>
      <p><strong>Team & Development:</strong> 5% of coins </p>
      <p><strong>Marketing & Partnerships:</strong> 10% of coins</p>
      <p><strong>Reserve & Future Development:</strong> 5% of coins</p>
      <p><strong>Note:</strong>500,000,000 Blinki will be distributed according to this rule</p>
      <p><strong>⚠️when limited users reached mining process will be closed and rewards will be distributed.</p>
    </div>
    <button onclick="navigateTo('settings-screen')">🔙 Back to Menu</button>
  </div>

  <div id="history-screen" class="screen">
    <h1>📜 Mining History</h1>
    <div id="mining-history" class="history-list"></div>
    <button class="nav-button" onclick="navigateTo('settings-screen')">
      🔙 Back to Menu
    </button>
  </div>

  <script>
    let balance = 0;
    let miningHistory = [];

    function navigateTo(screenId) {
      document.querySelectorAll('.screen').forEach(screen => screen.classList.remove('active'));
      document.getElementById(screenId).classList.add('active');
    }
    function generateReferralCode() {
  let code = 'BLINKI-' + Math.random().toString(36).substring(2, 10).toUpperCase();
  return code;
}

function setReferralCode() {
  let storedCode = localStorage.getItem("referralCode");
  if (!storedCode) {
    storedCode = generateReferralCode();
    localStorage.setItem("referralCode", storedCode);
  }
  document.getElementById("referral-code").innerText = storedCode;
  document.getElementById("referral-link").innerText = `https://blinki.com/ref?code=${storedCode}`;
  document.getElementById("referral-link").href = `https://blinki.com/ref?code=${storedCode}`;
}

function copyReferralCode() {
  let link = document.getElementById("referral-link").href;
  navigator.clipboard.writeText(link).then(() => {
    alert("Referral link copied: " + link);
  });
}

window.onload = setReferralCode;




function resetData() {
  balance = 0;
  document.getElementById("balance").innerText = balance;
  document.getElementById("total-mined").innerText = balance;
  alert("Progress reset!");
}

 

  function startMining() {
    // Load PopAds when mining starts
    var popScript = document.createElement("script");
    popScript.src = "//c1.popads.net/pop.js"; // Replace with your PopAds script URL
    document.body.appendChild(popScript);

    // Add temporary mining animation
    const miningAnim = document.createElement('div');
    miningAnim.className = 'mining-animation';
    miningAnim.textContent = '⛏️';
    document.body.appendChild(miningAnim);

    setTimeout(() => {
      balance += 10; // Add 10 Blinki
      localStorage.setItem("blinkiBalance", balance); // Save balance in localStorage

      miningHistory.push({ date: new Date().toLocaleString(), amount: 10 });

      updateBalanceDisplay(); // Update both home and wallet balance
      updateMiningHistory();
      document.body.removeChild(miningAnim);
    }, 3000);
  }

  function updateBalanceDisplay() {
    document.getElementById("balance").innerText = balance; // Update home screen
    document.getElementById("total-mined").innerText = balance; // Update wallet
  }

    function updateMiningHistory() {
      const historyElement = document.getElementById("mining-history");
      historyElement.innerHTML = "";
      miningHistory.reverse().forEach(entry => {
        const item = document.createElement("div");
        item.classList.add("history-item");
        item.innerHTML = `
          <div>
            <span class='history-icon'>⛏️</span>
            ${entry.date}
          </div>
          <div style="color: var(--accent)">+${entry.amount} BLINKI</div>
        `;
        historyElement.appendChild(item);
      });
    }

    setTimeout(() => { navigateTo('home-screen'); }, 3000);
  </script>
</body>
</html>
        </section>
    </main>
</body>
</html>