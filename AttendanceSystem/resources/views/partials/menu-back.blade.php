<div id="menu-back"> <div class="mt-2 mb-4 mb-3 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <button class="btn back-button" onclick="window.history.back()">
            <i style="font-size: 32px" class="material-icons">arrow_back</i>
        </button>
        <h4 class="ml-1 mt-2">{{$pageTitle}}</h4>
    </div>

    <div class="ml-auto">
        <a id="create-event" class="btn primaryButton btn-no-border-radius btn-custom-color" href="{{route('event.create')}}"
           role="button"
           aria-expanded="false">
            Create Event
        </a>
    </div>
</div>


<div>
        <nav aria-label="breadcrumb ">
            <ol  class="breadcrumb breadcrumb-container breadcrumb-separator-dash">
                {{\Diglactic\Breadcrumbs\Breadcrumbs::render()}}
            </ol>
        </nav>
    </div>
</div>
