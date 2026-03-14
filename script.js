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
        case 'leaves':
            loadAdminLeaves();
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
    
    // Update stat cards
    const totalEl = document.getElementById('total-employees');
    const activeEl = document.getElementById('active-employees');
    
    if (totalEl) totalEl.textContent = stats.total;
    if (activeEl) activeEl.textContent = stats.active;
    
    // Load recent employees
    loadRecentEmployees();
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
    UI.openModal('employeeModal');
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
    
    UI.openModal('employeeModal');
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
        status: document.getElementById('emp-status').value
    };

    // Validation
    if (!employeeData.fullName || !employeeData.username || !employeeData.password) {
        UI.showError('Zəhmət olmasa bütün vacib sahələri doldurun!');
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
    
    // Load page-specific data
    if (pageName === 'leaves') {
        loadLeaveHistory();
        updateLeaveBalance();
    }
}

function loadEmployeeData(employeeId) {
    // Load notifications count
    const unreadCount = NotificationManager.getUnreadCount(employeeId);
    const badgeEl = document.querySelector('.nav-item[data-page="notifications"] .badge');
    if (badgeEl) badgeEl.textContent = unreadCount;
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
