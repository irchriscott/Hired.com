<section class="hd-modal-container">
    <h4>Message Map</h4>
    <hr/>
    <div class="hd-big-message-map" id="hd-big-message-map"></div>
    <input type="hidden" id="latitude_else" />
    <input type="hidden" id="longitude_else" />
    <input type="hidden" id="search_else" />
    <hr/>
    <div>
        <a href="#" style="font-weight:normal; font-size:14px !important;" id="hd-close-message" class="genric-btn danger radius">Close</a>
        <a href="#" id="hd-show-map-menu" data-id="map" style="font-weight:normal; font-size:14px !important;" class="genric-btn primary radius">Direction</a>
        <a style="font-weight:normal; font-size:14px !important;" href="https://www.google.com/maps?q={{ $message->latitude }},{{ $message->longitude }}" target="_blank" class="genric-btn success radius">View</a>
        <span style="margin-left: 10px;"><i class="fa fa-road"></i> <span id="distance" class="distance"></span></span>
        <span style="margin-left: 10px;"><i class="fa fa-clock-o"></i> <span id="time"></span></span>
        <span style="margin-left: 10px; display: none;" id="with_traffic"><i class="fa fa-clock-o"></i> <span id="time_drive_traffic"></span></span>
        <div class="hd-menu" id="hd-menu-map" style="margin-top:-153px; margin-left:104px;">
			<ul>
                <li>
                    <span class="lnr lnr-wheelchair"></span>
                    <a href="#" id="direct_walk">Walk</a>
                </li>
                <div class="dropdown-divider"></div>
                <li>
                    <span class="lnr lnr-car"></span>
                    <a href="#" id="direct_drive">Drive</a>
                </li>
            </ul>
        </div>
    </div>
    <script>
        $("#hd-close-message").closePopup();
        $("#hd-show-map-menu").click(function(e){e.preventDefault()});
        $("#hd-show-map-menu").showMenu();
        getUserCurrentLocation("latitude_else", "longitude_else", "search_else");
        loadMapMessage("hd-big-message-map", "{{ $message->address }}", "{{ $message->longitude }}", "{{ $message->latitude }}", 17);
        $("#direct_walk").click(function(e){
            e.preventDefault();
            drawRouteMap("{{ $message->latitude }}", "{{ $message->longitude }}", "{{ $message->address }}", "hd-big-message-map", "w");
            $("#hd-menu-map").hide();
        });
        $("#direct_drive").click(function(e){
            e.preventDefault();
            drawRouteMap("{{ $message->latitude }}", "{{ $message->longitude }}", "{{ $message->address }}", "hd-big-message-map", "d");
            $("#hd-menu-map").hide();
        });
    </script>
</section>