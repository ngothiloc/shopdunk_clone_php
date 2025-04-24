document.addEventListener('DOMContentLoaded', function () {
    const productForm = document.getElementById('productForm');
    const addProductBtn = document.getElementById('addProductBtn');
    const searchInput = document.getElementById('searchInput');
    const editButtons = document.querySelectorAll('.btn-edit');
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const productImage = document.getElementById('productImage');

    // Preview image when selected
    productImage.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Here you would typically show the preview
                console.log('Image preview:', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Toggle form visibility
    addProductBtn.addEventListener('click', function () {
        const formContainer = document.querySelector('.form-container');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
    });

    // Form submission
    productForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const productName = document.getElementById('productName').value;
        const productCategory = document.getElementById('productCategory').value;
        const productPrice = document.getElementById('productPrice').value;
        const productQuantity = document.getElementById('productQuantity').value;
        const productDescription = document.getElementById('productDescription').value;
        const productStatus = document.getElementById('productStatus').value;
        const productImage = document.getElementById('productImage').files[0];

        // Here you would typically send the data to your backend
        console.log('Product Data:', {
            name: productName,
            category: productCategory,
            price: productPrice,
            quantity: productQuantity,
            description: productDescription,
            status: productStatus,
            image: productImage
        });

        // Reset form
        productForm.reset();

        // Show success message
        alert('Sản phẩm đã được lưu thành công!');
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
            document.getElementById('productName').value = cells[2].textContent;
            document.getElementById('productCategory').value = cells[3].textContent === 'Điện thoại' ? '1' : '2';
            document.getElementById('productPrice').value = cells[4].textContent.replace('đ', '').replace(/\./g, '');
            document.getElementById('productQuantity').value = cells[5].textContent;
            document.getElementById('productStatus').value = cells[6].querySelector('.status').classList.contains('active') ? 'active' : 'inactive';

            // Show form
            document.querySelector('.form-container').style.display = 'block';

            // Scroll to form
            document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Delete button functionality
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                const row = this.closest('tr');
                // Here you would typically send a delete request to your backend
                row.remove();
                alert('Sản phẩm đã được xóa thành công!');
            }
        });
    });

    // Pagination functionality
    const paginationButtons = document.querySelectorAll('.pagination button');
    paginationButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Here you would typically fetch the next/previous page of data from your backend
            console.log('Pagination clicked:', this.innerHTML.includes('left') ? 'Previous' : 'Next');
        });
    });

    // Format price input
    const priceInput = document.getElementById('productPrice');
    priceInput.addEventListener('input', function () {
        let value = this.value.replace(/[^\d]/g, '');
        if (value) {
            value = parseInt(value).toLocaleString('vi-VN');
        }
        this.value = value;
    });
}); 