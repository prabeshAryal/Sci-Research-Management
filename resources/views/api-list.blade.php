<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Research Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    <div class="container mx-auto px-4 pt-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($apiRoutes as $route)
            <div class="api-card p-6 rounded-lg">
                <div class="flex items-center space-x-2 mb-4">
                    <span class="method-badge method-{{strtolower($route['method'])}}">{{$route['method']}}</span>
                    <span class="text-slate-300">{{$route['url']}}</span>
                </div>
                <p class="text-slate-400">{{$route['desc']}}</p>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
