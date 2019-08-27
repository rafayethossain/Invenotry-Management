<aside class="sidebar-wrapper navbar-default">
	<div class="brand">
		<a href="{{ url('/') }}">
			<img src="{{ asset('images/brandimage.jpg') }}" class="brand-image" alt="{{ config('app.name', 'Tamim International') }}">
		</a>
	</div>
	<nav class="sidebar-menu" role="navigation" style="overflow-y: scroll; height:550px;">
		<ul class="sidebar-active">

			<li>
				<a href="{{ url('home') }}" class="btn-primary">
					<i class="fa fa-dashboard" aria-hidden="true"></i>
					<span>Dashboard</span>
				</a>
			</li>
			
			{{-- Products menu --}}
			<li @if(\Request::is('product/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('product') }}">
					<i class="fa fa-product-hunt" aria-hidden="true"></i>
					Products
				</a>
			</li>

			@role('super_admin')
			{{-- User menu --}}
			<li @if(\Request::is('user/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('user') }}">
					<i class="fa fa-user-o" aria-hidden="true"></i>
					Users
				</a>
			</li>

			{{-- Customer menu --}}
			<li @if(\Request::is('customer/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('customer') }}">
					<i class="fa fa-users" aria-hidden="true"></i>
					Customers
				</a>
			</li>

			{{-- Customer menu --}}
			<li @if(\Request::is('area/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('area') }}">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					Areas
				</a>
			</li>

			<li @if(\Request::is('subarea/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('subarea') }}">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					Sub Areas
				</a>
			</li>

			{{-- Income --}}
			<li @if(\Request::is('income/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('income') }}">
					<i class="fa fa-money" aria-hidden="true"></i>
					Incomes
				</a>
			</li>

			{{-- Expense menu --}}
			<li @if(\Request::is('expense/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('expense') }}">
					<i class="fa fa-usd" aria-hidden="true"></i>
					Expenses <i id="expensenotification"></i>
				</a>
			</li>

			{{-- Purchase menu --}}
			<li @if(\Request::is('purchase/*'))
               	class="active"
           		@endif>
				<a href="{{ url('purchase') }}" class="btn-primary">
					<i class="fa fa-shopping-bag" aria-hidden="true"></i>
					Purchases <i id="purchasenotification"></i>
				</a>
			</li>

			{{-- Sales menu --}}
			<li @if(\Request::is('sale/*'))
               	class="active"
           		@endif>
				<a href="{{ url('sale') }}" class="btn-primary">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
					<span>Sales</span> <i id="salenotification"></i>
				</a>
			</li>

			{{-- Order menu --}}
			<li @if(\Request::is('order/*'))
               	class="active"
           		@endif>
				<a href="{{ url('order') }}" class="btn-primary">
					<i class="fa fa-shopping-basket" aria-hidden="true"></i>
					<span>Orders</span>
				</a>
			</li>

			{{-- Category menu --}}
			<li @if(\Request::is('category/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('category') }}">
					<i class="fa fa-align-justify" aria-hidden="true"></i>
					Categories
				</a>
			</li>	

			{{-- Category menu --}}
			<li @if(\Request::is('subcategory/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('subcategory') }}">
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
					Sub Categories
				</a>
			</li>

			{{-- Category menu --}}
			<li @if(\Request::is('quotation/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('quotation') }}">
					<i class="fa fa-quote-right" aria-hidden="true"></i>
					Quotation
				</a>
			</li>

			{{-- Damaged Product menu --}}
			<li @if(\Request::is('damagedproduct/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('damagedproduct') }}">
					<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
					Damaged Product
				</a>
			</li>

			{{-- Returned Product menu --}}
			<li @if(\Request::is('returnedproduct/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('returnedproduct') }}">
					<i class="fa fa-undo" aria-hidden="true"></i>
					Returned Product
				</a>
			</li>

			{{-- Returned Product menu --}}
			<li @if(\Request::is('loan/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('loan') }}">
					<i class="fa fa-code-fork" aria-hidden="true"></i>
					Loan
				</a>
			</li>
			@endrole

			@role('admin')

			{{-- Customer menu --}}
			<li @if(\Request::is('customer/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('customer') }}">
					<i class="fa fa-users" aria-hidden="true"></i>
					Customers
				</a>
			</li>

			{{-- Customer menu --}}
			<li @if(\Request::is('area/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('area') }}">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					Areas
				</a>
			</li>

			<li @if(\Request::is('subarea/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('subarea') }}">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					Sub Areas
				</a>
			</li>

			{{-- Income --}}
			<li @if(\Request::is('income/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('income') }}">
					<i class="fa fa-money" aria-hidden="true"></i>
					Incomes
				</a>
			</li>

			{{-- Expense menu --}}
			<li @if(\Request::is('expense/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('expense') }}">
					<i class="fa fa-usd" aria-hidden="true"></i>
					Expenses
				</a>
			</li>

			{{-- Purchase menu --}}
			<li @if(\Request::is('purchase/*'))
               	class="active"
           		@endif>
				<a href="{{ url('purchase') }}" class="btn-primary">
					<i class="fa fa-shopping-bag" aria-hidden="true"></i>
					<span>Purchases</span>
				</a>
			</li>

			{{-- Category menu --}}
			<li @if(\Request::is('category/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('category') }}">
					<i class="fa fa-align-justify" aria-hidden="true"></i>
					Categories
				</a>
			</li>	

			{{-- Category menu --}}
			<li @if(\Request::is('subcategory/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('subcategory') }}">
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
					Sub Categories
				</a>
			</li>
			@endrole

			@role('accountant')
			{{-- Purchase menu --}}
			<li @if(\Request::is('purchase/*'))
               	class="active"
           		@endif>
				<a href="{{ url('purchase') }}" class="btn-primary">
					<i class="fa fa-shopping-bag" aria-hidden="true"></i>
					<span>Purchases</span>
				</a>
			</li>


			{{-- Income --}}
			<li @if(\Request::is('income/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('income') }}">
					<i class="fa fa-money" aria-hidden="true"></i>
					Incomes
				</a>
			</li>

			{{-- Expense menu --}}
			<li @if(\Request::is('expense/*'))
               	class="active"
           		@endif>
				<a class="btn-primary" href="{{ url('expense') }}">
					<i class="fa fa-usd" aria-hidden="true"></i>
					Expenses
				</a>
			</li>

			<li @if(\Request::is('sale/*'))
               	class="active"
           		@endif>
				<a href="{{ url('sale') }}" class="btn-primary">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
					<span>Sales</span>
				</a>
			</li>
			@endrole	

			@role('manager')

			{{-- Sales menu --}}
			<li @if(\Request::is('sale/*'))
               	class="active"
           		@endif>
				<a href="{{ url('sale') }}" class="btn-primary">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
					<span>Sales</span>
				</a>
			</li>

			{{-- Order menu --}}
			<li @if(\Request::is('order/*'))
               	class="active"
           		@endif>
				<a href="{{ url('order') }}" class="btn-primary">
					<i class="fa fa-shopping-basket" aria-hidden="true"></i>
					<span>Orders</span>
				</a>
			</li>
			@endrole	

			@role('seller')

			{{-- Order menu --}}
			<li @if(\Request::is('order/*'))
               	class="active"
           		@endif>
				<a href="{{ url('order/create') }}" class="btn-primary">
					<i class="fa fa-shopping-basket" aria-hidden="true"></i>
					<span>Orders</span>
				</a>
			</li>
			@endrole

			@role('area_manager')

			{{-- Order menu --}}
			<li @if(\Request::is('order/*'))
               	class="active"
           		@endif>
				<a href="{{ url('order/create') }}" class="btn-primary">
					<i class="fa fa-shopping-basket" aria-hidden="true"></i>
					<span>Orders</span>
				</a>
			</li>

			{{-- Order menu --}}
			<li @if(\Request::is('sellerreport/*'))
               	class="active"
           		@endif>
				<a href="{{ url('sellerreport') }}" class="btn-primary">
					<i class="fa fa-line-chart" aria-hidden="true"></i>
					<span>Report</span>
				</a>
			</li>
			@endrole	


		</ul>
	</nav>
</aside>