<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Research Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000000;
            color: #e0e0e0;
            min-height: 100vh;
        }

        .container {
            margin-top: 2rem;
            padding-top: 1rem;
        }

        h1 {
            color: #e0e0e0;
            margin-bottom: 2rem;
        }

        .tab-content {
            @apply bg-slate-800/70 backdrop-blur-lg p-8 rounded-lg border border-indigo-500/20;
        }

        .nav-tabs {
            @apply border-b border-indigo-500/20;
        }

        .nav-tabs .nav-link {
            @apply text-slate-200 border border-indigo-500/20 bg-slate-800/70 mr-2;
        }

        .nav-tabs .nav-link:hover {
            @apply border-indigo-500/50 bg-slate-800/90;
        }

        .nav-tabs .nav-link.active {
            @apply text-slate-200 bg-indigo-500/20 border-indigo-500/50;
        }

        .table {
            @apply w-full text-sm text-left border-collapse;
        }

        .table th {
            @apply px-6 py-4 bg-slate-700/50 text-slate-200 font-semibold text-center border-b border-slate-600;
        }

        .table td {
            @apply px-6 py-4 border-b border-slate-700/50 text-slate-300 text-center align-middle;
        }

        .table tr {
            @apply hover:bg-slate-700/30 transition-colors;
        }

        .table tr:last-child td {
            @apply border-b-0;
        }

        .btn {
            @apply px-4 py-2 rounded-lg font-medium transition-all duration-200 inline-flex items-center justify-center;
        }

        .btn-sm {
            @apply px-3 py-1.5 text-sm;
        }

        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow;
        }

        .btn-danger {
            @apply bg-red-600 hover:bg-red-700 text-white shadow-sm hover:shadow;
        }

        .btn-secondary {
            @apply bg-slate-600 hover:bg-slate-700 text-white shadow-sm hover:shadow;
        }

        .btn-success {
            @apply bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm hover:shadow;
        }

        .form-control, .form-select {
            @apply w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400;
            transition: all 0.2s ease;
        }

        .form-control:hover, .form-select:hover {
            @apply border-slate-500;
        }

        .form-control:focus, .form-select:focus {
            @apply outline-none ring-2 ring-indigo-500/50 border-indigo-500 bg-slate-600;
        }

        .form-label {
            @apply block text-slate-300 font-medium mb-2;
        }

        #crudModal {
            @apply fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm;
        }

        #crudModal > div {
            @apply bg-slate-800 border border-indigo-500/20 rounded-xl shadow-xl p-6 min-w-[400px] max-w-[90vw] max-h-[90vh] overflow-y-auto mx-auto;
            transform: translate(-50%, -50%);
            position: fixed;
            top: 50%;
            left: 50%;
        }

        #crudModal h4 {
            @apply text-xl font-semibold text-indigo-300 mb-6 pb-4 border-b border-slate-700;
        }

        .modal-content {
            @apply space-y-4;
        }

        .form-group {
            @apply mb-4;
        }

        .modal-footer {
            @apply flex justify-end space-x-3 mt-6 pt-4 border-t border-slate-700;
        }

        .action-buttons {
            @apply flex items-center justify-center space-x-2;
        }

        .action-buttons .btn {
            @apply min-w-[80px];
        }

        ::-webkit-scrollbar {
            @apply w-2;
        }
        ::-webkit-scrollbar-track {
            @apply bg-slate-800;
        }
        ::-webkit-scrollbar-thumb {
            @apply bg-indigo-600 rounded;
        }
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-indigo-500;
        }

        .text-danger {
            color: #ef4444 !important;
        }

        .nav-link {
            @apply text-slate-300 hover:text-indigo-300 transition-colors duration-200;
        }
        
        .nav-link.active {
            @apply text-indigo-300 border-b-2 border-indigo-500;
        }

        .section-content {
            @apply transition-all duration-300;
        }
    </style>
