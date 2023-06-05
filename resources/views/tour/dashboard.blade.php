@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Welcome {{Session::get('user')->data->name}}</h1>
                </div>

                <div id="myCarousel" class="carousel slide" data-ride="carousel">
			          <!-- Indicators -->
			            <ol class="carousel-indicators">
				            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				            <li data-target="#myCarousel" data-slide-to="1"></li>
				            <li data-target="#myCarousel" data-slide-to="2"></li>		
		            	</ol>

                <div class="carousel slide" role="listbox">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                          <img src="{{asset('assets/img/bg_danautoba.png')}}" height="600" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="{{asset('assets/img/bg_samosir.jpeg')}}" height="600" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="{{asset('assets/img/bg_batakshop.jpg')}}" height="600" class="d-block w-100" alt="...">
                      </div>
                    </div>			             
                </div>

              <a class="carousel-control-prev" href="myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>

              <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>

            </div>          
            
        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
@endsection

