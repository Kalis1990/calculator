(function ($) {
  $(document).ready(function () {
    $("#FuelCalculatorForm").submit(function (e) {
      e.preventDefault();
      
      // Fetch form data
      var formData = $(this).serialize();

      $.ajax({
        url: "/fuel-calculator-api", // This could be any URL or not used at all for your scenario
        type: "POST",
        data: formData,
        dataType: "json",
        success: function (data) {
          // Use passed data from drupalSettings
          var jsData = drupalSettings.fuelCalculatorData;
          // Update results block with the calculated data and the passed data
          $("#FuelCalculatorResultsBlock").html("Fuel spent: " + jsData.fuel_spend + " L/100km<br>Total fuel cost: " + jsData.fuel_spend + " eu");
          console.log(data)
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      });
    });
  });
})(jQuery);
