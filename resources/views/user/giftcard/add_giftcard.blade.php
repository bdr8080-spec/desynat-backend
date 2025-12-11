@extends('user.layout.header')


<style>
#myfatoorah-box {
    width: 100%;
    height: 400px;
}
</style>

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.gift_cards')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}"
                class="img-fluid"></a>
        <h3>Add Gift Card</h3>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-6">
            <div class="giftcard-type">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <h6>Select Occasion Type</h6>
                        <div class="occasion-buttons">
                            @foreach($giftCardCategory as $index => $category)
                            <button class="occasion-btn {{ $index === 0 ? 'active' : '' }}"
                                data-img="{{ $category['image'] }}" data-id="{{ $category['id'] }}">
                                {{ $category['name_english'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="giftoff">
                            <img id="occasionImage" src="{{ $giftCardCategory[0]['image'] }}" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="gift-pnl">
                    <h6>Choose Amount</h6>
                    <div class="occasion-buttons">
                        <button type="button" class="amount-btn active" data-value="50">50 KD</button>
                        <button type="button" class="amount-btn" data-value="100">100 KD</button>
                        <button type="button" class="amount-btn" data-value="200">200 KD</button>
                        <button type="button" class="amount-btn" data-value="500">500 KD</button>
                        <button type="button" class="amount-btn" data-value="">Enter Amount</button>
                    </div>

                    <div class="form-group w-100 py-2 amountpnl" style="display:none;">
                        <input type="text" class="form-control pline-10" id="customAmount" placeholder="Enter Amount">
                        <span class="text-danger error-text amount-error"></span>
                    </div>
                </div>

                <form id="giftCardForm">
                    @csrf
                    <div class="gift-pnl mt-4">
                        <input type="hidden" name="amount" id="amount" value="50">
                        <input type="hidden" name="gift_card_id" id="gift_card_id"
                            value="{{ $giftCardCategory[0]['id'] }}">
                        <input type="hidden" name="notes" id="notes">
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
                        <h6>Recipient Details</h6>
                        <div class="gift-pnl mt-4">
                            <h6>Recipient Details</h6>
                            <div class="form-group w-100 py-2">
                                <label>Name</label>
                                <input type="text" name="receiver_name" class="form-control pline-10"
                                    placeholder="Name">
                                <span class="text-danger error-text receiver_name_error"></span>
                            </div>
                            <div class="form-group w-100 py-2">
                                <label>Email ID</label>
                                <input type="text" name="receiver_email" class="form-control pline-10"
                                    placeholder="Email ID">
                                <span class="text-danger error-text receiver_email_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="gift-pnl">
                        <h6>From</h6>
                        <div class="form-group w-100 py-2">
                            <label>Name</label>
                            <input type="text" name="sender_name" class="form-control pline-10" placeholder="Name">
                            <span class="text-danger error-text sender_name_error"></span>
                        </div>
                        <div class="form-group w-100 py-2">
                            <label>Email ID</label>
                            <input type="text" name="sender_email" class="form-control pline-10" placeholder="Email ID">
                            <span class="text-danger error-text sender_email_error"></span>
                        </div>
                        <div class="form-group w-100 py-2">
                            <label>Wish Message</label>
                            <textarea name="wish_message" rows="3" class="form-control pline-10"
                                placeholder="Write here"></textarea>
                            <span class="text-danger error-text wish_message_error"></span>
                        </div>
                    </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="paycard">
                <div class="payment-option mb-3">
                    <label class="custom-radio">
                        <input type="radio" name="payment" id="onlinePayment" value="online" checked>
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">Online Payment</div>
                        </div>
                    </label>
                </div>
                <div id="" style="">
                    <div id="embedded-payment"></div>

                    <div id="unified-session"></div>

                    <div style="width:400px; margin: auto;">
                        <div id="apple-pay"></div>
                        <!-- This is the custom button for Apple Pay. -->
                        <!-- <button onclick="startApplePay()" style="display: block; margin: 0 auto; width: 400px; height: 30px; cursor: pointer; background-color: #000000; border: none; color: white; font-size: 16px; border-radius: 8px">Apple Pay</button> -->
                    </div>

                    <!-- This is a div element can be used as a container for Google Pay -->
                    <div style="width: 400px; margin: 0;">
                        <div id="google-pay"></div>
                    </div>

                    <!-- This is a div element can be used as a container for STC Pay -->
                    <div style="width: 400px; margin: 0;">
                        <div id="stc-pay"></div>
                    </div>

                    <div style="width: 400px; margin: 0;">
                        <div id="Card"></div>
                    </div>


                </div>
                <!-- <div class="payment-option mb-3">
                    <label class="custom-radio">
                        <input type="radio" name="payment" >
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">In-App Wallet</div>
                            <div class="balance">Available Balance : 349 KD</div>
                        </div>
                    </label>
                </div>
                <div class="payment-option">
                    <label class="custom-radio">
                        <input type="radio" name="payment">
                        <span class="radio-mark"></span>
                        <div class="label-content d-flex gap-2">
                            <span class="cod-box">COD</span>
                            <div class="title">Cash On Delivery</div>
                        </div>
                    </label>
                </div> -->
            </div>

            <div class="cmn-btn mt-4">
                <button type="submit" class="btn paybtn-common w-100">Pay Now</button>
            </div>
            </form>

            <div class="gift-pnl mt-4">
                <h6>Note</h6>
                <div class="note-bg">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto vero sint, odit neque
                        placeat natus voluptates assumenda, molestiae incidunt quos deserunt illum sequi. Laborum culpa
                        quaerat officia debitis labore! Facere.</p>
                </div>
            </div>

        </div>



    </div>
</div>

<script src="https://portal.myfatoorah.com/payment/v1/session.js"></script>

<script>
var sessionId = "{{$sessionId}}";
var countryCode = "ARE";
var currencyCode = "AED";
var amount = "0.25";

var payment = "http://127.0.0.1:8000/Payment-Callback";



// Define a callback function to handle the payment response
function paymentCallback(response) {
    // You can handle the response and send it to your server or perform any other action
    console.log(response);

    // For example, send the response to your server using fetch
    fetch(paymentUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(response) // Send the payment response to your server
        })
        .then(res => res.json())
        .then(data => {
            console.log("Server response:", data);
        })
        .catch(error => {
            console.error("Error while sending data to server:", error);
        });
}

// debugger
var config = {
    sessionId: sessionId,
    countryCode: countryCode,
    currencyCode: currencyCode,
    amount: amount,
    callback: payment,
    containerId: "unified-session",
    paymentOptions: ["Card"], //["GooglePay", "ApplePay", "Card"]
    supportedNetworks: ["visa", "masterCard"], //["visa", "masterCard", "mada", "amex"]
    language: "en",
    settings: {
        card: {
            onCardBinChanged: handleCardBinChanged,
            style: {
                hideNetworkIcons: false,
                cardHeight: "200px",
                tokenHeight: "230px",
                input: {
                    color: "black",
                    fontSize: "15px",
                    fontFamily: "courier",
                    inputHeight: "32px",
                    inputMargin: "3px",
                    borderColor: "black",
                    backgroundColor: "green",
                    borderWidth: "1px",
                    borderRadius: "30px",
                    outerRadius: "10px",
                    //boxShadow: "0 0 10px 5px purple, 0 0 15px 10px lightblue",
                    placeHolder: {
                        holderName: "Name On Card",
                        cardNumber: "Number",
                        expiryDate: "MM/YY",
                        securityCode: "CVV",
                    }
                },
                text: {
                    saveCard: "Save card info for future payments",
                    addCard: "Use another Card!",
                    deleteAlert: {
                        title: "Delete",
                        message: "Are you sure?",
                        confirm: "YES",
                        cancel: "NO"
                    }
                },
                label: {
                    display: true,
                    color: "black",
                    fontSize: "13px",
                    fontWeight: "bold",
                    fontFamily: "Times",
                    text: {
                        holderName: "Card Holder Name",
                        cardNumber: "Card Number",
                        expiryDate: "Expiry Date",
                        securityCode: "Security Code",
                    },
                },
                error: {
                    borderColor: "red",
                    borderRadius: "8px",
                    //boxShadow: "0 0 10px 5px purple, 0 0 15px 10px lightblue",
                },
                button: {
                    useCustomButton: false,
                    //onButtonClicked: submit,
                    textContent: "Pay",
                    fontSize: "16px",
                    fontFamily: "Times",
                    color: "white",
                    backgroundColor: "#4daee0",
                    height: "30px",
                    borderRadius: "8px",
                    width: "70%",
                    margin: "0 auto",
                    cursor: "pointer"
                },
                separator: {
                    useCustomSeparator: false,
                    textContent: "Enter your card",
                    fontSize: "20px",
                    color: "#4daee0",
                    fontFamily: "sans-serif",
                    textSpacing: "2px",
                    lineStyle: "dashed",
                    lineColor: "black",
                    lineThickness: "3px"
                }
            }
        }
    }
};

myfatoorah.init(config);
// myfatoorah.submitStcOtp("1234");

//Embedded Functions
function callback(response) {
    //Pass session id to your backend here
    if (response.isSuccess) {
        switch (response.paymentType) {
            case "ApplePay":
                console.log("Apple Pay Response>>\n" + JSON.stringify(response));
                break;
            case "GooglePay":
                console.log("Google Pay response >>\n" + JSON.stringify(response));
                break;
            case "Card":
                console.log("Card Response >>\n" + JSON.stringify(response));
                break;
            case "StcPay":
                console.log("STC Pay response >>\n" + JSON.stringify(response));
                break;
            default:
                console.log("Unknown payment type >>\n" + JSON.stringify(response));
                break;
        }
    } else {
        console.log("error", response);
    }
}

// #region STC Pay
function stcSessionStarted(data) {
    console.log("STC Session Started\n" + JSON.stringify(data));
}

function paymentSTC(response) {
    //Here you need to pass session id to you backend here
    var sessionId = response.sessionId;
    var STCMobileNumber = response.mobileNumber;

    console.log("SessionID via STC >> ", sessionId);
    console.log("Mobile Number via STC >> ", STCMobileNumber);
    console.log("response via STC >> ", response);
}

// #endregion

function sessionCanceled() {
    console.log("Failed");
}

function sessionStarted() {
    console.log("Start");
}

//This function enables you to update the amount displayed on Apple Pay and Google Pay after the initiation of the config.
function updateAmount(amount) {
    myfatoorah.updateAmount(amount);
}

//You need to implement here the handling of the callback for Apple Pay
function paymentAP(response) {
    //Here you need to pass session id to you backend here
    var sessionId = response.sessionId;
    var cardBrandAP = response.card.brand;

    console.log("SessionID via AP >> ", sessionId);
    console.log("cardBrand via AP >> ", cardBrandAP);
    console.log("response via AP >> ", response);
}

//You need to implement here the handling of the callback for Google Pay
function paymentGP(response) {
    //Here you need to pass session id to you backend here
    var sessionId = response.sessionId;
    var cardBrandGP = response.card.brand;

    console.log("SessionID via GP >> ", sessionId);
    console.log("cardBrand via GP >> ", cardBrandGP);
    console.log("response via GP >> ", response);
}

//Here you implement the function of clicking on the payment button using your own function
function submit() {
    console.log("Submit");
    myfatoorah.submitCardPayment(); //It is mandatory to call this function
}

//Here you implement the function of clicking on your custom payment button
function customSubmit() {
    console.log("Custom Submit");
    myfatoorah.submitCardPayment(); //It is mandatory to call this function
}

function handleCardBinChanged(response) {
    console.log(response);
}

//Here you specify the actions you need to do when customer clicks on your custom Apple Pay button
function startApplePay() {
    console.log("using custom button");
    myfatoorah.initApplePayPayment(); //It is mandatory to call this function
}
</script>