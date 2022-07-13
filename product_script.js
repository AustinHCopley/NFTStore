function valid(name, price) {
  if(name=='') {
    $('#error').html("Please Fill Product Name Field");
    $('#product_name').focus();
    return false;
  } else if (price=='') {
    $('#error').html("Please Fill Price Field");
    $('#price').focus();
    return false;
  } else {
    $('#error').html("");
    return true;
  }
};

$(document).ready(function(){
  $("#addButton").click(function(e){
    e.preventDefault();
    // get values from form data
    var name = $("#product_name").val();
    var price = $("#price").val();
    if ($("#inactive").is(':checked')) {
      var inactive = "&inact=1";
    } else {
      var inactive = "&inact=0";
    }

    // validate inputted data
    if ( valid(name, price) ) {
      // required fields are filled
      var serial = $("#4m").serialize();
      var fd = serial.concat(inactive);
      $.ajax({
        type: "POST",
        url: "ajaxadd.php",
        data: fd,
        cache: false,
        success: function(result){
          showTable();
          $('#product_name').val("");
          $('#image_name').val("");
          $('#quantity').val("");
          $('#price').val("");
          $('#inactive').prop( "checked", false );
        },
        error: function(){
          alert("Error: could not handle order form");
        }
      });
    }
  return false;
  });
});

$(document).ready(function(){
  $("#updateButton").click(function(e){
    e.preventDefault();
    // get values from form data
    var name = $("#product_name").val();
    var price = $("#price").val();
    if ($("#inactive").is(':checked')) {
      var inactive = "&inact=1";
    } else {
      var inactive = "&inact=0";
    }

    // validate inputted data
    if ( valid(name, price) ) {
      // required fields are filled
      var serial = $("#4m").serialize();
      var fd = serial.concat(inactive);
      $.ajax({
        type: "POST",
        url: "ajaxupdate.php",
        data: fd,
        cache: false,
        success: function(result){
          showTable();
          $('#product_name').val("");
          $('#image_name').val("");
          $('#quantity').val("");
          $('#price').val("");
          $('#inactive').prop( "checked", false );
          alert(result);
        },
        error: function(){
          alert("Error: could not handle order form");
        }
      });
    }
  return false;
  });
});

$(document).ready(function(){
  $("#deleteButton").click(function(e){
    e.preventDefault();
    // get values from form data
    var name = $("#product_name").val();
    var price = $("#price").val();

    // validate inputted data
    if ( valid(name, price) ) {
      // required fields are filled
      if ( confirm("Are you sure you want to delete this data?")) {
        var fd = $("#4m").serialize();
        $.ajax({
          type: "POST",
          url: "ajaxdelete.php",
          data: fd,
          cache: false,
          success: function(result){
            showTable();
            $('#product_name').val("");
            $('#image_name').val("");
            $('#quantity').val("");
            $('#price').val("");
            $('#inactive').prop( "checked", false );
            alert(result);
          },
          error: function(){
            alert("Error: could not handle order form");
          }
        });
      }
    }
  return false;
  });
});
