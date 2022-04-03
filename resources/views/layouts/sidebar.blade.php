<div class="" id="sidebar" style="position: fixed; height: 100%; width: 12%; background-color: #0F2549;">
	<ul class="nav nav-items p-0 mt-5 pt-5" style="list-style: none;" >
		<li class="nav-item " >
			<a  class="nav-link hvr-forward"  href="{{ url('/') }}"><i class="fa fa-home"></i> Dashboard</a>
		</li>

		<li class="nav-item " >
			<a class="nav-link hvr-forward"  href="{{ url('doctors') }}"><i class="fa fa-user-md"></i> Doctors</a>
		</li>

		<li class="nav-item " >
			<a class="nav-link hvr-forward"  href="{{ url('appointments') }}"><i class="fa fa-calendar-alt"></i> Appointments</a>
		</li>

		<li class="nav-item">
			<a  href="{{ url('diagnosis') }}" class="nav-link hvr-forward"><i class="fa fa-stethoscope"></i> Diagnosis </a>
		</li>

		<li class="nav-item">
			<a  href="{{ url('patients') }}" class="nav-link hvr-forward"><i class="fa fa-user"></i> Patients </a>
		</li>

		<li class="nav-item">
			<a  href="{{ url('messages') }}" class="nav-link hvr-forward"><i class="fa fa-envelope"></i> Enquiries </a>
		</li>

		<li class="nav-item">
			<a  href="{{ url('subscriptions') }}" class="nav-link hvr-forward"><i class="fa fa-list-alt"></i> Subscriptions </a>
		</li>

		<li class="nav-item">
			<a  href="{{ url('payments') }}" class="nav-link hvr-forward"><i class="fa fa-link"> </i> Payments</a>
		</li>

		<li class="nav-item">
			<a  href="{{ url('reports') }}" class="nav-link hvr-forward"><i class="fa fa-file"> </i> Reports</a>
		</li>

		<li class="nav-item">
			<a  href="{{ url('logs') }}" class="nav-link hvr-forward"><i class="fa fa-user-lock"> </i> System Logs</a>
		</li>
 
	</ul>
</div>


