// Client-side search function
function searchTable(query) {
    const table = document.querySelector('table');
    if (!table) return;

    const rows = table.querySelectorAll('tbody tr');
    const queryLower = query.toLowerCase();

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(queryLower) ? '' : 'none';
    });
}

// For more comprehensive searches (optional)
async function performSearch(query) {
    try {
        const response = await fetch('/WebProject-v2/api/search.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ query })
        });
        
        const results = await response.json();
        displaySearchResults(results);
    } catch (error) {
        console.error('Search error:', error);
    }
}

function displaySearchResults(results) {
    const container = document.querySelector('.search-results');
    if (!container) return;

    container.innerHTML = '';
    
    if (results.length === 0) {
        container.innerHTML = '<p>No results found</p>';
        return;
    }

    results.forEach(result => {
        const item = document.createElement('div');
        item.className = 'search-result-item';
        item.innerHTML = `
            <h4>${result.student_name} (${result.student_id})</h4>
            <p>${result.concern.substring(0, 100)}...</p>
            <small>${new Date(result.submission_date).toLocaleString()}</small>
            <a href="manage.php?id=${result.id}">View</a>
        `;
        container.appendChild(item);
    });
}
function filterTable(searchTerm) {
    const table = document.querySelector('table');
    if (!table) return;

    const rows = table.querySelectorAll('tbody tr');
    const searchTermLower = searchTerm.toLowerCase();

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let rowMatches = false;
        
        // Skip the last cell if it contains action buttons
        for (let i = 0; i < cells.length - 1; i++) {
            const cellText = cells[i].textContent.toLowerCase();
            if (cellText.includes(searchTermLower)) {
                rowMatches = true;
                break;
            }
        }
        
        row.style.display = rowMatches ? '' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const searchField = document.getElementById('search-field');
    
    // Trigger search on input (already handled by oninput attribute)
    // Optional: Add debounce for better performance
    let searchTimeout;
    searchField.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterTable(e.target.value);
        }, 300);
    });
});