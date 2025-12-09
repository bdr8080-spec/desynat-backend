@extends('user.layout.app')

@section('content')

<style>
.icon-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.select-btn {
    background: rgba(45, 45, 45, 0.6);
    padding: 6px 12px;
    border-radius: 6px;
    color: white;
    font-size: 13px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
}

.become-seller-btn {
    background: transparent;
    border: 1px solid #2d2d2d;
    padding: 6px 15px;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
}

.become-seller-btn:hover {
    background: rgba(45, 45, 45, 0.1);
}

.delivery-section {
    display: flex;
    align-items: center;
    gap: 20px;
}

.delivery-text {
    font-size: 13px;
    color: #2d2d2d;
}

.location-select {
    background: transparent;
    border: none;
    font-size: 13px;
    cursor: pointer;
    color: #2d2d2d;
}

.search-container {
    flex: 1;
    max-width: 500px;
    position: relative;
}

.search-input {
    width: 100%;
    padding: 10px 40px 10px 15px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
}

.search-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    color: #666;
}

.nav-menu {
    display: flex;
    gap: 25px;
    align-items: center;
}

.nav-item {
    color: #2d2d2d;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: color 0.3s;
}

.nav-item:hover {
    color: #fff;
}

/* Main Content */
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 30px 40px;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 30px;
    color: #2d2d2d;
}

.back-arrow {
    cursor: pointer;
    font-size: 20px;
}

.main-content {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 30px;
}

/* Cart Items */
.cart-section {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.cart-item {
    display: flex;
    gap: 20px;
    padding: 20px 0;
    border-bottom: 1px solid #f0f0f0;
}

.cart-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 100px;
    height: 120px;
    background: #f5f5f5;
    border-radius: 8px;
    overflow: hidden;
}

.item-details {
    flex: 1;
}

.item-name {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #2d2d2d;
}

.item-specs {
    display: flex;
    gap: 15px;
    margin-bottom: 8px;
    font-size: 13px;
    color: #666;
}

.item-price {
    font-size: 16px;
    font-weight: 600;
    color: #2d2d2d;
}

.item-price .old-price {
    text-decoration: line-through;
    color: #999;
    font-weight: 400;
    margin-left: 8px;
}

.return-info {
    font-size: 12px;
    color: #4caf50;
    margin-top: 5px;
}

.delivery-info {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
    font-size: 13px;
    color: #666;
}

.shop-more {
    color: #b8956a;
    text-decoration: none;
    font-size: 13px;
}

.item-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.qty-btn {
    width: 28px;
    height: 28px;
    background: #f5f5f5;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-display {
    font-size: 16px;
    font-weight: 600;
    padding: 0 10px;
}

.action-icon {
    width: 28px;
    height: 28px;
    background: #f5f5f5;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 14px;
}

/* Address & Promo */
.address-section {
    background: white;
    border-radius: 12px;
    padding: 20px 25px;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.section-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #2d2d2d;
}

.address-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #fafafa;
    border-radius: 8px;
    font-size: 14px;
}

.change-link {
    color: #b8956a;
    text-decoration: none;
    font-size: 13px;
}

