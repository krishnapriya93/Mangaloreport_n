@extends('backend.layouts.htmlheader')

@section('content')
  <section class="section">
    <div class="container-fluid">
      <!-- ========== title-wrapper start ========== -->
      <div class="title-wrapper pt-30">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="title mb-30">
              <h2> Dashboard</h2>
            </div>
          </div>
          <!-- end col -->
          <div class="col-md-6">
            <div class="breadcrumb-wrapper mb-30">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <!-- <a href="#0">Dashboard<i class="fas fa-clock"></i></a> -->
                  </li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
          <div class="alert alert-primary" role="alert">
           <img src="{{asset('/images/new.png')}}" class="dashboard_whatsne"></img>
          </div>


             <!-- ========== alerts-wrapper start ========== -->
             <div class="alerts-wrapper">
            <div class="card-style mb-30">
              <h5 class="text-medium mb-25"> Alert</h5>
              <p class="text-sm mb-30">
               Important alert in kseb
              </p>
              <div class="alert-list-wrapper">
          
                <div class="alert-box orange-alert pl-100">
                  <div class="left">
                    <h5 class="text-bold">Short Alert</h5>
                  </div>
                  <div class="alert">
                    <h4 class="alert-heading">Short Alert</h4>
                    <p class="text-medium">
                      Excitement, Energy, Passion, Courage, Attention
                    </p>
                  </div>
                </div>
                <!-- end alert-box -->
                <div class="alert-box warning-alert pl-100">
                  <div class="left">
                    <h5 class="text-bold">Long Alert</h5>
                  </div>
                  <div class="alert">
                    <h4 class="alert-heading">Long Alert</h4>
                    <p class="text-medium">
                      Enthusiasm, Opportunity, Spontaneity, Happiness,
                      Positivity
                    </p>
                  </div>
                </div>
                <!-- end alert-box -->
                <div class="alert-box info-alert pl-100">
                  <div class="left">
                    <h5 class="text-bold">Media Alert</h5>
                  </div>
                  <div class="alert">
                    <h4 class="alert-heading">Media Alert</h4>
                    <p class="text-medium">
                      Growth, Harmony, Kindness, Dependability
                    </p>
                  </div>
                </div>
                <!-- end alert-box -->
                <div class="alert-box success-alert pl-100">
                  <div class="left">
                    <h5 class="text-bold">Updates</h5>
                  </div>
                  <div class="alert">
                    <h4 class="alert-heading">Updates</h4>
                    <p class="text-medium">
                      Safety, Harmony, Stability, Reliability, Balance
                    </p>
                  </div>
                </div>
                <!-- end alert-box -->
      
        
     
              </div>
            </div>
          </div>
          <!-- ========== alerts-wrapper end ========== -->

      <!-- ========== title-wrapper end ========== -->

      <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <!-- <div class="icon purple">
              <i class="lni lni-cart-full"></i>
            </div> -->
            <!-- <div class="content">
              <h6 class="mb-10">New Orders</h6>
              <h3 class="text-bold mb-10">34567</h3>
              <p class="text-sm text-success">
                <i class="lni lni-arrow-up"></i> +2.00%
                <span class="text-gray">(30 days)</span>
              </p>
            </div> -->
          </div>
          <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <!-- <div class="icon success">
              <i class="lni lni-dollar"></i>
            </div> -->
            <!-- <div class="content">
              <h6 class="mb-10">Total Income</h6>
              <h3 class="text-bold mb-10">$74,567</h3>
              <p class="text-sm text-success">
                <i class="lni lni-arrow-up"></i> +5.45%
                <span class="text-gray">Increased</span>
              </p>
            </div> -->
          </div>
          <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <!-- <div class="icon primary">
              <i class="lni lni-credit-cards"></i>
            </div> -->
            <!-- <div class="content">
              <h6 class="mb-10">Total Expense</h6>
              <h3 class="text-bold mb-10">$24,567</h3>
              <p class="text-sm text-danger">
                <i class="lni lni-arrow-down"></i> -2.00%
                <span class="text-gray">Expense</span>
              </p>
            </div> -->
          </div>
          <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <!-- <div class="icon orange">
              <i class="lni lni-user"></i>
            </div> -->
            <!-- <div class="content">
              <h6 class="mb-10">New User</h6>
              <h3 class="text-bold mb-10">34567</h3>
              <p class="text-sm text-danger">
                <i class="lni lni-arrow-down"></i> -25.00%
                <span class="text-gray"> Earning</span>
              </p>
            </div> -->
          </div>
          <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
      </div>
    </div>
  </section>
  @endsection

    </body>

    </html>
