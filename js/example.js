var config = {
    // replace the publicKey with yours
    "publicKey": "test_public_key_7ba34abb8d51408a9cca54dfd919b984",
    "productIdentity": "1234567890",
    "productName": "Dragon",
    "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
    "eventHandler": {
        onSuccess(payload) {
            // hit merchant api for initiating verfication
            console.log(payload);
        },
        onError(error) {
            console.log(error);
        }
    }
};

var checkout = new KhaltiCheckout(config);
var btn = document.getElementById("payment-button");
btn.onclick = function () {
    checkout.show({ amount: 1000 });
}