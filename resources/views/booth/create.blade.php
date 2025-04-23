@extends('layouts.app') {{-- Or your admin layout --}}

@section('content')
    <div class="container">
        <h2 class="mb-4">Booth Map Editor</h2>

        <div style="position: relative;">
            <img src="{{ asset('assets/img/floorplan.png') }}" id="booth-image" style="width: 100%; max-width: 1000px;">
            <div id="selection-box" style="position: absolute; border: 2px dashed #007bff; display: none;"></div>
        </div>

        <form id="booth-form" class="mt-4">
            @csrf
            <div class="form-group mb-2">
                <label>Booth Code</label>
                <input type="text" name="code" class="form-control" required>
            </div>
            <input type="hidden" name="coords" id="coords">
            <input type="hidden" name="shape" value="rect">
            <div class="form-group mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Booth</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const img = document.getElementById('booth-image');
            const box = document.getElementById('selection-box');
            const coordsInput = document.getElementById('coords');

            let startX, startY, endX, endY;

            img.addEventListener('mousedown', function (e) {
                const rect = img.getBoundingClientRect();
                startX = e.clientX - rect.left;
                startY = e.clientY - rect.top;

                box.style.left = startX + 'px';
                box.style.top = startY + 'px';
                box.style.width = '0px';
                box.style.height = '0px';
                box.style.display = 'block';

                function onMouseMove(ev) {
                    const currentX = ev.clientX - rect.left;
                    const currentY = ev.clientY - rect.top;

                    box.style.left = Math.min(currentX, startX) + 'px';
                    box.style.top = Math.min(currentY, startY) + 'px';
                    box.style.width = Math.abs(currentX - startX) + 'px';
                    box.style.height = Math.abs(currentY - startY) + 'px';
                }

                function onMouseUp(ev) {
                    endX = ev.clientX - rect.left;
                    endY = ev.clientY - rect.top;

                    let x1 = Math.round(Math.min(startX, endX));
                    let y1 = Math.round(Math.min(startY, endY));
                    let x2 = Math.round(Math.max(startX, endX));
                    let y2 = Math.round(Math.max(startY, endY));

                    coordsInput.value = `${x1},${y1},${x2},${y2}`;

                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                }

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            });

            document.getElementById('booth-form').addEventListener('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                const res = await fetch("{{ route('admin.booths.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await res.json();
                if (data.success) {
                    alert('Booth saved successfully!');
                    this.reset();
                    box.style.display = 'none';
                } else {
                    alert('Error: ' + (data.message || 'Unknown error'));
                }
            });
        });
    </script>
@endsection
