<!-- Modal -->
<div class="modal fade" id="modalTags{{ $tag->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Data Tags</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Apakah ingin menghapus data <strong>{{ $tag->title }}</strong>?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger"
                    onclick="event.preventDefault(); document.querySelector('#delete').submit();">Delete</button>

                <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" id="delete">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