</head>
<body class="bg-black text-slate-200 min-h-screen">
    <!-- Navigation Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-lg border-b border-indigo-500/20">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <h1 class="text-xl font-bold text-indigo-300">Research Management System</h1>
                    <span class="text-slate-400">|</span>
                    <span class="text-sm text-slate-300">Admin Panel</span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="/" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-black hover:bg-slate-900 text-indigo-300 transition-colors border border-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="text-sm">Home</span>
                    </a>
                    <a href="/api" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-black hover:bg-slate-900 text-violet-300 transition-colors border border-violet-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm">API Documentation</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 pt-20">
        <div class="bg-slate-800/50 backdrop-blur-lg rounded-xl border border-indigo-500/20 p-6 mb-8">
            <h1 class="text-2xl font-bold text-indigo-300 mb-2">Backend Management</h1>
            <p class="text-slate-400 text-sm">Manage experiments, researchers, equipment, and observations</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-slate-800/50 backdrop-blur-lg rounded-xl border border-indigo-500/20 p-4">
                    <nav class="space-y-2">
                        <button onclick="showSection('experiments')" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg bg-slate-700/50 hover:bg-slate-700 text-indigo-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            <span>Experiments</span>
                        </button>
                        <button onclick="showSection('researchers')" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-slate-700/50 text-slate-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Researchers</span>
                        </button>
                        <button onclick="showSection('equipment')" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-slate-700/50 text-slate-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Equipment</span>
                        </button>
                        <button onclick="showSection('observations')" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-slate-700/50 text-slate-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <span>Observations</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <div class="bg-slate-800/50 backdrop-blur-lg rounded-xl border border-indigo-500/20 p-6">
                    <div id="experiments-section" class="section-content">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-indigo-300">Experiments</h2>
                            <button onclick="showExperimentForm()" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Add Experiment</span>
                            </button>
                        </div>
                        <div id="experiments-crud" class="bg-slate-800/30 rounded-lg p-4"></div>
                    </div>

                    <div id="researchers-section" class="section-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-indigo-300">Researchers</h2>
                            <button onclick="showResearcherForm()" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Add Researcher</span>
                            </button>
                        </div>
                        <div id="researchers-crud" class="bg-slate-800/30 rounded-lg p-4"></div>
                    </div>

                    <div id="equipment-section" class="section-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-indigo-300">Equipment</h2>
                            <button onclick="showEquipmentForm()" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Add Equipment</span>
                            </button>
                        </div>
                        <div id="equipment-crud" class="bg-slate-800/30 rounded-lg p-4"></div>
                    </div>

                    <div id="observations-section" class="section-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-indigo-300">Observations</h2>
                            <button onclick="showObservationForm()" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Add Observation</span>
                            </button>
                        </div>
                        <div id="observations-crud" class="bg-slate-800/30 rounded-lg p-4"></div>
                    </div>
                </div>
        </div>
        </div>
    </div>

<script>
// Helper to fetch and render data for each entity
async function fetchAndRender(entity, containerId, fields, apiUrl) {
    const container = document.getElementById(containerId);
        container.innerHTML = '<div class="text-center text-slate-400">Loading...</div>';
    try {
        const res = await fetch(apiUrl);
        const data = await res.json();
            let html = `
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-700/50">
                                ${fields.map(f => `<th class="px-6 py-4 text-slate-200 font-semibold text-center border-b border-slate-600">${f}</th>`).join('')}
                                <th class="px-6 py-4 text-slate-200 font-semibold text-center border-b border-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>`;
            
        data.forEach(item => {
                html += `
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        ${fields.map(f => `<td class="px-6 py-4 border-b border-slate-700/50 text-slate-300 text-center align-middle">${item[f] ?? ''}</td>`).join('')}
                        <td class="px-6 py-4 border-b border-slate-700/50 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button onclick="edit${entity}(${item.id})" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors shadow-sm hover:shadow">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <button onclick="delete${entity}(${item.id})" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm hover:shadow">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>`;
        });
            
            html += `
                        </tbody>
                    </table>
                </div>`;
        container.innerHTML = html;
    } catch (e) {
            container.innerHTML = '<div class="text-center text-red-500">Failed to load data.</div>';
    }
}

