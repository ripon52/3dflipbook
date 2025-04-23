@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Booth Map</h2>
            <a href="{{ route('admin.booths.create') }}" class="btn btn-primary">Add New Booth</a>
        </div>

        <div class="position-relative">
            <img src="{{ asset('assets/img/floorplan.png') }}" alt="Booth Map" class="img-fluid w-100" style="max-height: 700px;">
            <map name="boothmap">
            @foreach ($booths as $booth)
                @php
                    $coords = explode(',', $booth->coords);
                    $left = (int)$coords[0];
                    $top = (int)$coords[1];
                    $width = abs($coords[2] - $coords[0]);
                    $height = abs($coords[3] - $coords[1]);

                    $color = match($booth->status) {
                        'available' => 'btn-success',
                        'booked'    => 'btn-danger',
                        'reserved'  => 'btn-warning',
                        default     => 'btn-secondary',
                    };
                @endphp


                    <div class="draggable booth-block"
                         data-id="{{ $booth->id }}"
                         data-x="0"
                         data-y="0"
                         style="position:absolute;
                    top:{{ explode(',', $booth->coords)[1] }}px;
                    left:{{ explode(',', $booth->coords)[0] }}px;
                    width:{{ explode(',', $booth->coords)[2] - explode(',', $booth->coords)[0] }}px;
                    height:{{ explode(',', $booth->coords)[3] - explode(',', $booth->coords)[1] }}px;
                    background: rgba(0,123,255,0.4);
                    border:2px solid #007bff;
                    cursor: move;">
                        <span class="booth-code">{{ $booth->code }}</span>
                    </div>

{{--                <button--}}
{{--                    class="position-absolute btn btn-sm {{ $color }}"--}}
{{--                    style="left: {{ $left }}px; top: {{ $top }}px; width: {{ $width }}px; height: {{ $height }}px;"--}}
{{--                    data-bs-toggle="modal"--}}
{{--                    data-bs-target="#boothModal{{ $booth->id }}"--}}
{{--                >--}}
{{--                    {{ $booth->code }}--}}
{{--                </button>--}}

                <!-- Modal -->
                <div class="modal fade" id="boothModal{{ $booth->id }}" tabindex="-1" aria-labelledby="boothModalLabel{{ $booth->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="boothModalLabel{{ $booth->id }}">Booth {{ $booth->code }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Status:</strong> {{ ucfirst($booth->status) }}</p>
                                <p><strong>Type:</strong> {{ $booth->type ?? 'Standard' }}</p>
                                <p><strong>Description:</strong><br>{{ $booth->description ?? 'N/A' }}</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-warning">Edit</a>
                                <form action="#" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </map>

        </div>
    </div>
@endsection

@section("scripts")
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>

    <script>
        interact('.draggable')
            .draggable({
                onmove: window.dragMoveListener,
                onend: function (event) {
                    let target = event.target;
                    saveBoothPosition(target);
                }
            })
            .resizable({
                edges: { left: true, right: true, bottom: true, top: true },
                listeners: {
                    move (event) {
                        let target = event.target
                        let x = parseFloat(target.getAttribute('data-x')) || 0
                        let y = parseFloat(target.getAttribute('data-y')) || 0

                        // update the element's style
                        target.style.width  = `${event.rect.width}px`
                        target.style.height = `${event.rect.height}px`

                        // translate when resizing from top/left edges
                        x += event.deltaRect.left
                        y += event.deltaRect.top

                        target.style.transform = `translate(${x}px, ${y}px)`

                        target.setAttribute('data-x', x)
                        target.setAttribute('data-y', y)
                    },
                    end(event) {
                        saveBoothPosition(event.target);
                    }
                }
            })

        window.dragMoveListener = function (event) {
            var target = event.target
            var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
            var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy

            target.style.transform = 'translate(' + x + 'px, ' + y + 'px)'
            target.setAttribute('data-x', x)
            target.setAttribute('data-y', y)
        }

        function saveBoothPosition(el) {
            let id = el.dataset.id;
            let x = el.offsetLeft + parseFloat(el.getAttribute('data-x') || 0)
            let y = el.offsetTop + parseFloat(el.getAttribute('data-y') || 0)
            let width = el.offsetWidth
            let height = el.offsetHeight
            let coords = `${x},${y},${x + width},${y + height}`

            fetch(`/booths/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ coords: coords,_token:"{{ csrf_token() }}",_method:"PUT" })
            }).then(res => res.json())
                .then(data => {
                    console.log(`Booth ${id} updated`, data);
                });
        }
    </script>

@endsection
