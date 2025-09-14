@extends('layouts.header')

@section('customcss')
    <style>
        #raceCanvas {
            background: linear-gradient(#020202, #070707);
            border: 1px solid #222;
            display: block;
            width: 100%;
            height: 600px;
        }

        .list-group-item {
            background: transparent;
            border-color: #222;
            color: #fff;
        }

        .list-group-item.bg-light {
            background: rgba(255, 255, 255, 0.03) !important;
            color: #fff !important;
        }

        .controls-row>* {
            margin-right: 8px;
        }

        .btn.active {
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.03) inset;
        }

        /* New styles for improved layout */

        .session-info-card {
            background: rgba(40, 40, 40, 0.6);
            color: white;
            border-radius: 6px;
            padding: 10px 15px;
            margin: 0 10px;
            min-width: 120px;
            text-align: center;
        }

        .info-label {
            font-size: 0.8rem;
            color: #aaa;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .control-section {
            margin-bottom: 15px;
        }

        .position-cell {
            font-weight: bold;
            text-align: center;
        }

        .my-team-driver {
            border-left: 3px solid #ffc107;
            padding-left: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-flag-checkered me-2"></i>F1 Race Simulator
                </a>
                <div class="navbar-text">
                    {{ $schedule->name ?? 'Race Session' }}
                </div>
            </div>
        </nav>

        @if ($schedule->raceResults->isEmpty())
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="control-section-title">
                                <i class="ri-gamepad-line me-2"></i>Driver Controls (My Team Only)
                            </h6>
                            <div id="driverControls" class="mb-3"></div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="control-section-title">
                                <i class="ri-trophy-line me-1"></i>Leaderboard
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="leaderboard" class="list-group small"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="controls-row d-flex align-items-center mb-4">
                        <div class="control-section">
                            <h5>Simulation Controls</h5>
                            <hr>
                            <div class="d-flex align-items-center">
                                <button id="startBtn" class="btn btn-success">
                                    <i class="ri-play-circle-line"></i>
                                </button>
                                <button id="pauseBtn" class="btn btn-secondary ms-2" disabled>
                                    <i class="ri-pause-circle-line"></i>
                                </button>

                                <div class="btn-group ms-3" role="group" aria-label="speed">
                                    <button id="speed1" type="button" class="btn btn-outline-light active">
                                        <i class="ri-walk-fill me-1"></i> 1x
                                    </button>
                                    <button id="speed2" type="button" class="btn btn-outline-light">
                                        <i class="ri-run-fill me-1"></i> 2x
                                    </button>
                                    <button id="speed3" type="button" class="btn btn-outline-light">
                                        <i class="ri-flashlight-fill me-1"></i> 3x
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex ms-auto">
                            <div class="session-info-card">
                                <div class="info-label">Sector</div>
                                <div id="sectorInfo" class="info-value">1 / 3</div>
                            </div>
                            <div class="session-info-card">
                                <div class="info-label">Lap</div>
                                <div id="lapInfo" class="info-value">0 / {{ $lapsTotal }}</div>
                            </div>
                            <div class="session-info-card">
                                <div class="info-label">Race Time</div>
                                <div id="raceClock" class="info-value">00:00.000</div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <canvas id="raceCanvas" style="border-radius: 15px;"></canvas>
                    </div>
                </div>
            </div>
        @else
            <div class="race-container">

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2">POS</th>
                                <th class="text-center" rowspan="2">DRIVER</th>
                                <th class="text-center" rowspan="2">TEAM</th>
                                <th class="text-center" rowspan="2">LAPS</th>
                                <th class="text-center" rowspan="2">TOTAL TIME</th>
                                <th class="text-center" rowspan="2">BEST LAP</th>
                                <th class="text-center" rowspan="2">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($raceResults as $idx => $d)
                                <tr>
                                    <td>
                                        {{ $d['dnf'] ? '-' : $idx + 1 }}
                                    </td>
                                    <td nowrap>

                                        <i class="ri-circle-fill" style="color:{{ $d['team_color'] }};"></i>
                                        <strong>{{ $d['driver'] }}</strong> ({{ $d['code'] }})
                                    </td>
                                    <td>{{ $d['team'] }}</td>
                                    <td class="text-center">{{ $d['laps'] }}</td>
                                    <td class="text-end">{{ $d['total_time'] ? number_format($d['total_time'], 3) . 's' : '--' }}
                                    </td>
                                    <td class="text-end">{{ $d['best_lap'] ? number_format($d['best_lap'], 3) . 's' : '--' }}</td>
                                    <td class="text-center">
                                        @if($d['dnf'])
                                            <span class="badge bg-danger">DNF</span>
                                        @else
                                            <span class="badge bg-success">Finished</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('customjs')
    @if ($schedule->raceResults->isEmpty())
        <script>
            // === CONFIG ===
            const lapsTotal = {{ $lapsTotal }};
            const scheduleId = {{ $schedule->id }};
            const baseLapBySpeed = { 1: 6.0, 2: 4.0, 3: 2.0 };
            let currentSpeedKey = '1';
            let isRunning = false;
            let raceResults = [];

            // === DRIVER DATA ===
            const rawDrivers = @json($drivers);
            const myTeamId = {!! json_encode($team->id ?? 0) !!}; // Get user's team ID

            let drivers = rawDrivers.map((d, idx) => ({
                driver: d.driver ?? d.name ?? `Driver ${idx + 1}`,
                driver_id: d.driver_id ?? d.id ?? idx + 1,
                team_id: d.team_id ?? 0,
                color: d.color ?? `hsl(${(idx * 73) % 360} 70% 50%)`,
                pace: (typeof d.pace === 'number') ? d.pace : (d.pace ? Number(d.pace) || 1 : 1),
                isMyTeam: (d.team_id == myTeamId),
                code: d.code || d.driver.substring(0, 3).toUpperCase(),

                lapsCompleted: 0,
                currentLapProgress: 0,
                totalTime: 0,
                lastLapTime: 0,
                bestLapTime: null,
                currentSector: 1,
                sectorTimes: [],
                _sectorElapsed: 0,
                _currentLapTarget: null,
                _currentLapElapsed: 0,
                dnf: false,
                strategy: d.strategy ?? 'normal'
            }));

            // === DOM ===
            const lapInfo = document.getElementById('lapInfo');
            const sectorInfo = document.getElementById('sectorInfo');
            const raceClock = document.getElementById('raceClock');
            const pauseBtn = document.getElementById('pauseBtn');
            const startBtn = document.getElementById('startBtn');
            const speedBtn1 = document.getElementById('speed1');
            const speedBtn2 = document.getElementById('speed2');
            const speedBtn3 = document.getElementById('speed3');
            const driverControls = document.getElementById('driverControls');
            const leaderboard = document.getElementById('leaderboard');

            // === CANVAS SETUP ===
            const canvas = document.getElementById('raceCanvas');
            const ctx = canvas.getContext('2d');

            // Konfigurasi sirkuit lingkaran
            const trackPadding = 40;
            let centerX, centerY, trackRadius;

            function resizeCanvas() {
                try {
                    const DPR = window.devicePixelRatio || 1;
                    const rect = canvas.getBoundingClientRect();
                    let cssW = Math.floor(rect.width) || 1000;
                    let cssH = Math.floor(rect.height) || 600;
                    cssW = Math.max(300, cssW);
                    cssH = Math.max(200, cssH);

                    canvas.style.width = cssW + 'px';
                    canvas.style.height = cssH + 'px';
                    canvas.width = Math.floor(cssW * DPR);
                    canvas.height = Math.floor(cssH * DPR);
                    ctx.setTransform(DPR, 0, 0, DPR, 0, 0);

                    // Pusat dan radius sirkuit
                    centerX = cssW / 2;
                    centerY = cssH / 2;
                    trackRadius = Math.min(cssW, cssH) / 2 - trackPadding;

                    // Redraw after resize
                    drawCanvasDrivers();
                } catch (err) {
                    console.warn('resizeCanvas failed', err);
                }
            }

            function drawCircuit() {
                try {
                    // Gambar latar belakang (rumput)
                    ctx.fillStyle = '#2a6d30';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    // Gambar trek (aspal)
                    ctx.beginPath();
                    ctx.arc(centerX, centerY, trackRadius, 0, Math.PI * 2);
                    ctx.fillStyle = '#444';
                    ctx.fill();

                    // Gambar garis tepi trek
                    ctx.beginPath();
                    ctx.arc(centerX, centerY, trackRadius, 0, Math.PI * 2);
                    ctx.strokeStyle = '#fff';
                    ctx.lineWidth = 4;
                    ctx.stroke();

                    // Gambar garis start/finish (garis putih)
                    const startAngle = -Math.PI / 2; // Start/finish di atas (12 jam)
                    const startX = centerX + trackRadius * Math.cos(startAngle);
                    const startY = centerY + trackRadius * Math.sin(startAngle);
                    const startXInner = centerX + (trackRadius - 15) * Math.cos(startAngle);
                    const startYInner = centerY + (trackRadius - 15) * Math.sin(startAngle);

                    ctx.beginPath();
                    ctx.moveTo(startX, startY);
                    ctx.lineTo(startXInner, startYInner);
                    ctx.strokeStyle = '#fff';
                    ctx.lineWidth = 3;
                    ctx.stroke();

                    // Gambar garis pembatas sektor (120° dan 240° dari start)
                    for (let i = 1; i <= 2; i++) {
                        const angle = startAngle + (i * 120) * Math.PI / 180;
                        const sectorX = centerX + trackRadius * Math.cos(angle);
                        const sectorY = centerY + trackRadius * Math.sin(angle);
                        const sectorXInner = centerX + (trackRadius - 15) * Math.cos(angle);
                        const sectorYInner = centerY + (trackRadius - 15) * Math.sin(angle);

                        ctx.beginPath();
                        ctx.moveTo(sectorX, sectorY);
                        ctx.lineTo(sectorXInner, sectorYInner);
                        ctx.strokeStyle = '#ff0000';
                        ctx.lineWidth = 2;
                        ctx.setLineDash([5, 5]); // Garis putus-putus
                        ctx.stroke();
                        ctx.setLineDash([]);
                    }

                    // Tandai sektor
                    ctx.fillStyle = '#fff';
                    ctx.font = '12px Arial';
                    ctx.textAlign = 'center';

                    for (let i = 0; i < 3; i++) {
                        const angle = startAngle + ((i * 120) + 60) * Math.PI / 180;
                        const labelX = centerX + (trackRadius + 30) * Math.cos(angle);
                        const labelY = centerY + (trackRadius + 30) * Math.sin(angle);

                        ctx.fillText(`Sector ${i + 1}`, labelX, labelY);
                    }

                } catch (err) {
                    console.error('drawCircuit error', err);
                }
            }

            function drawCanvasDrivers() {
                try {
                    // Gambar sirkuit terlebih dahulu
                    drawCircuit();

                    // Gambar header info
                    ctx.fillStyle = '#fff';
                    ctx.font = '13px Inter, Arial';
                    ctx.textAlign = 'left';
                    ctx.fillText(`Lap: ${lapInfo ? lapInfo.textContent : '0 / ' + lapsTotal}`, 8, 18);
                    ctx.fillText(`Sector: ${sectorInfo ? sectorInfo.textContent : '1 / 3'}`, 180, 18);
                    ctx.fillText(`Time: ${raceClock ? raceClock.textContent : '00:00.000'}`, 320, 18);

                    // Gambar setiap pembalap di posisinya di sirkuit
                    drivers.forEach((d, i) => {
                        if (d.dnf && d.lapsCompleted >= lapsTotal) return;

                        // Hitung posisi pembalap di sirkuit berdasarkan progress
                        // 1 putaran lingkaran = 1 lap
                        const angle = -Math.PI / 2 + (d.currentLapProgress * 2 * Math.PI);

                        // Hitung posisi X dan Y
                        const carRadius = trackRadius - 15; // Mobil di dalam trek
                        const x = centerX + carRadius * Math.cos(angle);
                        const y = centerY + carRadius * Math.sin(angle);

                        // Gambar mobil pembalap
                        drawCar(x, y, angle + Math.PI / 2, d.color, d.isMyTeam, d.driver, d.code);
                    });
                } catch (err) {
                    console.error('drawCanvasDrivers error', err);
                }
            }

            function drawCar(x, y, angle, color, isMyTeam, driverName, code) {
                try {
                    ctx.save();
                    ctx.translate(x, y);
                    ctx.rotate(angle);

                    // Body mobil
                    ctx.fillStyle = color;
                    ctx.fillRect(-8, -5, 16, 10);

                    // Kabin mobil
                    ctx.fillStyle = '#222';
                    ctx.fillRect(-2, -7, 8, 4);

                    // Tampilkan kode pembalap
                    ctx.fillStyle = '#fff';
                    ctx.font = 'bold 9px Arial';
                    ctx.textAlign = 'center';
                    ctx.fillText(code, 0, 3);

                    // Highlight untuk mobil tim sendiri
                    if (isMyTeam) {
                        ctx.strokeStyle = '#ffc107';
                        ctx.lineWidth = 2;
                        ctx.strokeRect(-8, -5, 16, 10);
                    }

                    ctx.restore();

                    // Tampilkan info pembalap di samping mobil
                    ctx.fillStyle = '#fff';
                    ctx.font = '10px Arial';
                    ctx.textAlign = 'left';
                    ctx.fillText(`${driverName}`, x + 12, y + 4);
                } catch (err) {
                    console.error('drawCar error', err);
                }
            }

            // === UTILS ===
            function secToClock(t) {
                if (typeof t !== 'number' || isNaN(t)) return '00:00.000';
                const ms = Math.floor((t - Math.floor(t)) * 1000);
                const s = Math.floor(t % 60);
                const m = Math.floor((t / 60) % 60);
                return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}.${ms.toString().padStart(3, '0')}`;
            }

            function expectedLapSeconds(driver) {
                let base = baseLapBySpeed[currentSpeedKey] * (1 / driver.pace);

                // Apply strategy modifiers
                if (driver.strategy === 'aggressive') base *= 0.96; // 4% faster but higher risk
                if (driver.strategy === 'slowdown') base *= 1.04; // 4% slower but more consistent

                return base;
            }

            function escapeHtml(s) {
                if (s === null || s === undefined) return '';
                return String(s).replace(/[&<>"']/g, c => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                })[c]);
            }

            // === DRIVER CONTROLS ===
            function renderDriverControls() {
                if (!driverControls) return;
                driverControls.innerHTML = '';

                // Only show controls for my team drivers
                const myTeamDrivers = drivers.filter(d => d.isMyTeam);

                if (myTeamDrivers.length === 0) {
                    driverControls.innerHTML = '<div class="text-muted">No drivers from your team in this session</div>';
                    return;
                }

                myTeamDrivers.forEach((d, idx) => {
                    const row = document.createElement('div');
                    row.className = 'd-flex align-items-center justify-content-between mb-2 my-team-driver';

                    const left = document.createElement('div');
                    left.innerHTML = `<strong style="color:${d.color}">${escapeHtml(d.driver)}</strong>`;
                    row.appendChild(left);

                    const sel = document.createElement('select');
                    sel.className = 'form-select form-select-sm';
                    sel.style.width = '160px';
                    ['aggressive', 'normal', 'slowdown'].forEach(mode => {
                        const opt = document.createElement('option');
                        opt.value = mode;
                        opt.textContent = mode.charAt(0).toUpperCase() + mode.slice(1);
                        if (mode === d.strategy) opt.selected = true;
                        sel.appendChild(opt);
                    });
                    sel.addEventListener('change', (e) => {
                        d.strategy = e.target.value;
                    });
                    row.appendChild(sel);
                    driverControls.appendChild(row);
                });
            }

            // === EVENT GENERATOR ===
            function simulateEvents(driver, lap, sector) {
                let penalty = 0;
                let msg = null;

                // Adjust mistake probability based on strategy
                const baseMistake = driver.strategy === 'aggressive' ? 0.03 :
                    driver.strategy === 'slowdown' ? 0.005 : 0.015;

                // Random lock-up / mistake
                if (Math.random() < baseMistake) {
                    penalty += 1.0 + Math.random() * 1.0;
                    msg = `Lap ${lap} Sector ${sector}: ${driver.driver} lock-up! +${penalty.toFixed(1)}s`;
                }

                // Mechanical failure (small chance)
                if (!driver.dnf && Math.random() < 0.002) {
                    driver.dnf = true;
                    msg = `Lap ${lap}: ${driver.driver} DNF due to mechanical failure!`;
                }

                return { penalty, msg };
            }

            // === UI UPDATE ===
            function updateUI() {
                const maxLapFinished = Math.max(...drivers.map(d => d.lapsCompleted));
                if (lapInfo) lapInfo.textContent = `${Math.min(lapsTotal, maxLapFinished + (isRunning ? 1 : 0))} / ${lapsTotal}`;

                // Find current sector for the leader
                const activeDrivers = drivers.filter(d => !d.dnf && d.lapsCompleted < lapsTotal);
                const currentSector = activeDrivers.length > 0 ? activeDrivers[0].currentSector : 1;
                if (sectorInfo) sectorInfo.textContent = `${currentSector} / 3`;

                if (raceClock) raceClock.textContent = secToClock(raceElapsed);

                const ranking = drivers.slice().sort((a, b) => {
                    if (a.dnf !== b.dnf) return a.dnf ? 1 : -1;
                    if (a.lapsCompleted !== b.lapsCompleted) return b.lapsCompleted - a.lapsCompleted;
                    if (a.currentLapProgress !== b.currentLapProgress) return b.currentLapProgress - a.currentLapProgress;
                    return a.totalTime - b.totalTime;
                });

                if (leaderboard) {
                    leaderboard.innerHTML = '';

                    ranking.forEach((d, i) => {
                        const li = document.createElement('div');
                        li.className = `list-group-item d-flex justify-content-between align-items-center ${d.isMyTeam ? 'my-team-driver' : ''}`;
                        li.innerHTML = `
                                                                                                                                                                                                            <div>
                                                                                                                                                                                                                <span style="display:inline-block;width:10px;height:10px;background:${d.color};border-radius:50%;margin-right:8px;"></span>
                                                                                                                                                                                                                <strong class="text-body">${i + 1}. ${escapeHtml(d.driver)} ${d.dnf ? '(DNF)' : ''} ${d.isMyTeam ? '(My Team)' : ''}</strong>
                                                                                                                                                                                                                <div class="small text-muted">Lap: ${d.lapsCompleted}/${lapsTotal} · Sector: ${d.currentSector}/3</div>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="text-end small text-muted">
                                                                                                                                                                                                                <div>Total: ${d.totalTime.toFixed(3)}s</div>
                                                                                                                                                                                                                <div>Best: ${d.bestLapTime ? d.bestLapTime.toFixed(3) + 's' : '--'}</div>
                                                                                                                                                                                                            </div>`;
                        leaderboard.appendChild(li);
                    });
                }

                drawCanvasDrivers();
            }

            // === MAIN LOOP ===
            let raceElapsed = 0;
            let lastTick = performance.now();
            const TICK_MS = 50;

            function tick() {
                if (!isRunning) {
                    lastTick = performance.now();
                    return;
                }
                const now = performance.now();
                const dt = (now - lastTick) / 1000;
                lastTick = now;
                raceElapsed += dt;

                drivers.forEach(d => {
                    if (d.lapsCompleted >= lapsTotal || d.dnf) return;

                    const lapSec = expectedLapSeconds(d);
                    if (!d._currentLapTarget) {
                        const variance = (Math.random() * 0.2 - 0.1) * lapSec;
                        d._currentLapTarget = Math.max(0.5, lapSec + variance);
                        d._currentLapElapsed = 0;
                    }

                    d._currentLapElapsed += dt;
                    d._sectorElapsed += dt;
                    d.currentLapProgress = Math.min(1, d._currentLapElapsed / d._currentLapTarget);

                    // Sector check - 1 lap = 3 sektor
                    const sectorProgress = d.currentLapProgress * 3; // 0-3 (bukan 0-1)
                    let newSector = Math.floor(sectorProgress) + 1;
                    if (newSector > 3) newSector = 3;

                    if (newSector !== d.currentSector) {
                        // Finished sector
                        let { penalty, msg } = simulateEvents(d, d.lapsCompleted + 1, d.currentSector);
                        d._sectorElapsed += penalty;
                        d.sectorTimes.push(d._sectorElapsed);
                        if (msg) console.log(msg);
                        d._sectorElapsed = 0;
                        d.currentSector = newSector;
                    }

                    // Finished lap
                    if (d.currentLapProgress >= 1) {
                        let { penalty, msg } = simulateEvents(d, d.lapsCompleted + 1, 3);
                        d._sectorElapsed += penalty;
                        d.sectorTimes.push(d._sectorElapsed);

                        d.lastLapTime = d._currentLapTarget + penalty;
                        d.totalTime += d.lastLapTime;

                        // Update best lap time
                        if (!d.bestLapTime || d.lastLapTime < d.bestLapTime) {
                            d.bestLapTime = d.lastLapTime;
                        }

                        // Save to race results
                        raceResults.push({
                            schedule_id: scheduleId,
                            driver_id: d.driver_id,
                            lap_number: d.lapsCompleted + 1,
                            sector1_time: d.sectorTimes[0],
                            sector2_time: d.sectorTimes[1],
                            sector3_time: d.sectorTimes[2],
                            lap_time: d.lastLapTime,
                            dnf: d.dnf ? 1 : 0
                        });

                        d.lapsCompleted++;
                        d.currentLapProgress = 0;
                        d._currentLapTarget = null;
                        d._currentLapElapsed = 0;
                        d._sectorElapsed = 0;
                        d.sectorTimes = [];
                        d.currentSector = 1;
                    }
                });

                updateUI();

                // Check if race is finished
                if (drivers.every(d => d.lapsCompleted >= lapsTotal || d.dnf)) {
                    isRunning = false;
                    if (pauseBtn) {
                        pauseBtn.textContent = 'Race Finished';
                        pauseBtn.classList.remove('btn-secondary');
                        pauseBtn.classList.add('btn-success');
                    }

                    // Send results to server
                    try {
                        fetch('/api/race-store', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(raceResults)
                        })
                            .then(r => r.ok ? r.json().then(j => console.log('saved', j)).catch(() => { }) : console.warn('save failed'));
                    } catch (err) {
                        console.warn('save error', err);
                    }
                }
            }

            // === CONTROLS ===
            function setSpeed(k) {
                currentSpeedKey = k;
                ['1', '2', '3'].forEach(s => {
                    const el = document.getElementById('speed' + s);
                    if (!el) return;
                    if (s === k) el.classList.add('active');
                    else el.classList.remove('active');
                });
            }

            function startRace() {
                if (isRunning) return;
                isRunning = true;
                lastTick = performance.now();
                if (startBtn) startBtn.disabled = true;
                if (pauseBtn) {
                    pauseBtn.disabled = false;
                    pauseBtn.textContent = 'Pause';
                    pauseBtn.classList.remove('btn-danger');
                    pauseBtn.classList.add('btn-secondary');
                }
            }

            function togglePause() {
                isRunning = !isRunning;
                if (pauseBtn) pauseBtn.textContent = isRunning ? 'Pause' : 'Resume';
                lastTick = performance.now();
            }

            // === INIT ===
            document.addEventListener('DOMContentLoaded', function () {
                if (speedBtn1) speedBtn1.addEventListener('click', () => setSpeed('1'));
                if (speedBtn2) speedBtn2.addEventListener('click', () => setSpeed('2'));
                if (speedBtn3) speedBtn3.addEventListener('click', () => setSpeed('3'));
                if (startBtn) startBtn.addEventListener('click', startRace);
                if (pauseBtn) pauseBtn.addEventListener('click', togglePause);

                // Initial setup
                resizeCanvas();
                renderDriverControls();
                updateUI();

                // Start the tick interval
                setInterval(tick, TICK_MS);

                // Handle window resize
                window.addEventListener('resize', resizeCanvas);
            });
        </script>
    @endif
@endsection