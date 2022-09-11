@extends('layouts.layout')

@section('content')

@if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif


<div class="wrapper">
            <form enctype="multipart/form-data" method="POST" action="{{ route('pages.home') }}" id="calculateDistance">
        		<!-- SECTION 1 -->
            @csrf
                
                <section>
            <div class="inner">
						<div class="image-holder">
							<img src="images/form-wizard-1.jpg" alt="">
						</div>
						<div class="form-content" >
							<div class="form-header">
								<h3>Calculate distance</h3>
							</div>
							<p>Please Enter Post Codes</p>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" name="from" id="from" value="{{session()->get('from')}}"  required placeholder="From" class="form-control" >
								</div>

							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" name="to" id="to" value="{{session()->get('to')}}"  required placeholder="To" class="form-control">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
								<select name="unit" id="unit" placeholder="UNIT" required>
									<option value="Miles">Miles</option>
									<option value="Kilometers">Kilometers</option>
									<option value="Nautical Miles">Nautical Miles</option>
								</select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
								<input type="text" class="form-control" name="distance" id="distance" value="{{session()->get('distance')}} {{session()->get('unit')}}" disabled>
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
                				<input type="submit" value="calculate Distance"   />	
								</div>
							</div>
							
							
						</div>
					</div>
                </section>
            </form>
		</div>
		
		
		
                			
                
							

							
							

@endsection
