<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Individual Work - Backend CRUD Project by Afsana Quliyeva. Laravel backend with database, CRUD operations, and interactive periodic table UI.">
    <meta name="author" content="Afsana Quliyeva">
    <title>Individual Work | Prabesh Aryal | Backend CRUD Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
            <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
            overflow-x: hidden;
        }
        .container {
            max-width: 95%;
            margin: 0 auto;
        }
        .element-tile-glow {
            box-shadow: 0 0 20px 5px rgba(153, 51, 255, 0.5),
                        0 0 30px 10px rgba(204, 102, 255, 0.4);
        }
        .info-card-glow {
            box-shadow: 0 0 20px 5px rgba(153, 51, 255, 0.5),
                        0 0 5px 1px rgba(204, 102, 255, 0.3) inset;
        }
        .bg-element {
            background-color: rgba(30, 30, 40, 0.5); /* Darker, more transparent */
            border: 2px solid;
            border-color: #6200EA; /* Purple border */
            opacity: 0.7;
            transition: all 0.3s ease;
            transform: perspective(800px) rotateY(-10deg);
            min-width: 50px;
            min-height: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .bg-element:hover {
            opacity: 0.9;
            background-color: rgba(50, 50, 60, 0.7); /* Slightly lighter on hover */
            transform: perspective(800px) rotateY(-10deg) scale(1.05);
            border-color: #00FFFF; /* Cyan border on hover */
            box-shadow: 0 0 10px 2px rgba(0, 255, 255, 0.5);
        }
        .bg-element-symbol {
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
        }
        .bg-element-num {
            font-size: 0.7rem;
            color: #eeeeee;
            text-shadow: 0 0 3px rgba(255, 255, 255, 0.3);
        }
        .atom {
            width: 100px; height: 100px;
            border-radius: 50%; position: relative; display: flex;
            justify-content: center; align-items: center; margin: 1rem auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.8), inset 0 0 20px rgba(255,255,255,0.1);
            background: radial-gradient(circle at center, #222, #000);
            transform: perspective(800px) rotateY(-10deg);
        }
        .nucleus {
            width: 20px; height: 20px; background-color: #ff4081;
            border-radius: 50%; position: relative; z-index: 1;
            box-shadow: 0 0 6px 1px rgba(255,64,129,0.7);
        }
        .nucleus::before, .nucleus::after { content: ''; position: absolute; border-radius: 50%; }
        .nucleus::before { width: 10px; height: 10px; background-color: #42a5f5; top: 2px; left: 2px; box-shadow: 0 0 4px 1px rgba(66,165,245,0.5); }
        .nucleus::after { width: 8px; height: 8px; background-color: #f44336; bottom: 3px; right: 3px; box-shadow: 0 0 4px 1px rgba(244,67,54,0.5); }
        .electron-orbit { position: absolute; border-radius: 50%; border: 1px solid rgba(156,39,176,0.5); animation: orbit-rotation 5s linear infinite; }
        @keyframes orbit-rotation { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .electron-orbit:nth-child(1) { width: 50px; height: 50px; }
        .electron-orbit:nth-child(2) { width: 80px; height: 80px; }
        .electron-orbit:nth-child(3) { width: 110px; height: 110px; }
        .electron { width: 8px; height: 8px; background-color: #b388ff; border-radius: 50%; position: absolute; box-shadow: 0 0 5px 1px rgba(179,136,255,0.4); }
        .electron-orbit:nth-child(1) .electron { top: -4px; left: calc(50% - 4px); }
        .electron-orbit:nth-child(2) .electron { bottom: -4px; left: calc(50% - 4px); transform: rotate(45deg); transform-origin: 36px 36px; }
        .electron-orbit:nth-child(3) .electron { top: calc(50% - 4px); right: -4px; transform: rotate(-30deg); transform-origin: 48px 0px; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: #9c27b0; border-radius: 5px; box-shadow: 0 0 4px rgba(156,39,176,0.3); }
        ::-webkit-scrollbar-thumb:hover { background: #ba68c8; }

        #periodic-table-container {
            transform: perspective(800px) rotateX(10deg);
            transition: filter 0.3s ease, opacity 0.3s ease; /* Added transition for blur */
            max-height: 70vh; overflow-y: auto; display: grid;
            grid-template-columns: repeat(18, minmax(30px, 1fr));
            gap: 0.1rem; width: 100%;
            overflow: hidden; /* Prevent box-shadow spill */
            /* border-radius: 1.2rem; Rounded corners for clean edge */
            /* border: 2px solid #a259f7; Subtle border for clean edge */
        }

        #element-info-container {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background-color: rgba(10, 10, 20, 0.85);
            z-index: 100; display: none; /* Toggled by JS */
            align-items: center; justify-content: center;
            padding: 2rem 1rem; /* Default padding */
            gap: 2rem; /* Gap between the two cards */
            overflow-y: auto; /* For scrolling when stacked and content overflows */
            flex-direction: row; /* Default for larger screens */
            opacity: 0;
            transform: scale(0.97);
            transition: opacity 0.35s cubic-bezier(.4,0,.2,1), transform 0.35s cubic-bezier(.4,0,.2,1);
        }
        #element-info-container.active {
            display: flex !important;
            opacity: 1;
            transform: scale(1);
        }

        .blurred {
            filter: blur(5px); opacity: 0.3; pointer-events: none;
        }
        .lanthanide-row, .actinide-row {
            display: grid; grid-template-columns: repeat(15, minmax(30px, 1fr));
            gap: 0.1rem; margin-top: 0.5rem;
            transition: filter 0.3s ease, opacity 0.3s ease; /* Added transition for blur */
            transform: perspective(800px) rotateX(10deg); /* Sync tilt with main table */
        }
        /* For Lanthanide/Actinide wrapper divs */
        #lanthanide-row-wrapper, #actinide-row-wrapper {
            transition: filter 0.3s ease, opacity 0.3s ease; /* Added transition for blur */
        }

        /* Responsive stacking for the two info cards */
        @media (max-width: 900px) { /* Adjust breakpoint as needed */
            #element-info-container {
                flex-direction: column;
                padding: 1rem;
                gap: 1.5rem;
            }
            /* Individual card styles will use clamp for width, so direct override might not be needed
               unless clamp values are not suitable for stacked view. */
             #detailed-info-card {
                max-height: 60vh; /* Adjust max height for info card when stacked */
             }
             /* Make large display tile symbol smaller on mobile */
             #large-element-tile-display .element-symbol-large {
                font-size: 5rem; /* Tailwind: text-7xl */
             }
        }
         @media (max-width: 480px) {
             #large-element-tile-display .element-symbol-large {
                font-size: 4rem; /* Tailwind: text-6xl */
             }
             #large-element-tile-display .element-name-large {
                font-size: 1.25rem; /* Tailwind: text-xl */
             }
         }


        /* Empty cells for the gap - kept for clarity, ensure they don't interfere */
        #periodic-table-container div[style*="grid-column-start: 4; grid-column-end: 15;"] {
            background-color: transparent !important;
            border: none !important;
            pointer-events: none;
        }

        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, currentColor, transparent);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .nav-link:hover::after {
            transform: translateX(100%);
        }

        /* Add a subtle glow to the header */
        header {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.1);
        }

            </style>
    </head>
