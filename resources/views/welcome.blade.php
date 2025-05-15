<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Periodic Table</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        }

        .blurred {
            filter: blur(5px); opacity: 0.3; pointer-events: none;
        }
        .lanthanide-row, .actinide-row {
            display: grid; grid-template-columns: repeat(15, minmax(30px, 1fr));
            gap: 0.1rem; margin-top: 0.5rem;
            transition: filter 0.3s ease, opacity 0.3s ease; /* Added transition for blur */
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

    </style>
</head>
<body class="bg-black">
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
    <script>
       const periodicTableData = [
            { number: 1, symbol: 'H', name: 'Hydrogen', atomicMass: 1.008, category: 'Nonmetal', meltingPoint: -259.14, boilingPoint: -252.87, group: 1, period: 1 },
            { number: 2, symbol: 'He', name: 'Helium', atomicMass: 4.0026, category: 'Noble Gas', meltingPoint: -272.2, boilingPoint: -268.93, group: 18, period: 1 },
            { number: 3, symbol: 'Li', name: 'Lithium', atomicMass: 6.94, category: 'Alkali Metal', meltingPoint: 180.54, boilingPoint: 1342, group: 1, period: 2 },
            { number: 4, symbol: 'Be', name: 'Beryllium', atomicMass: 9.0122, category: 'Alkaline Earth Metal', meltingPoint: 1287, boilingPoint: 2470, group: 2, period: 2 },
            { number: 5, symbol: 'B', name: 'Boron', atomicMass: 10.81, category: 'Metalloid', meltingPoint: 2076, boilingPoint: 3927, group: 13, period: 2 },
            { number: 6, symbol: 'C', name: 'Carbon', atomicMass: 12.011, category: 'Nonmetal', meltingPoint: 3550, boilingPoint: 4027, group: 14, period: 2 },
            { number: 7, symbol: 'N', name: 'Nitrogen', atomicMass: 14.007, category: 'Nonmetal', meltingPoint: -210.01, boilingPoint: -195.79, group: 15, period: 2 },
            { number: 8, symbol: 'O', name: 'Oxygen', atomicMass: 15.999, category: 'Nonmetal', meltingPoint: -218.79, boilingPoint: -182.95, group: 16, period: 2 },
            { number: 9, symbol: 'F', name: 'Fluorine', atomicMass: 18.998, category: 'Halogen', meltingPoint: -220, boilingPoint: -188.14, group: 17, period: 2 },
            { number: 10, symbol: 'Ne', name: 'Neon', atomicMass: 20.180, category: 'Noble Gas', meltingPoint: -248.59, boilingPoint: -246.08, group: 18, period: 2 },
            { number: 11, symbol: 'Na', name: 'Sodium', atomicMass: 22.990, category: 'Alkali Metal', meltingPoint: 97.79, boilingPoint: 882.9, group: 1, period: 3 },
            { number: 12, symbol: 'Mg', name: 'Magnesium', atomicMass: 24.305, category: 'Alkaline Earth Metal', meltingPoint: 650, boilingPoint: 1090, group: 2, period: 3 },
            { number: 13, symbol: 'Al', name: 'Aluminum', atomicMass: 26.982, category: 'Post-Transition Metal', meltingPoint: 660.32, boilingPoint: 2467, group: 13, period: 3 },
            { number: 14, symbol: 'Si', name: 'Silicon', atomicMass: 28.085, category: 'Metalloid', meltingPoint: 1414, boilingPoint: 3265, group: 14, period: 3 },
            { number: 15, symbol: 'P', name: 'Phosphorus', atomicMass: 30.974, category: 'Nonmetal', meltingPoint: 44.15, boilingPoint: 280, group: 15, period: 3 },
            { number: 16, symbol: 'S', name: 'Sulfur', atomicMass: 32.06, category: 'Nonmetal', meltingPoint: 115.21, boilingPoint: 444.6, group: 16, period: 3 },
            { number: 17, symbol: 'Cl', name: 'Chlorine', atomicMass: 35.45, category: 'Halogen', meltingPoint: -101.5, boilingPoint: -34.04, group: 17, period: 3 },
            { number: 18, symbol: 'Ar', name: 'Argon', atomicMass: 39.95, category: 'Noble Gas', meltingPoint: -189.35, boilingPoint: -185.85, group: 18, period: 3 },
            { number: 19, symbol: 'K', name: 'Potassium', atomicMass: 39.098, category: 'Alkali Metal', meltingPoint: 63.38, boilingPoint: 759, group: 1, period: 4 },
            { number: 20, symbol: 'Ca', name: 'Calcium', atomicMass: 40.078, category: 'Alkaline Earth Metal', meltingPoint: 842, boilingPoint: 1484, group: 2, period: 4 },
            { number: 21, symbol: 'Sc', name: 'Scandium', atomicMass: 44.956, category: 'Transition Metal', meltingPoint: 1541, boilingPoint: 2836, group: 3, period: 4 },
            { number: 22, symbol: 'Ti', name: 'Titanium', atomicMass: 47.867, category: 'Transition Metal', meltingPoint: 1668, boilingPoint: 3287, group: 4, period: 4 },
            { number: 23, symbol: 'V', name: 'Vanadium', atomicMass: 50.942, category: 'Transition Metal', meltingPoint: 1910, boilingPoint: 3407, group: 5, period: 4 },
            { number: 24, symbol: 'Cr', name: 'Chromium', atomicMass: 51.996, category: 'Transition Metal', meltingPoint: 1857, boilingPoint: 2660, group: 6, period: 4 },
            { number: 25, symbol: 'Mn', name: 'Manganese', atomicMass: 54.938, category: 'Transition Metal', meltingPoint: 1246, boilingPoint: 2061, group: 7, period: 4 },
            { number: 26, symbol: 'Fe', name: 'Iron', atomicMass: 55.845, category: 'Transition Metal', meltingPoint: 1538, boilingPoint: 2862, group: 8, period: 4 },
            { number: 27, symbol: 'Co', name: 'Cobalt', atomicMass: 58.933, category: 'Transition Metal', meltingPoint: 1495, boilingPoint: 2927, group: 9, period: 4 },
            { number: 28, symbol: 'Ni', name: 'Nickel', atomicMass: 58.693, category: 'Transition Metal', meltingPoint: 1455, boilingPoint: 2732, group: 10, period: 4 },
            { number: 29, symbol: 'Cu', name: 'Copper', atomicMass: 63.546, category: 'Transition Metal', meltingPoint: 1084.62, boilingPoint: 2562, group: 11, period: 4 },
            { number: 30, symbol: 'Zn', name: 'Zinc', atomicMass: 65.38, category: 'Transition Metal', meltingPoint: 419.53, boilingPoint: 907, group: 12, period: 4 },
            { number: 31, symbol: 'Ga', name: 'Gallium', atomicMass: 69.723, category: 'Post-Transition Metal', meltingPoint: 29.76, boilingPoint: 2204, group: 13, period: 4 },
            { number: 32, symbol: 'Ge', name: 'Germanium', atomicMass: 72.630, category: 'Metalloid', meltingPoint: 938.25, boilingPoint: 2833, group: 14, period: 4 },
            { number: 33, symbol: 'As', name: 'Arsenic', atomicMass: 74.922, category: 'Metalloid', meltingPoint: 816, boilingPoint: 614, group: 15, period: 4 },
            { number: 34, symbol: 'Se', name: 'Selenium', atomicMass: 78.971, category: 'Nonmetal', meltingPoint: 221, boilingPoint: 685, group: 16, period: 4 },
            { number: 35, symbol: 'Br', name: 'Bromine', atomicMass: 79.904, category: 'Halogen', meltingPoint: -7.3, boilingPoint: 58.8, group: 17, period: 4 },
            { number: 36, symbol: 'Kr', name: 'Krypton', atomicMass: 83.798, category: 'Noble Gas', meltingPoint: -157.36, boilingPoint: -153.22, group: 18, period: 4 },
            { number: 37, symbol: 'Rb', name: 'Rubidium', atomicMass: 85.468, category: 'Alkali Metal', meltingPoint: 39.31, boilingPoint: 688, group: 1, period: 5 },
            { number: 38, symbol: 'Sr', name: 'Strontium', atomicMass: 87.62, category: 'Alkaline Earth Metal', meltingPoint: 777, boilingPoint: 1382, group: 2, period: 5 },
            { number: 39, symbol: 'Y', name: 'Yttrium', atomicMass: 88.906, category: 'Transition Metal', meltingPoint: 1526, boilingPoint: 3345, group: 3, period: 5 },
            { number: 40, symbol: 'Zr', name: 'Zirconium', atomicMass: 91.224, category: 'Transition Metal', meltingPoint: 1855, boilingPoint: 4409, group: 4, period: 5 },
            { number: 41, symbol: 'Nb', name: 'Niobium', atomicMass: 92.906, category: 'Transition Metal', meltingPoint: 2468, boilingPoint: 4744, group: 5, period: 5 },
            { number: 42, symbol: 'Mo', name: 'Molybdenum', atomicMass: 95.95, category: 'Transition Metal', meltingPoint: 2623, boilingPoint: 4639, group: 6, period: 5 },
            { number: 43, symbol: 'Tc', name: 'Technetium', atomicMass: 98, category: 'Transition Metal', meltingPoint: 2157, boilingPoint: 4265, group: 7, period: 5 },
            { number: 44, symbol: 'Ru', name: 'Ruthenium', atomicMass: 101.07, category: 'Transition Metal', meltingPoint: 2334, boilingPoint: 4537, group: 8, period: 5 },
            { number: 45, symbol: 'Rh', name: 'Rhodium', atomicMass: 102.91, category: 'Transition Metal', meltingPoint: 1966, boilingPoint: 3695, group: 9, period: 5 },
            { number: 46, symbol: 'Pd', name: 'Palladium', atomicMass: 106.42, category: 'Transition Metal', meltingPoint: 1554.9, boilingPoint: 2963, group: 10, period: 5 },
            { number: 47, symbol: 'Ag', name: 'Silver', atomicMass: 107.87, category: 'Transition Metal', meltingPoint: 961.78, boilingPoint: 2162, group: 11, period: 5 },
            { number: 48, symbol: 'Cd', name: 'Cadmium', atomicMass: 112.41, category: 'Transition Metal', meltingPoint: 321.07, boilingPoint: 767, group: 12, period: 5 },
            { number: 49, symbol: 'In', name: 'Indium', atomicMass: 114.82, category: 'Post-Transition Metal', meltingPoint: 156.6, boilingPoint: 2072, group: 13, period: 5 },
            { number: 50, symbol: 'Sn', name: 'Tin', atomicMass: 118.71, category: 'Post-Transition Metal', meltingPoint: 231.93, boilingPoint: 2602, group: 14, period: 5 },
            { number: 51, symbol: 'Sb', name: 'Antimony', atomicMass: 121.76, category: 'Metalloid', meltingPoint: 630.63, boilingPoint: 1587, group: 15, period: 5 },
            { number: 52, symbol: 'Te', name: 'Tellurium', atomicMass: 127.60, category: 'Metalloid', meltingPoint: 449.51, boilingPoint: 988, group: 16, period: 5 },
            { number: 53, symbol: 'I', name: 'Iodine', atomicMass: 126.90, category: 'Halogen', meltingPoint: 113.7, boilingPoint: 184.3, group: 17, period: 5 },
            { number: 54, symbol: 'Xe', name: 'Xenon', atomicMass: 131.29, category: 'Noble Gas', meltingPoint: -111.8, boilingPoint: -108.09, group: 18, period: 5 },
            { number: 55, symbol: 'Cs', name: 'Cesium', atomicMass: 132.91, category: 'Alkali Metal', meltingPoint: 28.44, boilingPoint: 671, group: 1, period: 6 },
            { number: 56, symbol: 'Ba', name: 'Barium', atomicMass: 137.33, category: 'Alkaline Earth Metal', meltingPoint: 727, boilingPoint: 1897, group: 2, period: 6 },
            { number: 57, symbol: 'La', name: 'Lanthanum', atomicMass: 138.91, category: 'Lanthanide', meltingPoint: 920, boilingPoint: 3454, group: 3, period: 6 },
            { number: 58, symbol: 'Ce', name: 'Cerium', atomicMass: 140.12, category: 'Lanthanide', meltingPoint: 799, boilingPoint: 3443, group: -1, period: 9 },
            { number: 59, symbol: 'Pr', name: 'Praseodymium', atomicMass: 140.91, category: 'Lanthanide', meltingPoint: 935, boilingPoint: 3563, group: -1, period: 9 },
            { number: 60, symbol: 'Nd', name: 'Neodymium', atomicMass: 144.24, category: 'Lanthanide', meltingPoint: 1024, boilingPoint: 3074, group: -1, period: 9 },
            { number: 61, symbol: 'Pm', name: 'Promethium', atomicMass: 145, category: 'Lanthanide', meltingPoint: 1045, boilingPoint: 3000, group: -1, period: 9 },
            { number: 62, symbol: 'Sm', name: 'Samarium', atomicMass: 150.36, category: 'Lanthanide', meltingPoint: 1072, boilingPoint: 1791, group: -1, period: 9 },
            { number: 63, symbol: 'Eu', name: 'Europium', atomicMass: 151.96, category: 'Lanthanide', meltingPoint: 826, boilingPoint: 1529, group: -1, period: 9 },
            { number: 64, symbol: 'Gd', name: 'Gadolinium', atomicMass: 157.25, category: 'Lanthanide', meltingPoint: 1313, boilingPoint: 3273, group: -1, period: 9 },
            { number: 65, symbol: 'Tb', name: 'Terbium', atomicMass: 158.93, category: 'Lanthanide', meltingPoint: 1356, boilingPoint: 3230, group: -1, period: 9 },
            { number: 66, symbol: 'Dy', name: 'Dysprosium', atomicMass: 162.50, category: 'Lanthanide', meltingPoint: 1412, boilingPoint: 2562, group: -1, period: 9 },
            { number: 67, symbol: 'Ho', name: 'Holmium', atomicMass: 164.93, category: 'Lanthanide', meltingPoint: 1470, boilingPoint: 2720, group: -1, period: 9 },
            { number: 68, symbol: 'Er', name: 'Erbium', atomicMass: 167.26, category: 'Lanthanide', meltingPoint: 1529, boilingPoint: 2868, group: -1, period: 9 },
            { number: 69, symbol: 'Tm', name: 'Thulium', atomicMass: 168.93, category: 'Lanthanide', meltingPoint: 1545, boilingPoint: 1950, group: -1, period: 9 },
            { number: 70, symbol: 'Yb', name: 'Ytterbium', atomicMass: 173.05, category: 'Lanthanide', meltingPoint: 824, boilingPoint: 1196, group: -1, period: 9 },
            { number: 71, symbol: 'Lu', name: 'Lutetium', atomicMass: 174.97, category: 'Lanthanide', meltingPoint: 1663, boilingPoint: 3402, group: -1, period: 9 }, // Lu in Group 3 for some tables
            { number: 72, symbol: 'Hf', name: 'Hafnium', atomicMass: 178.49, category: 'Transition Metal', meltingPoint: 2233, boilingPoint: 4603, group: 4, period: 6 },
            { number: 73, symbol: 'Ta', name: 'Tantalum', atomicMass: 180.95, category: 'Transition Metal', meltingPoint: 3017, boilingPoint: 5458, group: 5, period: 6 },
            { number: 74, symbol: 'W', name: 'Tungsten', atomicMass: 183.84, category: 'Transition Metal', meltingPoint: 3422, boilingPoint: 5555, group: 6, period: 6 },
            { number: 75, symbol: 'Re', name: 'Rhenium', atomicMass: 186.21, category: 'Transition Metal', meltingPoint: 3186, boilingPoint: 5596, group: 7, period: 6 },
            { number: 76, symbol: 'Os', name: 'Osmium', atomicMass: 190.23, category: 'Transition Metal', meltingPoint: 3033, boilingPoint: 5012, group: 8, period: 6 },
            { number: 77, symbol: 'Ir', name: 'Iridium', atomicMass: 192.22, category: 'Transition Metal', meltingPoint: 2446, boilingPoint: 4428, group: 9, period: 6 },
            { number: 78, symbol: 'Pt', name: 'Platinum', atomicMass: 195.08, category: 'Transition Metal', meltingPoint: 1768.3, boilingPoint: 3825, group: 10, period: 6 },
            { number: 79, symbol: 'Au', name: 'Gold', atomicMass: 196.97, category: 'Transition Metal', meltingPoint: 1064.18, boilingPoint: 2856, group: 11, period: 6 },
            { number: 80, symbol: 'Hg', name: 'Mercury', atomicMass: 200.59, category: 'Transition Metal', meltingPoint: -38.83, boilingPoint: 356.73, group: 12, period: 6 },
            { number: 81, symbol: 'Tl', name: 'Thallium', atomicMass: 204.38, category: 'Post-Transition Metal', meltingPoint: 303.6, boilingPoint: 1473, group: 13, period: 6 },
            { number: 82, symbol: 'Pb', name: 'Lead', atomicMass: 207.2, category: 'Post-Transition Metal', meltingPoint: 327.46, boilingPoint: 1749, group: 14, period: 6 },
            { number: 83, symbol: 'Bi', name: 'Bismuth', atomicMass: 208.98, category: 'Post-Transition Metal', meltingPoint: 271.4, boilingPoint: 1564, group: 15, period: 6 },
            { number: 84, symbol: 'Po', name: 'Polonium', atomicMass: 209, category: 'Post-Transition Metal', meltingPoint: 254, boilingPoint: 962, group: 16, period: 6 },
            { number: 85, symbol: 'At', name: 'Astatine', atomicMass: 210, category: 'Metalloid', meltingPoint: 302, boilingPoint: 337, group: 17, period: 6 },
            { number: 86, symbol: 'Rn', name: 'Radon', atomicMass: 222, category: 'Noble Gas', meltingPoint: -71, boilingPoint: -61.7, group: 18, period: 6 },
            { number: 87, symbol: 'Fr', name: 'Francium', atomicMass: 223, category: 'Alkali Metal', meltingPoint: 27, boilingPoint: 677, group: 1, period: 7 },
            { number: 88, symbol: 'Ra', name: 'Radium', atomicMass: 226, category: 'Alkaline Earth Metal', meltingPoint: 700, boilingPoint: 1737, group: 2, period: 7 },
            { number: 89, symbol: 'Ac', name: 'Actinium', atomicMass: 227, category: 'Actinide', meltingPoint: 1050, boilingPoint: 3200, group: 3, period: 7 },
            { number: 90, symbol: 'Th', name: 'Thorium', atomicMass: 232.04, category: 'Actinide', meltingPoint: 1750, boilingPoint: 4788, group: -1, period: 10 },
            { number: 91, symbol: 'Pa', name: 'Protactinium', atomicMass: 231.04, category: 'Actinide', meltingPoint: 1568, boilingPoint: 4000, group: -1, period: 10 },
            { number: 92, symbol: 'U', name: 'Uranium', atomicMass: 238.03, category: 'Actinide', meltingPoint: 1132, boilingPoint: 4131, group: -1, period: 10 },
            { number: 93, symbol: 'Np', name: 'Neptunium', atomicMass: 237, category: 'Actinide', meltingPoint: 639, boilingPoint: 4174, group: -1, period: 10 },
            { number: 94, symbol: 'Pu', name: 'Plutonium', atomicMass: 244, category: 'Actinide', meltingPoint: 640, boilingPoint: 3228, group: -1, period: 10 },
            { number: 95, symbol: 'Am', name: 'Americium', atomicMass: 243, category: 'Actinide', meltingPoint: 1176, boilingPoint: 2011, group: -1, period: 10 },
            { number: 96, symbol: 'Cm', name: 'Curium', atomicMass: 247, category: 'Actinide', meltingPoint: 1345, boilingPoint: 3110, group: -1, period: 10 },
            { number: 97, symbol: 'Bk', name: 'Berkelium', atomicMass: 247, category: 'Actinide', meltingPoint: 986, boilingPoint: 2900, group: -1, period: 10 },
            { number: 98, symbol: 'Cf', name: 'Californium', atomicMass: 251, category: 'Actinide', meltingPoint: 900, boilingPoint: 1743, group: -1, period: 10 },
            { number: 99, symbol: 'Es', name: 'Einsteinium', atomicMass: 252, category: 'Actinide', meltingPoint: 860, boilingPoint: 980, group: -1, period: 10 },
            { number: 100, symbol: 'Fm', name: 'Fermium', atomicMass: 257, category: 'Actinide', meltingPoint: 1527, boilingPoint: null, group: -1, period: 10 },
            { number: 101, symbol: 'Md', name: 'Mendelevium', atomicMass: 258, category: 'Actinide', meltingPoint: 827, boilingPoint: null, group: -1, period: 10 },
            { number: 102, symbol: 'No', name: 'Nobelium', atomicMass: 259, category: 'Actinide', meltingPoint: 800, boilingPoint: null, group: -1, period: 10 },
            { number: 103, symbol: 'Lr', name: 'Lawrencium', atomicMass: 262, category: 'Actinide', meltingPoint: 1627, boilingPoint: null, group: -1, period: 10 }, // Lr in Group 3 for some tables
            { number: 104, symbol: 'Rf', name: 'Rutherfordium', atomicMass: 261, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 4, period: 7 },
            { number: 105, symbol: 'Db', name: 'Dubnium', atomicMass: 262, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 5, period: 7 },
            { number: 106, symbol: 'Sg', name: 'Seaborgium', atomicMass: 263, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 6, period: 7 },
            { number: 107, symbol: 'Bh', name: 'Bohrium', atomicMass: 264, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 7, period: 7 },
            { number: 108, symbol: 'Hs', name: 'Hassium', atomicMass: 265, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 8, period: 7 },
            { number: 109, symbol: 'Mt', name: 'Meitnerium', atomicMass: 266, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 9, period: 7 },
            { number: 110, symbol: 'Ds', name: 'Darmstadtium', atomicMass: 269, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 10, period: 7 },
            { number: 111, symbol: 'Rg', name: 'Roentgenium', atomicMass: 272, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 11, period: 7 },
            { number: 112, symbol: 'Cn', name: 'Copernicium', atomicMass: 277, category: 'Transition Metal', meltingPoint: null, boilingPoint: null, group: 12, period: 7 },
            { number: 113, symbol: 'Nh', name: 'Nihonium', atomicMass: 284, category: 'Post-Transition Metal', meltingPoint: null, boilingPoint: null, group: 13, period: 7 },
            { number: 114, symbol: 'Fl', name: 'Flerovium', atomicMass: 289, category: 'Post-Transition Metal', meltingPoint: null, boilingPoint: null, group: 14, period: 7 },
            { number: 115, symbol: 'Mc', name: 'Moscovium', atomicMass: 288, category: 'Post-Transition Metal', meltingPoint: null, boilingPoint: null, group: 15, period: 7 },
            { number: 116, symbol: 'Lv', name: 'Livermorium', atomicMass: 293, category: 'Post-Transition Metal', meltingPoint: null, boilingPoint: null, group: 16, period: 7 },
            { number: 117, symbol: 'Ts', name: 'Tennessine', atomicMass: 294, category: 'Halogen', meltingPoint: null, boilingPoint: null, group: 17, period: 7 },
            { number: 118, symbol: 'Og', name: 'Oganesson', atomicMass: 294, category: 'Noble Gas', meltingPoint: null, boilingPoint: null, group: 18, period: 7 },
        ];

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
                     class="bg-element element-tile-glow p-4 md:p-6 rounded-xl flex flex-col text-white relative items-center justify-around"
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
                        <div>
                            <div class="flex items-baseline gap-2 sm:gap-3">
                                <span class="text-lg sm:text-xl font-bold text-violet-300">${element.number}</span>
                                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">${element.symbol}</h3>
                                <h4 class="text-xl sm:text-2xl md:text-3xl font-semibold text-violet-300">${element.name}</h4>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-400 mt-1">${element.category}</p>
                        </div>
                        <button id="close-info-button" class="text-slate-400 hover:text-white text-3xl p-1 -mr-2 -mt-2">×</button>
                    </div>

                    <div class="my-2 sm:my-4 text-center">
                        <div class="atom">
                            <div class="electron-orbit"><div class="electron"></div></div>
                            <div class="electron-orbit"><div class="electron"></div></div>
                            <div class="electron-orbit"><div class="electron"></div></div>
                            <div class="nucleus"></div>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed mb-4 sm:mb-6">
                        ${element.name} is a chemical element with symbol ${element.symbol} and atomic number ${element.number}.
                        It belongs to the ${element.category.toLowerCase()} group.
                        The atomic mass of ${element.name} is ${element.atomicMass} u.
                        ${element.meltingPoint !== null ? `It has a melting point of ${element.meltingPoint}°C` : 'Its melting point is not well-defined'}.
                        ${element.boilingPoint !== null ? `and a boiling point of ${element.boilingPoint}°C.` : 'and its boiling point is not well-defined.'}
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

            document.getElementById('close-info-button').addEventListener('click', () => {
                elementInfoContainer.innerHTML = '';
                elementInfoContainer.style.display = 'none';
                periodicTableContainer.classList.remove('blurred');
                lanthanideRowWrapper.classList.remove('blurred');
                actinideRowWrapper.classList.remove('blurred');
                document.body.style.overflowY = 'auto';
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
        renderPeriodicTable();
    </script>
</body>
</html>