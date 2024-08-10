$(function () {
    $("#online-delivery").on('click', function (e) {
        e.preventDefault();
        var self = $(e.target);

        self.text("Loading...");
        self.addClass("disabled");
        var amt = parseInt(self.data('1500')) * 100; // amount is in paisa
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_7ba34abb8d51408a9cca54dfd919b984",
            "productIdentity": "product-online-delivery", // some dummy product id
            "productName": "Online Delivery",
            "productUrl": "http://your-website.com/online-delivery",
            "merchant_button_id": "online-delivery",
            "eventHandler": {
                onSuccess(payload) {
                    debuginfo("success", "Success callback received. <br />" + JSON.stringify(payload));
                    // hit merchant api for initiating verification
                    console.log(payload);
                    self.text("Verifying payment...");

                    // verify from server side to complete the payment
                    verifyKhaltiPayment(payload, amt, e.target);
                    $("#khalt-widget").remove();
                },
                onError(error) {
                    console.log(error);
                    debuginfo("danger", "Error callback received. <br />" + JSON.stringify(error));
                    self.text("Payment failed");
                    self.addClass("btn-danger").removeClass("btn-success").removeClass("disabled");
                    $("#khalt-widget").remove();
                }
            }
        };

        // initiate KhaltiCheckout on the button click.
        var checkout = new KhaltiCheckout(Object.assign({}, config));
        checkout.show({ 'amount': amt });
    });
});
