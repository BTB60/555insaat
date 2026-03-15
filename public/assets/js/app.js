/**
 * 555 İNŞAAT - İŞÇİ İDARƏETMƏ SİSTEMİ
 * Complete JavaScript Application
 * Version 2.0
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
            createdAt: '2025-01-01',
            avatar: null
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
            createdAt: '2025-02-15',
            avatar: null,
            salary: 1200,
            leaveBalance: {
                annual: 21,
                used: 5,
                remaining: 16
            }
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
            createdAt: '2025-02-20',
            avatar: null,
            salary: 1000,
            leaveBalance: {
                annual: 21,
                used: 3,
                remaining: 18
            }
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
            createdAt: '2025-03-01',
            avatar: null,
            salary: 1100,
            leaveBalance: {
                annual: 21,
                used: 0,
                remaining: 21
            }
        }
    ],
    projects: [
        { id: 1, name: 'Bakı Layihəsi', location: 'Bakı', status: 'active', startDate: '2024-01-01', endDate: null },
        { id: 2, name: 'Sumqayıt Obyekti', location: 'Sumqayıt', status: 'active', startDate: '2024-03-15', endDate: null },
        { id: 3, name: 'Xırdalan Obyekti', location: 'Xırdalan', status: 'active', startDate: '2024-06-01', endDate: null }
    ],
    attendance: [
        { id: 1, employeeId: 2, date: '2025-03-01', status: 'present', checkIn: '08:00', checkOut: '17:00', notes: '' },
        { id: 2, employeeId: 2, date: '2025-03-02', status: 'present', checkIn: '08:05', checkOut: '17:00', notes: '' },
        { id: 3, employeeId: 2, date: '2025-03-03', status: 'late', checkIn: '09:15', checkOut: '17:00', notes: 'Gecikmə' },
        { id: 4, employeeId: 2, date: '2025-03-04', status: 'present', checkIn: '08:00', checkOut: '17:00', notes: '' },
        { id: 5, employeeId: 2, date: '2025-03-05', status: 'absent', checkIn: null, checkOut: null, notes: 'İznsiz' }
    ],
    salaries: [
        { id: 1, employeeId: 2, month: '2025-02', baseSalary: 1200, bonus: 0, overtime: 30, advance: 100, fine: 0, netSalary: 1130, status: 'paid', paidDate: '2025-03-05' },
        { id: 2, employeeId: 2, month: '2025-03', baseSalary: 1200, bonus: 100, overtime: 50, advance: 150, fine: 20, netSalary: 1180, status: 'pending', paidDate: null }
    ],
    advances: [
        { id: 1, employeeId: 2, amount: 150, date: '2025-03-15', reason: 'Şəxsi ehtiyac', status: 'approved', approvedBy: 1, approvedDate: '2025-03-15' },
        { id: 2, employeeId: 2, amount: 100, date: '2025-02-10', reason: 'Şəxsi ehtiyac', status: 'deducted', approvedBy: 1, approvedDate: '2025-02-10' },
        { id: 3, employeeId: 3, amount: 200, date: '2025-03-10', reason: 'Tibbi xərclər', status: 'pending', approvedBy: null, approvedDate: null }
    ],
    fines: [
        { id: 1, employeeId: 2, amount: 20, date: '2025-03-05', reason: 'Gecikmə (15 dəq)', status: 'active', projectId: null },
        { id: 2, employeeId: 2, amount: 50, date: '2025-02-20', reason: 'Təhlükəsizlik pozuntusu', status: 'deducted', projectId: 1 }
    ],
    tasks: [
        { id: 1, employeeId: 2, title: 'Beton tökmə işinə nəzarət', description: '3-cü blok beton tökmə işlərinin nəzarəti', dueDate: '2025-03-20', priority: 'high', status: 'pending', projectId: 1, createdBy: 1, createdAt: '2025-03-10' },
        { id: 2, employeeId: 2, title: 'Materialların qəbulu', description: 'Sifariş edilmiş materialların qəbulu və yoxlanışı', dueDate: '2025-03-15', priority: 'medium', status: 'completed', projectId: 1, createdBy: 1, createdAt: '2025-03-08' },
        { id: 3, employeeId: 3, title: 'Demir konstruksiya quraşdırma', description: '2-ci mərtəbə demir konstruksiya işləri', dueDate: '2025-03-25', priority: 'high', status: 'pending', projectId: 2, createdBy: 1, createdAt: '2025-03-12' }
    ],
    leaves: [
        { id: 1, employeeId: 2, type: 'annual', typeLabel: 'İllik məzuniyyət', startDate: '2025-03-10', endDate: '2025-03-12', days: 3, reason: 'Şəxsi işlər', status: 'approved', requestedAt: '2025-03-01', approvedBy: 1, approvedAt: '2025-03-02' },
        { id: 2, employeeId: 2, type: 'sick', typeLabel: 'Xəstəlik icazəsi', startDate: '2025-02-16', endDate: '2025-02-17', days: 2, reason: 'Qrip', status: 'approved', requestedAt: '2025-02-15', approvedBy: 1, approvedAt: '2025-02-15' },
        { id: 3, employeeId: 2, type: 'personal', typeLabel: 'Şəxsi iş', startDate: '2025-03-25', endDate: '2025-03-25', days: 1, reason: 'Ailəvi səbəb', status: 'pending', requestedAt: '2025-03-20', approvedBy: null, approvedAt: null }
    ],
    notifications: [
        { id: 1, employeeId: 2, title: 'Maaş ödənişi', message: 'Fevral ayı üzrə maaşınız hesabınıza köçürüldü.', type: 'salary', date: '2025-03-10', read: false },
        { id: 2, employeeId: 2, title: 'Yeni cərimə', message: '05.03.2025 tarixində gecikməyə görə 20 ₼ cərimə.', type: 'fine', date: '2025-03-05', read: false },
        { id: 3, employeeId: 2, title: 'Yeni tapşırıq', message: 'Yeni tapşırıq əlavə edildi: Beton tökmə işinə nəzarət', type: 'task', date: '2025-03-10', read: true }
    ],
    documents: [
        { id: 1, employeeId: 2, name: 'Əmək müqaviləsi.pdf', type: 'pdf', size: '2.5 MB', uploadedAt: '2025-02-15', url: '#' },
        { id: 2, employeeId: 2, name: 'İş qaydaları.docx', type: 'docx', size: '1.2 MB', uploadedAt: '2025-02-15', url: '#' },
        { id: 3, employeeId: 2, name: 'Təhlükəsizlik təlimatı.pdf', type: 'pdf', size: '3.8 MB', uploadedAt: '2025-03-01', url: '#' }
    ],
    settings: {
        companyName: '555 İnşaat',
        companyLogo: null,
        workingHours: { start: '08:00', end: '17:00' },
        workingDays: [1, 2, 3, 4, 5],
        currency: 'AZN',
        language: 'az'
    }
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
    },

    // Helper methods
    getUserById(id) {
        const data = this.getData();
        return data.users.find(u => u.id === parseInt(id));
    },

    getCurrentUserData() {
        const session = this.getSession();
        if (!session) return null;
        return this.getUserById(session.id);
    },

    updateUser(userId, updates) {
        const data = this.getData();
        const index = data.users.findIndex(u => u.id === parseInt(userId));
        if (index !== -1) {
            data.users[index] = { ...data.users[index], ...updates };
            this.setData(data);
            return data.users[index];
        }
        return null;
    }
};

// ============================================
// AUTHENTICATION SYSTEM
// ============================================
const Auth = {
    login(username, password) {
        const data = Storage.getData();
        const user = data.users.find(u => 
            u.username.toLowerCase() === username.toLowerCase() && 
            u.password === password &&
            u.status === 'active'
        );
        
        if (user) {
            // Update last login
            const updatedUser = { ...user, lastLogin: new Date().toISOString() };
            Storage.updateUser(user.id, updatedUser);
            Storage.setSession(updatedUser);
            
            return { 
                success: true, 
                user: updatedUser,
                message: 'Uğurla daxil oldunuz!'
            };
        }
        
        // Check if user exists but inactive
        const inactiveUser = data.users.find(u => 
            u.username.toLowerCase() === username.toLowerCase() && 
            u.password === password &&
            u.status === 'inactive'
        );
        
        if (inactiveUser) {
            return { 
                success: false, 
                message: 'Hesabınız deaktiv edilib. Admin ilə əlaqə saxlayın.' 
            };
        }
        
        return { 
            success: false, 
            message: 'İstifadəçi adı və ya şifrə yanlışdır!' 
        };
    },

    logout() {
        Storage.clearSession();
        window.location.href = 'login.html';
    },

    checkAuth(requiredRole = null) {
        const session = Storage.getSession();
        if (!session) {
            window.location.href = 'login.html';
            return null;
        }
        
        if (requiredRole && session.role !== requiredRole) {
            window.location.href = session.role === 'admin' ? 'admin-dashboard.html' : 'employee-dashboard.html';
            return null;
        }
        
        return session;
    },

    getCurrentUser() {
        return Storage.getSession();
    },

    isAdmin() {
        const user = this.getCurrentUser();
        return user && user.role === 'admin';
    },

    isEmployee() {
        const user = this.getCurrentUser();
        return user && user.role === 'employee';
    },

    changePassword(currentPassword, newPassword) {
        const user = this.getCurrentUser();
        if (!user) return { success: false, message: 'İstifadəçi tapılmadı!' };
        
        if (user.password !== currentPassword) {
            return { success: false, message: 'Cari şifrə yanlışdır!' };
        }
        
        Storage.updateUser(user.id, { password: newPassword });
        return { success: true, message: 'Şifrə uğurla dəyişdirildi!' };
    }
};

// ============================================
// UI HELPERS & UTILITIES
// ============================================
const UI = {
    // Notifications
    showNotification(message, type = 'info', duration = 3000) {
        // Remove existing notifications
        const existing = document.querySelector('.ui-notification');
        if (existing) existing.remove();

        const notification = document.createElement('div');
        notification.className = `ui-notification alert alert-${type}`;
        notification.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            animation: slideInRight 0.3s ease;
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideInRight 0.3s ease reverse';
            setTimeout(() => notification.remove(), 300);
        }, duration);
    },

    showError(message) {
        const errorDiv = document.getElementById('error-message');
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.classList.remove('d-none');
            errorDiv.classList.add('animate-shake');
            setTimeout(() => {
                errorDiv.classList.add('d-none');
                errorDiv.classList.remove('animate-shake');
            }, 5000);
        } else {
            this.showNotification(message, 'danger');
        }
    },

    showSuccess(message) {
        this.showNotification(message, 'success');
    },

    // Formatting
    formatDate(dateString, format = 'DD.MM.YYYY') {
        if (!dateString) return '-';
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return '-';

        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();

        switch (format) {
            case 'DD.MM.YYYY': return `${day}.${month}.${year}`;
            case 'YYYY-MM-DD': return `${year}-${month}-${day}`;
            case 'MMMM YYYY': return date.toLocaleDateString('az-AZ', { month: 'long', year: 'numeric' });
            default: return `${day}.${month}.${year}`;
        }
    },

    formatCurrency(amount, currency = 'AZN') {
        if (amount === null || amount === undefined) return '-';
        return new Intl.NumberFormat('az-AZ', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount) + ' ' + currency;
    },

    formatPhone(phone) {
        if (!phone) return '-';
        return phone.replace(/(\d{3})(\d{3})(\d{2})(\d{2})/, '$1 $2 $3 $4');
    },

    // Text helpers
    getInitials(name) {
        if (!name) return '?';
        return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
    },

    capitalize(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    },

    truncate(str, length = 50) {
        if (!str || str.length <= length) return str;
        return str.slice(0, length) + '...';
    },

    // Avatar generator
    generateAvatar(name, size = 44) {
        const colors = ['#ff8c42', '#1e3a5f', '#10b981', '#ef4444', '#8b5cf6', '#14b8a6'];
        const color = colors[name.length % colors.length];
        const initials = this.getInitials(name);
        
        return `<div class="avatar" style="background: ${color}; width: ${size}px; height: ${size}px; font-size: ${size * 0.4}px;">${initials}</div>`;
    },

    // Status helpers
    getStatusBadge(status, type = 'default') {
        const badges = {
            active: '<span class="badge active"><span></span>Aktiv</span>',
            inactive: '<span class="badge inactive"><span></span>Passiv</span>',
            pending: '<span class="badge bg-warning"><span></span>Gözləyir</span>',
            approved: '<span class="badge bg-success"><span></span>Təsdiqləndi</span>',
            rejected: '<span class="badge bg-danger"><span></span>Rədd edildi</span>',
            paid: '<span class="badge bg-success"><span></span>Ödənilib</span>',
            deducted: '<span class="badge bg-success"><span></span>Çıxılıb</span>',
            present: '<span class="badge bg-success"><span></span>İşdə</span>',
            absent: '<span class="badge bg-danger"><span></span>İznsiz</span>',
            late: '<span class="badge bg-warning"><span></span>Gecikmə</span>',
            excused: '<span class="badge bg-info"><span></span>İznlə</span>',
            vacation: '<span class="badge bg-info"><span></span>Məzuniyyət</span>'
        };
        return badges[status] || `<span class="badge bg-secondary">${status}</span>`;
    },

    // Loading states
    showLoading(element, text = 'Yüklənir...') {
        element.dataset.originalContent = element.innerHTML;
        element.innerHTML = `<span class="loading"></span> ${text}`;
        element.disabled = true;
    },

    hideLoading(element) {
        if (element.dataset.originalContent) {
            element.innerHTML = element.dataset.originalContent;
            element.disabled = false;
        }
    },

    // Modal helpers
    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    },

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    },

    // Confirm dialog
    confirm(message, onConfirm, onCancel = null) {
        if (confirm(message)) {
            onConfirm();
        } else if (onCancel) {
            onCancel();
        }
    }
};

// ============================================
// EMPLOYEE MANAGER (Admin functions)
// ============================================
const EmployeeManager = {
    getAll(filters = {}) {
        const data = Storage.getData();
        let employees = data.users.filter(u => u.role === 'employee');
        
        if (filters.status) {
            employees = employees.filter(e => e.status === filters.status);
        }
        if (filters.project) {
            employees = employees.filter(e => e.project === filters.project);
        }
        if (filters.search) {
            const search = filters.search.toLowerCase();
            employees = employees.filter(e => 
                e.fullName.toLowerCase().includes(search) ||
                e.username.toLowerCase().includes(search) ||
                (e.phone && e.phone.includes(search)) ||
                (e.position && e.position.toLowerCase().includes(search))
            );
        }
        
        return employees.sort((a, b) => b.id - a.id);
    },

    getById(id) {
        return Storage.getUserById(id);
    },

    create(employeeData) {
        const data = Storage.getData();
        const newId = Math.max(...data.users.map(u => u.id), 0) + 1;
        
        const newEmployee = {
            id: newId,
            role: 'employee',
            status: 'active',
            createdAt: new Date().toISOString().split('T')[0],
            avatar: null,
            leaveBalance: { annual: 21, used: 0, remaining: 21 },
            ...employeeData
        };
        
        data.users.push(newEmployee);
        Storage.setData(data);
        
        // Create notification for new employee
        NotificationManager.create({
            employeeId: newEmployee.id,
            title: 'Xoş gəlmisiniz!',
            message: '555 İnşaat sistemində hesabınız yaradıldı.',
            type: 'system'
        });
        
        return newEmployee;
    },

    update(id, employeeData) {
        const employee = Storage.updateUser(id, employeeData);
        if (employee) {
            UI.showSuccess('İşçi məlumatları yeniləndi!');
        }
        return employee;
    },

    delete(id) {
        UI.confirm('Bu işçini silmək istədiyinizə əminsiniz?', () => {
            const data = Storage.getData();
            data.users = data.users.filter(u => u.id !== parseInt(id));
            Storage.setData(data);
            UI.showSuccess('İşçi silindi!');
            return true;
        });
        return false;
    },

    toggleStatus(id) {
        const employee = this.getById(id);
        if (employee) {
            const newStatus = employee.status === 'active' ? 'inactive' : 'active';
            this.update(id, { status: newStatus });
            return newStatus;
        }
        return null;
    },

    assignToProject(employeeId, projectId) {
        const data = Storage.getData();
        const project = data.projects.find(p => p.id === parseInt(projectId));
        if (project) {
            this.update(employeeId, { project: project.name });
            return true;
        }
        return false;
    },

    getStats() {
        const employees = this.getAll();
        return {
            total: employees.length,
            active: employees.filter(e => e.status === 'active').length,
            inactive: employees.filter(e => e.status === 'inactive').length,
            byProject: this.groupByProject(employees)
        };
    },

    groupByProject(employees) {
        return employees.reduce((acc, emp) => {
            const project = emp.project || 'Təyin edilməyib';
            acc[project] = (acc[project] || 0) + 1;
            return acc;
        }, {});
    }
};

// ============================================
// NOTIFICATION MANAGER
// ============================================
const NotificationManager = {
    getForEmployee(employeeId, unreadOnly = false) {
        const data = Storage.getData();
        let notifications = data.notifications.filter(n => n.employeeId === parseInt(employeeId));
        if (unreadOnly) {
            notifications = notifications.filter(n => !n.read);
        }
        return notifications.sort((a, b) => new Date(b.date) - new Date(a.date));
    },

    create(notificationData) {
        const data = Storage.getData();
        const newNotification = {
            id: Date.now(),
            date: new Date().toISOString().split('T')[0],
            read: false,
            ...notificationData
        };
        
        if (!data.notifications) data.notifications = [];
        data.notifications.push(newNotification);
        Storage.setData(data);
        return newNotification;
    },

    markAsRead(notificationId) {
        const data = Storage.getData();
        const notification = data.notifications.find(n => n.id === parseInt(notificationId));
        if (notification) {
            notification.read = true;
            Storage.setData(data);
        }
    },

    markAllAsRead(employeeId) {
        const data = Storage.getData();
        data.notifications.forEach(n => {
            if (n.employeeId === parseInt(employeeId)) {
                n.read = true;
            }
        });
        Storage.setData(data);
    },

    getUnreadCount(employeeId) {
        return this.getForEmployee(employeeId, true).length;
    }
};

// ============================================
// ADVANCE MANAGER
// ============================================
const AdvanceManager = {
    getForEmployee(employeeId) {
        const data = Storage.getData();
        if (!data.advances) data.advances = [];
        return data.advances
            .filter(a => a.employeeId === parseInt(employeeId))
            .sort((a, b) => new Date(b.requestedAt) - new Date(a.requestedAt));
    },

    getAll(status = null) {
        const data = Storage.getData();
        if (!data.advances) data.advances = [];
        let advances = data.advances;
        if (status) {
            advances = advances.filter(a => a.status === status);
        }
        return advances.sort((a, b) => new Date(b.requestedAt) - new Date(a.requestedAt));
    },

    create(advanceData) {
        const data = Storage.getData();
        const user = Auth.getCurrentUser();
        
        if (!data.advances) data.advances = [];
        
        // Check monthly limit (max 2 per month)
        const currentMonth = new Date().toISOString().slice(0, 7);
        const monthlyRequests = data.advances.filter(a => 
            a.employeeId === user.id && 
            a.requestedAt.startsWith(currentMonth)
        ).length;
        
        if (monthlyRequests >= 2) {
            return { success: false, message: 'Bir ayda maksimum 2 avans istəyi edə bilərsiniz!' };
        }
        
        // Check max amount (50% of salary)
        if (user.salary && advanceData.amount > user.salary * 0.5) {
            return { success: false, message: `Maksimum avans məbləği aylıq maaşınızın 50%-i (${UI.formatCurrency(user.salary * 0.5)}) qədərdir!` };
        }
        
        const newAdvance = {
            id: Date.now(),
            employeeId: user.id,
            status: 'pending',
            requestedAt: new Date().toISOString().split('T')[0],
            ...advanceData
        };
        
        data.advances.push(newAdvance);
        Storage.setData(data);
        
        // Notify admin
        NotificationManager.create({
            employeeId: 1, // Admin
            title: 'Yeni avans istəyi',
            message: `${user.fullName} ${UI.formatCurrency(advanceData.amount)} avans istədi.`,
            type: 'advance'
        });
        
        return { success: true, advance: newAdvance };
    },

    approve(advanceId, approvedBy) {
        const data = Storage.getData();
        const advance = data.advances.find(a => a.id === parseInt(advanceId));
        if (advance) {
            advance.status = 'approved';
            advance.approvedBy = approvedBy;
            advance.approvedAt = new Date().toISOString().split('T')[0];
            Storage.setData(data);
            
            // Notify employee
            NotificationManager.create({
                employeeId: advance.employeeId,
                title: 'Avans təsdiqləndi',
                message: `${UI.formatCurrency(advance.amount)} məbləğində avans istəyiniz təsdiqləndi. Növbəti maaşdan çıxılacaq.`,
                type: 'advance'
            });
            
            return advance;
        }
        return null;
    },

    reject(advanceId, reason) {
        const data = Storage.getData();
        const advance = data.advances.find(a => a.id === parseInt(advanceId));
        if (advance) {
            advance.status = 'rejected';
            advance.rejectionReason = reason;
            advance.rejectedAt = new Date().toISOString().split('T')[0];
            Storage.setData(data);
            
            // Notify employee
            NotificationManager.create({
                employeeId: advance.employeeId,
                title: 'Avans rədd edildi',
                message: `Avans istəyiniz rədd edildi. Səbəb: ${reason}`,
                type: 'advance'
            });
            
            return advance;
        }
        return null;
    },

    markAsDeducted(advanceId) {
        const data = Storage.getData();
        const advance = data.advances.find(a => a.id === parseInt(advanceId));
        if (advance) {
            advance.status = 'deducted';
            advance.deductedAt = new Date().toISOString().split('T')[0];
            Storage.setData(data);
            
            // Notify employee
            NotificationManager.create({
                employeeId: advance.employeeId,
                title: 'Avans çıxıldı',
                message: `${UI.formatCurrency(advance.amount)} məbləğində avans maaşınızdan çıxıldı.`,
                type: 'advance'
            });
            
            return advance;
        }
        return null;
    },

    getStats(employeeId) {
        const advances = this.getForEmployee(employeeId);
        const currentYear = new Date().getFullYear().toString();
        
        return {
            totalYear: advances
                .filter(a => a.requestedAt.startsWith(currentYear) && (a.status === 'approved' || a.status === 'deducted'))
                .reduce((sum, a) => sum + a.amount, 0),
            pending: advances
                .filter(a => a.status === 'pending')
                .reduce((sum, a) => sum + a.amount, 0),
            approved: advances
                .filter(a => a.status === 'approved')
                .reduce((sum, a) => sum + a.amount, 0),
            totalCount: advances.length
        };
    }
};

// ============================================
// PROJECT MANAGER
// ============================================
const ProjectManager = {
    getAll(status = null) {
        const data = Storage.getData();
        if (!data.projects) data.projects = [];
        let projects = data.projects;
        if (status) {
            projects = projects.filter(p => p.status === status);
        }
        return projects.sort((a, b) => b.id - a.id);
    },

    getById(id) {
        const data = Storage.getData();
        return data.projects.find(p => p.id === parseInt(id));
    },

    create(projectData) {
        const data = Storage.getData();
        if (!data.projects) data.projects = [];
        
        const newId = Math.max(...data.projects.map(p => p.id), 0) + 1;
        
        const newProject = {
            id: newId,
            ...projectData,
            createdAt: new Date().toISOString().split('T')[0]
        };
        
        data.projects.push(newProject);
        Storage.setData(data);
        return newProject;
    },

    update(id, projectData) {
        const data = Storage.getData();
        const index = data.projects.findIndex(p => p.id === parseInt(id));
        if (index !== -1) {
            data.projects[index] = { ...data.projects[index], ...projectData };
            Storage.setData(data);
            return data.projects[index];
        }
        return null;
    },

    delete(id) {
        const data = Storage.getData();
        data.projects = data.projects.filter(p => p.id !== parseInt(id));
        Storage.setData(data);
    },

    getStats() {
        const projects = this.getAll();
        const data = Storage.getData();
        const employees = data.users.filter(u => u.role === 'employee');
        
        return {
            total: projects.length,
            active: projects.filter(p => p.status === 'active').length,
            completed: projects.filter(p => p.status === 'completed').length,
            paused: projects.filter(p => p.status === 'paused').length,
            employeeCount: employees.length
        };
    },

    getEmployeeCount(projectId) {
        const data = Storage.getData();
        const project = this.getById(projectId);
        if (!project) return 0;
        return data.users.filter(u => u.role === 'employee' && u.project === project.name).length;
    }
};

// ============================================
// ATTENDANCE MANAGER
// ============================================
const AttendanceManager = {
    getAll(date = null, status = null) {
        const data = Storage.getData();
        if (!data.attendance) data.attendance = [];
        let records = data.attendance;
        
        if (date) {
            records = records.filter(a => a.date === date);
        }
        if (status) {
            records = records.filter(a => a.status === status);
        }
        
        return records.sort((a, b) => new Date(b.date) - new Date(a.date));
    },

    getForEmployee(employeeId, month = null) {
        const data = Storage.getData();
        if (!data.attendance) data.attendance = [];
        let records = data.attendance.filter(a => a.employeeId === parseInt(employeeId));
        
        if (month) {
            records = records.filter(a => a.date.startsWith(month));
        }
        
        return records.sort((a, b) => new Date(b.date) - new Date(a.date));
    },

    create(recordData) {
        const data = Storage.getData();
        if (!data.attendance) data.attendance = [];
        
        const newRecord = {
            id: Date.now(),
            ...recordData
        };
        
        data.attendance.push(newRecord);
        Storage.setData(data);
        return newRecord;
    },

    update(id, recordData) {
        const data = Storage.getData();
        const index = data.attendance.findIndex(a => a.id === parseInt(id));
        if (index !== -1) {
            data.attendance[index] = { ...data.attendance[index], ...recordData };
            Storage.setData(data);
            return data.attendance[index];
        }
        return null;
    },

    delete(id) {
        const data = Storage.getData();
        data.attendance = data.attendance.filter(a => a.id !== parseInt(id));
        Storage.setData(data);
    },

    getTodayStats() {
        const today = new Date().toISOString().split('T')[0];
        const records = this.getAll(today);
        
        return {
            present: records.filter(r => r.status === 'present').length,
            late: records.filter(r => r.status === 'late').length,
            absent: records.filter(r => r.status === 'absent').length,
            excused: records.filter(r => r.status === 'excused').length,
            total: records.length
        };
    },

    getMonthlyStats(employeeId, month) {
        const records = this.getForEmployee(employeeId, month);
        
        return {
            present: records.filter(r => r.status === 'present').length,
            late: records.filter(r => r.status === 'late').length,
            absent: records.filter(r => r.status === 'absent').length,
            excused: records.filter(r => r.status === 'excused').length,
            total: records.length
        };
    }
};

// ============================================
// SALARY MANAGER
// ============================================
const SalaryManager = {
    getAll(month = null, status = null) {
        const data = Storage.getData();
        if (!data.salaries) data.salaries = [];
        let salaries = data.salaries;
        
        if (month) {
            salaries = salaries.filter(s => s.month === month);
        }
        if (status) {
            salaries = salaries.filter(s => s.status === status);
        }
        
        return salaries.sort((a, b) => b.id - a.id);
    },

    getForEmployee(employeeId) {
        const data = Storage.getData();
        if (!data.salaries) data.salaries = [];
        return data.salaries
            .filter(s => s.employeeId === parseInt(employeeId))
            .sort((a, b) => b.id - a.id);
    },

    calculateSalary(employeeId, month) {
        const data = Storage.getData();
        const employee = Storage.getUserById(employeeId);
        if (!employee || !employee.salary) return null;
        
        // Get employee's work settings (admin defined)
        const baseSalary = employee.salary || 0;
        const workDays = employee.workDays || 22;
        const dailyHours = employee.dailyHours || 8;
        const hourlyRate = baseSalary / (workDays * dailyHours);
        
        // Get attendance for this month to calculate actual work days
        const attendance = data.attendance ? data.attendance.filter(a => 
            a.employeeId === employeeId && 
            a.date.startsWith(month) &&
            (a.status === 'present' || a.status === 'late')
        ) : [];
        const actualWorkDays = attendance.length;
        
        // Get advances for this month
        const advances = data.advances ? data.advances.filter(a => 
            a.employeeId === employeeId && 
            a.date.startsWith(month) &&
            (a.status === 'approved' || a.status === 'deducted')
        ) : [];
        const totalAdvances = advances.reduce((sum, a) => sum + a.amount, 0);
        
        // Get fines for this month
        const fines = data.fines ? data.fines.filter(f => 
            f.employeeId === employeeId && 
            f.date.startsWith(month) &&
            (f.status === 'active' || f.status === 'deducted')
        ) : [];
        const totalFines = fines.reduce((sum, f) => sum + f.amount, 0);
        
        // Calculate overtime based on actual extra hours worked
        const overtimeRecords = data.attendance ? data.attendance.filter(a => 
            a.employeeId === employeeId && 
            a.date.startsWith(month) &&
            a.overtimeHours > 0
        ) : [];
        const totalOvertimeHours = overtimeRecords.reduce((sum, a) => sum + (a.overtimeHours || 0), 0);
        const overtime = totalOvertimeHours * hourlyRate * 1.5; // 1.5x for overtime
        
        // Calculate bonus (can be set by admin, default 0)
        const bonus = employee.monthlyBonus || 0;
        
        // Calculate salary based on actual work days
        const dailySalary = baseSalary / workDays;
        const workedSalary = actualWorkDays * dailySalary;
        
        const netSalary = workedSalary + bonus + overtime - totalAdvances - totalFines;
        
        return {
            employeeId: employeeId,
            month: month,
            baseSalary: employee.salary,
            bonus: bonus,
            overtime: overtime,
            advance: totalAdvances,
            fine: totalFines,
            netSalary: netSalary,
            status: 'pending'
        };
    },

    create(salaryData) {
        const data = Storage.getData();
        if (!data.salaries) data.salaries = [];
        
        const newId = Math.max(...data.salaries.map(s => s.id), 0) + 1;
        
        const newSalary = {
            id: newId,
            ...salaryData,
            createdAt: new Date().toISOString().split('T')[0]
        };
        
        data.salaries.push(newSalary);
        Storage.setData(data);
        
        // Notify employee
        NotificationManager.create({
            employeeId: salaryData.employeeId,
            title: 'Yeni maaş hesablanması',
            message: `${salaryData.month} ayı üzrə maaşınız hesablandı: ${UI.formatCurrency(salaryData.netSalary)}`,
            type: 'salary'
        });
        
        return newSalary;
    },

    markAsPaid(salaryId) {
        const data = Storage.getData();
        const salary = data.salaries.find(s => s.id === parseInt(salaryId));
        if (salary) {
            salary.status = 'paid';
            salary.paidDate = new Date().toISOString().split('T')[0];
            Storage.setData(data);
            
            // Notify employee
            NotificationManager.create({
                employeeId: salary.employeeId,
                title: 'Maaş ödənişi',
                message: `${salary.month} ayı üzrə maaşınız ödəndi: ${UI.formatCurrency(salary.netSalary)}`,
                type: 'salary'
            });
            
            return salary;
        }
        return null;
    },

    getStats(month = null) {
        const salaries = this.getAll(month);
        
        return {
            totalFund: salaries.reduce((sum, s) => sum + s.netSalary, 0),
            pending: salaries.filter(s => s.status === 'pending').length,
            paid: salaries.filter(s => s.status === 'paid').length,
            totalCount: salaries.length
        };
    }
};

// ============================================
// FINE MANAGER
// ============================================
const FineManager = {
    getAll(status = null) {
        const data = Storage.getData();
        if (!data.fines) data.fines = [];
        let fines = data.fines;
        if (status) {
            fines = fines.filter(f => f.status === status);
        }
        return fines.sort((a, b) => new Date(b.date) - new Date(a.date));
    },

    getForEmployee(employeeId) {
        const data = Storage.getData();
        if (!data.fines) data.fines = [];
        return data.fines
            .filter(f => f.employeeId === parseInt(employeeId))
            .sort((a, b) => new Date(b.date) - new Date(a.date));
    },

    create(fineData) {
        const data = Storage.getData();
        if (!data.fines) data.fines = [];
        
        const newFine = {
            id: Date.now(),
            status: 'active',
            ...fineData
        };
        
        data.fines.push(newFine);
        Storage.setData(data);
        
        // Notify employee
        const employee = Storage.getUserById(fineData.employeeId);
        NotificationManager.create({
            employeeId: fineData.employeeId,
            title: 'Yeni cərimə',
            message: `${UI.formatCurrency(fineData.amount)} məbləğində cəriməniz var. Səbəb: ${fineData.reason}`,
            type: 'fine'
        });
        
        return newFine;
    },

    markAsDeducted(fineId) {
        const data = Storage.getData();
        const fine = data.fines.find(f => f.id === parseInt(fineId));
        if (fine) {
            fine.status = 'deducted';
            fine.deductedAt = new Date().toISOString().split('T')[0];
            Storage.setData(data);
            
            // Notify employee
            NotificationManager.create({
                employeeId: fine.employeeId,
                title: 'Cərimə çıxıldı',
                message: `${UI.formatCurrency(fine.amount)} məbləğində cərimə maaşınızdan çıxıldı.`,
                type: 'fine'
            });
            
            return fine;
        }
        return null;
    },

    delete(fineId) {
        const data = Storage.getData();
        data.fines = data.fines.filter(f => f.id !== parseInt(fineId));
        Storage.setData(data);
    },

    getStats() {
        const fines = this.getAll();
        const currentMonth = new Date().toISOString().slice(0, 7);
        
        return {
            active: fines.filter(f => f.status === 'active').length,
            deducted: fines.filter(f => f.status === 'deducted').length,
            monthlyAmount: fines
                .filter(f => f.date.startsWith(currentMonth) && (f.status === 'active' || f.status === 'deducted'))
                .reduce((sum, f) => sum + f.amount, 0),
            totalCount: fines.length
        };
    }
};

// ============================================
// TASK MANAGER
// ============================================
const TaskManager = {
    getAll(status = null, priority = null) {
        const data = Storage.getData();
        if (!data.tasks) data.tasks = [];
        let tasks = data.tasks;
        
        if (status) {
            tasks = tasks.filter(t => t.status === status);
        }
        if (priority) {
            tasks = tasks.filter(t => t.priority === priority);
        }
        
        return tasks.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
    },

    getForEmployee(employeeId) {
        const data = Storage.getData();
        if (!data.tasks) data.tasks = [];
        return data.tasks
            .filter(t => t.employeeId === parseInt(employeeId))
            .sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
    },

    create(taskData) {
        const data = Storage.getData();
        if (!data.tasks) data.tasks = [];
        
        const newTask = {
            id: Date.now(),
            status: 'pending',
            createdAt: new Date().toISOString().split('T')[0],
            ...taskData
        };
        
        data.tasks.push(newTask);
        Storage.setData(data);
        
        // Notify employee
        NotificationManager.create({
            employeeId: taskData.employeeId,
            title: 'Yeni tapşırıq',
            message: `Yeni tapşırıq əlavə edildi: ${taskData.title}`,
            type: 'task'
        });
        
        return newTask;
    },

    update(id, taskData) {
        const data = Storage.getData();
        const index = data.tasks.findIndex(t => t.id === parseInt(id));
        if (index !== -1) {
            data.tasks[index] = { ...data.tasks[index], ...taskData };
            Storage.setData(data);
            return data.tasks[index];
        }
        return null;
    },

    updateStatus(taskId, status) {
        const data = Storage.getData();
        const task = data.tasks.find(t => t.id === parseInt(taskId));
        if (task) {
            task.status = status;
            if (status === 'completed') {
                task.completedAt = new Date().toISOString().split('T')[0];
            }
            Storage.setData(data);
            
            if (status === 'completed') {
                NotificationManager.create({
                    employeeId: 1, // Admin
                    title: 'Tapşırıq tamamlandı',
                    message: `${task.title} tapşırığı tamamlandı.`,
                    type: 'task'
                });
            }
            
            return task;
        }
        return null;
    },

    delete(taskId) {
        const data = Storage.getData();
        data.tasks = data.tasks.filter(t => t.id !== parseInt(taskId));
        Storage.setData(data);
    },

    getStats() {
        const tasks = this.getAll();
        
        return {
            pending: tasks.filter(t => t.status === 'pending').length,
            inProgress: tasks.filter(t => t.status === 'in-progress').length,
            completed: tasks.filter(t => t.status === 'completed').length,
            totalCount: tasks.length
        };
    }
};

// ============================================
// LEAVE MANAGER
// ============================================
const LeaveManager = {
    getForEmployee(employeeId) {
        const data = Storage.getData();
        if (!data.leaves) data.leaves = [];
        return data.leaves
            .filter(l => l.employeeId === parseInt(employeeId))
            .sort((a, b) => new Date(b.requestedAt) - new Date(a.requestedAt));
    },

    getAll(status = null) {
        const data = Storage.getData();
        if (!data.leaves) data.leaves = [];
        let leaves = data.leaves;
        if (status) {
            leaves = leaves.filter(l => l.status === status);
        }
        return leaves.sort((a, b) => new Date(b.requestedAt) - new Date(a.requestedAt));
    },

    create(leaveData) {
        const data = Storage.getData();
        const user = Auth.getCurrentUser();
        
        if (!data.leaves) data.leaves = [];
        
        // Calculate salary deduction for non-unpaid leaves
        let salaryDeduction = 0;
        if (leaveData.type !== 'unpaid' && user.salary) {
            const dailySalary = user.salary / 30;
            salaryDeduction = dailySalary * leaveData.days;
        }
        
        const newLeave = {
            id: Date.now(),
            employeeId: user.id,
            status: 'pending',
            requestedAt: new Date().toISOString().split('T')[0],
            salaryDeduction: salaryDeduction,
            isPaid: leaveData.type !== 'unpaid',
            ...leaveData
        };
        
        data.leaves.push(newLeave);
        Storage.setData(data);
        
        // Notify admin
        const leaveTypeText = leaveData.type === 'unpaid' ? 'pulsuz icazə' : 'icazə';
        NotificationManager.create({
            employeeId: 1, // Admin
            title: `Yeni ${leaveTypeText} istəyi`,
            message: `${user.fullName} ${leaveData.days} gün ${leaveTypeText} istədi.${salaryDeduction > 0 ? ` (Tutulacaq: ${UI.formatCurrency(salaryDeduction)})` : ''}`,
            type: 'leave'
        });
        
        return newLeave;
    },

    approve(leaveId, approvedBy) {
        const data = Storage.getData();
        const leave = data.leaves.find(l => l.id === parseInt(leaveId));
        if (leave) {
            leave.status = 'approved';
            leave.approvedBy = approvedBy;
            leave.approvedAt = new Date().toISOString().split('T')[0];
            Storage.setData(data);
            
            // Update employee leave balance only for paid leaves (not unpaid)
            if (leave.isPaid) {
                const employee = Storage.getUserById(leave.employeeId);
                if (employee && employee.leaveBalance) {
                    employee.leaveBalance.used += leave.days;
                    employee.leaveBalance.remaining -= leave.days;
                    Storage.updateUser(employee.id, { leaveBalance: employee.leaveBalance });
                }
                
                // Add salary deduction to employee's next salary
                if (leave.salaryDeduction > 0) {
                    this.addSalaryDeduction(leave.employeeId, leave.salaryDeduction, leave);
                }
            }
            
            // Notify employee
            const message = leave.isPaid 
                ? `İcazə istəyiniz təsdiqləndi. ${UI.formatCurrency(leave.salaryDeduction)} məbləğində tutulacaq.`
                : 'Pulsuz icazə istəyiniz təsdiqləndi. Maaşdan tutulma olmayacaq.';
            
            NotificationManager.create({
                employeeId: leave.employeeId,
                title: 'İcazə təsdiqləndi',
                message: message,
                type: 'leave'
            });
            
            return leave;
        }
        return null;
    },

    addSalaryDeduction(employeeId, amount, leave) {
        const data = Storage.getData();
        if (!data.salaryDeductions) data.salaryDeductions = [];
        
        data.salaryDeductions.push({
            id: Date.now(),
            employeeId: employeeId,
            amount: amount,
            leaveId: leave.id,
            description: `${UI.formatDate(leave.startDate)} - ${UI.formatDate(leave.endDate)} tarixləri arası icazə (${leave.days} gün)`,
            status: 'pending',
            createdAt: new Date().toISOString().split('T')[0]
        });
        
        Storage.setData(data);
    },

    reject(leaveId, reason) {
        const data = Storage.getData();
        const leave = data.leaves.find(l => l.id === parseInt(leaveId));
        if (leave) {
            leave.status = 'rejected';
            leave.rejectionReason = reason;
            leave.rejectedAt = new Date().toISOString().split('T')[0];
            Storage.setData(data);
            
            // Notify employee
            NotificationManager.create({
                employeeId: leave.employeeId,
                title: 'İcazə rədd edildi',
                message: `İcazə istəyiniz rədd edildi. Səbəb: ${reason}`,
                type: 'leave'
            });
            
            return leave;
        }
        return null;
    },

    calculateDays(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
    }
};

// ============================================
// LOGIN PAGE INITIALIZATION
// ============================================
function initLoginPage() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    // Check if already logged in
    const session = Storage.getSession();
    if (session) {
        redirectBasedOnRole(session.role);
        return;
    }

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const submitBtn = loginForm.querySelector('button[type="submit"]');
        
        UI.showLoading(submitBtn, 'Daxil olunur...');
        
        // Simulate network delay
        await new Promise(resolve => setTimeout(resolve, 500));
        
        const result = Auth.login(username, password);
        
        UI.hideLoading(submitBtn);
        
        if (result.success) {
            UI.showSuccess(result.message);
            setTimeout(() => redirectBasedOnRole(result.user.role), 500);
        } else {
            UI.showError(result.message);
        }
    });

    // Add enter key support for demo accounts
    document.querySelectorAll('.demo-card').forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', () => {
            const username = card.querySelector('p:first-of-type').textContent.split(':')[1].trim();
            const password = card.querySelector('p:last-of-type').textContent.split(':')[1].trim();
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
            loginForm.dispatchEvent(new Event('submit'));
        });
    });
}

function redirectBasedOnRole(role) {
    window.location.href = role === 'admin' ? 'admin-dashboard.html' : 'employee-dashboard.html';
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
// ADMIN DASHBOARD INITIALIZATION
// ============================================
function initAdminDashboard() {
    const user = Auth.checkAuth('admin');
    if (!user) return;

    // Update UI
    updateAdminUI(user);
    
    // Setup navigation
    setupNavigation();
    
    // Load initial data
    loadDashboardData();
    
    // Setup event listeners
    setupAdminEventListeners();
}

function updateAdminUI(user) {
    const adminNameEl = document.getElementById('admin-name');
    if (adminNameEl) adminNameEl.textContent = user.fullName;
}

function setupNavigation() {
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.dataset.page;
            showPage(page);
            
            navItems.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

function showPage(pageName) {
    document.querySelectorAll('.page-content').forEach(page => {
        page.classList.remove('active');
    });

    const selectedPage = document.getElementById(pageName + '-page');
    if (selectedPage) {
        selectedPage.classList.add('active');
    }

    updatePageTitle(pageName);
    
    // Load page-specific data
    switch(pageName) {
        case 'dashboard':
            loadDashboardData();
            break;
        case 'employees':
            loadEmployeesTable();
            break;
        case 'projects':
            loadAdminProjects();
            break;
        case 'attendance':
            loadAdminAttendance();
            break;
        case 'salary':
            loadAdminSalaries();
            break;
        case 'advances':
            loadAdminAdvances();
            break;
        case 'fines':
            loadAdminFines();
            break;
        case 'tasks':
            loadAdminTasks();
            break;
        case 'leaves':
            loadAdminLeaves();
            break;
        case 'reports':
            loadAdminReports();
            break;
    }
}

function updatePageTitle(pageName) {
    const titles = {
        dashboard: { title: 'Dashboard', subtitle: '555 İnşaat idarəetmə panelinə xoş gəlmisiniz' },
        employees: { title: 'İşçilər', subtitle: 'Bütün işçilərin idarə edilməsi' },
        projects: { title: 'Obyektlər', subtitle: 'Obyektlərin idarə edilməsi' },
        attendance: { title: 'Davamiyyət', subtitle: 'Gündəlik davamiyyət qeydləri' },
        salary: { title: 'Maaşlar', subtitle: 'Maaş hesablanması və ödənişlər' },
        advances: { title: 'Avanslar', subtitle: 'Avansların idarə edilməsi' },
        fines: { title: 'Cərimələr', subtitle: 'Cərimələrin idarə edilməsi' },
        tasks: { title: 'Tapşırıqlar', subtitle: 'Tapşırıqların idarə edilməsi' },
        leaves: { title: 'İcazələr', subtitle: 'İcazə istəklərinin idarə edilməsi' },
        reports: { title: 'Hesabatlar', subtitle: 'Müxtəlif hesabatlar' },
        settings: { title: 'Ayarlar', subtitle: 'Sistem ayarları' }
    };

    const titleInfo = titles[pageName] || titles.dashboard;
    const titleEl = document.getElementById('page-title');
    const subtitleEl = document.getElementById('page-subtitle');
    
    if (titleEl) titleEl.textContent = titleInfo.title;
    if (subtitleEl) subtitleEl.textContent = titleInfo.subtitle;
}

function loadDashboardData() {
    const stats = EmployeeManager.getStats();
    const projectStats = ProjectManager.getStats();
    const currentMonth = new Date().toISOString().slice(0, 7);
    const salaryStats = SalaryManager.getStats(currentMonth);
    const fineStats = FineManager.getStats();
    const todayStats = AttendanceManager.getTodayStats();
    
    // Update stat cards
    const totalEl = document.getElementById('total-employees');
    const activeEl = document.getElementById('active-employees');
    const todayAttendanceEl = document.getElementById('today-attendance');
    const activeProjectsEl = document.getElementById('active-projects');
    const salaryFundEl = document.getElementById('monthly-salary-fund');
    const monthlyFinesEl = document.getElementById('monthly-fines');
    
    if (totalEl) totalEl.textContent = stats.total;
    if (activeEl) activeEl.textContent = stats.active;
    if (todayAttendanceEl) todayAttendanceEl.textContent = todayStats.present;
    if (activeProjectsEl) activeProjectsEl.textContent = projectStats.active;
    if (salaryFundEl) salaryFundEl.textContent = UI.formatCurrency(salaryStats.totalFund);
    if (monthlyFinesEl) monthlyFinesEl.textContent = UI.formatCurrency(fineStats.monthlyAmount);
    
    // Load recent employees
    loadRecentEmployees();
    
    // Load recent activities
    loadRecentTasks();
    loadRecentFines();
    loadRecentAdvances();
    
    // Initialize charts
    initDashboardCharts();
}

// Dashboard Charts
let attendanceChart, projectsChart, salaryChart;

function initDashboardCharts() {
    initAttendanceChart();
    initProjectsChart();
    initSalaryChart();
}

function initAttendanceChart() {
    const ctx = document.getElementById('attendanceChart');
    if (!ctx) return;
    
    // Get last 7 days attendance data
    const labels = [];
    const presentData = [];
    const lateData = [];
    const absentData = [];
    
    for (let i = 6; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        const dateStr = date.toISOString().split('T')[0];
        labels.push(date.toLocaleDateString('az-AZ', { weekday: 'short' }));
        
        const records = AttendanceManager.getAll(dateStr);
        presentData.push(records.filter(r => r.status === 'present').length);
        lateData.push(records.filter(r => r.status === 'late').length);
        absentData.push(records.filter(r => r.status === 'absent').length);
    }
    
    if (attendanceChart) attendanceChart.destroy();
    
    attendanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'İşdə',
                    data: presentData,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Gecikmə',
                    data: lateData,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'İznsiz',
                    data: absentData,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

function initProjectsChart() {
    const ctx = document.getElementById('projectsChart');
    if (!ctx) return;
    
    const projects = ProjectManager.getAll();
    const labels = projects.map(p => p.name);
    const data = projects.map(p => ProjectManager.getEmployeeCount(p.id));
    const colors = ['#ff8c42', '#102542', '#10b981', '#3b82f6', '#8b5cf6', '#f59e0b'];
    
    if (projectsChart) projectsChart.destroy();
    
    projectsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors.slice(0, projects.length),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function initSalaryChart() {
    const ctx = document.getElementById('salaryChart');
    if (!ctx) return;
    
    // Get last 6 months salary data
    const labels = [];
    const salaryData = [];
    
    for (let i = 5; i >= 0; i--) {
        const date = new Date();
        date.setMonth(date.getMonth() - i);
        const monthStr = date.toISOString().slice(0, 7);
        labels.push(date.toLocaleDateString('az-AZ', { month: 'short' }));
        
        const stats = SalaryManager.getStats(monthStr);
        salaryData.push(stats.totalFund);
    }
    
    if (salaryChart) salaryChart.destroy();
    
    salaryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Maaş Fondu (₼)',
                data: salaryData,
                backgroundColor: '#102542',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' ₼';
                        }
                    }
                }
            }
        }
    });
}

function loadRecentTasks() {
    const tasks = TaskManager.getAll().slice(0, 5);
    const list = document.getElementById('recent-tasks');
    if (!list) return;
    
    if (tasks.length === 0) {
        list.innerHTML = '<li class="text-muted">Tapşırıq yoxdur</li>';
        return;
    }
    
    list.innerHTML = tasks.map(task => {
        const employee = Storage.getUserById(task.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        return `<li><span class="text-primary">${employeeName}</span> - ${task.title}</li>`;
    }).join('');
}

function loadRecentFines() {
    const fines = FineManager.getAll().slice(0, 5);
    const list = document.getElementById('recent-fines');
    if (!list) return;
    
    if (fines.length === 0) {
        list.innerHTML = '<li class="text-muted">Cərimə yoxdur</li>';
        return;
    }
    
    list.innerHTML = fines.map(fine => {
        const employee = Storage.getUserById(fine.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        return `<li><span class="text-danger">${employeeName}</span> - ${fine.reason} - ${fine.amount} ₼</li>`;
    }).join('');
}

function loadRecentAdvances() {
    const advances = AdvanceManager.getAll().slice(0, 5);
    const list = document.getElementById('recent-advances');
    if (!list) return;
    
    if (advances.length === 0) {
        list.innerHTML = '<li class="text-muted">Avans yoxdur</li>';
        return;
    }
    
    list.innerHTML = advances.map(advance => {
        const employee = Storage.getUserById(advance.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        return `<li><span class="text-primary">${employeeName}</span> - ${advance.amount} ₼</li>`;
    }).join('');
}

function loadRecentEmployees() {
    const employees = EmployeeManager.getAll().slice(0, 5);
    const tbody = document.getElementById('recent-employees');
    
    if (!tbody) return;
    
    tbody.innerHTML = employees.map(emp => `
        <tr>
            <td>
                <div style="display: flex; align-items: center; gap: 12px;">
                    ${UI.generateAvatar(emp.fullName, 36)}
                    <span>${emp.fullName}</span>
                </div>
            </td>
            <td>${UI.formatPhone(emp.phone)}</td>
            <td>${emp.position || '-'}</td>
            <td>${emp.project || '-'}</td>
            <td>${UI.getStatusBadge(emp.status)}</td>
        </tr>
    `).join('');
}

function loadEmployeesTable() {
    const employees = EmployeeManager.getAll();
    const tbody = document.getElementById('employees-table');
    
    if (!tbody) return;
    
    tbody.innerHTML = employees.map(emp => `
        <tr>
            <td>${emp.id}</td>
            <td>${UI.generateAvatar(emp.fullName, 36)}</td>
            <td>${emp.fullName}</td>
            <td>${emp.username}</td>
            <td>${UI.formatPhone(emp.phone)}</td>
            <td>${emp.position || '-'}</td>
            <td>${emp.project || '-'}</td>
            <td>${UI.getStatusBadge(emp.status)}</td>
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

function setupAdminEventListeners() {
    // Search filter
    const searchInput = document.getElementById('employee-search');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(filterEmployees, 300));
    }
    
    // Status filter
    const statusFilter = document.getElementById('status-filter');
    if (statusFilter) {
        statusFilter.addEventListener('change', filterEmployees);
    }
}

function filterEmployees() {
    const searchTerm = document.getElementById('employee-search')?.value || '';
    const statusFilter = document.getElementById('status-filter')?.value || '';
    
    const employees = EmployeeManager.getAll({
        search: searchTerm,
        status: statusFilter
    });
    
    const tbody = document.getElementById('employees-table');
    if (!tbody) return;
    
    tbody.innerHTML = employees.map(emp => `
        <tr>
            <td>${emp.id}</td>
            <td>${UI.generateAvatar(emp.fullName, 36)}</td>
            <td>${emp.fullName}</td>
            <td>${emp.username}</td>
            <td>${UI.formatPhone(emp.phone)}</td>
            <td>${emp.position || '-'}</td>
            <td>${emp.project || '-'}</td>
            <td>${UI.getStatusBadge(emp.status)}</td>
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
    
    // Set default values
    document.getElementById('emp-work-days').value = 22;
    document.getElementById('emp-daily-hours').value = 8;
    document.getElementById('emp-hourly-rate').value = '';
    
    // Add event listeners for auto-calculating hourly rate
    setupHourlyRateCalculation();
    
    UI.openModal('employeeModal');
}

function setupHourlyRateCalculation() {
    const salaryInput = document.getElementById('emp-salary');
    const workDaysInput = document.getElementById('emp-work-days');
    const dailyHoursInput = document.getElementById('emp-daily-hours');
    
    [salaryInput, workDaysInput, dailyHoursInput].forEach(input => {
        if (input) {
            input.addEventListener('input', calculateHourlyRate);
        }
    });
}

function editEmployee(id) {
    const employee = EmployeeManager.getById(id);
    if (!employee) return;
    
    editingEmployeeId = id;
    document.getElementById('modal-title').textContent = 'İşçini Redaktə Et';
    
    // Fill form
    document.getElementById('emp-fullname').value = employee.fullName;
    document.getElementById('emp-username').value = employee.username;
    document.getElementById('emp-password').value = employee.password;
    document.getElementById('emp-phone').value = employee.phone || '';
    document.getElementById('emp-position').value = employee.position || '';
    document.getElementById('emp-department').value = employee.department || '';
    document.getElementById('emp-project').value = employee.project || '';
    document.getElementById('emp-status').value = employee.status;
    document.getElementById('emp-salary').value = employee.salary || '';
    document.getElementById('emp-work-days').value = employee.workDays || 22;
    document.getElementById('emp-daily-hours').value = employee.dailyHours || 8;
    
    // Calculate hourly rate
    calculateHourlyRate();
    
    UI.openModal('employeeModal');
}

function calculateHourlyRate() {
    const salary = parseFloat(document.getElementById('emp-salary')?.value) || 0;
    const workDays = parseFloat(document.getElementById('emp-work-days')?.value) || 22;
    const dailyHours = parseFloat(document.getElementById('emp-daily-hours')?.value) || 8;
    
    const hourlyRateEl = document.getElementById('emp-hourly-rate');
    if (hourlyRateEl && salary > 0 && workDays > 0 && dailyHours > 0) {
        const hourlyRate = salary / (workDays * dailyHours);
        hourlyRateEl.value = hourlyRate.toFixed(2);
    }
}

function closeEmployeeModal() {
    UI.closeModal('employeeModal');
    editingEmployeeId = null;
}

function saveEmployee() {
    const employeeData = {
        fullName: document.getElementById('emp-fullname').value.trim(),
        username: document.getElementById('emp-username').value.trim(),
        password: document.getElementById('emp-password').value,
        phone: document.getElementById('emp-phone').value.trim(),
        position: document.getElementById('emp-position').value.trim(),
        department: document.getElementById('emp-department').value.trim(),
        project: document.getElementById('emp-project').value,
        status: document.getElementById('emp-status').value,
        salary: parseFloat(document.getElementById('emp-salary').value) || 0,
        workDays: parseInt(document.getElementById('emp-work-days').value) || 22,
        dailyHours: parseFloat(document.getElementById('emp-daily-hours').value) || 8
    };

    // Validation
    if (!employeeData.fullName || !employeeData.username || !employeeData.password) {
        UI.showError('Zəhmət olmasa bütün vacib sahələri doldurun!');
        return;
    }
    
    if (employeeData.salary <= 0) {
        UI.showError('Aylıq maaşı düzgün daxil edin!');
        return;
    }
    
    if (employeeData.workDays <= 0 || employeeData.workDays > 31) {
        UI.showError('Aylıq iş gününü düzgün daxil edin (1-31)!');
        return;
    }

    // Check username uniqueness
    const data = Storage.getData();
    const existingUser = data.users.find(u => 
        u.username.toLowerCase() === employeeData.username.toLowerCase() && 
        u.id !== editingEmployeeId
    );
    
    if (existingUser) {
        UI.showError('Bu istifadəçi adı artıq istifadə olunur!');
        return;
    }

    if (editingEmployeeId) {
        EmployeeManager.update(editingEmployeeId, employeeData);
    } else {
        EmployeeManager.create(employeeData);
        UI.showSuccess('Yeni işçi uğurla əlavə edildi!');
    }

    closeEmployeeModal();
    loadEmployeesTable();
    loadRecentEmployees();
    loadDashboardData();
}

function toggleEmployeeStatus(id) {
    const newStatus = EmployeeManager.toggleStatus(id);
    if (newStatus) {
        UI.showSuccess(`İşçi statusu ${newStatus === 'active' ? 'aktiv' : 'passiv'} edildi!`);
        loadEmployeesTable();
        loadDashboardData();
    }
}

function deleteEmployee(id) {
    UI.confirm('Bu işçini silmək istədiyinizə əminsiniz? Bu əməliyyat geri alına bilməz!', () => {
        const data = Storage.getData();
        data.users = data.users.filter(u => u.id !== parseInt(id));
        Storage.setData(data);
        UI.showSuccess('İşçi silindi!');
        loadEmployeesTable();
        loadDashboardData();
    });
}

// ============================================
// ADMIN LEAVE MANAGEMENT
// ============================================
let selectedLeaveId = null;

function loadAdminLeaves() {
    const statusFilter = document.getElementById('leave-status-filter')?.value || '';
    const leaves = LeaveManager.getAll(statusFilter);
    
    // Update stats
    const allLeaves = LeaveManager.getAll();
    document.getElementById('pending-leaves-count').textContent = allLeaves.filter(l => l.status === 'pending').length;
    document.getElementById('approved-leaves-count').textContent = allLeaves.filter(l => l.status === 'approved').length;
    document.getElementById('rejected-leaves-count').textContent = allLeaves.filter(l => l.status === 'rejected').length;
    
    // Update badge
    const badge = document.getElementById('pending-leaves-badge');
    if (badge) badge.textContent = allLeaves.filter(l => l.status === 'pending').length;
    
    const tbody = document.getElementById('admin-leaves-table');
    if (!tbody) return;
    
    if (leaves.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <p>Heç bir icazə istəyi yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = leaves.map(leave => {
        const employee = Storage.getUserById(leave.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        
        let salaryImpact = '';
        if (leave.type === 'unpaid') {
            salaryImpact = '<span class="text-success">0 ₼ (Pulsuz)</span>';
        } else if (leave.salaryDeduction > 0) {
            salaryImpact = `<span class="text-danger">-${UI.formatCurrency(leave.salaryDeduction)}</span>`;
        } else {
            salaryImpact = '<span class="text-muted">-</span>';
        }
        
        let actions = '';
        if (leave.status === 'pending') {
            actions = `
                <div class="btn-group">
                    <button class="btn btn-sm btn-success" onclick="openLeaveModal(${leave.id})" title="Təsdiqlə/Rədd et">
                        <i class="bi bi-check-lg"></i> Bax
                    </button>
                </div>
            `;
        } else {
            actions = `<span class="text-muted">${leave.status === 'approved' ? 'Təsdiqləndi' : 'Rədd edildi'}</span>`;
        }
        
        return `
            <tr>
                <td>${UI.generateAvatar(employeeName, 32)} ${employeeName}</td>
                <td>${leave.typeLabel}</td>
                <td>${UI.formatDate(leave.startDate)}</td>
                <td>${UI.formatDate(leave.endDate)}</td>
                <td>${leave.days}</td>
                <td>${salaryImpact}</td>
                <td>${UI.getStatusBadge(leave.status)}</td>
                <td>${actions}</td>
            </tr>
        `;
    }).join('');
}

function openLeaveModal(leaveId) {
    selectedLeaveId = leaveId;
    const leave = LeaveManager.getAll().find(l => l.id === leaveId);
    if (!leave) return;
    
    const employee = Storage.getUserById(leave.employeeId);
    const employeeName = employee ? employee.fullName : 'Naməlum';
    
    let salaryInfo = '';
    if (leave.type === 'unpaid') {
        salaryInfo = '<p><strong>Maaş təsiri:</strong> <span class="text-success">Pulsuz icazə - Tutulma olmayacaq</span></p>';
    } else if (leave.salaryDeduction > 0) {
        salaryInfo = `<p><strong>Maaş təsiri:</strong> <span class="text-danger">${UI.formatCurrency(leave.salaryDeduction)} tutulacaq</span></p>`;
    }
    
    document.getElementById('leave-details').innerHTML = `
        <div class="info-list">
            <div class="info-item">
                <span class="label">İşçi:</span>
                <span class="value">${employeeName}</span>
            </div>
            <div class="info-item">
                <span class="label">İcazə növü:</span>
                <span class="value">${leave.typeLabel}</span>
            </div>
            <div class="info-item">
                <span class="label">Tarix aralığı:</span>
                <span class="value">${UI.formatDate(leave.startDate)} - ${UI.formatDate(leave.endDate)}</span>
            </div>
            <div class="info-item">
                <span class="label">Gün sayı:</span>
                <span class="value">${leave.days} gün</span>
            </div>
            ${salaryInfo}
            <div class="info-item">
                <span class="label">Səbəb:</span>
                <span class="value">${leave.reason || '-'}</span>
            </div>
            <div class="info-item">
                <span class="label">İstək tarixi:</span>
                <span class="value">${UI.formatDate(leave.requestedAt)}</span>
            </div>
        </div>
    `;
    
    document.getElementById('reject-reason-container').style.display = 'none';
    document.getElementById('reject-reason').value = '';
    UI.openModal('leaveActionModal');
}

function closeLeaveModal() {
    UI.closeModal('leaveActionModal');
    selectedLeaveId = null;
}

function showRejectForm() {
    document.getElementById('reject-reason-container').style.display = 'block';
    document.getElementById('leave-modal-footer').innerHTML = `
        <button class="btn btn-secondary" onclick="cancelReject()">Geri</button>
        <button class="btn btn-danger" onclick="confirmReject()">Rədd et</button>
    `;
}

function cancelReject() {
    document.getElementById('reject-reason-container').style.display = 'none';
    document.getElementById('reject-reason').value = '';
    document.getElementById('leave-modal-footer').innerHTML = `
        <button class="btn btn-secondary" onclick="closeLeaveModal()">Bağla</button>
        <button class="btn btn-danger" onclick="showRejectForm()">Rədd et</button>
        <button class="btn btn-success" onclick="approveLeave()">Təsdiqlə</button>
    `;
}

function approveLeave() {
    if (!selectedLeaveId) return;
    
    const user = Auth.getCurrentUser();
    LeaveManager.approve(selectedLeaveId, user.id);
    
    UI.showSuccess('İcazə təsdiqləndi!');
    closeLeaveModal();
    loadAdminLeaves();
}

function confirmReject() {
    if (!selectedLeaveId) return;
    
    const reason = document.getElementById('reject-reason').value.trim();
    if (!reason) {
        UI.showError('Rədd səbəbini qeyd edin!');
        return;
    }
    
    LeaveManager.reject(selectedLeaveId, reason);
    
    UI.showSuccess('İcazə rədd edildi!');
    closeLeaveModal();
    loadAdminLeaves();
}

// Setup leave filter
document.addEventListener('DOMContentLoaded', function() {
    const leaveFilter = document.getElementById('leave-status-filter');
    if (leaveFilter) {
        leaveFilter.addEventListener('change', loadAdminLeaves);
    }
});

// ============================================
// ADMIN ADVANCE MANAGEMENT
// ============================================
let selectedAdvanceId = null;

function loadAdminAdvances() {
    const statusFilter = document.getElementById('advance-status-filter')?.value || '';
    const advances = AdvanceManager.getAll(statusFilter);
    
    // Update stats
    const allAdvances = AdvanceManager.getAll();
    const pendingAdvances = allAdvances.filter(a => a.status === 'pending');
    const approvedAdvances = allAdvances.filter(a => a.status === 'approved');
    const currentMonth = new Date().toISOString().slice(0, 7);
    const monthlyTotal = allAdvances
        .filter(a => a.requestedAt.startsWith(currentMonth) && (a.status === 'approved' || a.status === 'deducted'))
        .reduce((sum, a) => sum + a.amount, 0);
    
    document.getElementById('pending-advances-count').textContent = pendingAdvances.length;
    document.getElementById('approved-advances-count').textContent = approvedAdvances.length;
    document.getElementById('total-advances-amount').textContent = UI.formatCurrency(monthlyTotal);
    
    // Update badge
    const badge = document.getElementById('pending-advances-badge');
    if (badge) {
        badge.textContent = pendingAdvances.length;
        badge.style.display = pendingAdvances.length > 0 ? 'inline-flex' : 'none';
    }
    
    const tbody = document.getElementById('admin-advances-table');
    if (!tbody) return;
    
    if (advances.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-cash-stack"></i>
                        <p>Heç bir avans istəyi yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = advances.map(advance => {
        const employee = Storage.getUserById(advance.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        
        let actions = '';
        if (advance.status === 'pending') {
            actions = `
                <div class="btn-group">
                    <button class="btn btn-sm btn-success" onclick="openAdvanceModal(${advance.id})" title="Təsdiqlə/Rədd et">
                        <i class="bi bi-check-lg"></i> Bax
                    </button>
                </div>
            `;
        } else if (advance.status === 'approved') {
            actions = `
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary" onclick="markAdvanceDeducted(${advance.id})" title="Çıxıldı kimi işarələ">
                        <i class="bi bi-cash-stack"></i> Çıxıldı
                    </button>
                </div>
            `;
        } else {
            actions = `<span class="text-muted">${advance.status === 'deducted' ? 'Çıxıldı' : 'Rədd edildi'}</span>`;
        }
        
        return `
            <tr>
                <td>${UI.generateAvatar(employeeName, 32)} ${employeeName}</td>
                <td><strong>${UI.formatCurrency(advance.amount)}</strong></td>
                <td>${advance.reason}</td>
                <td>${UI.formatDate(advance.requestedAt)}</td>
                <td>${UI.getStatusBadge(advance.status)}</td>
                <td>${actions}</td>
            </tr>
        `;
    }).join('');
}

function openAdvanceModal(advanceId) {
    selectedAdvanceId = advanceId;
    const advance = AdvanceManager.getAll().find(a => a.id === advanceId);
    if (!advance) return;
    
    const employee = Storage.getUserById(advance.employeeId);
    const employeeName = employee ? employee.fullName : 'Naməlum';
    
    document.getElementById('advance-details').innerHTML = `
        <div class="info-list">
            <div class="info-item">
                <span class="label">İşçi:</span>
                <span class="value">${employeeName}</span>
            </div>
            <div class="info-item">
                <span class="label">Məbləğ:</span>
                <span class="value"><strong>${UI.formatCurrency(advance.amount)}</strong></span>
            </div>
            <div class="info-item">
                <span class="label">Səbəb:</span>
                <span class="value">${advance.reason}</span>
            </div>
            <div class="info-item">
                <span class="label">İstək tarixi:</span>
                <span class="value">${UI.formatDate(advance.requestedAt)}</span>
            </div>
            ${advance.requestedDate ? `
            <div class="info-item">
                <span class="label">İstənilən ödəniş:</span>
                <span class="value">${UI.formatDate(advance.requestedDate)}</span>
            </div>
            ` : ''}
        </div>
    `;
    
    document.getElementById('advance-reject-reason-container').style.display = 'none';
    document.getElementById('advance-reject-reason').value = '';
    document.getElementById('advance-modal-footer').innerHTML = `
        <button class="btn btn-secondary" onclick="closeAdvanceModal()">Bağla</button>
        <button class="btn btn-danger" onclick="showAdvanceRejectForm()">Rədd et</button>
        <button class="btn btn-success" onclick="approveAdvance()">Təsdiqlə</button>
    `;
    UI.openModal('advanceActionModal');
}

function closeAdvanceModal() {
    UI.closeModal('advanceActionModal');
    selectedAdvanceId = null;
}

function showAdvanceRejectForm() {
    document.getElementById('advance-reject-reason-container').style.display = 'block';
    document.getElementById('advance-modal-footer').innerHTML = `
        <button class="btn btn-secondary" onclick="cancelAdvanceReject()">Geri</button>
        <button class="btn btn-danger" onclick="confirmAdvanceReject()">Rədd et</button>
    `;
}

function cancelAdvanceReject() {
    document.getElementById('advance-reject-reason-container').style.display = 'none';
    document.getElementById('advance-reject-reason').value = '';
    document.getElementById('advance-modal-footer').innerHTML = `
        <button class="btn btn-secondary" onclick="closeAdvanceModal()">Bağla</button>
        <button class="btn btn-danger" onclick="showAdvanceRejectForm()">Rədd et</button>
        <button class="btn btn-success" onclick="approveAdvance()">Təsdiqlə</button>
    `;
}

function approveAdvance() {
    if (!selectedAdvanceId) return;
    
    const user = Auth.getCurrentUser();
    AdvanceManager.approve(selectedAdvanceId, user.id);
    
    UI.showSuccess('Avans təsdiqləndi!');
    closeAdvanceModal();
    loadAdminAdvances();
}

function confirmAdvanceReject() {
    if (!selectedAdvanceId) return;
    
    const reason = document.getElementById('advance-reject-reason').value.trim();
    if (!reason) {
        UI.showError('Rədd səbəbini qeyd edin!');
        return;
    }
    
    AdvanceManager.reject(selectedAdvanceId, reason);
    
    UI.showSuccess('Avans rədd edildi!');
    closeAdvanceModal();
    loadAdminAdvances();
}

function markAdvanceDeducted(advanceId) {
    UI.confirm('Bu avansı maaşdan çıxıldı kimi işarələmək istədiyinizə əminsiniz?', () => {
        AdvanceManager.markAsDeducted(advanceId);
        UI.showSuccess('Avans çıxıldı kimi işarələndi!');
        loadAdminAdvances();
    });
}

// Setup advance filter
document.addEventListener('DOMContentLoaded', function() {
    const advanceFilter = document.getElementById('advance-status-filter');
    if (advanceFilter) {
        advanceFilter.addEventListener('change', loadAdminAdvances);
    }
});

// ============================================
// ADMIN PROJECT MANAGEMENT
// ============================================
let editingProjectId = null;

function loadAdminProjects() {
    const statusFilter = document.getElementById('project-status-filter')?.value || '';
    const projects = ProjectManager.getAll(statusFilter);
    
    // Update stats
    const stats = ProjectManager.getStats();
    document.getElementById('total-projects-count').textContent = stats.total;
    document.getElementById('active-projects-count').textContent = stats.active;
    document.getElementById('project-employees-count').textContent = stats.employeeCount;
    
    const tbody = document.getElementById('projects-table');
    if (!tbody) return;
    
    if (projects.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-building"></i>
                        <p>Heç bir obyekt yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = projects.map(project => {
        const employeeCount = ProjectManager.getEmployeeCount(project.id);
        
        return `
            <tr>
                <td>${project.id}</td>
                <td><strong>${project.name}</strong></td>
                <td>${project.location}</td>
                <td>${UI.formatDate(project.startDate)}</td>
                <td>${employeeCount} işçi</td>
                <td>${UI.getStatusBadge(project.status)}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary" onclick="editProject(${project.id})" title="Redaktə">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteProject(${project.id})" title="Sil">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function openProjectModal() {
    editingProjectId = null;
    document.getElementById('project-modal-title').textContent = 'Yeni Obyekt Əlavə Et';
    document.getElementById('projectForm').reset();
    document.getElementById('project-start-date').value = new Date().toISOString().split('T')[0];
    UI.openModal('projectModal');
}

function closeProjectModal() {
    UI.closeModal('projectModal');
    editingProjectId = null;
}

function editProject(id) {
    const project = ProjectManager.getById(id);
    if (!project) return;
    
    editingProjectId = id;
    document.getElementById('project-modal-title').textContent = 'Obyekti Redaktə Et';
    
    document.getElementById('project-name').value = project.name;
    document.getElementById('project-location').value = project.location;
    document.getElementById('project-start-date').value = project.startDate;
    document.getElementById('project-status').value = project.status;
    
    UI.openModal('projectModal');
}

function saveProject() {
    const projectData = {
        name: document.getElementById('project-name').value.trim(),
        location: document.getElementById('project-location').value.trim(),
        startDate: document.getElementById('project-start-date').value,
        status: document.getElementById('project-status').value
    };
    
    if (!projectData.name || !projectData.location) {
        UI.showError('Zəhmət olmasa bütün vacib sahələri doldurun!');
        return;
    }
    
    if (editingProjectId) {
        ProjectManager.update(editingProjectId, projectData);
        UI.showSuccess('Obyekt yeniləndi!');
    } else {
        ProjectManager.create(projectData);
        UI.showSuccess('Yeni obyekt əlavə edildi!');
    }
    
    closeProjectModal();
    loadAdminProjects();
}

function deleteProject(id) {
    UI.confirm('Bu obyekti silmək istədiyinizə əminsiniz?', () => {
        ProjectManager.delete(id);
        UI.showSuccess('Obyekt silindi!');
        loadAdminProjects();
    });
}

// Setup project filter
document.addEventListener('DOMContentLoaded', function() {
    const projectFilter = document.getElementById('project-status-filter');
    if (projectFilter) {
        projectFilter.addEventListener('change', loadAdminProjects);
    }
});

// ============================================
// ADMIN ATTENDANCE MANAGEMENT
// ============================================
function loadAdminAttendance() {
    const dateFilter = document.getElementById('attendance-date')?.value || new Date().toISOString().split('T')[0];
    const statusFilter = document.getElementById('attendance-status-filter')?.value || '';
    
    // Update stats for today
    const todayStats = AttendanceManager.getTodayStats();
    document.getElementById('today-present-count').textContent = todayStats.present;
    document.getElementById('today-late-count').textContent = todayStats.late;
    document.getElementById('today-absent-count').textContent = todayStats.absent;
    
    // Set default date if not set
    const dateInput = document.getElementById('attendance-date');
    if (dateInput && !dateInput.value) {
        dateInput.value = new Date().toISOString().split('T')[0];
    }
    
    const records = AttendanceManager.getAll(dateFilter, statusFilter);
    const tbody = document.getElementById('attendance-table');
    
    if (!tbody) return;
    
    if (records.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <p>Bu tarixdə davamiyyət qeydi yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = records.map(record => {
        const employee = Storage.getUserById(record.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        
        return `
            <tr>
                <td>${UI.generateAvatar(employeeName, 32)} ${employeeName}</td>
                <td>${UI.formatDate(record.date)}</td>
                <td>${record.checkIn || '-'}</td>
                <td>${record.checkOut || '-'}</td>
                <td>${UI.getStatusBadge(record.status)}</td>
                <td>${record.notes || '-'}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary" onclick="editAttendance(${record.id})" title="Redaktə">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteAttendance(${record.id})" title="Sil">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function editAttendance(id) {
    // TODO: Implement attendance edit modal
    UI.showNotification('Davamiyyət redaktəsi tezliklə əlavə ediləcək', 'info');
}

function deleteAttendance(id) {
    UI.confirm('Bu davamiyyət qeydini silmək istədiyinizə əminsiniz?', () => {
        AttendanceManager.delete(id);
        UI.showSuccess('Davamiyyət qeydi silindi!');
        loadAdminAttendance();
    });
}

// Setup attendance filters
document.addEventListener('DOMContentLoaded', function() {
    const dateFilter = document.getElementById('attendance-date');
    const statusFilter = document.getElementById('attendance-status-filter');
    
    if (dateFilter) {
        dateFilter.addEventListener('change', loadAdminAttendance);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', loadAdminAttendance);
    }
});

// ============================================
// ADMIN SALARY MANAGEMENT
// ============================================
function loadAdminSalaries() {
    const monthFilter = document.getElementById('salary-month-filter')?.value || '2025-03';
    const statusFilter = document.getElementById('salary-status-filter')?.value || '';
    
    // Update stats
    const stats = SalaryManager.getStats(monthFilter);
    document.getElementById('total-salary-fund').textContent = UI.formatCurrency(stats.totalFund);
    document.getElementById('pending-salary-count').textContent = stats.pending;
    document.getElementById('paid-salary-count').textContent = stats.paid;
    
    const salaries = SalaryManager.getAll(monthFilter, statusFilter);
    const tbody = document.getElementById('salary-table');
    
    if (!tbody) return;
    
    if (salaries.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="10" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-cash-stack"></i>
                        <p>Bu ay üçün maaş hesablanmayıb</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = salaries.map(salary => {
        const employee = Storage.getUserById(salary.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        
        let actions = '';
        if (salary.status === 'pending') {
            actions = `
                <button class="btn btn-sm btn-success" onclick="markSalaryPaid(${salary.id})" title="Ödəndi kimi işarələ">
                    <i class="bi bi-check-lg"></i> Ödə
                </button>
            `;
        } else {
            actions = `<span class="text-muted">Ödənilib</span>`;
        }
        
        return `
            <tr>
                <td>${UI.generateAvatar(employeeName, 32)} ${employeeName}</td>
                <td>${salary.month}</td>
                <td>${UI.formatCurrency(salary.baseSalary)}</td>
                <td class="text-success">+${UI.formatCurrency(salary.bonus)}</td>
                <td class="text-success">+${UI.formatCurrency(salary.overtime)}</td>
                <td class="text-danger">-${UI.formatCurrency(salary.advance)}</td>
                <td class="text-danger">-${UI.formatCurrency(salary.fine)}</td>
                <td><strong>${UI.formatCurrency(salary.netSalary)}</strong></td>
                <td>${UI.getStatusBadge(salary.status)}</td>
                <td>${actions}</td>
            </tr>
        `;
    }).join('');
}

function calculateMonthlySalary() {
    const month = document.getElementById('salary-month-filter')?.value || '2025-03';
    const employees = EmployeeManager.getAll({ status: 'active' });
    
    let count = 0;
    employees.forEach(employee => {
        // Check if salary already calculated for this month
        const existing = SalaryManager.getAll(month).find(s => s.employeeId === employee.id);
        if (!existing) {
            const salaryData = SalaryManager.calculateSalary(employee.id, month);
            if (salaryData) {
                SalaryManager.create(salaryData);
                count++;
            }
        }
    });
    
    if (count > 0) {
        UI.showSuccess(`${count} işçi üçün maaş hesablandı!`);
    } else {
        UI.showNotification('Bütün işçilər üçün maaş artıq hesablanıb', 'info');
    }
    
    loadAdminSalaries();
}

function markSalaryPaid(salaryId) {
    SalaryManager.markAsPaid(salaryId);
    UI.showSuccess('Maaş ödəndi kimi işarələndi!');
    loadAdminSalaries();
}

// Setup salary filters
document.addEventListener('DOMContentLoaded', function() {
    const monthFilter = document.getElementById('salary-month-filter');
    const statusFilter = document.getElementById('salary-status-filter');
    
    if (monthFilter) {
        monthFilter.addEventListener('change', loadAdminSalaries);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', loadAdminSalaries);
    }
});

// ============================================
// ADMIN FINE MANAGEMENT
// ============================================
function loadAdminFines() {
    const statusFilter = document.getElementById('fine-status-filter')?.value || '';
    const fines = FineManager.getAll(statusFilter);
    
    // Update stats
    const stats = FineManager.getStats();
    document.getElementById('active-fines-count').textContent = stats.active;
    document.getElementById('monthly-fines-amount').textContent = UI.formatCurrency(stats.monthlyAmount);
    document.getElementById('deducted-fines-count').textContent = stats.deducted;
    
    const tbody = document.getElementById('fines-table');
    if (!tbody) return;
    
    if (fines.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-exclamation-triangle"></i>
                        <p>Heç bir cərimə yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = fines.map(fine => {
        const employee = Storage.getUserById(fine.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        
        let actions = '';
        if (fine.status === 'active') {
            actions = `
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary" onclick="markFineDeducted(${fine.id})" title="Çıxıldı kimi işarələ">
                        <i class="bi bi-cash-stack"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteFine(${fine.id})" title="Sil">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
        } else {
            actions = `<span class="text-muted">Çıxıldı</span>`;
        }
        
        return `
            <tr>
                <td>${UI.generateAvatar(employeeName, 32)} ${employeeName}</td>
                <td class="text-danger"><strong>${UI.formatCurrency(fine.amount)}</strong></td>
                <td>${fine.reason}</td>
                <td>${UI.formatDate(fine.date)}</td>
                <td>${UI.getStatusBadge(fine.status)}</td>
                <td>${actions}</td>
            </tr>
        `;
    }).join('');
}

function openFineModal() {
    document.getElementById('fineForm').reset();
    document.getElementById('fine-date').value = new Date().toISOString().split('T')[0];
    
    // Load employees dropdown
    const employees = EmployeeManager.getAll();
    const select = document.getElementById('fine-employee');
    select.innerHTML = '<option value="">Seçin</option>' + 
        employees.map(e => `<option value="${e.id}">${e.fullName}</option>`).join('');
    
    UI.openModal('fineModal');
}

function closeFineModal() {
    UI.closeModal('fineModal');
}

function saveFine() {
    const fineData = {
        employeeId: parseInt(document.getElementById('fine-employee').value),
        amount: parseFloat(document.getElementById('fine-amount').value),
        date: document.getElementById('fine-date').value,
        reason: document.getElementById('fine-reason').value.trim()
    };
    
    if (!fineData.employeeId || !fineData.amount || !fineData.reason) {
        UI.showError('Zəhmət olmasa bütün vacib sahələri doldurun!');
        return;
    }
    
    FineManager.create(fineData);
    UI.showSuccess('Cərimə əlavə edildi!');
    closeFineModal();
    loadAdminFines();
}

function markFineDeducted(fineId) {
    FineManager.markAsDeducted(fineId);
    UI.showSuccess('Cərimə çıxıldı kimi işarələndi!');
    loadAdminFines();
}

function deleteFine(fineId) {
    UI.confirm('Bu cəriməni silmək istədiyinizə əminsiniz?', () => {
        FineManager.delete(fineId);
        UI.showSuccess('Cərimə silindi!');
        loadAdminFines();
    });
}

// Setup fine filter
document.addEventListener('DOMContentLoaded', function() {
    const fineFilter = document.getElementById('fine-status-filter');
    if (fineFilter) {
        fineFilter.addEventListener('change', loadAdminFines);
    }
});

// ============================================
// ADMIN TASK MANAGEMENT
// ============================================
function loadAdminTasks() {
    const statusFilter = document.getElementById('task-status-filter')?.value || '';
    const priorityFilter = document.getElementById('task-priority-filter')?.value || '';
    
    // Update stats
    const stats = TaskManager.getStats();
    document.getElementById('pending-tasks-count').textContent = stats.pending;
    document.getElementById('inprogress-tasks-count').textContent = stats.inProgress;
    document.getElementById('completed-tasks-count').textContent = stats.completed;
    
    const tasks = TaskManager.getAll(statusFilter, priorityFilter);
    const tbody = document.getElementById('tasks-table');
    
    if (!tbody) return;
    
    if (tasks.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-list-task"></i>
                        <p>Heç bir tapşırıq yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = tasks.map(task => {
        const employee = Storage.getUserById(task.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        const project = ProjectManager.getById(task.projectId);
        const projectName = project ? project.name : '-';
        
        const priorityLabels = { high: 'Yüksək', medium: 'Orta', low: 'Aşağı' };
        const priorityClass = { high: 'text-danger', medium: 'text-warning', low: 'text-success' };
        
        let actions = `
            <div class="btn-group">
                <button class="btn btn-sm btn-primary" onclick="editTask(${task.id})" title="Redaktə">
                    <i class="bi bi-pencil"></i>
                </button>
        `;
        
        if (task.status !== 'completed') {
            actions += `
                <button class="btn btn-sm btn-success" onclick="markTaskCompleted(${task.id})" title="Tamamlandı">
                    <i class="bi bi-check-lg"></i>
                </button>
            `;
        }
        
        actions += `
                <button class="btn btn-sm btn-danger" onclick="deleteTask(${task.id})" title="Sil">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        
        return `
            <tr>
                <td><strong>${task.title}</strong></td>
                <td>${UI.generateAvatar(employeeName, 32)} ${employeeName}</td>
                <td>${projectName}</td>
                <td>${UI.formatDate(task.dueDate)}</td>
                <td class="${priorityClass[task.priority]}">${priorityLabels[task.priority]}</td>
                <td>${UI.getStatusBadge(task.status)}</td>
                <td>${actions}</td>
            </tr>
        `;
    }).join('');
}

function openTaskModal() {
    document.getElementById('taskForm').reset();
    document.getElementById('task-due-date').value = new Date().toISOString().split('T')[0];
    
    // Load employees dropdown
    const employees = EmployeeManager.getAll();
    const employeeSelect = document.getElementById('task-employee');
    employeeSelect.innerHTML = '<option value="">Seçin</option>' + 
        employees.map(e => `<option value="${e.id}">${e.fullName}</option>`).join('');
    
    // Load projects dropdown
    const projects = ProjectManager.getAll();
    const projectSelect = document.getElementById('task-project');
    projectSelect.innerHTML = '<option value="">Seçin</option>' + 
        projects.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
    
    UI.openModal('taskModal');
}

function closeTaskModal() {
    UI.closeModal('taskModal');
}

function saveTask() {
    const taskData = {
        title: document.getElementById('task-title').value.trim(),
        description: document.getElementById('task-description').value.trim(),
        employeeId: parseInt(document.getElementById('task-employee').value),
        projectId: parseInt(document.getElementById('task-project').value) || null,
        dueDate: document.getElementById('task-due-date').value,
        priority: document.getElementById('task-priority').value,
        createdBy: Auth.getCurrentUser()?.id
    };
    
    if (!taskData.title || !taskData.employeeId || !taskData.dueDate) {
        UI.showError('Zəhmət olmasa bütün vacib sahələri doldurun!');
        return;
    }
    
    TaskManager.create(taskData);
    UI.showSuccess('Tapşırıq əlavə edildi!');
    closeTaskModal();
    loadAdminTasks();
}

function editTask(taskId) {
    // TODO: Implement task edit
    UI.showNotification('Tapşırıq redaktəsi tezliklə əlavə ediləcək', 'info');
}

function markTaskCompleted(taskId) {
    TaskManager.updateStatus(taskId, 'completed');
    UI.showSuccess('Tapşırıq tamamlandı kimi işarələndi!');
    loadAdminTasks();
}

function deleteTask(taskId) {
    UI.confirm('Bu tapşırığı silmək istədiyinizə əminsiniz?', () => {
        TaskManager.delete(taskId);
        UI.showSuccess('Tapşırıq silindi!');
        loadAdminTasks();
    });
}

// Setup task filters
document.addEventListener('DOMContentLoaded', function() {
    const taskStatusFilter = document.getElementById('task-status-filter');
    const taskPriorityFilter = document.getElementById('task-priority-filter');
    
    if (taskStatusFilter) {
        taskStatusFilter.addEventListener('change', loadAdminTasks);
    }
    if (taskPriorityFilter) {
        taskPriorityFilter.addEventListener('change', loadAdminTasks);
    }
});

// ============================================
// ADMIN REPORTS
// ============================================
function loadAdminReports() {
    // General stats
    const employeeStats = EmployeeManager.getStats();
    const projectStats = ProjectManager.getStats();
    const currentMonth = new Date().toISOString().slice(0, 7);
    const salaryStats = SalaryManager.getStats(currentMonth);
    const advanceStats = AdvanceManager.getAll().filter(a => a.requestedAt.startsWith(currentMonth));
    const fineStats = FineManager.getStats();
    
    document.getElementById('report-total-employees').textContent = employeeStats.total;
    document.getElementById('report-active-employees').textContent = employeeStats.active;
    document.getElementById('report-active-projects').textContent = projectStats.active;
    document.getElementById('report-monthly-salary').textContent = UI.formatCurrency(salaryStats.totalFund);
    document.getElementById('report-monthly-advances').textContent = UI.formatCurrency(
        advanceStats.reduce((sum, a) => sum + a.amount, 0)
    );
    document.getElementById('report-monthly-fines').textContent = UI.formatCurrency(fineStats.monthlyAmount);
    
    // Projects breakdown
    const projectsList = document.getElementById('report-projects-list');
    if (projectsList) {
        const projects = ProjectManager.getAll();
        projectsList.innerHTML = projects.map(project => {
            const employeeCount = ProjectManager.getEmployeeCount(project.id);
            return `
                <div class="report-item">
                    <span class="name">${project.name}</span>
                    <span class="count">${employeeCount} işçi</span>
                </div>
            `;
        }).join('');
    }
    
    // Attendance report
    generateReport();
}

function generateReport() {
    const month = document.getElementById('report-month')?.value || '2025-03';
    const employees = EmployeeManager.getAll();
    const tbody = document.getElementById('report-attendance-table');
    
    if (!tbody) return;
    
    tbody.innerHTML = employees.map(employee => {
        const stats = AttendanceManager.getMonthlyStats(employee.id, month);
        const totalDays = stats.present + stats.late + stats.absent + stats.excused;
        const attendanceRate = totalDays > 0 ? Math.round((stats.present / totalDays) * 100) : 0;
        
        return `
            <tr>
                <td>${UI.generateAvatar(employee.fullName, 32)} ${employee.fullName}</td>
                <td>${employee.project || '-'}</td>
                <td>${stats.present}</td>
                <td>${stats.late}</td>
                <td>${stats.absent}</td>
                <td>${stats.excused}</td>
                <td>
                    <div class="progress-bar">
                        <div class="progress" style="width: ${attendanceRate}%; background: ${attendanceRate >= 90 ? '#10b981' : attendanceRate >= 70 ? '#f59e0b' : '#ef4444'}"></div>
                        <span>${attendanceRate}%</span>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

// Setup report month filter
document.addEventListener('DOMContentLoaded', function() {
    const reportMonth = document.getElementById('report-month');
    if (reportMonth) {
        reportMonth.addEventListener('change', generateReport);
    }
});

// ============================================
// EMPLOYEE DASHBOARD INITIALIZATION
// ============================================
function initEmployeeDashboard() {
    const user = Auth.checkAuth('employee');
    if (!user) return;

    // Update UI
    updateEmployeeUI(user);
    
    // Setup navigation
    setupEmployeeNavigation();
    
    // Setup forms
    setupLeaveForm();
    setupAdvanceForm();
    setupPasswordForm();
    
    // Load data
    loadEmployeeData(user.id);
}

function updateEmployeeUI(user) {
    // Update sidebar info
    const empNameEl = document.getElementById('emp-name');
    const empAvatarEl = document.getElementById('emp-avatar');
    
    if (empNameEl) empNameEl.textContent = user.fullName;
    if (empAvatarEl) empAvatarEl.textContent = UI.getInitials(user.fullName);
    
    // Update profile page
    const profileInitialEl = document.getElementById('profile-initial');
    const profileNameEl = document.getElementById('profile-name');
    const profilePositionEl = document.getElementById('profile-position');
    
    if (profileInitialEl) profileInitialEl.textContent = UI.getInitials(user.fullName);
    if (profileNameEl) profileNameEl.textContent = user.fullName;
    if (profilePositionEl) profilePositionEl.textContent = user.position || 'İşçi';
    
    // Fill info list
    const infoFields = {
        'info-name': user.fullName,
        'info-username': user.username,
        'info-phone': UI.formatPhone(user.phone),
        'info-position': user.position || '-',
        'info-department': user.department || '-',
        'info-project': user.project || '-',
        'info-joined': UI.formatDate(user.createdAt)
    };
    
    Object.entries(infoFields).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    });
    
    // Update stats cards
    const workDaysEl = document.getElementById('emp-stat-work-days');
    const salaryEl = document.getElementById('emp-stat-salary');
    const advanceEl = document.getElementById('emp-stat-advance');
    
    if (workDaysEl) workDaysEl.textContent = user.workDays || 22;
    if (salaryEl) salaryEl.textContent = UI.formatCurrency(user.salary || 0);
    if (advanceEl) {
        // Get current month pending advance
        const currentMonth = new Date().toISOString().slice(0, 7);
        const data = Storage.getData();
        const pendingAdvance = data.advances?.filter(a => 
            a.employeeId === user.id && 
            a.requestedAt?.startsWith(currentMonth) &&
            (a.status === 'pending' || a.status === 'approved')
        ).reduce((sum, a) => sum + a.amount, 0) || 0;
        advanceEl.textContent = UI.formatCurrency(pendingAdvance);
    }
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

    const titleEl = document.getElementById('page-title');
    if (titleEl) titleEl.textContent = titles[pageName] || 'Profil';
    
    const user = Auth.getCurrentUser();
    if (!user) return;
    
    // Load page-specific data
    switch(pageName) {
        case 'profile':
            updateEmployeeUI(user);
            break;
        case 'attendance':
            loadEmployeeAttendanceStats(user.id);
            break;
        case 'salary':
            loadEmployeeSalaryHistory(user.id);
            break;
        case 'leaves':
            loadLeaveHistory();
            updateLeaveBalance();
            break;
        case 'advances':
            loadAdvanceHistory();
            updateAdvanceStats();
            break;
        case 'tasks':
            loadEmployeeTasks(user.id);
            break;
        case 'fines':
            loadEmployeeFines(user.id);
            break;
    }
}

function loadEmployeeData(employeeId) {
    // Load notifications count
    const unreadCount = NotificationManager.getUnreadCount(employeeId);
    const badgeEl = document.querySelector('.nav-item[data-page="notifications"] .badge');
    if (badgeEl) badgeEl.textContent = unreadCount;
    
    // Load salary history
    loadEmployeeSalaryHistory(employeeId);
    
    // Load attendance stats
    loadEmployeeAttendanceStats(employeeId);
    
    // Load tasks
    loadEmployeeTasks(employeeId);
    
    // Load fines
    loadEmployeeFines(employeeId);
}

function loadEmployeeTasks(employeeId) {
    const tasksList = document.getElementById('employee-tasks-list');
    if (!tasksList) return;
    
    const tasks = TaskManager.getForEmployee(employeeId);
    
    if (tasks.length === 0) {
        tasksList.innerHTML = `
            <div class="empty-state">
                <i class="bi bi-list-task"></i>
                <p>Heç bir tapşırıq yoxdur</p>
            </div>
        `;
        return;
    }
    
    const priorityLabels = { high: 'Yüksək', medium: 'Orta', low: 'Aşağı' };
    const priorityClass = { high: 'high', medium: 'medium', low: 'low' };
    
    tasksList.innerHTML = tasks.map(task => `
        <div class="task-item ${task.status}">
            <div class="task-status"></div>
            <div class="task-content">
                <h4>${task.title}</h4>
                <p>Son tarix: ${UI.formatDate(task.dueDate)}</p>
                <span class="priority ${priorityClass[task.priority]}">${priorityLabels[task.priority]}</span>
            </div>
        </div>
    `).join('');
}

function loadEmployeeFines(employeeId) {
    const tbody = document.getElementById('employee-fines-table');
    if (!tbody) return;
    
    const fines = FineManager.getForEmployee(employeeId);
    
    if (fines.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-check-circle"></i>
                        <p>Heç bir cərimə yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = fines.map(fine => `
        <tr>
            <td>${UI.formatDate(fine.date)}</td>
            <td class="text-danger">${UI.formatCurrency(fine.amount)}</td>
            <td>${fine.reason}</td>
            <td>${UI.getStatusBadge(fine.status)}</td>
        </tr>
    `).join('');
}

function loadEmployeeAttendanceStats(employeeId) {
    const currentMonth = new Date().toISOString().slice(0, 7);
    const stats = AttendanceManager.getMonthlyStats(employeeId, currentMonth);
    
    const presentEl = document.getElementById('emp-attendance-present');
    const lateEl = document.getElementById('emp-attendance-late');
    const absentEl = document.getElementById('emp-attendance-absent');
    const excusedEl = document.getElementById('emp-attendance-excused');
    
    if (presentEl) presentEl.textContent = stats.present;
    if (lateEl) lateEl.textContent = stats.late;
    if (absentEl) absentEl.textContent = stats.absent;
    if (excusedEl) excusedEl.textContent = stats.excused;
}

function loadEmployeeSalaryHistory(employeeId) {
    const tbody = document.getElementById('employee-salary-table');
    if (!tbody) return;
    
    const salaries = SalaryManager.getForEmployee(employeeId);
    
    if (salaries.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-cash-stack"></i>
                        <p>Heç bir maaş qeydi yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = salaries.map(salary => {
        const statusText = salary.status === 'paid' ? 'Ödənilib' : 'Gözləyir';
        const statusClass = salary.status === 'paid' ? 'bg-success' : 'bg-warning';
        
        return `
            <tr>
                <td>${salary.month}</td>
                <td>${UI.formatCurrency(salary.baseSalary)}</td>
                <td class="text-success">+${UI.formatCurrency(salary.bonus)}</td>
                <td class="text-success">+${UI.formatCurrency(salary.overtime)}</td>
                <td class="text-danger">-${UI.formatCurrency(salary.advance)}</td>
                <td class="text-danger">-${UI.formatCurrency(salary.fine)}</td>
                <td><strong>${UI.formatCurrency(salary.netSalary)}</strong></td>
                <td><span class="badge ${statusClass}">${statusText}</span></td>
            </tr>
        `;
    }).join('');
}

// ============================================
// LEAVE FORM SETUP
// ============================================
function setupLeaveForm() {
    const leaveForm = document.getElementById('leaveForm');
    const startDate = document.getElementById('leave-start');
    const endDate = document.getElementById('leave-end');
    const daysInput = document.getElementById('leave-days');
    const leaveType = document.getElementById('leave-type');

    if (!leaveForm) return;

    // Set min date to today
    const today = new Date().toISOString().split('T')[0];
    if (startDate) startDate.min = today;
    if (endDate) endDate.min = today;

    // Calculate days when dates change
    function calculateDays() {
        if (startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            
            if (end < start) {
                endDate.value = startDate.value;
                UI.showError('Bitmə tarixi başlama tarixindən əvvəl ola bilməz!');
                return;
            }
            
            const days = LeaveManager.calculateDays(startDate.value, endDate.value);
            if (daysInput) daysInput.value = days;
            
            // Update salary preview
            updateSalaryPreview();
        }
    }

    if (startDate) startDate.addEventListener('change', calculateDays);
    if (endDate) endDate.addEventListener('change', calculateDays);
    
    // Update salary preview when leave type changes
    if (leaveType) {
        leaveType.addEventListener('change', updateSalaryPreview);
    }
    
    // Function to show salary impact preview
    function updateSalaryPreview() {
        const type = leaveType?.value;
        const days = parseInt(daysInput?.value) || 0;
        const user = Auth.getCurrentUser();
        
        // Remove existing preview
        const existingPreview = document.getElementById('salary-preview');
        if (existingPreview) existingPreview.remove();
        
        if (!type || !days || !user?.salary) return;
        
        const dailySalary = user.salary / 30;
        const deduction = dailySalary * days;
        
        const previewDiv = document.createElement('div');
        previewDiv.id = 'salary-preview';
        previewDiv.className = 'form-group';
        previewDiv.style.marginTop = '16px';
        
        if (type === 'unpaid') {
            previewDiv.innerHTML = `
                <div class="alert alert-success" style="margin: 0;">
                    <i class="bi bi-check-circle"></i>
                    <strong>Pulsuz icazə:</strong> Maaşdan tutulma olmayacaq. İllik balansdan da çıxılmayacaq.
                </div>
            `;
        } else {
            previewDiv.innerHTML = `
                <div class="alert alert-warning" style="margin: 0;">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Maaş təsiri:</strong> ${UI.formatCurrency(deduction)} tutulacaq 
                    (Günlük: ${UI.formatCurrency(dailySalary)} × ${days} gün)
                </div>
            `;
        }
        
        // Insert before submit button
        const submitBtn = leaveForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            leaveForm.insertBefore(previewDiv, submitBtn);
        }
    }

    // Form submit
    leaveForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const leaveType = document.getElementById('leave-type');
        const leaveData = {
            type: leaveType.value,
            typeLabel: leaveType.options[leaveType.selectedIndex].text,
            startDate: startDate.value,
            endDate: endDate.value,
            days: parseInt(daysInput.value) || 0,
            reason: document.getElementById('leave-reason')?.value.trim() || ''
        };

        // Validation
        if (!leaveData.type) {
            UI.showError('İcazə növünü seçin!');
            return;
        }
        
        if (!leaveData.startDate || !leaveData.endDate) {
            UI.showError('Başlama və bitmə tarixlərini seçin!');
            return;
        }

        // Check leave balance
        const user = Auth.getCurrentUser();
        if (leaveData.type === 'annual' && user.leaveBalance) {
            if (leaveData.days > user.leaveBalance.remaining) {
                UI.showError(`Yalnız ${user.leaveBalance.remaining} gün icazə balansınız var!`);
                return;
            }
        }

        // Create leave request
        LeaveManager.create(leaveData);
        
        UI.showSuccess('İcazə istəyi uğurla göndərildi!');
        
        // Reset form
        leaveForm.reset();
        if (daysInput) daysInput.value = '';
        
        // Refresh history
        loadLeaveHistory();
    });
}

function loadLeaveHistory() {
    const user = Auth.getCurrentUser();
    if (!user) return;
    
    const leaves = LeaveManager.getForEmployee(user.id);
    const tbody = document.getElementById('leaves-table');
    
    if (!tbody) return;
    
    if (leaves.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <p>Heç bir icazə qeydi yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = leaves.map(leave => {
        // Calculate salary impact
        let salaryImpact = '';
        if (leave.type === 'unpaid') {
            salaryImpact = '<span class="text-success">0 ₼ (Pulsuz)</span>';
        } else if (leave.salaryDeduction > 0) {
            salaryImpact = `<span class="text-danger">-${UI.formatCurrency(leave.salaryDeduction)}</span>`;
        } else if (leave.isPaid && user.salary) {
            const deduction = (user.salary / 30) * leave.days;
            salaryImpact = `<span class="text-danger">-${UI.formatCurrency(deduction)}</span>`;
        } else {
            salaryImpact = '<span class="text-muted">-</span>';
        }
        
        return `
            <tr>
                <td>${UI.formatDate(leave.requestedAt)}</td>
                <td>${leave.typeLabel}</td>
                <td>${UI.formatDate(leave.startDate)}</td>
                <td>${UI.formatDate(leave.endDate)}</td>
                <td>${leave.days}</td>
                <td>${salaryImpact}</td>
                <td>${UI.getStatusBadge(leave.status)}</td>
            </tr>
        `;
    }).join('');
}

function updateLeaveBalance() {
    const user = Auth.getCurrentUser();
    if (!user || !user.leaveBalance) return;
    
    const annualEl = document.getElementById('annual-balance');
    const usedEl = document.getElementById('used-leaves');
    const remainingEl = document.getElementById('remaining-leaves');
    
    if (annualEl) annualEl.textContent = user.leaveBalance.annual;
    if (usedEl) usedEl.textContent = user.leaveBalance.used;
    if (remainingEl) remainingEl.textContent = user.leaveBalance.remaining;
}

// ============================================
// ADVANCE FORM SETUP
// ============================================
function setupAdvanceForm() {
    const advanceForm = document.getElementById('advanceForm');
    if (!advanceForm) return;

    // Set min date to today
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('advance-date');
    if (dateInput) dateInput.min = today;

    // Form submit
    advanceForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const amount = parseFloat(document.getElementById('advance-amount').value);
        const reason = document.getElementById('advance-reason').value.trim();
        const requestedDate = document.getElementById('advance-date')?.value || null;

        // Validation
        if (!amount || amount < 1) {
            UI.showError('Məbləği düzgün daxil edin!');
            return;
        }
        
        if (!reason) {
            UI.showError('Səbəbi qeyd edin!');
            return;
        }

        // Create advance request
        const result = AdvanceManager.create({
            amount: amount,
            reason: reason,
            requestedDate: requestedDate
        });
        
        if (result.success) {
            UI.showSuccess('Avans istəyi uğurla göndərildi!');
            
            // Reset form
            advanceForm.reset();
            
            // Refresh history and stats
            loadAdvanceHistory();
            updateAdvanceStats();
            
            // Update badge
            updateAdvanceBadge();
        } else {
            UI.showError(result.message);
        }
    });
}

function loadAdvanceHistory() {
    const user = Auth.getCurrentUser();
    if (!user) return;
    
    const advances = AdvanceManager.getForEmployee(user.id);
    const tbody = document.getElementById('advances-table');
    
    if (!tbody) return;
    
    if (advances.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-cash-stack"></i>
                        <p>Heç bir avans qeydi yoxdur</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = advances.map(advance => {
        let note = '-';
        if (advance.status === 'rejected' && advance.rejectionReason) {
            note = advance.rejectionReason;
        } else if (advance.status === 'deducted' && advance.deductedAt) {
            note = `Çıxılma tarixi: ${UI.formatDate(advance.deductedAt)}`;
        } else if (advance.status === 'approved' && advance.approvedAt) {
            note = `Təsdiqlənmə: ${UI.formatDate(advance.approvedAt)}`;
        }
        
        return `
            <tr>
                <td>${UI.formatDate(advance.requestedAt)}</td>
                <td><strong>${UI.formatCurrency(advance.amount)}</strong></td>
                <td>${advance.reason}</td>
                <td>${UI.getStatusBadge(advance.status)}</td>
                <td><small class="text-muted">${note}</small></td>
            </tr>
        `;
    }).join('');
}

function updateAdvanceStats() {
    const user = Auth.getCurrentUser();
    if (!user) return;
    
    const stats = AdvanceManager.getStats(user.id);
    
    const totalYearEl = document.getElementById('total-advances-year');
    const pendingEl = document.getElementById('pending-advances');
    const approvedEl = document.getElementById('approved-advances');
    
    if (totalYearEl) totalYearEl.textContent = stats.totalYear.toFixed(0);
    if (pendingEl) pendingEl.textContent = stats.pending.toFixed(0);
    if (approvedEl) approvedEl.textContent = stats.approved.toFixed(0);
}

function updateAdvanceBadge() {
    const user = Auth.getCurrentUser();
    if (!user) return;
    
    const advances = AdvanceManager.getForEmployee(user.id);
    const pendingCount = advances.filter(a => a.status === 'pending').length;
    
    const badge = document.getElementById('advance-badge');
    if (badge) {
        badge.textContent = pendingCount;
        badge.style.display = pendingCount > 0 ? 'inline-flex' : 'none';
    }
}

// ============================================
// PASSWORD FORM SETUP
// ============================================
function setupPasswordForm() {
    const form = document.getElementById('passwordForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const currentPassword = form.querySelector('input[type="password"]:nth-of-type(1)').value;
        const newPassword = form.querySelector('input[type="password"]:nth-of-type(2)').value;
        const confirmPassword = form.querySelector('input[type="password"]:nth-of-type(3)').value;
        
        if (newPassword !== confirmPassword) {
            UI.showError('Yeni şifrələr uyğun gəlmir!');
            return;
        }
        
        if (newPassword.length < 6) {
            UI.showError('Şifrə ən az 6 simvol olmalıdır!');
            return;
        }
        
        const result = Auth.changePassword(currentPassword, newPassword);
        
        if (result.success) {
            UI.showSuccess(result.message);
            form.reset();
        } else {
            UI.showError(result.message);
        }
    });
}

// ============================================
// UTILITY FUNCTIONS
// ============================================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function logout() {
    Auth.logout();
}

// ============================================
// INITIALIZE APPLICATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize storage
    Storage.init();

    // Determine page and initialize
    const path = window.location.pathname;
    const page = path.split('/').pop();
    
    switch(page) {
        case 'login.html':
        case '':
        case 'index.html':
            initLoginPage();
            break;
        case 'admin-dashboard.html':
            initAdminDashboard();
            break;
        case 'employee-dashboard.html':
            initEmployeeDashboard();
            break;
    }
});

// Close modal on outside click
window.addEventListener('click', function(event) {
    const modal = document.querySelector('.modal.active');
    if (modal && event.target === modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Close notification panel when clicking outside
    const notificationPanel = document.getElementById('notification-panel');
    const notificationBtn = document.querySelector('.notification-dropdown .btn-icon');
    if (notificationPanel && !notificationPanel.contains(event.target) && 
        notificationBtn && !notificationBtn.contains(event.target)) {
        notificationPanel.classList.remove('active');
    }
});

// ============================================
// NOTIFICATION SYSTEM
// ============================================
function toggleNotificationPanel() {
    const panel = document.getElementById('notification-panel');
    if (panel) {
        panel.classList.toggle('active');
        if (panel.classList.contains('active')) {
            loadNotifications();
        }
    }
}

function loadNotifications() {
    const data = Storage.getData();
    const notifications = data.notifications ? data.notifications.slice().reverse().slice(0, 20) : [];
    const list = document.getElementById('notification-list');
    const badge = document.getElementById('notification-badge');
    
    if (!list) return;
    
    // Update badge
    const unreadCount = notifications.filter(n => !n.read).length;
    if (badge) {
        badge.textContent = unreadCount;
        badge.style.display = unreadCount > 0 ? 'flex' : 'none';
    }
    
    if (notifications.length === 0) {
        list.innerHTML = `
            <div class="notification-empty">
                <i class="bi bi-bell-slash"></i>
                <p>Bildiriş yoxdur</p>
            </div>
        `;
        return;
    }
    
    const iconMap = {
        salary: { icon: 'bi-cash-stack', class: 'salary' },
        fine: { icon: 'bi-exclamation-triangle', class: 'fine' },
        task: { icon: 'bi-list-task', class: 'task' },
        leave: { icon: 'bi-calendar-plus', class: 'leave' },
        advance: { icon: 'bi-cash', class: 'advance' },
        system: { icon: 'bi-info-circle', class: 'task' }
    };
    
    list.innerHTML = notifications.map(notification => {
        const iconConfig = iconMap[notification.type] || iconMap.system;
        const employee = notification.employeeId ? Storage.getUserById(notification.employeeId) : null;
        
        return `
            <div class="notification-item ${notification.read ? '' : 'unread'}" onclick="markNotificationAsRead(${notification.id})">
                <div class="notification-icon ${iconConfig.class}">
                    <i class="bi ${iconConfig.icon}"></i>
                </div>
                <div class="notification-content">
                    <h5>${notification.title}</h5>
                    <p>${notification.message}</p>
                    <small>${UI.formatDate(notification.date)}</small>
                </div>
            </div>
        `;
    }).join('');
}

function markNotificationAsRead(notificationId) {
    NotificationManager.markAsRead(notificationId);
    loadNotifications();
}

function markAllNotificationsAsRead() {
    const data = Storage.getData();
    if (data.notifications) {
        data.notifications.forEach(n => n.read = true);
        Storage.setData(data);
    }
    loadNotifications();
}

// Update notification badge on page load
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    initDarkMode();
});

// ============================================
// DARK MODE
// ============================================
function initDarkMode() {
    const isDarkMode = localStorage.getItem('555insaat_darkmode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        updateDarkModeIcon(true);
    }
}

function toggleDarkMode() {
    const isDarkMode = document.body.classList.toggle('dark-mode');
    localStorage.setItem('555insaat_darkmode', isDarkMode);
    updateDarkModeIcon(isDarkMode);
}

function updateDarkModeIcon(isDarkMode) {
    const icon = document.getElementById('dark-mode-icon');
    if (icon) {
        icon.className = isDarkMode ? 'bi bi-sun' : 'bi bi-moon';
    }
}

// ============================================
// EXPORT FUNCTIONS
// ============================================
function exportSalaryToExcel() {
    const month = document.getElementById('salary-month-filter')?.value || '2025-03';
    const salaries = SalaryManager.getAll(month);
    
    if (salaries.length === 0) {
        UI.showError('İxrac ediləcək məlumat yoxdur!');
        return;
    }
    
    // Create CSV content
    let csv = '\uFEFF'; // BOM for UTF-8
    csv += 'İşçi,Ay,Baza Maaş,Bonus,Əlavə Saat,Avans,Cərimə,Yekun,Status\n';
    
    salaries.forEach(salary => {
        const employee = Storage.getUserById(salary.employeeId);
        const employeeName = employee ? employee.fullName : 'Naməlum';
        const status = salary.status === 'paid' ? 'Ödənilib' : 'Gözləyir';
        
        csv += `"${employeeName}","${salary.month}",${salary.baseSalary},${salary.bonus},${salary.overtime},${salary.advance},${salary.fine},${salary.netSalary},"${status}"\n`;
    });
    
    // Download CSV
    downloadCSV(csv, `maas-hesabati-${month}.csv`);
    UI.showSuccess('Maaş hesabatı ixrac edildi!');
}

function exportTableToExcel(tableId, filename) {
    const table = document.getElementById(tableId);
    if (!table) {
        UI.showError('Cədvəl tapılmadı!');
        return;
    }
    
    let csv = '\uFEFF';
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = [];
        cells.forEach(cell => {
            // Remove HTML tags and get text content
            let text = cell.textContent.replace(/"/g, '""').trim();
            rowData.push(`"${text}"`);
        });
        csv += rowData.join(',') + '\n';
    });
    
    downloadCSV(csv, `${filename}.csv`);
    UI.showSuccess('Fayl ixrac edildi!');
}

function downloadCSV(csv, filename) {
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// ============================================
// GLOBAL SEARCH
// ============================================
function initGlobalSearch() {
    const searchInput = document.getElementById('global-search');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', debounce(function() {
        const query = this.value.trim().toLowerCase();
        if (query.length < 2) return;
        
        performGlobalSearch(query);
    }, 300));
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = this.value.trim().toLowerCase();
            if (query.length >= 2) {
                performGlobalSearch(query);
            }
        }
    });
}

function performGlobalSearch(query) {
    const results = [];
    
    // Search employees
    const employees = EmployeeManager.getAll();
    employees.forEach(emp => {
        if (emp.fullName.toLowerCase().includes(query) || 
            emp.username.toLowerCase().includes(query) ||
            (emp.phone && emp.phone.includes(query))) {
            results.push({ type: 'employee', data: emp });
        }
    });
    
    // Search projects
    const projects = ProjectManager.getAll();
    projects.forEach(proj => {
        if (proj.name.toLowerCase().includes(query) || 
            proj.location.toLowerCase().includes(query)) {
            results.push({ type: 'project', data: proj });
        }
    });
    
    // Show search results (simplified - in a real app, you'd show a dropdown)
    if (results.length > 0) {
        UI.showNotification(`${results.length} nəticə tapıldı`, 'info');
    } else {
        UI.showNotification('Nəticə tapılmadı', 'warning');
    }
}

// Initialize global search
document.addEventListener('DOMContentLoaded', function() {
    initGlobalSearch();
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // ESC to close modals
    if (e.key === 'Escape') {
        const modal = document.querySelector('.modal.active');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
});
