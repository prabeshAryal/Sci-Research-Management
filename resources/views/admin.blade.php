<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CRUD Interface</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .container { margin-top: 2rem; }
        h1 { margin-bottom: 2rem; }
        .tab-content { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px #0001; }
    </style>
</head>
<body>
<div class="container">
    <h1>Backend Management - CRUD Interface</h1>
    <ul class="nav nav-tabs" id="crudTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="experiments-tab" data-bs-toggle="tab" data-bs-target="#experiments" type="button" role="tab">Experiments</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="researchers-tab" data-bs-toggle="tab" data-bs-target="#researchers" type="button" role="tab">Researchers</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="equipment-tab" data-bs-toggle="tab" data-bs-target="#equipment" type="button" role="tab">Equipment</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="observations-tab" data-bs-toggle="tab" data-bs-target="#observations" type="button" role="tab">Observations</button>
        </li>
    </ul>
    <div class="tab-content mt-3" id="crudTabsContent">
        <div class="tab-pane fade show active" id="experiments" role="tabpanel">
            <div id="experiments-crud"></div>
        </div>
        <div class="tab-pane fade" id="researchers" role="tabpanel">
            <div id="researchers-crud"></div>
        </div>
        <div class="tab-pane fade" id="equipment" role="tabpanel">
            <div id="equipment-crud"></div>
        </div>
        <div class="tab-pane fade" id="observations" role="tabpanel">
            <div id="observations-crud"></div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Helper to fetch and render data for each entity
async function fetchAndRender(entity, containerId, fields, apiUrl) {
    const container = document.getElementById(containerId);
    container.innerHTML = '<div>Loading...</div>';
    try {
        const res = await fetch(apiUrl);
        const data = await res.json();
        let html = `<button class='btn btn-success mb-2' onclick='show${entity}Form()'>Add New</button>`;
        html += `<table class='table table-bordered'><thead><tr>`;
        fields.forEach(f => html += `<th>${f}</th>`);
        html += `<th>Actions</th></tr></thead><tbody>`;
        data.forEach(item => {
            html += '<tr>';
            fields.forEach(f => html += `<td>${item[f] ?? ''}</td>`);
            html += `<td><button class='btn btn-sm btn-primary' onclick='edit${entity}(${item.id})'>Edit</button> <button class='btn btn-sm btn-danger' onclick='delete${entity}(${item.id})'>Delete</button></td>`;
            html += '</tr>';
        });
        html += '</tbody></table>';
        container.innerHTML = html;
    } catch (e) {
        container.innerHTML = '<div class="text-danger">Failed to load data.</div>';
    }
}

// --- CRUD Modal and Form Logic ---
async function showExperimentForm(id = null) {
    // Fetch researchers and equipment for select options
    const [researchers, equipment, experiment] = await Promise.all([
        fetch('/api/researchers').then(r => r.json()),
        fetch('/api/equipment').then(r => r.json()),
        id ? fetch(`/api/experiments/${id}`).then(r => r.json()) : Promise.resolve(null)
    ]);
    let formHtml = `<form id='experimentForm'>
        <div class='mb-2'><input class='form-control' name='title' placeholder='Title' required value='${experiment ? experiment.title : ''}'></div>
        <div class='mb-2'><textarea class='form-control' name='description' placeholder='Description'>${experiment ? (experiment.description || '') : ''}</textarea></div>
        <div class='mb-2'><input class='form-control' name='start_date' type='date' required value='${experiment ? experiment.start_date : ''}'></div>
        <div class='mb-2'><input class='form-control' name='end_date' type='date' value='${experiment ? (experiment.end_date || '') : ''}'></div>
        <div class='mb-2'>
            <label>Researchers</label>
            <select class='form-select' name='researcher_ids' multiple required>
                ${researchers.map(r => `<option value='${r.id}' ${experiment && experiment.researchers.some(er => er.id === r.id) ? 'selected' : ''}>${r.name}</option>`).join('')}
            </select>
        </div>
        <div class='mb-2'>
            <label>Equipment</label>
            <select class='form-select' name='equipment_ids' multiple required>
                ${equipment.map(eq => `<option value='${eq.id}' ${experiment && experiment.equipment.some(ee => ee.id === eq.id) ? 'selected' : ''}>${eq.name}</option>`).join('')}
            </select>
        </div>
        <button type='submit' class='btn btn-success'>Save</button>
        <button type='button' class='btn btn-secondary' onclick='closeModal()'>Cancel</button>
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
    let formHtml = `<form id='researcherForm'>
        <div class='mb-2'><input class='form-control' name='name' placeholder='Name' required value='${researcher ? researcher.name : ''}'></div>
        <div class='mb-2'><input class='form-control' name='email' placeholder='Email' required type='email' value='${researcher ? researcher.email : ''}'></div>
        <div class='mb-2'><input class='form-control' name='institution' placeholder='Institution' value='${researcher ? (researcher.institution || '') : ''}'></div>
        <button type='submit' class='btn btn-success'>Save</button>
        <button type='button' class='btn btn-secondary' onclick='closeModal()'>Cancel</button>
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
    let formHtml = `<form id='equipmentForm'>
        <div class='mb-2'><input class='form-control' name='name' placeholder='Name' required value='${equipment ? equipment.name : ''}'></div>
        <div class='mb-2'><input class='form-control' name='manufacturer' placeholder='Manufacturer' value='${equipment ? (equipment.manufacturer || '') : ''}'></div>
        <div class='mb-2'><input class='form-control' name='serial_number' placeholder='Serial Number' required value='${equipment ? equipment.serial_number : ''}'></div>
        <button type='submit' class='btn btn-success'>Save</button>
        <button type='button' class='btn btn-secondary' onclick='closeModal()'>Cancel</button>
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
    // Fetch experiments for select options
    const [experiments, observation] = await Promise.all([
        fetch('/api/experiments').then(r => r.json()),
        id ? fetch(`/api/observations/${id}`).then(r => r.json()) : Promise.resolve(null)
    ]);
    let formHtml = `<form id='observationForm'>
        <div class='mb-2'>
            <label>Experiment</label>
            <select class='form-select' name='experiment_id' required>
                ${experiments.map(ex => `<option value='${ex.id}' ${observation && observation.experiment_id == ex.id ? 'selected' : ''}>${ex.title}</option>`).join('')}
            </select>
        </div>
        <div class='mb-2'><input class='form-control' name='observation_date' type='date' required value='${observation ? observation.observation_date : ''}'></div>
        <div class='mb-2'><input class='form-control' name='data' placeholder='Data' required value='${observation ? observation.data : ''}'></div>
        <div class='mb-2'><input class='form-control' name='notes' placeholder='Notes' value='${observation ? (observation.notes || '') : ''}'></div>
        <button type='submit' class='btn btn-success'>Save</button>
        <button type='button' class='btn btn-secondary' onclick='closeModal()'>Cancel</button>
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
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100vw';
        modal.style.height = '100vh';
        modal.style.background = 'rgba(0,0,0,0.3)';
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
        modal.innerHTML = `<div style='background:#fff;padding:2rem;border-radius:8px;min-width:300px;max-width:90vw;'>
            <h4>${title}</h4>
            <div id='modalContent'>${content}</div>
        </div>`;
        document.body.appendChild(modal);
    } else {
        document.getElementById('modalContent').innerHTML = content;
        modal.style.display = 'flex';
    }
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
</script>
</body>
</html>
