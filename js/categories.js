document.addEventListener('DOMContentLoaded', function () {
    const categoryForm = document.getElementById('categoryForm');
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const searchInput = document.getElementById('searchInput');
    const editButtons = document.querySelectorAll('.btn-edit');
    const deleteButtons = document.querySelectorAll('.btn-delete');

    // Toggle form visibility
    addCategoryBtn.addEventListener('click', function () {
        const formContainer = document.querySelector('.form-container');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
    });

    // Form submission
    categoryForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const categoryName = document.getElementById('categoryName').value;
        const categoryDescription = document.getElementById('categoryDescription').value;
        const categoryStatus = document.getElementById('categoryStatus').value;

        // Here you would typically send the data to your backend
        console.log('Category Data:', {
            name: categoryName,
            description: categoryDescription,
            status: categoryStatus
        });

        // Reset form
        categoryForm.reset();

        // Show success message
        alert('Danh mục đã được lưu thành công!');
    });

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
            document.getElementById('categoryName').value = cells[1].textContent;
            document.getElementById('categoryDescription').value = cells[2].textContent;
            document.getElementById('categoryStatus').value = cells[3].querySelector('.status').classList.contains('active') ? 'active' : 'inactive';

            // Show form
            document.querySelector('.form-container').style.display = 'block';

            // Scroll to form
            document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Delete button functionality
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                const row = this.closest('tr');
                // Here you would typically send a delete request to your backend
                row.remove();
                alert('Danh mục đã được xóa thành công!');
            }
        });
    });

}); 