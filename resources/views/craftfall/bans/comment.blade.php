<div class="card bg-light {!! $comment->commenter->id === auth()->user()->id ? 'pull-right' : '' !!}" style="width: 70%; margin-bottom: 10px">
    <h4 class="card-header">{!! $comment->commenter->name !!} <i class="fa fa-comment"></i></h4>
    <div class="card-body">
        {!! $comment->comment !!}
    </div>
</div>
