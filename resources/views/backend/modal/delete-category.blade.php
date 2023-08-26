<!-- Modal -->
<div class="modal fade" id="modalCategory{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Data Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Apakah ingin menghapus data <strong>{{ $category->title }}</strong>?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger"
                    onclick="event.preventDefault(); document.querySelector('#delete').submit();">Delete</button>

                <form action="{{ route('category.destroy', $category->id) }}" method="POST" id="delete">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