<body class="bg-black">
    <!-- Navigation Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-lg border-b border-indigo-500/20">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-indigo-300">Research Management System</h1>
                    <span class="text-slate-400">|</span>
                    <span class="text-slate-300">Interactive Periodic Table</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/api" class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-black hover:bg-slate-900 text-indigo-300 transition-colors border border-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                        <span>API Routes</span>
                    </a>
                    <a href="/admin" class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-black hover:bg-slate-900 text-violet-300 transition-colors border border-violet-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                        <span>Admin Panel</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="periodic-table-container pt-20"> <!-- Added padding-top to account for fixed header -->
        <div class="container mx-auto p-4">
            <div class="mb-6 text-center">
                <h1 class="text-2xl md:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-violet-400 to-purple-600 mb-2">Interactive Periodic Table</h1>
                <p class="text-gray-400">Click on any element to view detailed information</p>
            </div>

            <div id="periodic-table-container" class="w-full overflow-auto mb-8 z-0 transform transition duration-500 ease-in-out">
            </div>
            <div id="lanthanide-row-wrapper" class="flex justify-center">
                <div class="lanthanide-row">
                </div>
            </div>
            <div id="actinide-row-wrapper" class="flex justify-center">
                <div class="actinide-row">
                </div>
            </div>

            <div id="element-info-container">
                <!-- Two cards will be populated here by JS -->
            </div>
        </div>
    </div>
    <script>
       let periodicTableData = [];
       fetch('/elements')
         .then(response => response.json())
         .then(data => {
           periodicTableData = data.map(e => ({
             number: e.number,
             symbol: e.symbol,
             name: e.name,
             atomicMass: e.atomic_mass,
             category: e.category,
             meltingPoint: e.melting_point,
             boilingPoint: e.boiling_point,
             group: e.group,
             period: e.period,
             description: e.description,
             modelPath: e.model_path
           }));
           renderPeriodicTable();
         });

        const periodicTableContainer = document.getElementById('periodic-table-container');
        const elementInfoContainer = document.getElementById('element-info-container');
        const lanthanidesContainer = document.querySelector('.lanthanide-row');
        const actinidesContainer = document.querySelector('.actinide-row');
        const lanthanideRowWrapper = document.getElementById('lanthanide-row-wrapper');
        const actinideRowWrapper = document.getElementById('actinide-row-wrapper');

        function createElementTile(element, isPlaceholder = false) {
            const tile = document.createElement('div');
            tile.classList.add('bg-element', 'p-1', 'rounded', 'text-center', 'aspect-square', 'flex', 'flex-col', 'justify-center', 'items-center', 'w-full', 'h-full', 'cursor-pointer');
            if (isPlaceholder) {
                tile.classList.add('italic', 'opacity-80');
                tile.innerHTML = `<span class="bg-element-num text-xs">${element.number}</span><span class="bg-element-symbol">${element.symbol}</span><span class="text-xs text-slate-300">${element.namePlaceholder || ''}</span>`;
            } else {
                tile.innerHTML = `<span class="bg-element-num">${element.number}</span><span class="bg-element-symbol">${element.symbol}</span>`;
                tile.addEventListener('click', () => displayElementInfo(element));
                tile.style.cursor = 'pointer';
            }


            let borderColor = '#6200EA';
            switch (element.category) {
                case 'Alkali Metal': borderColor = '#FF5722'; break;
                case 'Alkaline Earth Metal': borderColor = '#FFC107'; break;
                case 'Transition Metal': borderColor = '#2196F3'; break;
                case 'Post-Transition Metal': borderColor = '#4CAF50'; break;
                case 'Metalloid': borderColor = '#9C27B0'; break;
                case 'Nonmetal': borderColor = '#8BC34A'; break;
                case 'Halogen': borderColor = '#00BCD4'; break;
                case 'Noble Gas': borderColor = '#E91E63'; break;
                case 'Lanthanide': borderColor = '#795548'; break;
                case 'Actinide': borderColor = '#5D4037'; break;
            }
            tile.style.borderColor = borderColor;
            return tile;
        }

        function displayElementInfo(element) {
            periodicTableContainer.classList.add('blurred');
            lanthanideRowWrapper.classList.add('blurred');
            actinideRowWrapper.classList.add('blurred');
            document.body.style.overflowY = 'hidden';

            elementInfoContainer.innerHTML = `
                <!-- Large Element Display Tile (Left) -->
                <div id="large-element-tile-display"
                     class="bg-element element-tile-glow p-4 md:p-6 rounded-xl flex flex-col text-white relative items-center justify-around cursor-pointer"
                     style="width: clamp(280px, 30vw, 380px); aspect-ratio: 10/12; min-height:330px;">

                    <div class="flex justify-between w-full">
                        <span class="text-xl md:text-2xl font-bold text-violet-300">${element.number}</span>
                        <span class="text-lg md:text-xl font-medium text-slate-300">${element.atomicMass} u</span>
                    </div>

                    <div class="flex-grow flex flex-col justify-center items-center my-2 md:my-0">
                        <h2 class="element-symbol-large text-7xl md:text-8xl lg:text-9xl font-bold" style="text-shadow: 0 0 15px rgba(255,255,255,0.7);">${element.symbol}</h2>
                    </div>

                    <h3 class="element-name-large text-xl md:text-2xl lg:text-3xl font-semibold text-violet-200 text-center">${element.name}</h3>
                </div>

                <!-- Detailed Info Card (Right) -->
                <div id="detailed-info-card"
                     class="bg-slate-800 p-6 sm:p-8 rounded-xl shadow-2xl info-card-glow flex flex-col max-h-[85vh] md:max-h-[80vh] overflow-y-auto"
                     style="width: clamp(300px, 45vw, 520px); transform: perspective(800px) rotateY(-10deg);">

                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1 text-center">
                            <div class="flex items-center justify-center gap-2 sm:gap-3">
                                <h4 class="text-xl sm:text-2xl md:text-3xl font-semibold text-violet-300">${element.name}</h4>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-400 mt-1">${element.category}</p>
                        </div>
                        <button id="close-info-button" class="text-slate-400 hover:text-white text-3xl p-1 -mr-2 -mt-2">×</button>
                    </div>

                    <div class="my-2 sm:my-4 text-center">
                        ${element.modelPath ? `
                        <model-viewer src="${element.modelPath}" alt="3D model of ${element.name}"
                            style="width: 100%; height: 250px; background: transparent; border-radius: 1rem;"
                            camera-controls auto-rotate auto-rotate-delay="0" rotation-per-second="0" interaction-prompt="auto" interaction-prompt-style="wiggle" ar ar-modes="webxr scene-viewer quick-look">
                        </model-viewer>
                        ` : `
                        <div class="atom">
                            <div class="electron-orbit"><div class="electron"></div></div>
                            <div class="electron-orbit"><div class="electron"></div></div>
                            <div class="electron-orbit"><div class="electron"></div></div>
                            <div class="nucleus"></div>
                        </div>
                        `}
                    </div>

                    <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed mb-4 sm:mb-6">
                        ${element.description && element.description.trim() !== ''
                            ? element.description
                            : `${element.name} is a chemical element with symbol ${element.symbol} and atomic number ${element.number}. It belongs to the ${element.category.toLowerCase()} group. The atomic mass of ${element.name} is ${element.atomicMass} u. ${element.meltingPoint !== null ? `It has a melting point of ${element.meltingPoint}°C` : 'Its melting point is not well-defined'}.${element.boilingPoint !== null ? ` and a boiling point of ${element.boilingPoint}°C.` : ' and its boiling point is not well-defined.'}`
                        }
                    </p>

                    <div class="space-y-2 sm:space-y-3 text-xs sm:text-sm md:text-base mt-auto">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Atomic mass:</span>
                            <span class="font-semibold text-white">${element.atomicMass} u</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Melting point:</span>
                            <span class="font-semibold text-white">${element.meltingPoint !== null ? element.meltingPoint + '°C' : 'N/A'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Boiling point:</span>
                            <span class="font-semibold text-white">${element.boilingPoint !== null ? element.boilingPoint + '°C' : 'N/A'}</span>
                        </div>
                         <div class="flex justify-between">
                            <span class="text-slate-400">Group / Period:</span>
                            <span class="font-semibold text-white">${element.group > 0 ? element.group : 'N/A'}, ${element.period <= 7 ? element.period : 'N/A'}</span>
                        </div>
                    </div>
                </div>
            `;
            elementInfoContainer.style.display = 'flex';
            elementInfoContainer.classList.remove('active');
            requestAnimationFrame(() => {
                elementInfoContainer.classList.add('active');
            });

            document.getElementById('close-info-button').addEventListener('click', () => {
                elementInfoContainer.classList.remove('active');
                setTimeout(() => {
                    elementInfoContainer.innerHTML = '';
                    elementInfoContainer.style.display = 'none';
                    periodicTableContainer.classList.remove('blurred');
                    lanthanideRowWrapper.classList.remove('blurred');
                    actinideRowWrapper.classList.remove('blurred');
                    document.body.style.overflowY = 'auto';
                }, 350);
            });
        }

        function renderPeriodicTable() {
            periodicTableContainer.innerHTML = '';
            lanthanidesContainer.innerHTML = '';
            actinidesContainer.innerHTML = '';

            periodicTableData.forEach(element => {
                let tile;
                if (element.category === 'Lanthanide' && element.number >= 58 && element.number <= 71) {
                    tile = createElementTile(element);
                    lanthanidesContainer.appendChild(tile);
                } else if (element.category === 'Actinide' && element.number >= 90 && element.number <= 103) {
                    tile = createElementTile(element);
                    actinidesContainer.appendChild(tile);
                } else if (element.group > 0 && element.period > 0 && element.period <= 7) {
                    const cell = document.createElement('div');
                    cell.style.gridColumnStart = element.group;
                    cell.style.gridRowStart = element.period;
                    tile = createElementTile(element);
                    cell.appendChild(tile);
                    periodicTableContainer.appendChild(cell);
                }
            });

            const laPlaceholderData = { number: '57-71', symbol: 'La*', namePlaceholder: 'Lanthanides', category: 'Lanthanide', group: 3, period: 6 };
            const laPlaceholderTile = createElementTile(laPlaceholderData, true);
            laPlaceholderTile.onclick = () => lanthanidesContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            let cellLa = periodicTableContainer.querySelector(`div[style*="grid-column-start: ${laPlaceholderData.group};"][style*="grid-row-start: ${laPlaceholderData.period};"]`);
            if (!cellLa) { // If La (57) isn't already there, create a cell for the placeholder
                const actualLa = periodicTableData.find(el => el.number === 57);
                if(!actualLa){ // Only add placeholder if actual La is not in main table (which it is)
                    cellLa = document.createElement('div');
                    cellLa.style.gridColumnStart = laPlaceholderData.group;
                    cellLa.style.gridRowStart = laPlaceholderData.period;
                    cellLa.appendChild(laPlaceholderTile);
                    periodicTableContainer.appendChild(cellLa);
                }
            }


            const acPlaceholderData = { number: '89-103', symbol: 'Ac*', namePlaceholder: 'Actinides', category: 'Actinide', group: 3, period: 7 };
            const acPlaceholderTile = createElementTile(acPlaceholderData, true);
            acPlaceholderTile.onclick = () => actinidesContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            let cellAc = periodicTableContainer.querySelector(`div[style*="grid-column-start: ${acPlaceholderData.group};"][style*="grid-row-start: ${acPlaceholderData.period};"]`);
             if (!cellAc) {
                const actualAc = periodicTableData.find(el => el.number === 89);
                 if(!actualAc){
                    cellAc = document.createElement('div');
                    cellAc.style.gridColumnStart = acPlaceholderData.group;
                    cellAc.style.gridRowStart = acPlaceholderData.period;
                    cellAc.appendChild(acPlaceholderTile);
                    periodicTableContainer.appendChild(cellAc);
                }
            }
            // Create empty cells for the gap visually (groups 4-17 for periods 6 and 7)
            // This is mostly for any visual styling of empty space, actual element positioning is by grid.
            for (let period of [6, 7]) {
                if (period === 6 && periodicTableData.find(el => el.number === 57 && el.group === 3)) continue; // Skip if La is there
                if (period === 7 && periodicTableData.find(el => el.number === 89 && el.group === 3)) continue; // Skip if Ac is there
                for (let group = 4; group <= 17; group++) { // Groups 4-17 are empty in these rows
                    const emptyCell = document.createElement('div');
                    emptyCell.style.gridColumnStart = group;
                    emptyCell.style.gridRowStart = period;
                    emptyCell.style.visibility = 'hidden'; // Make them take space but be invisible
                    periodicTableContainer.appendChild(emptyCell);
                }
            }
        }
    </script>
    </body>
</html>