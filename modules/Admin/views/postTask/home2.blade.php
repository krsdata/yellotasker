<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
<!-- BEGIN PAGE HEAD-->

<!-- END PAGE HEAD-->
<!-- BEGIN PAGE BREADCRUMB -->
@include('packages::partials.breadcrumb')

<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET--> 
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{ $heading }}</span>
                </div>
                 
            </div>
                  
            @if(Session::has('flash_alert_notice'))
                 <div class="alert alert-success alert-dismissable" style="margin:10px">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                  <i class="icon fa fa-check"></i>  
                 {{ Session::get('flash_alert_notice') }} 
                 </div>
            @endif
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row"> 

                        <div class="modal-body">
            <div class="post-detail-left">
                <div class="detail-pic-name">
                    <div class="pic-name-left">
                        <img src="{{url('storage/image/poster-big.png')}}" alt="">
                    </div>
                    <div class="pic-name-right"> 

                        <h4>Mark Josh <span class="follow-ico"><a href="#">
                        <img src="{{url('storage/image/follow.png')}}"></a></span>

                        </h4>
                        <p>Lorem ipsum dolor sit amet is the dummy lorem
            Lorem ipsum dolor sit amet is the dummy</p>
                        <p><a href="#">
                            <img src="{{url('storage/image/open.png')}}">

                        </a> &nbsp;&nbsp;<a href="#"><img src="{{url('storage/image/assigned.png')}}"></a> &nbsp;&nbsp;<a href="#"><img src="{{url('storage/image/complete.png')}}"></a></p>
                    </div>
                </div>
                <div class="post-description">
                    <h4>Description</h4>
                    <p>
                        Need a reliable Airtasker to help clean my 2 bedroom / 2 bathroom apartment.
                    Notes:<br>
                    Wash down bathroom walls as well please.They just need a freshen up
                    <br><br>
                    Standard Airtasker cleaning tasks should include: <br>
                    - Everywhere in the house: Wiping down furniture and visible surfaces; Mop and
                       vacuum floors; Empty rubbish <br>
                    - Bathrooms: Cleaning showers, bathtub and toilets; <br>
                    - Kitchen: Washing dishes; <br><br>

                    I would also like the following cleaning tasks included:<br>

                    - Windows (interior side) cleaned - should be about 1 hour

                    This task was created using a Template. You can still ask questions and make offers
                    as you would on a standard task.

                    </p>
                    <br>
                    <h4>Requirement</h4>
                    <p>This task has certain requirements of the Airtasker Worker</p>
                    <p>
                        <img src="{{url('storage/image/map.jpg')}}" alt="" width="100%;">
                    </p>
                </div>
            </div>
            <div class="post-detail-right">
                <h4>Task Budget</h4>
                <div class="rate">
                    <p class="main-price">
                                $100
                                <span>Approx. 4hrs</span>
                    </p>
                    <p class="make-offer">
                                <a href="#">Make An Offer</a>
                    </p>
                </div>
                                <div class="popup-location">
                                    <div class="pop-location-nav">
                                        <i class="fa fa-location-arrow"></i>
                                    </div>
                                    <div class="pop-location-desc">
                                        <h5>Location</h5>
                                        <p>Brookvale, New South
                Wales, Australia</p>
                                    </div>
                                    
                                </div>
                                <div class="popup-location">
                                    <div class="pop-location-nav">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="pop-location-desc">
                                        <h5>Posted by 20 sep</h5>
                                        <p>Brookvale, New South
                Wales, Australia</p>
                                    </div>
                                    
                                </div>
                                <div class="offers-pop">
                                    
                                </div>
                            </div>
                      </div>
                                 
                
                    </div> 
                </div>
            <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    <!-- END PAGE BASE CONTENT -->
    </div>
<!-- END CONTENT BODY -->
</div>


<!-- END QUICK SIDEBAR -->
</div>


 
        