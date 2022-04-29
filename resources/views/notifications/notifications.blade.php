<div class="m-dropdown__wrapper" id="notifications">
    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
    @if(isset($notifications))
        <div class="m-dropdown__inner">
            <div class="m-dropdown__header m--align-center" style="background: url({{asset('assets/app/media/img/misc/notification_bg.jpg')}}); background-size: cover;">
                <span class="m-dropdown__header-title">{{$unread_notifications}} New</span>
                <input type="hidden" id="unread_count" value="{{$unread_notifications}}">
                <span class="m-dropdown__header-subtitle">User Notifications</span>
            </div>
            <div class="m-dropdown__body">
                <div class="m-dropdown__content">
                    @if(count($notifications) > 0)
                        <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                            <div class="m-list-timeline m-list-timeline--skin-light">
                                @foreach($notifications as $notification)
                                    @if($notification->status == 1)
                                        <?php $notification_status = 'Unread'; ?>
                                    @elseif($notification->status == 2)
                                        <?php $notification_status = 'Read'; ?>
                                    @endif
                                    <div class="m-list-timeline__items">
                                        <div class="m-list-timeline__item">
                                            <span class="m-list-timeline__badge"></span>
                                            <a href="{{route('read_notification',['notification_id' => $notification->notification_id, 'type' => $notification->type])}}" class="m-list-timeline__text">
                                                {{$notification->message}}
                                            <span class="m-badge m-badge--success m-badge--wide">{{$notification_status}} </span></a>
                                            <span class="m-list-timeline__time">{{parse_date_get($notification->added_on)}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    <hr>
                        <div class="m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href="{{route('read_notification',['notification_id' => 0, 'type' => 'all'])}}" class="btn btn-success">
                                            Mark all as read
                                        </a>
                                        <a href="{{route('clear_all_notifications')}}"  class="btn btn-primary">
                                            Clear All
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                <span class="">All caught up!<br>No new logs.</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
<script>
    function get_pending_notifications() {
        $.ajax({
            type:'get',
            url:"{{ route('get_pending_notifications') }}",
            success: function( data ) {
                document.getElementById('notifications').innerHTML = data;
                if($('#unread_count').val() > 0 ){
                    $('.notification_icon').addClass('new');
                    $('.notification_icon').html($('#unread_count').val());
                }
            }
        });
    }
    document.addEventListener("DOMContentLoaded", function(event) {
        get_pending_notifications();
    });
    setInterval(function (){
        get_pending_notifications()
    }, 50000);
</script>