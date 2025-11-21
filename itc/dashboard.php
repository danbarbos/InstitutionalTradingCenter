<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'] ?? 'user';
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/style.css" />

    <script>
        // Toggle dropdown pe mobil la click
        document.addEventListener('DOMContentLoaded', function () {
            const menuItems = document.querySelectorAll('nav ul.menu > li');

            menuItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    if(window.innerWidth <= 768) {
                        e.preventDefault();
                        // Toggle clasa active
                        if (this.classList.contains('active')) {
                            this.classList.remove('active');
                        } else {
                            // Inchide alte dropdown-uri
                            menuItems.forEach(i => i.classList.remove('active'));
                            this.classList.add('active');
                        }
                    }
                });
            });
        });
    </script>
</head>

<body class="with-bg-image"> 
<nav>
    <div class="container">
        <a href="dashboard.php" class="logo">Institutional Trading Center</a>
        <ul class="menu">
            <?php if ($role === 'admin'): ?>
                <li>
                    <a href="#" tabindex="0">Admin</a>
                    <ul class="submenu" aria-label="Admin menu">
                        <li><a href="../admin/crud_portfolios.php">Manage Portfolios</a></li>
                        <li><a href="../admin/crud_institutions.php">Manage Institutions</a></li>
                        <li><a href="../admin/crud_counterparties.php">Manage Counterparties</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li>
                    <a href="#" tabindex="0">Views</a>
                    <ul class="submenu" aria-label="Views menu">
                        <li><a href="../user/views/portfolios.php">Portfolios</a></li>
                        <li><a href="../user/views/vinstitutions.php">Institutions</a></li>
                        <li><a href="../user/views/vcounterparties.php">Counterparties</a></li>
                        <li><a href="../user/views/vtradehistory.php">Trade History</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" tabindex="0">Trade</a>
                    <ul class="submenu" aria-label="Trade menu">
                        <li><a href="../user/actions/add_trade.php">Add Trade</a></li>
                        <li><a href="../user/actions/positions.php">Positions</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
        <div class="user-info">
            <span><?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" title="Logout" class="logout-link" aria-label="Logout">
                <!-- SVG icon logout inline -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M14 8v-2a2 2 0 0 0-2-2h-7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2"/>
                    <path d="M9 12h12l-3-3"/>
                    <path d="M18 15l3-3"/>
                </svg>
                <span class="logout-text">Logout</span>
            </a>
        </div>
    </div>
</nav>

<main>
    <div id="welcomePopup" class="welcome-card" role="region" aria-label="Welcome message" aria-live="polite" aria-atomic="true">
        <button id="closeWelcome" aria-label="Close welcome message" class="close-btn" style="position:absolute; top:8px; right:12px; background:none; border:none; color:white; font-size:1.5rem; cursor:pointer;">&times;</button>
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
        <p>Choose an option from the menu above to start.</p>
    </div>

    <script>
        document.getElementById('closeWelcome').addEventListener('click', function() {
            const popup = document.getElementById('welcomePopup');
            popup.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            popup.style.opacity = '0';
            popup.style.transform = 'translate(-50%, -50%) scale(0.8)';
            setTimeout(() => popup.remove(), 300);
        });
    </script>

    <section id="chart">
        <h2>Market Heatmap</h2>
        <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-stock-heatmap.js" async>
                    {
                    "exchanges": [],
                    "dataSource": "SPX500",
                    "grouping": "sector",
                    "blockSize": "market_cap_basic",
                    "blockColor": "change",
                    "locale": "en",
                    "symbolUrl": "",
                    "colorTheme": "dark",
                    "hasTopBar": false,
                    "isDataSetEnabled": false,
                    "isZoomEnabled": true,
                    "hasSymbolTooltip": true,
                    "isMonoSize": false,
                    "width": "90%",
                    "height": "80%"
                    }
            </script>
        </div>
    </section>
    
    <section id="soverview">
        <h2>Symbol Overview</h2>
        <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
            {
            "symbols": [
                [
                "Apple",
                "AAPL|1D"
                ],
                [
                "Google",
                "GOOGL|1D"
                ],
                [
                "Microsoft",
                "MSFT|1D"
                ]
            ],
            "chartOnly": false,
            "width": "100%",
            "height": "70%",
            "locale": "en",
            "colorTheme": "dark",
            "autosize": true,
            "showVolume": false,
            "showMA": false,
            "hideDateRanges": false,
            "hideMarketStatus": false,
            "hideSymbolLogo": false,
            "scalePosition": "right",
            "scaleMode": "Normal",
            "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
            "fontSize": "10",
            "noTimeScale": false,
            "valuesTracking": "1",
            "changeMode": "price-and-percent",
            "chartType": "area",
            "maLineColor": "#2962FF",
            "maLineWidth": 1,
            "maLength": 9,
            "headerFontSize": "medium",
            "lineWidth": 2,
            "lineType": 0,
            "dateRanges": [
                "1d|1",
                "1m|30",
                "3m|60",
                "12m|1D",
                "60m|1W",
                "all|1M"
            ]
            }
        </script>
        </div>
    </section>

    <section id="news">
    <h2>Latest News</h2>
        <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
            {
            "feedMode": "all_symbols",
            "isTransparent": false,
            "displayMode": "regular",
            "width": "400",
            "height": "550",
            "colorTheme": "dark",
            "locale": "en"
            }
        </script>
        </div>

    </section>

    <section id="calendar">
        <h2>Economic Calendar</h2>
        <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-events.js" async>
                {
                "width": "100%",
                "height": "100%",
                "colorTheme": "dark",
                "isTransparent": false,
                "locale": "en",
                "importanceFilter": "-1,0,1",
                "countryFilter": "ar,au,br,ca,cn,fr,de,in,id,it,jp,kr,mx,ru,sa,za,tr,gb,us,eu"
                }
        </script>
        </div>
    </section>
</main>

<script>
    (() => {
        const sections = document.querySelectorAll('section');
        let isScrolling;
        
        window.addEventListener('scroll', () => {
            window.clearTimeout(isScrolling);
            
            isScrolling = setTimeout(() => {
            // Determină secțiunea cea mai apropiată de poziția scroll-ului
            let scrollPosition = window.scrollY;
            let closestSection = sections[0];
            let minDistance = Math.abs(sections[0].offsetTop - scrollPosition);

            sections.forEach(section => {
                const distance = Math.abs(section.offsetTop - scrollPosition);
                if (distance < minDistance) {
                minDistance = distance;
                closestSection = section;
                }
            });

            // Scroll animat la secțiunea cea mai apropiată
            closestSection.scrollIntoView({ behavior: 'smooth' });
            }, 100); // 100ms după ultimul scroll
        });
    })();
</script>

</body>
</html>
