<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Research Management System</title>
    <!-- TODO: Replace with proper asset compilation in production -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000000;
            color: #e0e0e0;
            min-height: 100vh;
        }

        .api-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.3s ease;
        }

        .api-card:hover {
            transform: translateY(-5px);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        .method-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
        }

        .method-get { background-color: #059669; }
        .method-post { background-color: #2563eb; }
        .method-put { background-color: #d97706; }
        .method-delete { background-color: #dc2626; }
        .method-patch { background-color: #7c3aed; }

        .terminal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: none;
            padding: 2rem;
            overflow-y: auto;
        }

        .terminal-container {
            background-color: #1a1a1a;
            border-radius: 12px;
            padding: 1.5rem;
            font-family: 'JetBrains Mono', monospace;
            color: #00ff00;
            max-width: 800px;
            margin: 2rem auto;
            border: 1px solid rgba(99, 102, 241, 0.3);
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.2);
            position: relative;
            z-index: 1001;
        }

        .terminal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .terminal-title {
            font-size: 1.1rem;
            color: #e0e0e0;
            font-weight: 600;
        }

        .close-terminal {
            color: #e0e0e0;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.25rem;
            line-height: 1;
        }

        .close-terminal:hover {
            color: #ff4444;
        }

        .terminal-input {
            background-color: transparent;
            border: none;
            color: #00ff00;
            font-family: 'JetBrains Mono', monospace;
            width: 100%;
            outline: none;
            font-size: 0.9rem;
        }

        .terminal-response {
            white-space: pre-wrap;
            word-break: break-all;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            max-height: 400px;
            overflow-y: auto;
        }

        .curl-command {
            color: #ffd700;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 0.75rem;
            border-radius: 6px;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .request-body {
            background-color: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 0.75rem;
            border-radius: 6px;
            margin-top: 0.5rem;
            font-family: 'JetBrains Mono', monospace;
            width: 100%;
            min-height: 100px;
            resize: vertical;
            font-size: 0.9rem;
        }

        .execute-btn {
            background-color: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .execute-btn:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
        }

        .blur-background {
            filter: blur(8px);
            pointer-events: none;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1e1e2e;
        }
        ::-webkit-scrollbar-thumb {
            background: #4f46e5;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-lg border-b border-indigo-500/20">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-indigo-300">Research Management System</h1>
                    <span class="text-slate-400">|</span>
                    <span class="text-slate-300">API Documentation</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-black hover:bg-slate-900 text-indigo-300 transition-colors border border-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Home</span>
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

    <div class="container mx-auto px-4 pt-24" id="main-content">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($apiRoutes as $route)
            <div class="api-card p-6 rounded-lg">
                <div class="flex items-center space-x-2 mb-4">
                    <span class="method-badge method-{{strtolower($route['method'])}}">{{$route['method']}}</span>
                    <span class="text-slate-300">{{$route['url']}}</span>
                </div>
                <p class="text-slate-400 mb-4">{{$route['desc']}}</p>
                <button onclick="toggleTerminal('{{$route['method']}}', '{{$route['url']}}')" 
                        class="text-indigo-400 hover:text-indigo-300 text-sm flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Try it out</span>
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Terminal Overlay -->
    <div id="terminal-overlay" class="terminal-overlay">
        <div class="terminal-container">
            <div class="terminal-header">
                <div class="terminal-title"></div>
                <div class="close-terminal" onclick="closeTerminal()">×</div>
            </div>
            <div id="url-params-container" class="mb-4" style="display: none;">
                <label class="block text-sm text-slate-400 mb-2">URL Parameters</label>
                <div id="url-params-inputs" class="space-y-2"></div>
            </div>
            <div class="curl-command"></div>
            <div id="request-body-container" class="mt-4" style="display: none;">
                <label class="block text-sm text-slate-400 mb-2">Request Body (JSON)</label>
                <textarea class="request-body" placeholder="Enter JSON request body"></textarea>
            </div>
            <div class="terminal-response"></div>
        </div>
    </div>

    <script>
        let currentMethod = '';
        let currentUrl = '';
        let urlParams = {};

        function extractUrlParams(url) {
            const params = {};
            const matches = url.match(/\{([^}]+)\}/g) || [];
            matches.forEach(match => {
                const paramName = match.slice(1, -1);
                params[paramName] = '';
            });
            return params;
        }

        function createUrlWithParams(url, params) {
            let finalUrl = url;
            Object.entries(params).forEach(([key, value]) => {
                finalUrl = finalUrl.replace(`{${key}}`, value);
            });
            return finalUrl;
        }

        function toggleTerminal(method, url) {
            currentMethod = method;
            currentUrl = url;
            urlParams = extractUrlParams(url);
            
            const overlay = document.getElementById('terminal-overlay');
            const mainContent = document.getElementById('main-content');
            const title = overlay.querySelector('.terminal-title');
            const curlCommand = overlay.querySelector('.curl-command');
            const requestBodyContainer = document.getElementById('request-body-container');
            const requestBody = overlay.querySelector('.request-body');
            const terminalResponse = overlay.querySelector('.terminal-response');
            const urlParamsContainer = document.getElementById('url-params-container');
            const urlParamsInputs = document.getElementById('url-params-inputs');
            
            // Update title
            title.textContent = `${method} ${url}`;
            
            // Handle URL parameters
            if (Object.keys(urlParams).length > 0) {
                urlParamsContainer.style.display = 'block';
                urlParamsInputs.innerHTML = '';
                
                Object.keys(urlParams).forEach(param => {
                    const inputGroup = document.createElement('div');
                    inputGroup.className = 'flex items-center space-x-2';
                    
                    const label = document.createElement('label');
                    label.className = 'text-sm text-slate-400 min-w-[60px]';
                    label.textContent = param;
                    
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'flex-1 bg-black/50 border border-slate-700 rounded px-3 py-1.5 text-sm text-white focus:outline-none focus:border-indigo-500';
                    input.placeholder = `Enter ${param}`;
                    input.value = urlParams[param];
                    
                    input.addEventListener('input', (e) => {
                        urlParams[param] = e.target.value;
                        updateCurlCommand();
                    });
                    
                    inputGroup.appendChild(label);
                    inputGroup.appendChild(input);
                    urlParamsInputs.appendChild(inputGroup);
                });
            } else {
                urlParamsContainer.style.display = 'none';
            }
            
            // Show/hide request body for POST/PUT/PATCH
            requestBodyContainer.style.display = ['POST', 'PUT', 'PATCH'].includes(method) ? 'block' : 'none';
            
            function updateCurlCommand() {
                const finalUrl = createUrlWithParams(currentUrl, urlParams);
                let curlCmd = `curl -X ${method} "${window.location.origin}${finalUrl}"`;
                if (['POST', 'PUT', 'PATCH'].includes(method)) {
                    curlCmd += ` \\\n  -H "Content-Type: application/json" \\\n  -d '${requestBody ? requestBody.value : '{}'}'`;
                }
                curlCommand.textContent = curlCmd;
            }
            
            // Initial curl command
            updateCurlCommand();

            // Add event listener for request body changes
            if (requestBody) {
                requestBody.addEventListener('input', updateCurlCommand);
            }

            // Add execute button if not already present
            if (!overlay.querySelector('.execute-btn')) {
                const executeBtn = document.createElement('button');
                executeBtn.className = 'execute-btn mt-4';
                executeBtn.textContent = 'Execute Request';
                executeBtn.onclick = executeRequest;
                overlay.querySelector('.terminal-container').insertBefore(
                    executeBtn,
                    terminalResponse
                );
            }

            // Show overlay and blur background
            overlay.style.display = 'block';
            mainContent.classList.add('blur-background');
        }

        function closeTerminal() {
            const overlay = document.getElementById('terminal-overlay');
            const mainContent = document.getElementById('main-content');
            overlay.style.display = 'none';
            mainContent.classList.remove('blur-background');
        }

        async function executeRequest() {
            const overlay = document.getElementById('terminal-overlay');
            const requestBody = overlay.querySelector('.request-body');
            const terminalResponse = overlay.querySelector('.terminal-response');
            
            try {
                const finalUrl = createUrlWithParams(currentUrl, urlParams);
                const options = {
                    method: currentMethod,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                };

                if (['POST', 'PUT', 'PATCH'].includes(currentMethod) && requestBody) {
                    options.body = requestBody.value;
                }

                const response = await fetch(finalUrl, options);
                const data = await response.json();
                terminalResponse.textContent = JSON.stringify(data, null, 2);
            } catch (error) {
                terminalResponse.textContent = `Error: ${error.message}`;
            }
        }

        // Close terminal when clicking outside
        document.getElementById('terminal-overlay').addEventListener('click', (e) => {
            if (e.target.id === 'terminal-overlay') {
                closeTerminal();
            }
        });
    </script>
</body>
</html>
