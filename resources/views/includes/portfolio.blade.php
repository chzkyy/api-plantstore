<div class="container-portfolio">
    <div class="grid">

        {{-- Project --}}
        @forelse($project as $item)
            <article>
                <img src="{{ url('images/' . $item->image) }}" alt="{{ $item->name }}">
                <div class="text">
                    <h3>{{ $item->name }}</h3>
                    <p class="Pdesc">{{ $item->short_description }}</p>
                    <div class="Ptools">
                        @forelse ($output = explode(',' , $item->tools_project) as $tools)
                            <div class="tools">{{ $tools }}</div>
                        @empty
                            <div>No Tools</div>
                        @endforelse
                    </div>
                    <button type="button" class="btn-detail" data-toggle="modal"
                        data-target="#modal{{ $item->id }}">View
                        Detail
                    </button>
                </div>
            </article>

            <div id="modal{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ $item->name }}</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div class="container-body">
                                <img src="{{ url('images/' . $item->image) }}" alt="{{ $item->name }}">
                            </div>

                            <div class="container-fluid">
                                {!! $item->long_description !!}

                                <div class="Prole">
                                    <span>Project Role : <b>{{ $item->role }}</b></span>
                                    <span>{!! $item->project_role_description !!}</span>
                                </div>

                                <span class="Prole">Tools :</span>
                                <div class="Ptools">
                                    @forelse ($output = explode(',' , $item->tools_project) as $tools)
                                        <div class="tools">{{ $tools }}</div>
                                    @empty
                                        <div>No Tools</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ $item->linkgithub }}" target="_blank" rel="noopener noreferrer">
                                <button type="button" class="btn-view">
                                    View Code
                                </button>
                            </a>
                            <a href="{{ $item->linkproject }}" target="_blank" rel="noopener noreferrer">
                                <button type="button" class="btn-view">
                                    View Project
                                </button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="justify-content-center text-center">
                Data Tidak Tersedia
            </div>
        @endforelse
    </div>
</div>