.promo-section {
    background: white;
    border-radius: 12px;
    padding: 20px 25px;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.promo-input-group {
    display: flex;
    gap: 10px;
}

.promo-input {
    flex: 1;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
}

.apply-btn {
    padding: 10px 20px;
    background: transparent;
    border: 1px solid #b8956a;
    border-radius: 8px;
    color: #b8956a;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s;
}

.apply-btn:hover {
    background: #b8956a;
    color: white;
}

/* Billing Section */
.billing-section {
    background: white;
    border-radius: 12px;
    padding: 20px 25px;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.billing-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 14px;
    color: #666;
}

.billing-row.total {
    border-top: 2px solid #f0f0f0;
    margin-top: 10px;
    padding-top: 15px;
    font-weight: 600;
    font-size: 16px;
    color: #2d2d2d;
}

.discount-amount {
    color: #f44336;
}

.savings-note {
    color: #4caf50;
    font-size: 13px;
    margin-top: 10px;
}

/* Payment Section */
.payment-section {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.payment-option:hover {
    border-color: #b8956a;
    background: #fafafa;
}

.payment-option.selected {
    border-color: #b8956a;
    background: #fff8f0;
}

.radio {
    width: 18px;
    height: 18px;
    border: 2px solid #ddd;
    border-radius: 50%;
    position: relative;
    flex-shrink: 0;
}

.payment-option.selected .radio {
    border-color: #b8956a;
}

.payment-option.selected .radio::after {
    content: '';
    width: 10px;
    height: 10px;
    background: #b8956a;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.payment-icon {
    font-size: 20px;
    flex-shrink: 0;
}

.payment-label {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
}

.default-badge {
    font-size: 12px;
    color: #666;
}

.card-details {
    margin-left: 42px;
    margin-top: 12px;
}

.card-number {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 13px;
    color: #666;
}

.card-radio {
    width: 16px;
    height: 16px;
    border: 2px solid #ddd;
    border-radius: 50%;
    flex-shrink: 0;
}

.card-radio.selected {
    border-color: #b8956a;
    position: relative;
}

.card-radio.selected::after {
    content: '';
    width: 8px;
    height: 8px;
    background: #b8956a;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.add-new-link {
    color: #b8956a;
    font-size: 13px;
    margin-left: 42px;
    display: block;
    margin-top: 8px;
    cursor: pointer;
    text-decoration: none;
}

.balance-info {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
    margin-left: 42px;
}

.gift-card-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #fff8e6;
    border-radius: 8px;
    margin-top: 20px;
}

.gift-card-text {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}

.apply-gift-link {
    color: #b8956a;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
}

.place-order-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #b8956a 0%, #a07d4f 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 20px;
    transition: all 0.3s;
}

.place-order-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(184, 149, 106, 0.3);
}

/* Footer */
.footer {
    background: linear-gradient(135deg, #b8956a 0%, #a07d4f 100%);
    padding: 50px 40px 20px;
    margin-top: 60px;
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
}

.footer-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #2d2d2d;
}

.footer-logo-icon {
    width: 45px;
    height: 45px;
    background: #2d2d2d;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #b8956a;
    font-weight: bold;
    font-size: 22px;
}

.footer-text {
    color: #3d3d3d;
    font-size: 13px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.affiliate-btn {
    background: transparent;
    border: 2px solid #2d2d2d;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    color: #2d2d2d;
    font-weight: 500;
}

.affiliate-btn:hover {
    background: #2d2d2d;
    color: #b8956a;
}

.footer-column h3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #2d2d2d;
    text-decoration: underline;
    text-decoration-thickness: 2px;
    text-underline-offset: 8px;
}

.footer-links {
    list-style: none;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: #3d3d3d;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s;
}

.footer-links a:hover {
    color: #2d2d2d;
}

.app-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 20px;
}

.app-btn {
    width: 150px;
    height: 45px;
    background: #2d2d2d;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 12px;
}

.app-btn:hover {
    transform: translateY(-2px);
}

.social-icons {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.social-icon {
    width: 40px;
    height: 40px;
    background: #2d2d2d;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 18px;
}

.social-icon:hover {
    transform: translateY(-3px);
}

.footer-bottom {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid rgba(45, 45, 45, 0.2);
    color: #3d3d3d;
    font-size: 13px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .main-content {
        grid-template-columns: 1fr 380px;
    }

    .footer-content {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 992px) {
    .main-content {
        grid-template-columns: 1fr;
    }

    .nav-menu {
        display: none;
    }

    .header-top {
        flex-wrap: wrap;
    }

    .search-container {
        order: 3;
        width: 100%;
        max-width: 100%;
        margin-top: 15px;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 20px;
    }

    .header {
        padding: 12px 20px;
    }

    .footer {
        padding: 30px 20px;
    }

    .footer-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .cart-item {
        flex-direction: column;
    }

    .item-image {
        width: 100%;
        height: 200px;
    }

    .header-icons {
        gap: 8px;
    }

    .icon-btn {
        width: 28px;
        height: 28px;
        font-size: 14px;
    }

    .delivery-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .logo {
        font-size: 20px;
    }

    .logo-icon {
        width: 30px;
        height: 30px;
        font-size: 16px;
    }

    .page-title {
        font-size: 20px;
    }

    .item-specs {
        flex-direction: column;
        gap: 5px;
    }
}
</style>

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.gift_cards')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>My Bag</h3>
    </div>

    <div class="main-content">
        


    
    </div>
</div>



@endsection