@if (Session::has('success'))
<div class="alert alert-success text-center">
<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
<p>{{ Session::get('success') }}</p>
</div>
@endif
<div class="footer">
 
                <div class="container">
                <p class="text-xs-center" style="text-align:center;">&copy;2021 | www.Form.in | Powered by <a href="#" style="color:white;">Sourajit.</a></p>
                </div>
                
        </div>
    </div>

    <style>
    
    .footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #066fcc;
  color: white;
  text-align: center;
  font-weight: bold;
 
} 


</style>
@section('js')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        // $(document).ready(function() {
        // $('.ckeditor').ckeditor();
        // });
    </script>
@stop