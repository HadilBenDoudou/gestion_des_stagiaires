
    document.addEventListener("DOMContentLoaded", function() {
        const portfolioFilters = document.querySelectorAll('#portfolio-flters li');

        portfolioFilters.forEach(filter => {
            filter.addEventListener('click', function() {
                const selectedFilter = this.getAttribute('data-filter');
                const portfolioItems = document.querySelectorAll('.portfolio-item');

                portfolioItems.forEach(item => {
                    item.style.display = 'none';

                    if (selectedFilter === '*' || item.classList.contains(selectedFilter)) {
                        item.style.display = 'block';
                    }
                });

                portfolioFilters.forEach(f => {
                    f.classList.remove('filter-active');
                });

                this.classList.add('filter-active');
            });
        });
    });