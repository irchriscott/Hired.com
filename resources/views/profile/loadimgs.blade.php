<div class="hd-item-images-ex">
    @if(count($images) > 0)
        <ul>
            @foreach($images as $image)
                <li id="hd-profile-image-{{ $image->id }}" data-id="{{ $profile->id }}" data-url="{{ route('user.profile.image.destroy', [$profile->id, $image->id]) }}" data-item="Image" data-container="hd-load-img-ex" data-loader="{{ route('user.profile.images.load', $profile->id) }}">
                    @csrf
                    <img src="{{ $image->getImagePath() }}" />
                    <span class="hd-remove-btn"><span class="lnr lnr-cross"></span></span>
                    <script type="text/javascript">$("#hd-profile-image-{{ $image->id }}").deleteDataAJAX();</script>
                </li>
            @endforeach
        </ul>
    @else
        <span class="hd-error">NO IMAGES. PLEASE ADD SOME</span>
    @endif
</div>