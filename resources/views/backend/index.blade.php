@extends('backend.layout.app')

@section('content')

    <div class="content">

        <!-- Animated -->
        <div class="animated fadeIn">
            <!-- Widgets  -->
            <div class="row">
                
                <div class="col-lg-3 col-md-6">
                <a href="https://yoyocar.xyz/admin-approve-car">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count"> {{ $car_apporved }}</span></div>
                                        <div class="stat-heading">Total Car (Approved)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                <div class="col-lg-3 col-md-6">
                <a href="https://yoyocar.xyz/admin-pending-car">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $car_pending }}</span></div>
                                        <div class="stat-heading">Total Car (Pending)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                
                
                <div class="col-lg-3 col-md-6">
                <a href="https://yoyocar.xyz/admin-car-brand">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $car_brand }}</span></div>
                                        <div class="stat-heading">Total Car Brand</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                
                <div class="col-lg-3 col-md-6">
                <a href="https://yoyocar.xyz/admin-complete-book">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count"> {{ $complete_book }}</span></div>
                                        <div class="stat-heading">Total Complete Booking</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                
                <div class="col-lg-3 col-md-6">
                
                <a href="https://yoyocar.xyz/admin-partial-book">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $partial_book }}</span></div>
                                        <div class="stat-heading">Total Partial Booking</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                
                <div class="col-lg-3 col-md-6">
                
                <a href="https://yoyocar.xyz/admin-not-book">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $not_book }}</span></div>
                                        <div class="stat-heading">Total Not Booked</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                
                
                <div class="col-lg-3 col-md-6">
                
                <a href="https://yoyocar.xyz/admin-ongoing-book">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $on_going_booked }}</span></div>
                                        <div class="stat-heading">Total Ongoing Booked</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                
                
                <div class="col-lg-3 col-md-6">
                
                <a href="https://yoyocar.xyz/admin-complete-ride">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $total_complete_ride }}</span></div>
                                        <div class="stat-heading">Total Complete Ride</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                
                
                <div class="col-lg-3 col-md-6">
                
                <a href="https://yoyocar.xyz/admin-booking-list">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $total_booking_list }}</span></div>
                                        <div class="stat-heading">Total Booking List</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                
                
                
            </div>
        </div>
        <!-- .animated -->


    </div>

@endsection