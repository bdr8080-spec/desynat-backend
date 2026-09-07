<h2>Staff Login Credentials</h2>


<p>Hello {{ $seller_details->first_name }},</p>

<p>Your login credentials are:</p>

<p><strong>Email:</strong> {{ $seller_details->email }}</p>
<p><strong>Password:</strong> {{ $seller_details->save_password }}</p>

<a href="https://desynat.com.kw/seller/login">Click here </a>

<p>Thanks,Team Desynat</p>