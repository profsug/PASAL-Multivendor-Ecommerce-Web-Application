<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<!-- css for chat box  -->
<style>
   @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

    ::-webkit-scrollbar{
        width: 3px;
        border-radius: 25px;
    }
    ::-webkit-scrollbar-track{
        background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb{
        background: #ddd;
    }
    ::-webkit-scrollbar-thumb:hover{
        background: #ccc;
    }

    .wrapper{
        width: 370px;
        background: #fff;
        border-radius: 5px;
        border: 1px solid lightgrey;
        border-top: 0px;
        margin-left : 65%;
    }
    .wrapper .title{
        background: #007bff;
        color: #fff;
        font-size: 20px;
        font-weight: 500;
        line-height: 60px;
        text-align: center;
        border-bottom: 1px solid #006fe6;
        border-radius: 5px 5px 0 0;
    }
    .wrapper .form{
        padding: 20px 15px;
        min-height: 400px;
        max-height: 400px;
        overflow-y: auto;
    }
    .wrapper .form .inbox{
        width: 100%;
        display: flex;
        align-items: baseline;
    }
    .wrapper .form .user-inbox{
        justify-content: flex-end;
        margin: 13px 0;
    }
    .wrapper .form .inbox .icon{
        height: 40px;
        width: 40px;
        color: #fff;
        text-align: center;
        line-height: 40px;
        border-radius: 50%;
        font-size: 18px;
        background: #007bff;
    }
    .wrapper .form .inbox .msg-header{
        max-width: 53%;
        margin-left: 10px;
    }
    .form .inbox .msg-header p{
        color: #fff;
        background: #007bff;
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 14px;
        word-break: break-all;
    }
    .form .user-inbox .msg-header p{
        color: #333;
        background: #efefef;
    }
    .wrapper .typing-field{
        display: flex;
        height: 60px;
        width: 100%;
        align-items: center;
        justify-content: space-evenly;
        background: #efefef;
        border-top: 1px solid #d9d9d9;
        border-radius: 0 0 5px 5px;
    }
    .wrapper .typing-field .input-data{
        height: 40px;
        width: 335px;
        position: relative;
    }
    .wrapper .typing-field .input-data input{
        height: 100%;
        width: 100%;
        outline: none;
        border: 1px solid transparent;
        padding: 0 80px 0 15px;
        border-radius: 3px;
        font-size: 15px;
        background: #fff;
        transition: all 0.3s ease;
    }
    .typing-field .input-data input:focus{
        border-color: rgba(0,123,255,0.8);
    }
    .input-data input::placeholder{
        color: #999999;
        transition: all 0.3s ease;
    }
    .input-data input:focus::placeholder{
        color: #bfbfbf;
    }
    .wrapper .typing-field .input-data button{
        position: absolute;
        right: 5px;
        top: 50%;
        height: 30px;
        width: 65px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        outline: none;
        opacity: 0;
        pointer-events: none;
        border-radius: 3px;
        background: #007bff;
        border: 1px solid #007bff;
        transform: translateY(-50%);
        transition: all 0.3s ease;
    }
    .wrapper .typing-field .input-data input:valid ~ button{
        opacity: 1;
        pointer-events: auto;
    }
    .typing-field .input-data button:hover{
        background: #006fef;
    }
    .pull-right #togglechat{
        font-size: large;
    }
</style>
    <div class="pull-right"> 
        <!-- This is the toggle button to open/close the chatbot -->
        <button id='togglechat' class="btn btn-sm btn-primary">Chat</button>
    </div>
       <br><br> 
    </div>
    <div class="wrapper sidebar" id='sidebar'>
        <!-- This is the container for the chatbot -->
        <div class="title">Chatbot</div>
        <!-- values are added in this div-->
        <div class="form">
            <div class="bot-inbox inbox">
                <!-- This is the initial message displayed by the chatbot -->
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Hello there, Please leave a Message. We will get back to you soon</p>
                </div>
            </div>
        </div>
        <!-- This is the container for the input field and send button -->
        <div class="typing-field">
            <div class="input-data">
                <input id="data" type="text" placeholder="Type something here.." required>
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){  
            // Hide the chatbot by default   
            $("#sidebar").hide();
            // Toggle the chatbot when the button is clicked
            $("#togglechat").on("click",function(){
                if ($('#sidebar').css('display') == 'none') {                    
                    $("#sidebar").show();
                }else{                    
                    $("#sidebar").hide();
                }
            })
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                // start ajax code
                $.ajax({
                    url: './classes/Message.php',
                    type: 'POST',
                    data: {text : $value , get_message : 1 }, 
                    success: function(result){
                        console.log(result);
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>