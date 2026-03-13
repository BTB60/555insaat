/**
 * 555 İNŞAAT - İŞÇİ İDARƏETMƏ SİSTEMİ
 * Main JavaScript File
 */

// ============================================
// INITIAL DATA SETUP
// ============================================
const INITIAL_DATA = {
    users: [
        {
            id: 1,
            username: 'admin',
            password: 'admin123',
            role: 'admin',
            fullName: 'Sistem Admin',
            phone: '055 555 00 00',
            position: 'Administrator',
            department: 'İdarəetmə',
            project: null,
            status: 'active',
            createdAt: '2025-01-01'
        },
        {
            id: 2,
            username: 'murad',
            password: '123456',
            role: 'employee',
            fullName: 'Murad Əliyev',
            phone: '055 555 55 55',
            position: 'Usta',
            department: 'İnşaat',
            project: 'Bakı Layihəsi',
            status: 'active',
            createdAt: '2025-02-15'
        },
        {
            id: 3,
            username: 'resad',
            password: '123456',
            role: 'employee',
            fullName: 'Rəşad Məmmədov',
            phone: '050 444 44 44',
            position: 'Fəhlə',
            department: 'İnşaat',
            project: 'Sumqayıt Obyekti',
            status: 'active',
            createdAt: '2025-02-20'
        },
        {
            id: 4,
            username: 'kamran',
            password: '123456',
            role: 'employee',
            fullName: 'Kamran Həsənov',
            phone: '070 333 33 33',
            position: 'Qaynaqçı',
            department: 'Texniki',
            project: 'Xırdalan Obyekti',
            status: 'inactive',
            createdAt: '2025-03-01'
        }
    ],
    projects: [
        { id: 1, name: 'Bakı Layihəsi', location: 'Bakı', status: 'active' },
        { id: 2, name: 'Sumqayıt Obyekti', location: 'Sumqayıt', status: 'active' },
        { id: 3, name: 'Xırdalan Obyekti', location: 'Xırdalan', status: 'active' }
    ],
    attendance: [],
    salaries: [],
    advances: [
        { id: 1, employeeId: 2, amount: 150, date: '2025-03-15', reason: 'Şəxsi ehtiyac', status: 'approved' },
        { id: 2, employeeId: 3, amount: 100, date: '2025-02-10', reason: 'Şəxsi ehtiyac', status: 'deducted' }
    ],
    fines: [
        { id: 1, employeeId: 2, amount: 20, date: '2025-03-05', reason: 'Gecikmə (15 dəq)', status: 'active' }
    ],
    tasks: [
        { id: 1, employeeId: 2, title: 'Beton tökmə işinə nəzarət', dueDate: '2025-03-20', priority: 'high', status: 'pending' },
        { id: 2, employeeId: 2, title: 'Materialların qəbulu', dueDate: '2025-03-15', priority: 'medium', status: 'completed' }
    ],
    notifications: [
        { id: 1, employeeId: 2, title: 'Maaş ödənişi', message: 'Fevral ayı üzrə maaşınız hesabınıza köçürüldü.', date: '2025-03-10', read: false },
        { id: 2, employeeId: 2, title: 'Yeni cərimə', message: '05.03.2025 tarixində gecikməyə görə 20 ₼ cərimə.', date: '2025-03-05', read: false }
    ]
};

// ============================================
// LOCAL STORAGE MANAGEMENT
// ============================================
const Storage = {
    init() {
        if (!localStorage.getItem('555insaat_data')) {
            localStorage.setItem('555insaat_data', JSON.stringify(INITIAL_DATA));
        }
        if (!localStorage.getItem('555insaat_session')) {
            localStorage.setItem('555insaat_session', JSON.stringify(null));
        }
    },

    getData() {
        return JSON.parse(localStorage.getItem('555insaat_data'));
    },

    setData(data) {
        localStorage.setItem('555insaat_data', JSON.stringify(data));
    },

    getSession() {
        return JSON.parse(localStorage.getItem('555insaat_session'));
    },

    setSession(user) {
        localStorage.setItem('555insaat_session', JSON.stringify(user));
    },

    clearSession() {
        localStorage.setItem('555insaat_session', JSON.stringify(null));
    }
};

