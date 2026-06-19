@php
    $firstMedia = $images_show[0][0] ?? '';
    $isVideo = preg_match('/\.(mp4|mov|avi|webm|mkv)$/i', $firstMedia);
@endphp

<!-- Main Media -->
<div class="main-img-container mb-3">

    @if($isVideo)
        <video id="mainVideo" class="img-fluid rounded main-img" controls>
            <source src="{{ $firstMedia }}">
        </video>
    @else
        <img id="mainImage" src="{{ $firstMedia }}"
             class="img-fluid rounded main-img" alt="">
    @endif

</div>

<!-- Thumbnails -->
<div class="d-flex justify-content-center gap-2 my-1"
     style="position:absolute;bottom:1rem;left:50%;transform:translate(-50%, -20%);">

    @foreach ($images_show as $item)
        @foreach ($item as $item1)

            @php
                $isThumbVideo = preg_match('/\.(mp4|mov|avi|webm|mkv)$/i', $item1);
            @endphp

            @if($isThumbVideo)

                <video class="thumb-img"
                       width="60"
                       height="60"
                       onclick="changeMedia('{{ $item1 }}','video')">
                    <source src="{{ $item1 }}">
                </video>

            @else

                <img src="{{ $item1 }}"
                     class="thumb-img"
                     onclick="changeMedia('{{ $item1 }}','image')">

            @endif

        @endforeach
    @endforeach

</div>

<script>
function changeMedia(src, type) {

    if (type === 'video') {

        $('.main-img-container').html(`
            <video id="mainVideo"
                   class="img-fluid rounded main-img"
                   controls autoplay>
                <source src="${src}">
            </video>
        `);

    } else {

        $('.main-img-container').html(`
            <img id="mainImage"
                 src="${src}"
                 class="img-fluid rounded main-img">
        `);

    }
}
</script>