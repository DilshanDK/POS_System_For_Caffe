$(document).ready(function() {
  $("#inputData").keyup(function() {
      var inputVal = $(this).val();
      $.ajax({
          url: "itemsUser.php",
          method: "POST",
          data: { inputData: inputVal },
          success: function(response) {
              $("#output").html(response);
              $("#itemdiv").hide();
          },
          error: function() {
              console.error("An error occurred.");
          }
      });
  });
});

function btnI() {
  window.location.href = "itemsUser.php";
  let item = document.getElementById("btnI");
  let cart = document.getElementById("btnC");
  let my = document.getElementById("btnM");
  item.style.backgroundColor = "red";
  cart.style.backgroundColor = "blueviolet";
  my.style.backgroundColor = "blueviolet";
}
function btnC() {
  window.location.href = "cart.php";
  let item = document.getElementById("btnI");
  let cart = document.getElementById("btnC");
  let my = document.getElementById("btnM");
  item.style.backgroundColor = "blueviolet";
  cart.style.backgroundColor = "red";
  my.style.backgroundColor = "blueviolet";
}
function btnM() {
  window.location.href = "ordersUser.php";
  let item = document.getElementById("btnI");
  let cart = document.getElementById("btnC");
  let my = document.getElementById("btnM");
  item.style.backgroundColor = "blueviolet";
  cart.style.backgroundColor = "blueviolet";
  my.style.backgroundColor = "red";
}
