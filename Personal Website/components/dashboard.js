document.addEventListener('DOMContentLoaded', loadBooks);

function loadBooks() {
    fetch('get_books.php')
        .then(response => response.json())
        .then(data => {
            const completeBooks = document.getElementById('complete-books');
            const notCompleteBooks = document.getElementById('not-complete-books');
            completeBooks.innerHTML = '';
            notCompleteBooks.innerHTML = '';

            data.books.forEach(book => {
                const bookItem = document.createElement('article');
                bookItem.classList.add('book-item');
                bookItem.innerHTML = `
                    <h3 class="title-item">${book.title}</h3>
                    <p class="author-name">${book.author}</p>
                    <p class="date-time">${book.date}</p>
                    <div class="action">
                        <button class="done" onclick="toggleComplete(${book.id}, ${book.is_complete ? 0 : 1})">${book.is_complete ? 'Belum Selesai' : 'Selesai'}</button>
                        <button class="remove" onclick="removeBook(${book.id})">Remove</button>
                    </div>
                `;
                if (book.is_complete) {
                    completeBooks.appendChild(bookItem);
                } else {
                    notCompleteBooks.appendChild(bookItem);
                }
            });
        });
}



function toggleComplete(id, isComplete) {
    fetch('toggle_complete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, is_complete })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadBooks();
        } else {
            alert('Failed to update book');
        }
    });
}

function removeBook(id) {
    fetch('remove_book.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadBooks();
        } else {
            alert('Failed to remove book');
        }
    });
}
