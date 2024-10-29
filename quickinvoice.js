// function addItem() {
//     const table = document.getElementById('invoiceTable').getElementsByTagName('tbody')[0];
//     const newRow = table.insertRow();
  
//     const cell1 = newRow.insertCell(0);
//     const cell2 = newRow.insertCell(1);
//     const cell3 = newRow.insertCell(2);
//     const cell4 = newRow.insertCell(3);
  
//     cell1.innerHTML = '<select> </select>';
//     cell2.innerHTML = '<input type="number" class="quantity" min="1" value="1" required>';
//     cell3.innerHTML = '<input type="number" class="unitPrice" min="0" step="1" value="00.00" required>';
//     cell4.innerHTML = '<span class="totalPrice">$0.00</span>';

//     updateTotal();
//   }
  

//   function updateTotal() {
//     const totalCells = document.getElementsByClassName('totalPrice');
//     let totalAmount = 0;
  
//     for (let i = 0; i < totalCells.length; i++) {
//       const quantity = parseFloat(totalCells[i].parentNode.previousSibling.previousSibling.childNodes[0].value);
//       const unitPrice = parseFloat(totalCells[i].parentNode.previousSibling.childNodes[0].value);
//       const totalPrice = quantity * unitPrice;
  
//       totalCells[i].textContent = '$' + totalPrice.toFixed(2);
//       totalAmount += totalPrice;
//     }
  
//     document.getElementById('totalAmount').textContent = '$' + totalAmount.toFixed(2);
//   }
  
//   document.getElementById('invoiceForm').addEventListener('input', updateTotal);
  
//   function invoice(){

//     alert("hi");
//   }