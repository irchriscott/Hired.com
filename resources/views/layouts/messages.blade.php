@if(session()->has('success'))
	<script type="text/javascript">showSuccessMessage('success', "{{session()->get('success')}}");</script>
@endif
@if(session()->has('error'))
	<script type="text/javascript">showErrorMessage('error', "{{session()->get('error')}}");</script>
@endif
@if(session()->has('info'))
	<script type="text/javascript">showInfoMessage('info', "{{session()->get('info')}}");</script>
@endif
@if(count($errors) > 0)
    @foreach ($errors->all() as $error)
        <script type="text/javascript">showErrorMessage('error', '{{$error}}');</script>
    @endforeach
@endif