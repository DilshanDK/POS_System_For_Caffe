<style>
    body {
        background-color: #f7f7f7;
        font-family: Arial, sans-serif;
    }

    .containe {
        width: 1300px;
        margin: 10px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        overflow: scroll;
        height: 450px;
    }

    h1,
    h2 {
        text-align: center;
        color: #333;
    }

    .input-group {
        margin-bottom: 20px;
    }

    .input-group label {
        display: block;
        margin-bottom: 5px;
        color: #666;
    }

    .input-group input[type="text"] {
        width: calc(100% - 20px);
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .table-wrapper {
        overflow-x: auto;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .button-wrapper {
        text-align: right;
        margin: 10px 110px;
    }

    .btnIn {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 16px;
        position: fixed;
        top: 600px;
    }

    .btnIn:hover {
        background-color: #0056b3;
    }

    .total {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        position: sticky;
        bottom: 60px;
    }

    .total span {
        color: #333;
    }

    .delete-btn {
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        padding: 8px 12px;
        transition: background-color 0.3s;
    }

    .delete-btn:hover {
        background-color: #bb2124;
    }
</style>

<script>
    var items = <?php echo json_encode($items); ?>;

    function addItem() {
        const table = document.getElementById('invoiceTable').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();

        const cell1 = newRow.insertCell(0);
        const cell2 = newRow.insertCell(1);
        const cell3 = newRow.insertCell(2);
        const cell4 = newRow.insertCell(3);
        const cell5 = newRow.insertCell(4);

        let selectHTML = '<select class="description" onchange="updateTotal()">';
        selectHTML += '<option value="" disabled selected>Select Item</option>';
        items.forEach(item => {
            selectHTML += `<option value="${item.itemid}" data-price="${item.price}">${item.name}</option>`;
        });
        selectHTML += '</select>';

        cell1.innerHTML = selectHTML;
        cell2.innerHTML = '<input type="number" class="quantity" min="1" value="1" required>';
        cell3.innerHTML = '<input type="number" class="unitPrice" min="0" step="0.01" value="0.00" required readonly>';
        cell4.innerHTML = '<span class="totalPrice">$0.00</span>';
        cell5.innerHTML = '<button class="delete-btn" type="button" onclick="deleteItem(this)">Delete</button>';

        updateTotal();
    }

    function deleteItem(btn) {
        const row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateTotal();
    }

    function updateTotal() {
        const totalCells = document.getElementsByClassName('totalPrice');
        let totalAmount = 0;

        for (let i = 0; i < totalCells.length; i++) {
            const row = totalCells[i].parentNode.parentNode;
            const quantity = parseFloat(row.querySelector('.quantity').value);
            const select = row.querySelector('.description');
            const unitPrice = parseFloat(select.options[select.selectedIndex].getAttribute('data-price')) || 0;
            const totalPrice = quantity * unitPrice;

            row.querySelector('.unitPrice').value = unitPrice.toFixed(2);
            totalCells[i].textContent = '$' + totalPrice.toFixed(2);
            totalAmount += totalPrice;
        }

        document.getElementById('totalAmount').textContent = '$' + totalAmount.toFixed(2);
    }

    document.getElementById('invoiceForm').addEventListener('input', updateTotal);
</script>