<?php
session_start();
if (!isset($_SESSION["userName"])) {
  header("Location: index.php");
  exit();
}

include('headerAdmin.php');
include('connection.php');

// Fetch items from the database
$items = [];
$sql = "SELECT `itemid`, `name`, `price` FROM items";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $items[] = $row;
  }
}

if (isset($_POST["gen"])) {
  // Process the form data and generate the invoice
  $companyName = $_POST['companyName'];
  $selectedItems = $_POST['items']; // This will be a JSON string

  // Decode JSON string to an array
  $selectedItemsArray = json_decode($selectedItems, true);

  // Calculate total amount
  $totalAmount = 0;
  foreach ($selectedItemsArray as $item) {
    $totalAmount += $item['quantity'] * $item['unitPrice'];
  }

  // You can save the invoice data to the database or generate a PDF
  // For simplicity, we just display a success message
  echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Your Invoice has been generated successfully!'
        }).then((result) => {
          if (result.isConfirmed) {
              // window.location.href = 'paymentA.php';
          }
      });
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Generation</title>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body style="background-color: #f7f7f7;">
  <div style="margin: 5px auto;">
    <h1>Invoice Form</h1>
    <div class="containe">
      <form id="invoiceForm" action="quickInvoice.php" method="post">
        <div class="input-group">
          <label for="companyName">Company Name</label>
          <input type="text" id="companyName" name="companyName" value="Kandy Art Recidence" required />
        </div>
        <h2>Itemized Invoice</h2>
        <div class="table-wrapper">
          <table id="invoiceTable">
            <thead>
              <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price ($)</th>
                <th>Total Price ($)</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Rows will be dynamically added using JavaScript -->
            </tbody>
          </table>
        </div>
        <div class="button-wrapper">
          <button class="btnIn" type="button" onclick="addItem()">Add Item</button>
        </div>
        <div class="total">
          <p>Total: <span id="totalAmount">$0.00</span></p>
        </div>
        <input type="hidden" id="itemsInput" name="items" value="">
        <button class="btnIn" type="submit" name="gen" onclick="p">Checkout</button>
      </form>
    </div>
  </div>

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

      // Collect the data to send to the server
      collectFormData();
    }

    function collectFormData() {
      const rows = document.querySelectorAll('#invoiceTable tbody tr');
      const itemsData = [];

      rows.forEach(row => {
        const itemId = row.querySelector('.description').value;
        const quantity = row.querySelector('.quantity').value;
        const unitPrice = row.querySelector('.unitPrice').value;

        if (itemId && quantity && unitPrice) {
          itemsData.push({
            itemId: itemId,
            quantity: parseFloat(quantity),
            unitPrice: parseFloat(unitPrice)
          });
        }
      });

      document.getElementById('itemsInput').value = JSON.stringify(itemsData);
    }

    document.getElementById('invoiceForm').addEventListener('input', updateTotal);
  </script>
</body>

</html>

<?php
include('foot.php');
?>