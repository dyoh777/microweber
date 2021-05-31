<script type="text/javascript">

    mw.require('{{modules_url()}}/blog/js/filter.js');
    mw.require('{{modules_url()}}/blog/css/filter.css');

    filter = new ContentFilter();
    filter.setModuleId('{{$moduleId}}');
    filter.init();
</script>

<section class="section section-blog">
    <div class="container">
    <div class="row">

        <div class="col-md-3">
            <div class="card">

                {!! $posts->activeFilters('blog::partials.active_filters') !!}

                {!! $posts->search('blog::partials.search') !!}

                {!! $posts->tags('blog::partials.tags') !!}

                {!! $posts->categories('blog::partials.categories') !!}

                {!! $posts->filters('blog::partials.filters') !!}

             </div>
        </div>


        <div class="col-md-9">

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-2">
                    {!! $posts->limit('blog::partials.limit'); !!}
                </div>
                <div class="col-md-2">
                    {!! $posts->sort('blog::partials.sort'); !!}
                </div>
            </div>
            <div class="row">
            @foreach($posts->results() as $post)
                    <div class="col-md-3">
            <div class="post" style="margin-top:25px;">
)
                <h4>{{$post->title}}</h4>
                <p>{{$post->content_text}}</p>
                <br />
                <small>Posted At:{{$post->posted_at}}</small>
                <br />
                <a href="{{site_url($post->url)}}">View</a>
                <hr />
                @foreach($post->tags as $tag)
                   <span class="badge badge-success"><a href="?tags={{$tag->slug}}">{{$tag->name}}</a></span>
                @endforeach

                @php
                    $resultCustomFields = $post->customField()->with('fieldValue')->get();
                @endphp
                @foreach ($resultCustomFields as $resultCustomField)
                    {{--@if ($resultCustomField->type !== 'date')
                        @continue
                    @endif--}}
                    {{$resultCustomField->name}}:
                    @php
                        $customFieldValues = $resultCustomField->fieldValue()->get();
                    @endphp
                    @foreach($customFieldValues as $customFieldValue)
                        {{$customFieldValue->value}};
                    @endforeach

                @endforeach
            </div>
            </div>
            @endforeach
            </div>

            {!! $posts->pagination('pagination::bootstrap-4-flex') !!}

            <br />
            <p>
                Displaying {{$posts->count()}} of {{ $posts->total() }} result(s).
            </p>
        </div>


        </div>
        </div>
</section>
