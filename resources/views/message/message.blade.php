<section class="hd-modal-container" style="width:45%">
    <h4>Text Message</h4>
    <hr/>
    @if($message)
    <div>
        {!! $message->message !!}
    </div>
    @endif
    <div class="modal-footer" style="padding-bottom:0 !important;">
        <a href="#" style="font-weight:normal; font-size:14px !important;" id="hd-close-message" class="genric-btn danger radius">Close</a>
    </div>
    <script>$("#hd-close-message").closePopup()</script>
</section>