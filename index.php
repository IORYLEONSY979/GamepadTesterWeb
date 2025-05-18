<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamepad Tester</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #fff;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #e94560;
            text-shadow: 0 0 10px rgba(233, 69, 96, 0.5);
        }
        
        .gamepad-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }
        
        .gamepad-visual {
            flex: 1;
            min-width: 300px;
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .gamepad-visual:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }
        
        .gamepad {
            width: 100%;
            height: auto;
        }
        
        .button {
            position: absolute;
            width: 30px;
            height: 30px;
            background: rgba(233, 69, 96, 0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            transition: all 0.2s;
            transform: scale(0.9);
        }
        
        .button.active {
            background: #e94560;
            transform: scale(1.1);
            box-shadow: 0 0 15px #e94560;
        }
        
        .info-panel {
            flex: 1;
            min-width: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        
        .info-item {
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .info-item:hover {
            background: rgba(233, 69, 96, 0.2);
        }
        
        .info-label {
            font-weight: bold;
            color: #e94560;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-family: monospace;
        }
        
        .no-gamepad {
            text-align: center;
            padding: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            margin-top: 20px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 0.7; }
            50% { opacity: 1; }
            100% { opacity: 0.7; }
        }
        
        .connection-status {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        
        .connected {
            background: rgba(46, 213, 115, 0.2);
            color: #2ed573;
        }
        
        .disconnected {
            background: rgba(255, 71, 87, 0.2);
            color: #ff4757;
        }
        
        .axes-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        
        .axis {
            flex: 1;
            min-width: 100px;
            background: rgba(0, 0, 0, 0.3);
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        
        .axis-value {
            height: 10px;
            background: #333;
            border-radius: 5px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .axis-fill {
            height: 100%;
            background: linear-gradient(90deg, #e94560, #ff7b00);
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gamepad Tester Web</h1>
        
        <div id="status" class="connection-status disconnected">
            No se detectó ningún gamepad. Presiona cualquier botón en tu gamepad para conectarlo.
        </div>
        
        <div class="gamepad-container">
            <div class="gamepad-visual">
                <svg class="gamepad" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg">
                    <rect x="50" y="30" width="300" height="140" rx="20" fill="#333" stroke="#555" stroke-width="2"/>
                    <circle id="btnA" cx="320" cy="100" r="15" fill="#444" stroke="#666" stroke-width="2"/>
                    <circle id="btnB" cx="350" cy="70" r="15" fill="#444" stroke="#666" stroke-width="2"/>
                    <circle id="btnX" cx="290" cy="70" r="15" fill="#444" stroke="#666" stroke-width="2"/>
                    <circle id="btnY" cx="320" cy="40" r="15" fill="#444" stroke="#666" stroke-width="2"/>
                    <rect id="dpadUp" x="70" y="50" width="30" height="20" rx="3" fill="#444" stroke="#666" stroke-width="2"/>
                    <rect id="dpadDown" x="70" y="90" width="30" height="20" rx="3" fill="#444" stroke="#666" stroke-width="2"/>
                    <rect id="dpadLeft" x="50" y="70" width="20" height="30" rx="3" fill="#444" stroke="#666" stroke-width="2"/>
                    <rect id="dpadRight" x="90" y="70" width="20" height="30" rx="3" fill="#444" stroke="#666" stroke-width="2"/>
                    <rect id="btnL1" x="60" y="20" width="50" height="10" rx="5" fill="#444" stroke="#666" stroke-width="2"/>
                    <rect id="btnR1" x="290" y="20" width="50" height="10" rx="5" fill="#444" stroke="#666" stroke-width="2"/>                    
                    <circle id="joystickLeft" cx="150" cy="100" r="25" fill="#444" stroke="#666" stroke-width="2"/>
                    <circle id="joystickRight" cx="250" cy="100" r="25" fill="#444" stroke="#666" stroke-width="2"/>
                    <circle id="btnStart" cx="220" cy="100" r="10" fill="#444" stroke="#666" stroke-width="2"/>
                    <circle id="btnSelect" cx="180" cy="100" r="10" fill="#444" stroke="#666" stroke-width="2"/>
                </svg>
                <div class="button" id="visBtnA" style="top: 85px; right: 80px;">A</div>
                <div class="button" id="visBtnB" style="top: 55px; right: 50px;">B</div>
                <div class="button" id="visBtnX" style="top: 55px; right: 110px;">X</div>
                <div class="button" id="visBtnY" style="top: 25px; right: 80px;">Y</div>   
                <div class="button" id="visDpadUp" style="top: 50px; left: 85px;">↑</div>
                <div class="button" id="visDpadDown" style="top: 90px; left: 85px;">↓</div>
                <div class="button" id="visDpadLeft" style="top: 70px; left: 65px;">←</div>
                <div class="button" id="visDpadRight" style="top: 70px; left: 105px;">→</div>
                
                <div class="button" id="visBtnL1" style="top: 25px; left: 85px;">L1</div>
                <div class="button" id="visBtnR1" style="top: 25px; right: 85px;">R1</div>
            </div>
            
            <div class="info-panel">
                <div class="info-item">
                    <div class="info-label">Gamepad conectado:</div>
                    <div class="info-value" id="gamepad-id">Ninguno</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Último botón presionado:</div>
                    <div class="info-value" id="last-button">Ninguno</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Estado de botones:</div>
                    <div class="info-value" id="buttons-state">Presiona botones para ver el estado</div>
                </div>
                
                <div class="axes-container">
                    <div class="axis">
                        <div>Eje X Izquierdo</div>
                        <div class="axis-value">
                            <div class="axis-fill" id="axisLX"></div>
                        </div>
                        <div id="axisLX-value">0.00</div>
                    </div>
                    
                    <div class="axis">
                        <div>Eje Y Izquierdo</div>
                        <div class="axis-value">
                            <div class="axis-fill" id="axisLY"></div>
                        </div>
                        <div id="axisLY-value">0.00</div>
                    </div>
                    
                    <div class="axis">
                        <div>Eje X Derecho</div>
                        <div class="axis-value">
                            <div class="axis-fill" id="axisRX"></div>
                        </div>
                        <div id="axisRX-value">0.00</div>
                    </div>
                    
                    <div class="axis">
                        <div>Eje Y Derecho</div>
                        <div class="axis-value">
                            <div class="axis-fill" id="axisRY"></div>
                        </div>
                        <div id="axisRY-value">0.00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let gamepadIndex = null;
        let animationFrameId = null;
        
        const buttonNames = [
            "A", "B", "X", "Y", 
            "L1", "R1", "L2", "R2",
            "Select", "Start",
            "Left Stick", "Right Stick",
            "D-Pad Up", "D-Pad Down",
            "D-Pad Left", "D-Pad Right"
        ];
        
        const buttonVisuals = {
            "A": "visBtnA",
            "B": "visBtnB",
            "X": "visBtnX",
            "Y": "visBtnY",
            "L1": "visBtnL1",
            "R1": "visBtnR1",
            "D-Pad Up": "visDpadUp",
            "D-Pad Down": "visDpadDown",
            "D-Pad Left": "visDpadLeft",
            "D-Pad Right": "visDpadRight"
        };
        
        function connectHandler(e) {
            gamepadIndex = e.gamepad.index;
            updateStatus(true);
            updateGamepadInfo();
            if (!animationFrameId) {
                animationFrameId = requestAnimationFrame(updateGamepad);
            }
        }
        
        function disconnectHandler(e) {
            if (e.gamepad.index === gamepadIndex) {
                gamepadIndex = null;
                updateStatus(false);
                cancelAnimationFrame(animationFrameId);
                animationFrameId = null;
            }
        }
        
        function updateStatus(connected) {
            const statusElement = document.getElementById('status');
            if (connected) {
                statusElement.textContent = `Gamepad conectado: ${navigator.getGamepads()[gamepadIndex].id}`;
                statusElement.className = 'connection-status connected';
            } else {
                statusElement.textContent = 'Gamepad desconectado. Presiona cualquier botón para reconectar.';
                statusElement.className = 'connection-status disconnected';
                document.getElementById('gamepad-id').textContent = 'Ninguno';
                document.getElementById('last-button').textContent = 'Ninguno';
                document.getElementById('buttons-state').textContent = 'Presiona botones para ver el estado';
      
                Object.values(buttonVisuals).forEach(id => {
                    document.getElementById(id).classList.remove('active');
                });
                
                ['LX', 'LY', 'RX', 'RY'].forEach(axis => {
                    document.getElementById(`axis${axis}`).style.width = '50%';
                    document.getElementById(`axis${axis}-value`).textContent = '0.00';
                });
            }
        }
        
        function updateGamepadInfo() {
            const gamepad = navigator.getGamepads()[gamepadIndex];
            if (!gamepad) return;
            
            document.getElementById('gamepad-id').textContent = gamepad.id;
            
            let lastPressed = 'Ninguno';
            let buttonsState = '';
            
            gamepad.buttons.forEach((button, index) => {
                if (button.pressed) {
                    const buttonName = buttonNames[index] || `Botón ${index}`;
                    lastPressed = buttonName;
                    
                    if (buttonVisuals[buttonName]) {
                        document.getElementById(buttonVisuals[buttonName]).classList.add('active');
                    }
                } else {
                    const buttonName = buttonNames[index];
                    if (buttonName && buttonVisuals[buttonName]) {
                        document.getElementById(buttonVisuals[buttonName]).classList.remove('active');
                    }
                }
                
                buttonsState += `${buttonNames[index] || `Botón ${index}`}: ${button.pressed ? 'PRESIONADO' : 'libre'}<br>`;
            });
            
            document.getElementById('last-button').textContent = lastPressed;
            document.getElementById('buttons-state').innerHTML = buttonsState;
            
            updateAxis('LX', gamepad.axes[0]);
            updateAxis('LY', gamepad.axes[1]);
            updateAxis('RX', gamepad.axes[2]);
            updateAxis('RY', gamepad.axes[3]);
        }
        
        function updateAxis(axis, value) {
            const percentage = ((value + 1) / 2) * 100;
            document.getElementById(`axis${axis}`).style.width = `${percentage}%`;
            document.getElementById(`axis${axis}-value`).textContent = value.toFixed(2);
            
            if (axis === 'LX' || axis === 'LY') {
                const joystick = document.getElementById('joystickLeft');
                const x = axis === 'LX' ? value * 15 : 0;
                const y = axis === 'LY' ? value * 15 : 0;
                joystick.setAttribute('transform', `translate(${x}, ${y})`);
            }
            
            if (axis === 'RX' || axis === 'RY') {
                const joystick = document.getElementById('joystickRight');
                const x = axis === 'RX' ? value * 15 : 0;
                const y = axis === 'RY' ? value * 15 : 0;
                joystick.setAttribute('transform', `translate(${x}, ${y})`);
            }
        }
        
        function updateGamepad() {
            if (gamepadIndex !== null) {
                updateGamepadInfo();
            }
            animationFrameId = requestAnimationFrame(updateGamepad);
        }
        
        function scanGamepads() {
            const gamepads = navigator.getGamepads();
            for (let i = 0; i < gamepads.length; i++) {
                if (gamepads[i] && gamepads[i].connected) {
                    gamepadIndex = i;
                    updateStatus(true);
                    if (!animationFrameId) {
                        animationFrameId = requestAnimationFrame(updateGamepad);
                    }
                    break;
                }
            }
        }
        
        window.addEventListener('gamepadconnected', connectHandler);
        window.addEventListener('gamepaddisconnected', disconnectHandler);
        
        setInterval(scanGamepads, 1000);
    </script>
</body>
</html>