// --- CRUD Modal and Form Logic ---
async function showExperimentForm(id = null) {
    const [researchers, equipment, experiment] = await Promise.all([
        fetch('/api/researchers').then(r => r.json()),
        fetch('/api/equipment').then(r => r.json()),
        id ? fetch(`/api/experiments/${id}`).then(r => r.json()) : Promise.resolve(null)
    ]);
        
        let formHtml = `
            <form id="experimentForm" class="space-y-4">
                <div class="space-y-2">
                    <label class="block text-slate-300 font-medium">Title</label>
                    <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name="title" placeholder="Enter title" required value="${experiment ? experiment.title : ''}">
                </div>
                <div class="space-y-2">
                    <label class="block text-slate-300 font-medium">Description</label>
                    <textarea class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name="description" placeholder="Enter description" rows="3">${experiment ? (experiment.description || '') : ''}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="block text-slate-300 font-medium">Start Date</label>
                    <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name="start_date" type="date" required value="${experiment ? experiment.start_date : ''}">
                </div>
                <div class="space-y-2">
                    <label class="block text-slate-300 font-medium">End Date</label>
                    <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name="end_date" type="date" value="${experiment ? (experiment.end_date || '') : ''}">
                </div>
                <div class="space-y-2">
                    <label class="block text-slate-300 font-medium">Researchers</label>
                    <select class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name="researcher_ids" multiple required>
                        ${researchers.map(r => `<option value="${r.id}" ${experiment && experiment.researchers.some(er => er.id === r.id) ? 'selected' : ''}>${r.name}</option>`).join('')}
            </select>
        </div>
                <div class="space-y-2">
                    <label class="block text-slate-300 font-medium">Equipment</label>
                    <select class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name="equipment_ids" multiple required>
                        ${equipment.map(eq => `<option value="${eq.id}" ${experiment && experiment.equipment.some(ee => ee.id === eq.id) ? 'selected' : ''}>${eq.name}</option>`).join('')}
            </select>
        </div>
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-slate-700">
                    <button type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm hover:shadow" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors shadow-sm hover:shadow">Save Changes</button>
                </div>
    </form>`;
        
    showModal('Experiment', formHtml);
    document.getElementById('experimentForm').onsubmit = async function(e) {
        e.preventDefault();
        const form = e.target;
        const data = {
            title: form.title.value,
            description: form.description.value,
            start_date: form.start_date.value,
            end_date: form.end_date.value,
            researcher_ids: Array.from(form.researcher_ids.selectedOptions).map(o => o.value),
            equipment_ids: Array.from(form.equipment_ids.selectedOptions).map(o => o.value)
        };
        await fetch('/api/experiments' + (id ? '/' + id : ''), {
            method: id ? 'PUT' : 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        closeModal();
        fetchAndRender('Experiment', 'experiments-crud', ['id','title','description','start_date','end_date'], '/api/experiments');
    };
}
async function editExperiment(id) { showExperimentForm(id); }
function deleteExperiment(id) {
    if (confirm('Are you sure you want to delete this experiment?')) {
        fetch(`/api/experiments/${id}`, { method: 'DELETE' })
            .then(() => fetchAndRender('Experiment', 'experiments-crud', ['id','title','description','start_date','end_date'], '/api/experiments'));
    }
}
async function showResearcherForm(id = null) {
    let researcher = null;
    if (id) {
        researcher = await fetch(`/api/researchers/${id}`).then(r => r.json());
    }
        let formHtml = `<form id='researcherForm' class="space-y-4">
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Name</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='name' placeholder='Name' required value='${researcher ? researcher.name : ''}'>
            </div>
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Email</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='email' placeholder='Email' required type='email' value='${researcher ? researcher.email : ''}'>
            </div>
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Institution</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='institution' placeholder='Institution' value='${researcher ? (researcher.institution || '') : ''}'>
            </div>
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-slate-700">
                <button type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm hover:shadow" onclick="closeModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors shadow-sm hover:shadow">Save Changes</button>
            </div>
    </form>`;
    showModal('Researcher', formHtml);
    document.getElementById('researcherForm').onsubmit = async function(e) {
        e.preventDefault();
        const form = e.target;
        const data = {
            name: form.name.value,
            email: form.email.value,
            institution: form.institution.value
        };
        await fetch('/api/researchers' + (id ? '/' + id : ''), {
            method: id ? 'PUT' : 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        closeModal();
        fetchAndRender('Researcher', 'researchers-crud', ['id','name','email','institution'], '/api/researchers');
    };
}
async function editResearcher(id) { showResearcherForm(id); }
function deleteResearcher(id) {
    if (confirm('Are you sure you want to delete this researcher?')) {
        fetch(`/api/researchers/${id}`, { method: 'DELETE' })
            .then(() => fetchAndRender('Researcher', 'researchers-crud', ['id','name','email','institution'], '/api/researchers'));
    }
}
async function showEquipmentForm(id = null) {
    let equipment = null;
    if (id) {
        equipment = await fetch(`/api/equipment/${id}`).then(r => r.json());
    }
        let formHtml = `<form id='equipmentForm' class="space-y-4">
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Name</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='name' placeholder='Name' required value='${equipment ? equipment.name : ''}'>
            </div>
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Manufacturer</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='manufacturer' placeholder='Manufacturer' value='${equipment ? (equipment.manufacturer || '') : ''}'>
            </div>
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Serial Number</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='serial_number' placeholder='Serial Number' required value='${equipment ? equipment.serial_number : ''}'>
            </div>
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-slate-700">
                <button type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm hover:shadow" onclick="closeModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors shadow-sm hover:shadow">Save Changes</button>
            </div>
    </form>`;
    showModal('Equipment', formHtml);
    document.getElementById('equipmentForm').onsubmit = async function(e) {
        e.preventDefault();
        const form = e.target;
        const data = {
            name: form.name.value,
            manufacturer: form.manufacturer.value,
            serial_number: form.serial_number.value
        };
        await fetch('/api/equipment' + (id ? '/' + id : ''), {
            method: id ? 'PUT' : 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        closeModal();
        fetchAndRender('Equipment', 'equipment-crud', ['id','name','manufacturer','serial_number'], '/api/equipment');
    };
}
async function editEquipment(id) { showEquipmentForm(id); }
function deleteEquipment(id) {
    if (confirm('Are you sure you want to delete this equipment?')) {
        fetch(`/api/equipment/${id}`, { method: 'DELETE' })
            .then(() => fetchAndRender('Equipment', 'equipment-crud', ['id','name','manufacturer','serial_number'], '/api/equipment'));
    }
}
async function showObservationForm(id = null) {
    const [experiments, observation] = await Promise.all([
        fetch('/api/experiments').then(r => r.json()),
        id ? fetch(`/api/observations/${id}`).then(r => r.json()) : Promise.resolve(null)
    ]);
        let formHtml = `<form id='observationForm' class="space-y-4">
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Experiment</label>
                <select class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='experiment_id' required>
                ${experiments.map(ex => `<option value='${ex.id}' ${observation && observation.experiment_id == ex.id ? 'selected' : ''}>${ex.title}</option>`).join('')}
            </select>
        </div>
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Observation Date</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='observation_date' type='date' required value='${observation ? observation.observation_date : ''}'>
            </div>
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Data</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='data' placeholder='Data' required value='${observation ? observation.data : ''}'>
            </div>
            <div class="space-y-2">
                <label class="block text-slate-300 font-medium">Notes</label>
                <input class="w-full px-4 py-2.5 rounded-lg bg-slate-700 border border-slate-600 text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" name='notes' placeholder='Notes' value='${observation ? (observation.notes || '') : ''}'>
            </div>
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-slate-700">
                <button type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm hover:shadow" onclick="closeModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors shadow-sm hover:shadow">Save Changes</button>
            </div>
    </form>`;
    showModal('Observation', formHtml);
    document.getElementById('observationForm').onsubmit = async function(e) {
        e.preventDefault();
        const form = e.target;
        const data = {
            experiment_id: form.experiment_id.value,
            observation_date: form.observation_date.value,
            data: form.data.value,
            notes: form.notes.value
        };
        await fetch('/api/observations' + (id ? '/' + id : ''), {
            method: id ? 'PUT' : 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        closeModal();
        fetchAndRender('Observation', 'observations-crud', ['id','experiment_id','observation_date','data','notes'], '/api/observations');
    };
}
async function editObservation(id) { showObservationForm(id); }
function deleteObservation(id) {
    if (confirm('Are you sure you want to delete this observation?')) {
        fetch(`/api/observations/${id}`, { method: 'DELETE' })
            .then(() => fetchAndRender('Observation', 'observations-crud', ['id','experiment_id','observation_date','data','notes'], '/api/observations'));
    }
}
// --- Modal Helper ---
function showModal(title, content) {
    let modal = document.getElementById('crudModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'crudModal';
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm';
        document.body.appendChild(modal);
        }
        
        modal.innerHTML = `
            <div class="bg-slate-800/90 backdrop-blur-lg border border-indigo-500/20 rounded-xl shadow-2xl p-8 min-w-[600px] max-w-[90vw] max-h-[90vh] overflow-y-auto mx-auto transform -translate-x-1/2 -translate-y-1/2 fixed top-1/2 left-1/2">
                <h4 class="text-xl font-semibold text-indigo-300 mb-6 pb-4 border-b border-slate-700">${title}</h4>
                <div class="space-y-4">${content}</div>
            </div>
        `;
        
        modal.style.display = 'flex';
    modal.onclick = function(e) { if (e.target === modal) closeModal(); };
}
function closeModal() {
    let modal = document.getElementById('crudModal');
    if (modal) modal.style.display = 'none';
}

// Render all CRUD tables on load
fetchAndRender('Experiment', 'experiments-crud', ['id','title','description','start_date','end_date'], '/api/experiments');
fetchAndRender('Researcher', 'researchers-crud', ['id','name','email','institution'], '/api/researchers');
fetchAndRender('Equipment', 'equipment-crud', ['id','name','manufacturer','serial_number'], '/api/equipment');
fetchAndRender('Observation', 'observations-crud', ['id','experiment_id','observation_date','data','notes'], '/api/observations');

    // Add this to your existing JavaScript
    function showSection(sectionName) {
        // Hide all sections
        document.querySelectorAll('.section-content').forEach(section => {
            section.classList.add('hidden');
        });
        
        // Show selected section
        document.getElementById(`${sectionName}-section`).classList.remove('hidden');
        
        // Update navigation buttons
        document.querySelectorAll('nav button').forEach(btn => {
            btn.classList.remove('bg-slate-700/50', 'text-indigo-300');
            btn.classList.add('text-slate-300');
        });
        
        // Highlight active button
        const activeBtn = document.querySelector(`nav button[onclick="showSection('${sectionName}')"]`);
        activeBtn.classList.remove('text-slate-300');
        activeBtn.classList.add('bg-slate-700/50', 'text-indigo-300');
    }

    // Initialize with experiments section
    showSection('experiments');
</script>
</body>
</html>