// ============================================
// AUTHENTICATION
// ============================================
const Auth = {
    login(username, password) {
        const data = Storage.getData();
        const user = data.users.find(u => u.username === username && u.password === password);
        
        if (user) {
            Storage.setSession(user);
            return { success: true, user };
        }
        return { success: false, message: 'İstifadəçi adı və ya şifrə yanlışdır!' };
    },

    logout() {
        Storage.clearSession();
        window.location.href = 'login.html';
    },

    checkAuth() {
        const session = Storage.getSession();
        if (!session) {
            window.location.href = 'login.html';
            return null;
        }
        return session;
    },

    getCurrentUser() {
        return Storage.getSession();
    },

    updateCurrentUser(userData) {
        const data = Storage.getData();
        const index = data.users.findIndex(u => u.id === userData.id);
        if (index !== -1) {
            data.users[index] = { ...data.users[index], ...userData };
            Storage.setData(data);
            Storage.setSession(data.users[index]);
        }
    }
};

// ============================================
// EMPLOYEE MANAGEMENT (Admin)
// ============================================
const EmployeeManager = {
    getAll() {
        const data = Storage.getData();
        return data.users.filter(u => u.role === 'employee');
    },

    getById(id) {
        const data = Storage.getData();
        return data.users.find(u => u.id === parseInt(id));
    },

    create(employeeData) {
        const data = Storage.getData();
        const newId = Math.max(...data.users.map(u => u.id), 0) + 1;
        
        const newEmployee = {
            id: newId,
            role: 'employee',
            status: 'active',
            createdAt: new Date().toISOString().split('T')[0],
            ...employeeData
        };
        
        data.users.push(newEmployee);
        Storage.setData(data);
        return newEmployee;
    },

    update(id, employeeData) {
        const data = Storage.getData();
        const index = data.users.findIndex(u => u.id === parseInt(id));
        
        if (index !== -1) {
            data.users[index] = { ...data.users[index], ...employeeData };
            Storage.setData(data);
            return data.users[index];
        }
        return null;
    },

    delete(id) {
        const data = Storage.getData();
        data.users = data.users.filter(u => u.id !== parseInt(id));
        Storage.setData(data);
    },

    toggleStatus(id) {
        const employee = this.getById(id);
        if (employee) {
            const newStatus = employee.status === 'active' ? 'inactive' : 'active';
            return this.update(id, { status: newStatus });
        }
        return null;
    }
};

// ============================================
// UI HELPERS
// ============================================
const UI = {
    showError(message) {
        const errorDiv = document.getElementById('error-message');
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.classList.remove('d-none');
            setTimeout(() => errorDiv.classList.add('d-none'), 5000);
        }
    },

    formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('az-AZ');
    },

    getInitials(name) {
        return name ? name.charAt(0).toUpperCase() : 'E';
    },

    generateAvatar(name) {
        const colors = ['#ff8c42', '#1e3a5f', '#2a9d8f', '#e63946', '#457b9d'];
        const color = colors[name.length % colors.length];
        return `<div class="avatar" style="background: ${color}">${this.getInitials(name)}</div>`;
    }
};

