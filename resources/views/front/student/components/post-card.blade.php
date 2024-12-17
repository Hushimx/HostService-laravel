@props(['post'])

<div class="post-card" @if (App::getLocale() == 'ar') dir="rtl" @endif>
  <a href="{{ route('student.showpost', $post->id) }}">
    @if ($post->thumbnail && Storage::disk('posts_images')->exists($post->thumbnail))
    <img class="img-fluid"  src="{{ url('storage/posts_images/', $post->thumbnail) }}" alt="{{$post->title}}">
    @else
    <img class="img-fluid" src="{{ url('storage/posts_images/photo22.jpg') }}" alt="{{$post->title}}">
    @endif
    <div class="post-info p-3">
      <h4>{{ $post->title }}</h4>
      <p class="font-size-sm"><span class="text-primary">Admin</span> on {{ $post->created_at->format('M d Y') }} · <em class="muted">{{ $post->created_at->diffForHumans() }}</em></p>
      <p class="font-size-sm mb-0">{!! Str::limit(strip_tags($post->content), 70, '...') !!}</p>
    </div>
  </a>
</div>
