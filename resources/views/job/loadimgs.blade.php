<div class="hd-item-images-ex">
    @if(count($images) > 0)
        <ul>
            @foreach($images as $image)
                <li id="hd-job-image-{{ $image->id }}" data-id="{{ $job->id }}" data-url="{{ route('job.image.destroy', [$job->id, $image->id]) }}" data-item="Image" data-container="hd-load-img-ex" data-loader="{{ route('job.images.load', $job->id) }}">
                    @csrf
                    <img src="{{ $image->getImagePath() }}" />
                    <span class="hd-remove-btn"><span class="lnr lnr-cross"></span></span>
                    <script type="text/javascript">$("#hd-job-image-{{ $image->id }}").deleteDataAJAX();</script>
                </li>
            @endforeach
        </ul>
    @else
        <span class="hd-error">NO IMAGES. PLEASE ADD SOME</span>
    @endif
</div>