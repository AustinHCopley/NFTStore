$(document).ready(function(){
  $("#submitButton").click(function(e){
    e.preventDefault();
    // get values from form data
    var first = $("#first_name").val();
    var last = $("#last_name").val();
    var email = $("#email").val();
    var prod = $("#product").val();
    var quant = parseInt($("#quantity").val());
    var avail = $("#available").val();
    // validate inputted data
    if(first==''||last==''||email==''||prod==''||quant=='') {
      // if fields are empty
      alert("Please Fill All Fields");
    } else if (quant > avail) {
      // if quantity ordered is greater than amount in stock
      alert("Quantity entered (" + quant + ") is greater than available (" + avail + ")");
    } else {

      var fd = $("#4m").serialize();

      $.ajax({
        type: "POST",
        url: "ajaxsubmit.php",
        data: fd,
        cache: false,
        success: function(result){
          $('#first_name').val("");
          $('#last_name').val("");
          $('#email').val("");
          $('#product').val("");
          $('#quantity').val("");
          $('#available').val("");
          // replace contents of table div with php echo statement
          $('#table').html(result);
        },
        error: function(){
          alert("Error: could not handle order form");
        }
      });
    }
  return false;
  });
});
