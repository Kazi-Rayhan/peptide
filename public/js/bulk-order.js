document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('csv-upload-form');
    const summaryItems = document.getElementById('bulk-order-summary-items');
    const subtotalElem = document.getElementById('bulk-order-subtotal');
    const totalElem = document.getElementById('bulk-order-total');
    const productsJson = document.getElementById('products-json');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const fileInput = document.getElementById('csv_file');
            if (!fileInput.files.length) return alert('Please select a CSV file.');
            const formData = new FormData();
            formData.append('csv_file', fileInput.files[0]);
            fetch('/user/bulk-order/parse-csv', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                // Render product rows
                let html = '';
                let subtotal = 0;
                data.products.forEach(item => {
                    const itemSubtotal = (item.price || 0) * (item.quantity || 0);
                    subtotal += itemSubtotal;
                    html += `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0">${item.name} <span class="text-muted small">(${item.sku})</span></h6>
                                <small class="text-muted">Qty: ${item.quantity}</small>
                            </div>
                            <span>$${itemSubtotal.toFixed(2)}</span>
                        </div>
                    `;
                });
                summaryItems.innerHTML = html;
                subtotalElem.textContent = `$${subtotal.toFixed(2)}`;
                totalElem.textContent = `$${subtotal.toFixed(2)}`;
                productsJson.value = JSON.stringify(data.products);
            });
        });
    }
}); 