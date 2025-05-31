document.addEventListener('DOMContentLoaded', function() {
    console.log('=== PROJECT FORM SCRIPT LOADED ===');
    
    const addProjectBtn = document.getElementById('add-project-btn');
    const addProjectEmptyBtn = document.getElementById('add-project-empty-btn');
    const projectFormCard = document.getElementById('project-form-card');
    const projectForm = document.getElementById('project-form');
    const cancelBtn = document.getElementById('cancel-btn');
    const formTitle = document.getElementById('form-title');
    const formMethod = document.getElementById('form-method');
    const projectId = document.getElementById('project-id');

    // Debug: Cek semua elemen
    console.log('Elements check:', {
        addProjectBtn: !!addProjectBtn,
        addProjectEmptyBtn: !!addProjectEmptyBtn,
        projectFormCard: !!projectFormCard,
        projectForm: !!projectForm,
        cancelBtn: !!cancelBtn,
        formTitle: !!formTitle,
        formMethod: !!formMethod,
        projectId: !!projectId
    });

    if (!projectForm) {
        console.error('CRITICAL: Project form not found!');
        return;
    }

    // Debug: Cek form attributes awal
    console.log('Initial form state:', {
        action: projectForm.action,
        method: projectForm.method,
        enctype: projectForm.enctype
    });

    // Show add project form
    function showAddForm() {
        console.log('showAddForm() called');
        
        // Reset form
        projectForm.reset();
        
        // Set form untuk mode add
        if (formTitle) formTitle.textContent = 'Tambah Proyek Baru';
        if (formMethod) formMethod.value = 'POST';
        if (projectId) projectId.value = '';
        
        // Set form action - PENTING!
        const baseUrl = window.baseUrl || '';
        const newAction = baseUrl + '/projects';
        projectForm.action = newAction;
        
        console.log('Form configured for ADD:', {
            action: projectForm.action,
            method: formMethod ? formMethod.value : 'N/A',
            title: formTitle ? formTitle.textContent : 'N/A'
        });
        
        // Show form
        if (projectFormCard) {
            projectFormCard.style.display = 'block';
            projectFormCard.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // Hide project form
    function hideForm() {
        console.log('hideForm() called');
        if (projectFormCard) {
            projectFormCard.style.display = 'none';
        }
        if (projectForm) {
            projectForm.reset();
        }
    }

    // Event listeners
    if (addProjectBtn) {
        addProjectBtn.addEventListener('click', function(e) {
            console.log('Add project button clicked');
            e.preventDefault();
            showAddForm();
        });
        console.log('Add project button listener attached');
    } else {
        console.warn('Add project button not found');
    }
    
    if (addProjectEmptyBtn) {
        addProjectEmptyBtn.addEventListener('click', function(e) {
            console.log('Add project empty button clicked');
            e.preventDefault();
            showAddForm();
        });
        console.log('Add project empty button listener attached');
    } else {
        console.warn('Add project empty button not found');
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            console.log('Cancel button clicked');
            e.preventDefault();
            hideForm();
        });
        console.log('Cancel button listener attached');
    } else {
        console.warn('Cancel button not found');
    }

    // FORM SUBMIT HANDLER - YANG PALING PENTING
    projectForm.addEventListener('submit', function(e) {
        console.log('=== FORM SUBMIT EVENT TRIGGERED ===');
        
        // Debug: Log semua data form
        const formData = new FormData(projectForm);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        console.log('Form submit details:', {
            action: projectForm.action,
            method: projectForm.method,
            enctype: projectForm.enctype,
            data: data
        });

        // Cek CSRF token
        const csrfToken = document.querySelector('input[name="_token"]');
        console.log('CSRF Token:', csrfToken ? csrfToken.value : 'NOT FOUND');

        // Get form fields
        const title = document.getElementById('project-title');
        const description = document.getElementById('project-description');
        const startDate = document.getElementById('start-date');
        const endDate = document.getElementById('end-date');
        const status = document.getElementById('project-status');
        
        console.log('Form fields:', {
            title: title ? title.value : 'FIELD NOT FOUND',
            description: description ? description.value : 'FIELD NOT FOUND',
            startDate: startDate ? startDate.value : 'FIELD NOT FOUND',
            endDate: endDate ? endDate.value : 'FIELD NOT FOUND',
            status: status ? status.value : 'FIELD NOT FOUND'
        });

        // Validation
        if (!title || !title.value.trim()) {
            e.preventDefault();
            console.log('VALIDATION FAILED: Title empty');
            alert('Silakan masukkan judul proyek');
            return false;
        }

        if (!description || !description.value.trim()) {
            e.preventDefault();
            console.log('VALIDATION FAILED: Description empty');
            alert('Silakan masukkan deskripsi proyek');
            return false;
        }

        if (!startDate || !startDate.value) {
            e.preventDefault();
            console.log('VALIDATION FAILED: Start date empty');
            alert('Silakan pilih tanggal mulai');
            return false;
        }

        if (!endDate || !endDate.value) {
            e.preventDefault();
            console.log('VALIDATION FAILED: End date empty');
            alert('Silakan pilih tanggal selesai');
            return false;
        }

        if (new Date(startDate.value) > new Date(endDate.value)) {
            e.preventDefault();
            console.log('VALIDATION FAILED: Start date > End date');
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
            return false;
        }

        console.log('✅ VALIDATION PASSED - Form will submit');
        console.log('Final form action:', projectForm.action);
        console.log('Final form method:', projectForm.method);
        
        // Form akan submit secara normal
        return true;
    });

    console.log('Form submit listener attached');

    // Edit functionality
    document.querySelectorAll('.btn-edit').forEach(function(button) {
        button.addEventListener('click', function() {
            console.log('Edit button clicked');
            const projectIdValue = this.getAttribute('data-project-id');
            
            // Find project data
            const project = window.projectsData && window.projectsData.data ? 
                window.projectsData.data.find(p => p.id == projectIdValue) :
                (window.projectsData ? window.projectsData.find(p => p.id == projectIdValue) : null);
            
            if (!project) {
                console.error('Project not found:', {
                    searchId: projectIdValue,
                    availableData: window.projectsData
                });
                alert('Data proyek tidak ditemukan!');
                return;
            }

            console.log('Editing project:', project);

            // Fill form for edit
            if (formTitle) formTitle.textContent = 'Edit Proyek';
            if (formMethod) formMethod.value = 'PUT';
            if (projectId) projectId.value = project.id;
            
            // Fill form fields
            if (document.getElementById('project-title')) 
                document.getElementById('project-title').value = project.title;
            if (document.getElementById('project-description')) 
                document.getElementById('project-description').value = project.description;
            if (document.getElementById('start-date')) 
                document.getElementById('start-date').value = project.start_date;
            if (document.getElementById('end-date')) 
                document.getElementById('end-date').value = project.end_date;
            if (document.getElementById('project-status')) 
                document.getElementById('project-status').value = project.status;
            
            // Set form action for edit
            const baseUrl = window.baseUrl || '';
            projectForm.action = baseUrl + '/projects/' + project.id;
            
            console.log('Form configured for EDIT:', {
                action: projectForm.action,
                method: formMethod ? formMethod.value : 'N/A',
                projectId: project.id
            });
            
            // Show form
            if (projectFormCard) {
                projectFormCard.style.display = 'block';
                projectFormCard.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Test function - panggil dari console
    window.debugForm = function() {
        console.log('=== FORM DEBUG INFO ===');
        console.log('Form element:', projectForm);
        console.log('Form action:', projectForm.action);
        console.log('Form method:', projectForm.method);
        console.log('Form data:', new FormData(projectForm));
        console.log('Window data:', {
            baseUrl: window.baseUrl,
            csrfToken: window.csrfToken,
            projectsData: window.projectsData
        });
    };

    // Test submit function
    window.testSubmit = function() {
        console.log('=== TESTING FORM SUBMIT ===');
        
        // Fill with test data
        document.getElementById('project-title').value = 'Test Project ' + Date.now();
        document.getElementById('project-description').value = 'Test Description';
        document.getElementById('start-date').value = '2025-06-01';
        document.getElementById('end-date').value = '2025-06-30';
        document.getElementById('project-status').value = 'progress';
        
        console.log('Test data filled, submitting form...');
        projectForm.submit();
    };

    console.log('=== PROJECT FORM SCRIPT INITIALIZED ===');
    console.log('Available debug functions: debugForm(), testSubmit()');
});

// Global error handler
window.addEventListener('error', function(e) {
    console.error('Global JavaScript Error:', e.error);
});

// Form submission monitor
document.addEventListener('beforeunload', function(e) {
    console.log('Page unloading - form might have submitted');
});