// ============================================
// LOGIN PAGE FUNCTIONS
// ============================================
function initLoginPage() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    // Check if already logged in
    const session = Storage.getSession();
    if (session) {
        if (session.role === 'admin') {
            window.location.href = 'admin-dashboard.html';
        } else {
            window.location.href = 'employee-dashboard.html';
        }
        return;
    }

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        
        const result = Auth.login(username, password);
        
        if (result.success) {
            if (result.user.role === 'admin') {
                window.location.href = 'admin-dashboard.html';
            } else {
                window.location.href = 'employee-dashboard.html';
            }
        } else {
            UI.showError(result.message);
        }
    });
}

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const icon = document.querySelector('.toggle-password i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

// ============================================
// ADMIN DASHBOARD FUNCTIONS
// ============================================
function initAdminDashboard() {
    const user = Auth.checkAuth();
    if (!user || user.role !== 'admin') {
        window.location.href = 'login.html';
        return;
    }

    // Update admin info
    document.getElementById('admin-name').textContent = user.fullName;

    // Setup navigation
    setupNavigation();

    // Load dashboard data
    loadDashboardStats();
    loadRecentEmployees();
    loadEmployeesTable();

    // Setup filters
    setupFilters();
}

function setupNavigation() {
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.dataset.page;
            showPage(page);
            
            // Update active nav
            navItems.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

function showPage(pageName) {
    // Hide all pages
    document.querySelectorAll('.page-content').forEach(page => {
        page.classList.remove('active');
    });

    // Show selected page
    const selectedPage = document.getElementById(pageName + '-page');
    if (selectedPage) {
        selectedPage.classList.add('active');
    }

    // Update page title
    const titles = {
        dashboard: { title: 'Dashboard', subtitle: '555 İnşaat idarəetmə panelinə xoş gəlmisiniz' },
        employees: { title: 'İşçilər', subtitle: 'Bütün işçilərin idarə edilməsi' },
        projects: { title: 'Obyektlər', subtitle: 'Obyektlərin idarə edilməsi' },
        attendance: { title: 'Davamiyyət', subtitle: 'Gündəlik davamiyyət qeydləri' },
        salary: { title: 'Maaşlar', subtitle: 'Maaş hesablanması və ödənişlər' },
        advances: { title: 'Avanslar', subtitle: 'Avansların idarə edilməsi' },
        fines: { title: 'Cərimələr', subtitle: 'Cərimələrin idarə edilməsi' },
        tasks: { title: 'Tapşırıqlar', subtitle: 'Tapşırıqların idarə edilməsi' },
        reports: { title: 'Hesabatlar', subtitle: 'Müxtəlif hesabatlar' },
        settings: { title: 'Ayarlar', subtitle: 'Sistem ayarları' }
    };

    const titleInfo = titles[pageName] || titles.dashboard;
    document.getElementById('page-title').textContent = titleInfo.title;
    document.getElementById('page-subtitle').textContent = titleInfo.subtitle;
}

function loadDashboardStats() {
    const employees = EmployeeManager.getAll();
    document.getElementById('total-employees').textContent = employees.length;
    document.getElementById('active-employees').textContent = 
        employees.filter(e => e.status === 'active').length;
}

function loadRecentEmployees() {
    const employees = EmployeeManager.getAll().slice(-3).reverse();
    const tbody = document.getElementById('recent-employees');
    
    tbody.innerHTML = employees.map(emp => `
        <tr>
            <td>
                <div style="display: flex; align-items: center; gap: 12px;">
                    ${UI.generateAvatar(emp.fullName)}
                    <span>${emp.fullName}</span>
                </div>
            </td>
            <td>${emp.phone || '-'}</td>
            <td>${emp.position || '-'}</td>
            <td>${emp.project || '-'}</td>
            <td><span class="badge ${emp.status}">${emp.status === 'active' ? 'Aktiv' : 'Passiv'}</span></td>
        </tr>
    `).join('');
}

function loadEmployeesTable() {
    const employees = EmployeeManager.getAll();
    const tbody = document.getElementById('employees-table');
    
    tbody.innerHTML = employees.map(emp => `
        <tr>
            <td>${emp.id}</td>
            <td>${UI.generateAvatar(emp.fullName)}</td>
            <td>${emp.fullName}</td>
            <td>${emp.username}</td>
            <td>${emp.phone || '-'}</td>
            <td>${emp.position || '-'}</td>
            <td>${emp.project || '-'}</td>
            <td><span class="badge ${emp.status}">${emp.status === 'active' ? 'Aktiv' : 'Passiv'}</span></td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary" onclick="editEmployee(${emp.id})" title="Redaktə">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-secondary" onclick="toggleEmployeeStatus(${emp.id})" title="Status dəyiş">
                        <i class="bi bi-toggle-${emp.status === 'active' ? 'on' : 'off'}"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteEmployee(${emp.id})" title="Sil">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function setupFilters() {
    const searchInput = document.getElementById('employee-search');
    const statusFilter = document.getElementById('status-filter');

    if (searchInput) {
        searchInput.addEventListener('input', filterEmployees);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterEmployees);
    }
}

function filterEmployees() {
    const searchTerm = document.getElementById('employee-search')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('status-filter')?.value || '';
    
    let employees = EmployeeManager.getAll();
    
    if (searchTerm) {
        employees = employees.filter(emp => 
            emp.fullName.toLowerCase().includes(searchTerm) ||
            emp.username.toLowerCase().includes(searchTerm) ||
            (emp.phone && emp.phone.includes(searchTerm))
        );
    }
    
    if (statusFilter) {
        employees = employees.filter(emp => emp.status === statusFilter);
    }
    
    const tbody = document.getElementById('employees-table');
    tbody.innerHTML = employees.map(emp => `
        <tr>
            <td>${emp.id}</td>
            <td>${UI.generateAvatar(emp.fullName)}</td>
            <td>${emp.fullName}</td>
            <td>${emp.username}</td>
            <td>${emp.phone || '-'}</td>
            <td>${emp.position || '-'}</td>
            <td>${emp.project || '-'}</td>
            <td><span class="badge ${emp.status}">${emp.status === 'active' ? 'Aktiv' : 'Passiv'}</span></td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary" onclick="editEmployee(${emp.id})" title="Redaktə">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-secondary" onclick="toggleEmployeeStatus(${emp.id})" title="Status dəyiş">
                        <i class="bi bi-toggle-${emp.status === 'active' ? 'on' : 'off'}"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteEmployee(${emp.id})" title="Sil">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Employee Modal Functions
let editingEmployeeId = null;

function openEmployeeModal() {
    editingEmployeeId = null;
    document.getElementById('modal-title').textContent = 'Yeni İşçi Əlavə Et';
    document.getElementById('employeeForm').reset();
    document.getElementById('employeeModal').classList.add('active');
}

function editEmployee(id) {
    const employee = EmployeeManager.getById(id);
    if (!employee) return;
    
    editingEmployeeId = id;
    document.getElementById('modal-title').textContent = 'İşçini Redaktə Et';
    
    document.getElementById('emp-fullname').value = employee.fullName;
    document.getElementById('emp-username').value = employee.username;
    document.getElementById('emp-password').value = employee.password;
    document.getElementById('emp-phone').value = employee.phone || '';
    document.getElementById('emp-position').value = employee.position || '';
    document.getElementById('emp-department').value = employee.department || '';
    document.getElementById('emp-project').value = employee.project || '';
    document.getElementById('emp-status').value = employee.status;
    
    document.getElementById('employeeModal').classList.add('active');
}

function closeEmployeeModal() {
    document.getElementById('employeeModal').classList.remove('active');
    editingEmployeeId = null;
}

function saveEmployee() {
    const employeeData = {
        fullName: document.getElementById('emp-fullname').value,
        username: document.getElementById('emp-username').value,
        password: document.getElementById('emp-password').value,
        phone: document.getElementById('emp-phone').value,
        position: document.getElementById('emp-position').value,
        department: document.getElementById('emp-department').value,
        project: document.getElementById('emp-project').value,
        status: document.getElementById('emp-status').value
    };

    if (!employeeData.fullName || !employeeData.username || !employeeData.password) {
        alert('Zəhmət olmasa bütün vacib sahələri doldurun!');
        return;
    }

    if (editingEmployeeId) {
        EmployeeManager.update(editingEmployeeId, employeeData);
    } else {
        EmployeeManager.create(employeeData);
    }

    closeEmployeeModal();
    loadEmployeesTable();
    loadRecentEmployees();
    loadDashboardStats();
}

function toggleEmployeeStatus(id) {
    EmployeeManager.toggleStatus(id);
    loadEmployeesTable();
    loadDashboardStats();
}

function deleteEmployee(id) {
    if (confirm('Bu işçini silmək istədiyinizə əminsiniz?')) {
        EmployeeManager.delete(id);
        loadEmployeesTable();
        loadDashboardStats();
    }
}

// ============================================
// EMPLOYEE DASHBOARD FUNCTIONS
// ============================================
function initEmployeeDashboard() {
    const user = Auth.checkAuth();
    if (!user || user.role !== 'employee') {
        window.location.href = 'login.html';
        return;
    }

    // Update employee info
    document.getElementById('emp-name').textContent = user.fullName;
    document.getElementById('emp-avatar').textContent = UI.getInitials(user.fullName);
    document.getElementById('profile-initial').textContent = UI.getInitials(user.fullName);
    document.getElementById('profile-name').textContent = user.fullName;
    document.getElementById('profile-position').textContent = user.position || 'İşçi';

    // Fill profile info
    document.getElementById('info-name').textContent = user.fullName;
    document.getElementById('info-username').textContent = user.username;
    document.getElementById('info-phone').textContent = user.phone || '-';
    document.getElementById('info-position').textContent = user.position || '-';
    document.getElementById('info-department').textContent = user.department || '-';
    document.getElementById('info-project').textContent = user.project || '-';
    document.getElementById('info-joined').textContent = UI.formatDate(user.createdAt);

    // Setup navigation
    setupEmployeeNavigation();

    // Setup leave form
    setupLeaveForm();
}

function setupEmployeeNavigation() {
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.dataset.page;
            showEmployeePage(page);
            
            navItems.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

function showEmployeePage(pageName) {
    document.querySelectorAll('.page-content').forEach(page => {
        page.classList.remove('active');
    });

    const selectedPage = document.getElementById(pageName + '-page');
    if (selectedPage) {
        selectedPage.classList.add('active');
    }

    const titles = {
        profile: 'Profil Məlumatları',
        attendance: 'Davamiyyət Tarixçəsi',
        salary: 'Maaş Məlumatları',
        advances: 'Avans Tarixçəsi',
        fines: 'Cərimə Tarixçəsi',
        tasks: 'Tapşırıqlar',
        notifications: 'Bildirişlər',
        documents: 'Fayllar və Sənədlər',
        leaves: 'İcazə İstə',
        password: 'Şifrəni Dəyiş'
    };

    document.getElementById('page-title').textContent = titles[pageName] || 'Profil';
}

// ============================================
// LEAVE MANAGEMENT
// ============================================
function setupLeaveForm() {
    const leaveForm = document.getElementById('leaveForm');
    const startDate = document.getElementById('leave-start');
    const endDate = document.getElementById('leave-end');
    const daysInput = document.getElementById('leave-days');

    if (!leaveForm) return;

    // Calculate days when dates change
    function calculateDays() {
        if (startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            daysInput.value = diffDays > 0 ? diffDays : 0;
        }
    }

    if (startDate) startDate.addEventListener('change', calculateDays);
    if (endDate) endDate.addEventListener('change', calculateDays);

    // Form submit
    leaveForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const leaveData = {
            type: document.getElementById('leave-type').value,
            typeLabel: document.getElementById('leave-type').options[document.getElementById('leave-type').selectedIndex].text,
            startDate: startDate.value,
            endDate: endDate.value,
            days: daysInput.value,
            reason: document.getElementById('leave-reason').value,
            status: 'pending',
            requestedAt: new Date().toISOString().split('T')[0]
        };

        if (!leaveData.type || !leaveData.startDate || !leaveData.endDate) {
            alert('Zəhmət olmasa bütün vacib sahələri doldurun!');
            return;
        }

        // Save to localStorage
        const data = Storage.getData();
        const user = Auth.getCurrentUser();
        
        if (!data.leaves) data.leaves = [];
        
        data.leaves.push({
            id: Date.now(),
            employeeId: user.id,
            ...leaveData
        });
        
        Storage.setData(data);
        
        // Add to table
        addLeaveToTable(leaveData);
        
        // Reset form
        leaveForm.reset();
        daysInput.value = '';
        
        alert('İcazə istəyi uğurla göndərildi!');
    });
}

function addLeaveToTable(leave) {
    const tbody = document.getElementById('leaves-table');
    if (!tbody) return;

    const statusBadges = {
        pending: '<span class="badge bg-warning">Gözləyir</span>',
        approved: '<span class="badge bg-success">Təsdiqləndi</span>',
        rejected: '<span class="badge bg-danger">Rədd edildi</span>'
    };

    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${leave.requestedAt}</td>
        <td>${leave.typeLabel}</td>
        <td>${leave.startDate}</td>
        <td>${leave.endDate}</td>
        <td>${leave.days}</td>
        <td>${leave.reason || '-'}</td>
        <td>${statusBadges[leave.status] || statusBadges.pending}</td>
    `;
    
    tbody.insertBefore(row, tbody.firstChild);
}

// ============================================
// LOGOUT
// ============================================
function logout() {
    Auth.logout();
}

// ============================================
// INITIALIZE
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    Storage.init();

    const path = window.location.pathname;
    
    if (path.includes('login.html') || path.endsWith('/')) {
        initLoginPage();
    } else if (path.includes('admin-dashboard.html')) {
        initAdminDashboard();
    } else if (path.includes('employee-dashboard.html')) {
        initEmployeeDashboard();
    }
});

// Close modal on outside click
window.onclick = function(event) {
    const modal = document.getElementById('employeeModal');
    if (event.target === modal) {
        closeEmployeeModal();
    }
};
