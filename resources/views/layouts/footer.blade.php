<footer class="main-footer well" style="margin-bottom:0px;">
	<div class="pull-right hidden-xs">
	</div>
	Copyright &copy; {{ Carbon\Carbon::now()->year }} {{ config('app.name', 'Creator') }}. All Rights Reserved.
</footer>

{{-- Flash message --}}
<flash message="{{ Session('flash') }}"></flash>