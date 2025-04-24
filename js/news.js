document.addEventListener('DOMContentLoaded', function () {
    const newsForm = document.getElementById('newsForm');
    const addNewsBtn = document.getElementById('addNewsBtn');
    const searchInput = document.getElementById('searchInput');
    const editButtons = document.querySelectorAll('.btn-edit');
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const newsImage = document.getElementById('newsImage');

    // Preview image when selected
    newsImage.addEventListener('change', function (e) {
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
    addNewsBtn.addEventListener('click', function () {
        const formContainer = document.querySelector('.form-container');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
    });

    // Form submission
    newsForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const newsTitle = document.getElementById('newsTitle').value;
        const newsCategory = document.getElementById('newsCategory').value;
        const newsContent = document.getElementById('newsContent').value;
        const newsStatus = document.getElementById('newsStatus').value;
        const newsImage = document.getElementById('newsImage').files[0];

        // Here you would typically send the data to your backend
        console.log('News Data:', {
            title: newsTitle,
            category: newsCategory,
            content: newsContent,
            status: newsStatus,
            image: newsImage
        });

        // Reset form
        newsForm.reset();

        // Show success message
        alert('Tin tức đã được lưu thành công!');
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
            document.getElementById('newsTitle').value = cells[2].textContent;
            document.getElementById('newsCategory').value = cells[3].textContent === 'Tin tức' ? '1' :
                cells[3].textContent === 'Khuyến mãi' ? '2' : '3';
            document.getElementById('newsStatus').value = cells[5].querySelector('.status').classList.contains('active') ? 'active' : 'inactive';

            // Show form
            document.querySelector('.form-container').style.display = 'block';

            // Scroll to form
            document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Delete button functionality
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Bạn có chắc chắn muốn xóa tin tức này?')) {
                const row = this.closest('tr');
                // Here you would typically send a delete request to your backend
                row.remove();
                alert('Tin tức đã được xóa thành công!');
            }
        });
    });

}); 