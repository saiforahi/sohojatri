<aside id="left-panel" class="left-panel border-right shadow">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href=""><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                </li>
                <li class="menu-title">Resource</li><!-- /.menu-title -->
                <!---
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-user-cog"></i>Resource Management</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-id-badge"></i><a href="">View Resource</a></li>
                        <li><i class="fa fa-bars"></i><a href="">Adjusting Resource</a></li>
                    </ul>
                </li>
                --->
                 <li class="menu-item-has-children dropdown navbar navbar-nav">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-cog"></i>Setting</a>
                    <ul class="sub-menu children dropdown-menu active">
                         <li><i class="fas fa-check-circle"></i><a href="{{route('admin.car.brand')}}">Create Car Brand</a></li>
                        <li><i class="fas fa-pause"></i> <a href="{{route('admin.ride.setting')}}"></i>Create Ride Rules</a></li>
                        <li><i class="menu-icon fab fa-centercode"></i><a href="{{route('promo_code.index')}}">Promo Code</a></li>
                    </ul>
                </li>
                <!-- <li class="">
                    <a href="{{route('admin.ride.setting')}}"> <i class="menu-icon fas fa-sliders-h"></i> Ride Setting</a>
                </li> -->
                <li class="">
                    <a href="{{route('admin.transition')}}"> <i class="menu-icon fas fa-sliders-h"></i> Transition</a>
                </li>
                <li class="">
                    <a href="{{route('admin.faultyTrip')}}"> <i class="menu-icon fas fa-sliders-h"></i> Faulty Trip</a>
                </li>
                <li class="">
                    <a href="{{route('admin.time.updates')}}"> <i class="menu-icon fas fa-clock"></i> Time Update Request</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-car"></i>Car management</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.approve.car')}}">Approve List</a></li>
                        <li><i class="fas fa-pause"></i><a href="{{route('admin.pending.car')}}">Pending List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Reject List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">All List</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fas fa-bookmark"></i> Booking</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.complete.book')}}">Complete Book</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.partial.book')}}">Partial Book</a></li>
                        <li><i class="fas fa-ban"></i><a href="{{route('admin.not.book')}}">Not Book</a></li>
                        <li><i class="fas fa-pause"></i><a href="{{route('admin.ongoing.book')}}">Ongoing Book</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.complete.ride')}}">Complete Ride</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.booking.list')}}">Booking List</a></li>

                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-car"></i>Trip Status</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.complete.ride')}}">Completed Trip</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">On Going Trip</a></li>
                        <li><i class="fas fa-times-circle"></i><a href="#">Faulty Trip</a></li>
                         <li><i class="fas fa-pause"></i><a href="#">Trip History Archived</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fab fa-bandcamp"></i>Post a Ride Status</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-check-circle"></i><a href="#">All Post List</a>
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.approve.post')}}">Post Approved List</a></li>
                        <li><i class="fas fa-pause"></i><a href="{{route('admin.pending.post')}}">Post Pending List</a></li>
                        <li><i class="fas fa-times-circle"></i><a href="{{route('admin.disapprove.post')}}">Post Reject List</a></li>
                    </ul>
                </li>
                 <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-money-bill-wave"></i>Account Closing Request</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.sp.account.close')}}">All List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Approved List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Pending List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Inquiry List</a></li>
                    </ul>
                </li>
               <!--  <li class="">
                   <a href="{{route('admin.sp.account.close')}}"> <i class="menu-icon fas fa-closed-captioning"></i>Account close request</a>
               </li> -->
              <!--   <li class="">
                  <a href="{{route('promo_code.index')}}"> <i class="menu-icon fab fa-centercode"></i>Promo Code</a>
              </li> -->
                <li class="">
                    <a href="{{route('admin.landing.image')}}"> <i class="menu-icon fas fa-road"></i>Landing Image</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-car"></i>Corporate</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-check-circle"></i><a href="{{route('corporate.index')}}">Add Corporate</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="#">Corporate List by Company</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="#">List of Member Under Corporate</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="#">Discount History Under Corporate</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="#">Close Corporate Deal</a></li>
                        <li><i class="fas fa-pause"></i><a href="{{route('corporate.group.index')}}">Corporate Group</a></li>
                    </ul>
                </li>
                 <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-money-bill-wave"></i>Transaction</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.transection')}}">All Transaction List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Completed Transaction List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Pending Transaction List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Faulty Transaction List</a></li>
                    </ul>
                </li>
               <!--  <li class="">
                   <a href="{{route('admin.transection')}}"> <i class="menu-icon fas fa-money-bill-wave"></i> Transection</a>
               </li> -->
               <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-money-bill"></i>Accounts</a>
                    <ul class="sub-menu children dropdown-menu">

                        <li><i class="fas fa-pause"></i><a href="#">Earning List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Commission History</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Discount Offered</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Corporate Accounts History</a></li>
                    </ul>
                </li>
               <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>Request One Status</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.requestRide')}}">List of Request</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Approved Request</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Pending Request</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Reject Reject</a></li>
                    </ul>
                </li>
                <!-- <li class="">
                    <a href="{{route('admin.requestRide')}}"> <i class="menu-icon fas fa-hands-helping"></i>Request a Ride</a>
                </li> -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-check-square"></i>Verification Status</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fas fa-hands-helping"></i><a href="{{route('profile.manage')}}">Coustomer Profile</a></li>
                        <li><i class="fas fa-book"></i><a href="{{route('admin.all.verification')}}">All List</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="{{route('admin.approve.verification')}}">Approve List</a></li>
                        <li><i class="fas fa-pause"></i><a href="{{route('admin.pending.verification')}}">Pending List</a></li>
                        <li><i class="fas fa-pause"></i><a href="{{route('admin.disapprove.verification')}}">Reject List With Reason</a></li>
                    </ul>
                </li>
                <li class="">
                    <a href="{{route('admin.popular.ride')}}"> <i class="menu-icon fas fa-user"></i>Popular Ride</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list"></i>Resource Status</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-book"></i><a href="{{route('admin.resourceList')}}">List of Resource</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="#">Pending Resource</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Approved Resource</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Reject Resource</a></li>
                    </ul>
                </li>
              <!--   <li class="">
                  <a href="{{route('admin.resourceList')}}"> <i class="menu-icon fas fa-user"></i>Resource List</a>
              </li> -->
              <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-envelope-open"></i>Messaging</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-book"></i><a href="#">Messaging History</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="#">Message to All</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Unread Message</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Read Message</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Delete Message</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Archived Message</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Draft Message</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Client to Client Message</a></li>
                    </ul>
                </li>
               <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bullhorn"></i>Complain</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-book"></i><a href="{{route('admin.complain')}}">List of Complain</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="#">Reply List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Pending List</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">Archived Complain</a></li>
                    </ul>
                </li>
                <!-- <li class="">
                    <a href="{{route('admin.complain')}}"> <i class="menu-icon fas fa-exclamation-circle"></i>Complain</a>
                </li> -->
                 <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-car"></i>Car Comfort</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-book"></i><a href="#">Luxury</a></li>
                        <li><i class="fas fa-check-circle"></i><a href="#">Comfort</a></li>
                        <li><i class="fas fa-pause"></i><a href="#">All</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</aside>
