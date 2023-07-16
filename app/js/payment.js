// A reference to Stripe.js initialized with your real test publishable API key.
// pk_live_51IQ79SDzY9AsmTJ8hiX2lz9102ZGFktUH60mWQVQ0sESraSBRH7ExuJYOJLWPvQ6UQBbdHU43LlzIWOwYo1Gl0CX007He3oaWN
// pk_test_51IQ79SDzY9AsmTJ8Bq56HQ3XoV8axtwcgs73TsppvSDlKjW3UBVahw8Z1gaHDCWdgjK1eZaMoBskAb8kcNlnGaMM00nTudY0dg
var stripe = Stripe("pk_test_51IQ79SDzY9AsmTJ8Bq56HQ3XoV8axtwcgs73TsppvSDlKjW3UBVahw8Z1gaHDCWdgjK1eZaMoBskAb8kcNlnGaMM00nTudY0dg");

// The items the customer wants to buy
var purchase = {
  items: [{ id: "xl-tshirt" }]
};

// Disable the button until we have Stripe set up on the page
document.querySelector("#submit").disabled = true;
fetch("conexiones/payment.php", {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  body: JSON.stringify(purchase)
})
  .then(function(result) {
    return result.json();
  })
  .then(function(data) {
    var elements = stripe.elements();

    var style = {
      base: {
        color: "#666",
        fontFamily: 'Arial, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
          color: "#666"
        }
      },
      invalid: {
        fontFamily: 'Arial, sans-serif',
        color: "#fe392f",
        iconColor: "#fe392f"
      }
    };

    var card = elements.create("card", { style: style });
    // Stripe injects an iframe into the DOM
    card.mount("#card-element");

    card.on("change", function (event) {
      // Disable the Pay button if there are no card details in the Element
      document.querySelector("#submit").disabled = event.empty;
      document.querySelector("#card-errors").textContent = event.error ? event.error.message : "";
    });

    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
      event.preventDefault();
      // Complete payment when the submit button is clicked
      payWithCard(stripe, card, data.clientSecret);
    });
  });

// Calls stripe.confirmCardPayment
// If the card requires authentication Stripe shows a pop-up modal to
// prompt the user to enter authentication details without leaving your page.
var payWithCard = function(stripe, card, clientSecret) {
  loading(true);
  stripe
    .confirmCardPayment(clientSecret, {
      receipt_email: document.getElementById('email').value,
      payment_method: {
        card: card
      }
    })
    .then(function(result) {
      if (result.error) {
        // Show error to your customer
        showError(result.error.message);
      } else {
        // The payment succeeded!
        orderComplete(result.paymentIntent.id);
      }
    });
};

/* ------- UI helpers ------- */

// Shows a success message when the payment is complete
var orderComplete = function(paymentIntentId) {
  loading(false);
  document
    .querySelector(".result-message a")
    .setAttribute(
      "href",
      "https://dashboard.stripe.com/test/payments/" + paymentIntentId
    );
  var checkoutSaldo = document.getElementById("checkoutSaldo").getAttribute("href");
  document.querySelector(".result-message").classList.remove("hidden");
  document.querySelector("#submit").disabled = true;
  document.querySelector("#payment-form").classList.add("hidden");
  document.querySelector("#succeeded-payment").classList.remove("hidden");
  /*setTimeout(function() {
    window.location.replace(checkoutSaldo);
  }, 500);*/
};

// Show the customer the error from Stripe if their card fails to charge
var showError = function(errorMsgText) {
  loading(false);
  var errorMsg = document.querySelector("#card-errors");
  errorMsg.textContent = errorMsgText;
  document.querySelector("#payment-form").classList.add("hidden");
  document.querySelector("#fail-payment").classList.remove("hidden");
  /*setTimeout(function() {
    location.reload(true);
  }, 2000);*/
};

// Show a spinner on payment submission
var loading = function(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("#submit").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
};