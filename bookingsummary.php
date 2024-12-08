<?php
session_start();
error_reporting(0);
include('includes/config.php');
?> 
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">     
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FritzAnn Shuttle Services </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
</head>
<style>
body {
  background-color: #111111;
}

.board {
  position: absolute;
  top: 50%;
  left: 50%;
  height: 150px;
  width: 500px;
  margin: -75px 0 0 -250px;
  padding: 20px;
  font: 75px/75px "Monoton", cursive;
  text-align: center;
  text-transform: uppercase;
  text-shadow: 
    0 0 80px red, 
    0 0 30px FireBrick, 
    0 0 6px DarkRed;
  color: red;
}

#error {
  color: #fff;
  text-shadow: 
    0 0 80px #ffffff, 
    0 0 30px #008000, 
    0 0 6px #0000ff;
}

#customPopupBox {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 400px;
  height: 200px;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  display: none;
}


  #customHeaderBar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #f44336; 
    color: #fff;
    border-radius: 8px 8px 0 0;
  }

  #customAlertTitle {
    font-size: 16px;
    font-weight: bold;
  }

  #customExitWindow button {
    background: none;
    border: none;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
  }

  #customExitWindow button:hover {
    color: #ffdddd;
  }

  #customMessageContent {
    padding: 20px;
    text-align: center;
  }

  #customAlertSymbol img {
    width: 60px;
    height: 60px;
    margin-bottom: 10px;
  }

  #customAlertMessage p {
    font-size: 14px;
    color: #333;
    margin: 0;
  }

  #customCloseButtonContainer {
    margin-top: 20px;
  }

  #customVerifyButton {
    background-color: #f44336; /* Red button */
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    font-size: 14px;
    cursor: pointer;
  }

  #customVerifyButton:hover {
    background-color: #c62828; 
  }


  :root {
  --bg: #11111b;
  --red: #ff6778;
  --green: #ff6778; /* Set green-related references to red */
  --blue: #1122ff;
  --text: var(--red); /* Change the text color to red */
  --dot-grid-size: 22px;
  --dot-grid-dot-size: 1px;
}

@keyframes scan {
  0%, 20%, 100% {
    height: 0;
    transform: translate(-50%, 0.44em);
  }
  10%, 15% {
    height: 1em;
    line-height: 0.2em;
    transform: translate(-55%, 0.3em);
  }
}

@keyframes pulse {
  from {
    text-shadow: 0 0 0 var(--text), 0 0 0 rgba(var(--text), 0.3), 0 0 0 rgba(var(--text), 0.3);
  }
  to {
    text-shadow: 0 0 0.07em var(--text), -0.2em 0 2em rgba(var(--text), 0.3), 0.2em 0 2em rgba(var(--text), 0.3);
  }
}

@keyframes attn {
  0%, 100% {
    opacity: 1;
  }
  30%, 35% {
    opacity: 0.4;
  }
}

@keyframes shake {
  0%, 100% {
    transform: translate(-1px, 0);
  }
  10% {
    transform: translate(2px, 1px);
  }
  30% {
    transform: translate(-3px, 2px);
  }
  35% {
    transform: translate(2px, -3px);
    filter: blur(4px);
  }
  45% {
    transform: translate(2px, 2px) skewY(-8deg) scale(0.96, 1);
    filter: blur(0);
  }
  50% {
    transform: translate(-3px, 1px);
  }
}

html, body {
  width: 100%;
  height: 100%;
  background-color: var(--bg);
  color: var(--text);
  font-size: 16px; /* Replace dynamic font function with a standard font size */
}

.error-body {
  position: relative;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.error-body:before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: var(--text);
  mix-blend-mode: overlay;
  z-index: 1;
}

.error-body:after {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, var(--bg) calc(var(--dot-grid-size) - var(--dot-grid-dot-size)), transparent 1%) center, linear-gradient(var(--bg) calc(var(--dot-grid-size) - var(--dot-grid-dot-size)), transparent 1%) center, var(--red);
  background-size: var(--dot-grid-size) var(--dot-grid-size);
  opacity: 0.2;
  z-index: 1;
}

.error-body .background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  filter: grayscale(1);
  mix-blend-mode: luminosity;
}

.error-body .message {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  z-index: 3;
}

.error-body .message h1 {
  position: absolute;
  top: 10%;
  left: 0%;
  width: 100%;
  font-size: 10em;
  margin: 0;
  animation: shake 600ms ease-in-out infinite alternate;
  text-shadow: 0 0 0.07em var(--text), -0.2em 0 2em rgba(var(--text), 0.3), 0.2em 0 2em rgba(var(--text), 0.3);
  user-select: none;
}

.error-body .message .bottom {
  position: absolute;
  top: 65%;
  left: 0;
  width: 100%;
}

.error-body .message p, .error-body .message a {
  font-size: 2em;
  font-family: monospace;
  text-shadow: 0 0 5px var(--text);
  filter: blur(0.8px);
}

.error-body .message a {
  position: relative;
  color: var(--text);
  text-decoration: none;
  font-weight: 700;
  border: 2px solid var(--text);
  text-transform: uppercase;
  padding: 5px 30px;
  box-shadow: inset 0 0 0 0 rgba(var(--text), 0.2);
  transition: 25ms ease-in-out all 0ms;
  animation: attn 3s ease-in-out infinite;
}

.error-body .message a:hover {
  cursor: crosshair;
  box-shadow: inset 0 -2em 0 0 rgba(var(--text), 0.2);
}

.error-body .message a:active {
  box-shadow: inset 0 -2em 0 0 rgba(var(--text), 0.5);
}

    </style>
<body>
<section class="error-body">
	<video preload="auto" class="background" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/396624/err.mp4" autoplay muted loop></video>
	<div class="message">
		<h1 t="404">404</h1>
		<div class="bottom">
			<p>You have lost your way</p>
		</div>
	</div>
</section>


<div id="customPopupBox">
  <div id="customHeaderBar">
    <div id="customAlertTitle">Fatal Error</div>
    <div id="customExitWindow">
      <button id="customExitWindowButton">✖</button>
    </div>
  </div>
  
  <div id="customMessageContent">
    <div id="customAlertSymbol">
      <img id="customAlertSymbolImage" src="https://cdn2.scratch.mit.edu/get_image/user/2379494_90x90.png" alt="Error Symbol">
    </div>
    <div id="customAlertMessage">
      <p id="customAlertMessageText">USER PLEASE VERIFY YOUR ACCOUNT.</p>
    </div>
    <div id="customCloseButtonContainer">
      <button id="customVerifyButton">Verify</button>
    </div>
  </div>
</div>






<script>
  
  document.getElementById('customExitWindowButton').onclick = function() {
    document.getElementById('customPopupBox').style.display = 'none';
  };

  document.getElementById('customVerifyButton').onclick = function() {
    window.location.href = 'profile.php'; 
  };

  
  function showPopup() {
    document.getElementById('customPopupBox').style.display = 'block';
  }


  setInterval(showPopup, 2000);
</script>
  </body> 
  </html>