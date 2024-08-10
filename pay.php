<!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/khalti.css" type="text/css">
<?php
include("connection.php");
session_start();
error_reporting(0);

    if(!isset($_SESSION['customer']))
    {
        header("location:login.php");
    }
?>
<?php
    $order_id = $_SESSION['order_id']; 
    // get the order details
    $query= "SELECT * from orders where order_id='".$order_id."'";
    $data= mysqli_query($conn, $query);
    $result = $data->fetch_row();  
?>
<div id="alert-content"></div>
 <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script> 
 <!-- Place this where you need payment button -->

 <!-- insert code for order summary display here -->
    <button id="payment-button">Pay with Khalti</button>

<script src="js/jquery-1.11.1.min.js"></script>
<script>
    $(function(){
        $("#payment-button").on('click',function(e){
            e.preventDefault();
            var self = $(e.target);
            var amt = <?php echo($result[7] * 100); ?>;
            var config = {
                // replace the publicKey with yours
                "publicKey": "test_public_key_a23e5d8508854d299fd548ca88b983a1",
                "productIdentity": "<?php echo $order_id?>",
                "productName": "Dragon",
                "productUrl": "http://localhost/order_success.php",
                "paymentPreference": [
                    "KHALTI",
                    ],
                "eventHandler": {
                    onSuccess (payload) {
                        // hit merchant api for initiating verfication
                        console.log(payload);
                        verifyKhaltiPayment(payload , 1000 , e.target )

                    },
                    onError (error) {
                        console.log(error);
                    },
                    onClose () {
                        console.log('widget is closing');
                    }
                }
            };
            var checkout = new KhaltiCheckout(config);
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            checkout.show({amount: amt});
        })
    })
    function verifyKhaltiPayment(payload , amt , targetBtn){
        var token = payload.token;
        var amt = payload.amt;
        var self = $(targetBtn);

        debuginfo("success",'Payment token received = ' + token);

        // ajax call
        $.post("verify.php",payload,function(resp){
            debuginfo("success","Payment verification response : <br/><pre>" + resp + "</pre>");
            self.removeClass("disabled");
            self.text("Payment Verified");
            self.removeClass("btn-danger").addClass("btn-success");
            var result = $.parseJSON(resp);

            console.log(result['khalti']['state']['name']);
             // update order table
            $.ajax({
                url : './classes/Order.php',
                method : 'POST',
                data : {confirm_payment:1, order_id: <?php echo $order_id ?> , payment_token : token , payment_status : result['khalti']['state']['name'] , payment_user : result['khalti']['user']['name'] },
                success : function(response){
                    console.log(response);
			        var resp = $.parseJSON(response);
                    if (resp.status == 202) {
                        alert(resp.message);  
                        window.location.replace("order_success.php");
                    }else{
                        alert(resp.message);
                    }
                }
            });
        })
 
    }
    function debuginfo(alertclass , msg){
        var _msg = $("<div class='alert'></div>");
        _msg.append(msg);
        _msg.addClass("alert-" + alertclass);
        $('#alert-content').append(_msg);
    }
</script>
</html>