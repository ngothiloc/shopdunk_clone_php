document.addEventListener('DOMContentLoaded', function () {
    const customerForm = document.getElementById('customerForm');
    const addCustomerBtn = document.getElementById('addCustomerBtn');
    const searchInput = document.getElementById('searchInput');
    const editButtons = document.querySelectorAll('.btn-edit');
    const deleteButtons = document.querySelectorAll('.btn-delete');

    // Toggle form visibility
    addCustomerBtn.addEventListener('click', function () {
        const formContainer = document.querySelector('.form-container');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
    });

    // Form submission
    customerForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const customerName = document.getElementById('customerName').value;
        const customerEmail = document.getElementById('customerEmail').value;
        const customerPhone = document.getElementById('customerPhone').value;
        const customerAddress = document.getElementById('customerAddress').value;
        const customerStatus = document.getElementById('customerStatus').value;

        // Validate email
        if (!isValidEmail(customerEmail)) {
            alert('Vui lòng nhập đúng định dạng email!');
            return;
        }

        // Validate phone number
        if (!isValidPhone(customerPhone)) {
            alert('Vui lòng nhập đúng định dạng số điện thoại!');
            return;
        }

        // Here you would typically send the data to your backend
        console.log('Customer Data:', {
            name: customerName,
            email: customerEmail,
            phone: customerPhone,
            address: customerAddress,
            status: customerStatus
        });

        // Reset form
        customerForm.reset();

        // Show success message
        alert('Khách hàng đã được lưu thành công!');
    });

    // Email validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Phone number validation
    function isValidPhone(phone) {
        const phoneRegex = /^[0-9]{10}$/;
        return phoneRegex.test(phone);
    }

    // Search functionality
    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('.data-table tbody tr');

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Edit button functionality
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const cells = row.cells;

            // Fill form with existing data
            document.getElementById('customerName').value = cells[1].textContent;
            document.getElementById('customerEmail').value = cells[2].textContent;
            document.getElementById('customerPhone').value = cells[3].textContent;
            document.getElementById('customerAddress').value = cells[4].textContent;
            document.getElementById('customerStatus').value = cells[5].querySelector('.status').classList.contains('active') ? 'active' : 'inactive';

            // Show form
            document.querySelector('.form-container').style.display = 'block';

            // Scroll to form
            document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Delete button functionality
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Bạn có chắc chắn muốn xóa khách hàng này?')) {
                const row = this.closest('tr');
                // Here you would typically send a delete request to your backend
                row.remove();
                alert('Khách hàng đã được xóa thành công!');
            }
        });
    });

}); 