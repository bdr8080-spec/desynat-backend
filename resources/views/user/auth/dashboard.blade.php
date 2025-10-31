<h1>Hello World</h1>

@if (Auth::guard('web')->check())
  <h1>Pawan Kumar</h1>  
@endif
