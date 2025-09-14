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
    <div class="container py-4">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <i class="ri-flag-line me-2"></i>F1 Qualifying Simulator
                </a>
                <div class="navbar-text">
                    {{ $schedule->name ?? 'Qualifying Session' }}
                </div>
            </div>
        </nav>

        @if ($schedule->qualifyingResults->isEmpty())
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
                                <div class="info-label">Session</div>
                                <div id="sessionInfo" class="info-value">Q1 of 3</div>
                            </div>
                            <div class="session-info-card">
                                <div class="info-label">Lap</div>
                                <div id="lapInfo" class="info-value">0 / 5</div>
                            </div>
                            <div class="session-info-card">
                                <div class="info-label">Quali Time</div>
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
            <div class="card">
                <div class="card-header">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm results-table">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2">POS</th>
                                <th rowspan="2">DRIVER</th>
                                <th rowspan="2">TEAM</th>
                                <th class="text-center" colspan="3">TIME</th>
                            </tr>
                            <tr>
                                <th class="text-center">Q1</th>
                                <th class="text-center">Q2</th>
                                <th class="text-center">Q3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedule->qualifyingResults->sortBy('position') as $qualifying)
                                <tr>
                                    <td class="text-center">
                                        {{ $qualifying->position }}
                                    </td>
                                    <td>
                                        <i class="ri-circle-fill"
                                            style="color:{{ $qualifying->driver->teams->first()->team->color_primary }};"></i>
                                        {{ $qualifying->driver->name ?? '' }}
                                    </td>
                                    <td>{{ $qualifying->driver->teams->first()->team->name ?? '' }}</td>
                                    <td class="text-center">{{ $qualifying->q1_time ?? '-' }}</td>
                                    <td class="text-center">{{ $qualifying->q2_time ?? '-' }}</td>
                                    <td class="text-center">{{ $qualifying->q3_time ?? '-' }}</td>
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
    @if ($schedule->qualifyingResults->isEmpty())
        <script>
            // JavaScript code with fixes for strategy controls and impact
            // Only drivers from my team can change strategy, and strategy now properly affects performance

            /* ----- Config ----- */
            const lapsPerSession = 5;
            const totalSessions = 3;
            let currentSession = 1;
            let lapsThisSession = 0;
            let isRunning = false;
            let qualifyingResults = [];

            // Adjusted base lap times for more realistic pace (seconds per lap)
            const baseLapBySpeed = {
                1: 12.0, // Slow speed - lebih lambat
                2: 8.0,  // Medium speed 
                3: 5.0   // Fast speed - tetap cepat tapi tidak terlalu ekstrim
            };
            let currentSpeedKey = '1';

            /* ----- Server-provided data (safe) ----- */
            const scheduleId = {!! json_encode($schedule->id ?? null) !!};
            const rawDrivers = {!! json_encode($drivers ?? []) !!} || [];
            const myTeamId = {!! json_encode($team->id ?? []) !!}; // Get user's team ID from controller

            /* ----- Canvas setup ----- */
            const canvas = document.getElementById('raceCanvas');
            const ctx = canvas.getContext('2d');

            // Konfigurasi sirkuit lingkaran
            const trackPadding = 40;
            let centerX, centerY, trackRadius;

            /* ----- Normalize drivers ----- */
            let drivers = rawDrivers.map((d, idx) => ({
                driver: d.driver ?? d.name ?? `Driver ${idx + 1}`,
                driver_id: d.driver_id ?? d.id ?? idx + 1,
                team_id: d.team_id ?? 0, // Add team_id to drivers
                color: d.color ?? `hsl(${(idx * 73) % 360} 70% 50%)`,
                pace: (typeof d.pace === 'number') ? d.pace : (d.pace ? Number(d.pace) || 1 : 1),
                isMyTeam: (d.team_id == myTeamId), // Flag for my team drivers
                lapsCompleted: 0,
                sessionLapsCompleted: 0,
                totalTime: 0,
                lastLapTime: 0,
                currentLapProgress: 0,
                _currentLapTarget: null,
                _currentLapElapsed: 0,
                dnf: false,
                eliminatedAtSession: 0,
                q1_time: null,
                q2_time: null,
                q3_time: null,
                strategy: d.strategy ?? 'normal'
            }));

            let activeDrivers = drivers.slice();
            let eliminatedQ1 = [];
            let eliminatedQ2 = [];

            /* ----- DOM refs (defensive) ----- */
            const startBtn = document.getElementById('startBtn');
            const pauseBtn = document.getElementById('pauseBtn');
            const speedBtn1 = document.getElementById('speed1');
            const speedBtn2 = document.getElementById('speed2');
            const speedBtn3 = document.getElementById('speed3');
            const driverControls = document.getElementById('driverControls');
            const leaderboardEl = document.getElementById('leaderboard');
            const lapInfo = document.getElementById('lapInfo');
            const sessionInfo = document.getElementById('sessionInfo');
            const raceClock = document.getElementById('raceClock');

            /* ----- Helpers ----- */
            function secToClock(t) {
                if (typeof t !== 'number' || isNaN(t)) return '00:00.000';
                const ms = Math.floor((t - Math.floor(t)) * 1000);
                const s = Math.floor(t % 60);
                const m = Math.floor((t / 60) % 60);
                return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}.${ms.toString().padStart(3, '0')}`;
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

            function expectedLapSeconds(driver) {
                let base = baseLapBySpeed[currentSpeedKey] ?? baseLapBySpeed[1];

                // Base time berdasarkan pace driver (semakin tinggi pace, semakin cepat)
                base = base * (1.2 - (driver.pace || 1) * 0.2); // Pace 1 = 100%, Pace 5 = 20% lebih cepat

                // Reduced strategy modifiers untuk efek yang lebih halus
                if (driver.strategy === 'aggressive') base *= 0.97; // 3% faster but higher risk
                if (driver.strategy === 'slowdown') base *= 1.03; // 3% slower but more consistent

                // Add some random variance untuk realism (±2%)
                const variance = 1 + (Math.random() * 0.04 - 0.02);
                return base * variance;
            }

            function simulateEvents(driver) {
                let penalty = 0;
                // Adjust mistake probability based on strategy - reduced probabilities
                const baseMistake = driver.strategy === 'aggressive' ? 0.03 :
                    driver.strategy === 'slowdown' ? 0.001 : 0.015;

                // Smaller penalties for more realism
                if (Math.random() < baseMistake) penalty += 0.3 + Math.random() * 0.4; // Reduced from 0.6-1.4s to 0.3-0.7s
                if (Math.random() < 0.0015) penalty += 0.8; // Reduced from 1.8s to 0.8s
                return penalty;
            }

            /* ----- Canvas resizing - robust ----- */
            function resizeCanvas() {
                try {
                    const DPR = window.devicePixelRatio || 1;
                    const rect = canvas.getBoundingClientRect();
                    // if element hidden or width/height 0, fallback to default dims
                    let cssW = Math.floor(rect.width) || 1000;
                    let cssH = Math.floor(rect.height) || 600;
                    // ensure minimum
                    cssW = Math.max(300, cssW);
                    cssH = Math.max(200, cssH);

                    // set CSS size explicitly (keeps clientWidth stable)
                    canvas.style.width = cssW + 'px';
                    canvas.style.height = cssH + 'px';

                    // set internal pixel size according to DPR
                    canvas.width = Math.floor(cssW * DPR);
                    canvas.height = Math.floor(cssH * DPR);

                    // scale draw coordinates to CSS pixels
                    ctx.setTransform(DPR, 0, 0, DPR, 0, 0);

                    // Pusat dan radius sirkuit
                    centerX = cssW / 2;
                    centerY = cssH / 2;
                    trackRadius = Math.min(cssW, cssH) / 2 - trackPadding;
                } catch (err) {
                    console.warn('resizeCanvas failed', err);
                }
            }
            window.addEventListener('resize', () => {
                resizeCanvas();
                drawCanvasDrivers();
            });

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
                        const labelX = centerX + (trackRadius + 20) * Math.cos(angle);
                        const labelY = centerY + (trackRadius + 20) * Math.sin(angle);

                        ctx.fillText(`Sector ${i + 1}`, labelX, labelY);
                    }

                } catch (err) {
                    console.error('drawCircuit error', err);
                }
            }

            /* ----- Rendering ----- */
            function drawCanvasDrivers() {
                try {
                    // Gambar sirkuit terlebih dahulu
                    drawCircuit();

                    // Gambar header info
                    ctx.fillStyle = '#fff';
                    ctx.font = '13px Inter, Arial';
                    ctx.textAlign = 'left';
                    ctx.fillText(`Session: Q${Math.min(currentSession, totalSessions)} / ${totalSessions}`, 8, 18);
                    ctx.fillText(`Lap: ${lapInfo ? lapInfo.textContent : '0 / ' + lapsPerSession}`, 180, 18);
                    ctx.fillText(`Time: ${raceClock ? raceClock.textContent : '00:00.000'}`, 320, 18);

                    // Gambar setiap pembalap di posisinya di sirkuit
                    drivers.forEach((d, i) => {
                        if (d.dnf && d.lapsCompleted >= lapsPerSession) return;

                        // Hitung posisi pembalap di sirkuit berdasarkan progress
                        // 1 putaran lingkaran = 1 lap
                        const angle = -Math.PI / 2 + (d.currentLapProgress * 2 * Math.PI);

                        // Hitung posisi X dan Y
                        const carRadius = trackRadius - 15; // Mobil di dalam trek
                        const x = centerX + carRadius * Math.cos(angle);
                        const y = centerY + carRadius * Math.sin(angle);

                        // Gambar mobil pembalap
                        drawCar(x, y, angle + Math.PI / 2, d.color, d.isMyTeam, d.driver, d.sessionLapsCompleted, d.eliminatedAtSession);
                    });
                } catch (err) {
                    console.error('drawCanvasDrivers error', err);
                }
            }

            function drawCar(x, y, angle, color, isMyTeam, driverName, lapsCompleted, eliminatedAtSession) {
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

                    // Tampilkan kode pembalap (3 huruf pertama)
                    const code = driverName.substring(0, 3).toUpperCase();
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
                    const lapText = eliminatedAtSession > 0 ? `ELIM Q${eliminatedAtSession}` : `${lapsCompleted}/${lapsPerSession}`;
                    ctx.fillText(`${driverName}`, x + 12, y + 4);
                } catch (err) {
                    console.error('drawCar error', err);
                }
            }

            /* ----- UI: Driver controls and leaderboard ----- */
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

            function updateUI() {
                if (!lapInfo || !sessionInfo || !raceClock) return;
                const maxSessionDone = activeDrivers.length ? Math.max(...activeDrivers.map(d => d.sessionLapsCompleted)) : lapsPerSession;
                const displayLap = Math.min(lapsPerSession, maxSessionDone + (isRunning ? 1 : 0));
                lapInfo.textContent = `${displayLap} / ${lapsPerSession}`;
                sessionInfo.textContent = `Q${Math.min(currentSession, totalSessions)} of ${totalSessions}`;
                raceClock.textContent = secToClock(qualiElapsed);

                if (!leaderboardEl) return;
                leaderboardEl.innerHTML = '';

                const activeSorted = activeDrivers.slice().sort((a, b) => (a.q3_time ?? a.q2_time ?? a.q1_time ?? Infinity) - (b.q3_time ?? b.q2_time ?? b.q1_time ?? Infinity));
                const eliminatedSorted = drivers.filter(d => !activeDrivers.includes(d)).sort((a, b) => (a.eliminatedAtSession - b.eliminatedAtSession) || ((a.q2_time ?? a.q1_time ?? Infinity) - (b.q2_time ?? b.q1_time ?? Infinity)));

                activeSorted.forEach((d, idx) => {
                    const li = document.createElement('div');
                    li.className = `list-group-item d-flex justify-content-between align-items-center ${d.isMyTeam ? 'my-team-driver' : ''}`;
                    li.innerHTML = `
                                        <div>
                                            <span style="display:inline-block;width:10px;height:10px;background:${d.color};border-radius:50%;margin-right:8px;"></span>
                                            <strong class="text-body">P${idx + 1} ${escapeHtml(d.driver)} ${d.isMyTeam ? '(My Team)' : ''}</strong>
                                            <div class="small text-muted">Q1: ${d.q1_time ? d.q1_time.toFixed(3) + 's' : '--'} · Q2: ${d.q2_time ? d.q2_time.toFixed(3) + 's' : '--'} · Q3: ${d.q3_time ? d.q3_time.toFixed(3) + 's' : '--'}</div>
                                        </div>
                                        <div class="text-end small text-muted">${d.lastLapTime ? d.lastLapTime.toFixed(3) + 's' : '--'}</div>`;
                    leaderboardEl.appendChild(li);
                });

                eliminatedSorted.forEach(d => {
                    const li = document.createElement('div');
                    li.className = `list-group-item d-flex justify-content-between align-items-center bg-light ${d.isMyTeam ? 'my-team-driver' : ''}`;
                    li.innerHTML = `
                                        <div>
                                            <strong class="text-body">ELIM (Q${d.eliminatedAtSession || '-'}) ${escapeHtml(d.driver)} ${d.isMyTeam ? '(My Team)' : ''}</strong>
                                            <div class="small text-muted">Q1: ${d.q1_time ? d.q1_time.toFixed(3) + 's' : '--'} · Q2: ${d.q2_time ? d.q2_time.toFixed(3) + 's' : '--'}</div>
                                        </div>
                                        <div class="text-end small text-danger fw-bold">ELIM</div>`;
                    leaderboardEl.appendChild(li);
                });
            }

            function updateUI_final(finalOrder) {
                if (lapInfo) lapInfo.textContent = `${lapsPerSession} / ${lapsPerSession}`;
                if (sessionInfo) sessionInfo.textContent = `Q Done`;
                if (raceClock) raceClock.textContent = secToClock(qualiElapsed);
                if (!leaderboardEl) return;

                leaderboardEl.innerHTML = '';
                finalOrder.forEach((d, idx) => {
                    const li = document.createElement('div');
                    li.className = `list-group-item d-flex justify-content-between align-items-center ${d.isMyTeam ? 'my-team-driver' : ''}`;
                    li.innerHTML = `
                                        <div>
                                            <span style="display:inline-block;width:10px;height:10px;background:${d.color};border-radius:50%;margin-right:8px;"></span>
                                            <strong>${idx + 1}. ${escapeHtml(d.driver)} ${d.isMyTeam ? '(My Team)' : ''}</strong>
                                            <div class="small text-muted">Q1: ${d.q1_time ? d.q1_time.toFixed(3) + 's' : '--'} · Q2: ${d.q2_time ? d.q2_time.toFixed(3) + 's' : '--'} · Q3: ${d.q3_time ? d.q3_time.toFixed(3) + 's' : '--'}</div>
                                        </div>
                                        <div class="text-end small text-muted">${d.q3_time ?? d.q2_time ?? d.q1_time ? ((d.q3_time ?? d.q2_time ?? d.q1_time).toFixed(3) + 's') : '--'}</div>`;
                    leaderboardEl.appendChild(li);
                });
            }

            /* ----- Simulation loop ----- */
            let qualiElapsed = 0;
            let lastTick = performance.now();
            const TICK_MS = 50;

            function tick() {
                try {
                    if (!isRunning) {
                        lastTick = performance.now();
                        return;
                    }
                    const now = performance.now();
                    const dt = (now - lastTick) / 1000;
                    lastTick = now;
                    qualiElapsed += dt;

                    activeDrivers.forEach(d => {
                        if (d.dnf) return;
                        const lapSec = expectedLapSeconds(d);
                        if (!d._currentLapTarget) {
                            const variance = (Math.random() * 0.2 - 0.1) * lapSec;
                            d._currentLapTarget = Math.max(0.5, lapSec + variance);
                            d._currentLapElapsed = 0;
                        }
                        d._currentLapElapsed += dt;
                        d.currentLapProgress = Math.min(1, (d._currentLapElapsed || 0) / d._currentLapTarget);

                        if (d.currentLapProgress >= 1) {
                            const penalty = simulateEvents(d);
                            d.lastLapTime = d._currentLapTarget + penalty;
                            if (currentSession === 1) {
                                if (d.q1_time === null || d.lastLapTime < d.q1_time) d.q1_time = d.lastLapTime;
                            } else if (currentSession === 2) {
                                if (d.q2_time === null || d.lastLapTime < d.q2_time) d.q2_time = d.lastLapTime;
                            } else if (currentSession === 3) {
                                if (d.q3_time === null || d.lastLapTime < d.q3_time) d.q3_time = d.lastLapTime;
                            }

                            d.lapsCompleted++;
                            d.sessionLapsCompleted++;
                            lapsThisSession++;

                            d.currentLapProgress = 0;
                            d._currentLapTarget = null;
                            d._currentLapElapsed = 0;

                            if (lapsThisSession >= lapsPerSession * activeDrivers.length) nextSession();
                        }
                    });

                    updateUI();
                    drawCanvasDrivers();
                } catch (err) {
                    console.error('tick error', err);
                    // stop running to avoid repeated errors (keeps canvas visible)
                    isRunning = false;
                    if (pauseBtn) {
                        pauseBtn.textContent = 'Error - Stopped';
                        pauseBtn.classList.remove('btn-secondary');
                        pauseBtn.classList.add('btn-danger');
                    }
                }
            }

            /* ----- Sessions / Eliminations ----- */
            function nextSession() {
                // Q1 elimination -> keep top 8
                if (currentSession === 1) {
                    const sorted = activeDrivers.slice().sort((a, b) => (a.q1_time ?? Infinity) - (b.q1_time ?? Infinity));
                    const keep = sorted.slice(0, 8);
                    const out = sorted.slice(8);
                    out.forEach(d => d.eliminatedAtSession = 1);
                    eliminatedQ1 = out.slice();
                    activeDrivers = keep.slice();
                } else if (currentSession === 2) {
                    const sorted = activeDrivers.slice().sort((a, b) => (a.q2_time ?? Infinity) - (b.q2_time ?? Infinity));
                    const keep = sorted.slice(0, 4);
                    const out = sorted.slice(4);
                    out.forEach(d => d.eliminatedAtSession = 2);
                    eliminatedQ2 = out.slice();
                    activeDrivers = keep.slice();
                }

                // reset per-session counters for remaining active drivers
                activeDrivers.forEach(d => d.sessionLapsCompleted = 0);
                lapsThisSession = 0;
                currentSession++;
                if (currentSession > totalSessions) finishQualifying();
            }

            function finishQualifying() {
                isRunning = false;
                if (pauseBtn) {
                    pauseBtn.textContent = 'Qualifying Finished';
                    pauseBtn.classList.remove('btn-secondary');
                    pauseBtn.classList.add('btn-success');
                }
                const top = activeDrivers.slice().sort((a, b) => (a.q3_time ?? a.q2_time ?? a.q1_time ?? Infinity) - (b.q3_time ?? b.q2_time ?? b.q1_time ?? Infinity));
                const el2 = eliminatedQ2.slice().sort((a, b) => (a.q2_time ?? Infinity) - (b.q2_time ?? Infinity));
                const el1 = eliminatedQ1.slice().sort((a, b) => (a.q1_time ?? Infinity) - (b.q1_time ?? Infinity));
                const finalOrder = [...top, ...el2, ...el1];
                qualifyingResults = finalOrder.map((d, i) => ({
                    schedule_id: scheduleId,
                    driver_id: d.driver_id,
                    position: i + 1,
                    q1_time: d.q1_time,
                    q2_time: d.q2_time,
                    q3_time: d.q3_time
                }));
                updateUI_final(finalOrder);

                // push results (best-effort)
                try {
                    fetch('/api/qualifying-store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(qualifyingResults)
                    })
                        .then(r => r.ok ? r.json().then(j => console.log('saved', j)).catch(() => { }) : console.warn('save failed'));
                } catch (err) {
                    console.warn('save error', err);
                }
            }

            /* ----- Controls: attach listeners safely ----- */
            function setSpeed(k) {
                currentSpeedKey = k;
                ['1', '2', '3'].forEach(s => {
                    const el = document.getElementById('speed' + s);
                    if (!el) return;
                    if (s === k) el.classList.add('active');
                    else el.classList.remove('active');
                });
            }

            function startQualifying() {
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

            if (speedBtn1) speedBtn1.addEventListener('click', () => setSpeed('1'));
            if (speedBtn2) speedBtn2.addEventListener('click', () => setSpeed('2'));
            if (speedBtn3) speedBtn3.addEventListener('click', () => setSpeed('3'));
            if (startBtn) startBtn.addEventListener('click', startQualifying);
            if (pauseBtn) pauseBtn.addEventListener('click', togglePause);

            /* ----- Init ----- */
            resizeCanvas();
            renderDriverControls();
            updateUI();
            drawCanvasDrivers();
            setInterval(tick, TICK_MS);
        </script>
    @endif
@endsection